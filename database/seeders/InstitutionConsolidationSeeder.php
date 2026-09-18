<?php

namespace Database\Seeders;

use App\Models\Institution;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstitutionConsolidationSeeder extends Seeder
{
    public function run(?string $acronym = null): void
    {
        foreach ($this->groups() as $group) {
            if ($acronym !== null && $group['acronym'] !== $acronym) {
                continue;
            }
            DB::transaction(fn () => $this->merge($group));
        }
    }

    private function merge(array $group): void
    {
        $members = Institution::with(['department', 'units'])->whereIn('slug', $group['members'])->orderBy('id')->get();
        if ($members->isEmpty()) {
            return;
        }
        $canonical = $members->firstWhere('slug', $group['primary']) ?? $members->firstWhere('slug', $group['slug']) ?? $members->first();
        $campuses = collect();
        foreach ($members as $member) {
            foreach ($member->campuses ?? [] as $campus) {
                $campuses->push($campus);
            }
            if ($member->isNot($canonical)) {
                $campuses->push(['name' => 'Sede '.$member->city, 'city' => $member->city, 'address' => $member->address, 'department' => $member->department?->name, 'department_slug' => $member->department?->slug, 'latitude' => $member->latitude, 'longitude' => $member->longitude, 'programs' => $member->careers()->wherePivot('is_active', true)->pluck('careers.name')->values()->all()]);
                $this->moveUnits($member, $canonical);
                $this->moveCareers($member, $canonical);
                $member->delete();
            }
        }
        $canonical->update(['name' => $group['name'], 'slug' => $group['slug'], 'acronym' => $group['acronym'], 'campuses' => $campuses->reject(fn ($c) => ($c['address'] ?? null) === $canonical->address && ($c['city'] ?? null) === $canonical->city)->filter(fn ($c) => ! empty($c['address']))->unique(fn ($c) => mb_strtolower(($c['address'] ?? '').'|'.($c['city'] ?? '')))->values()->all() ?: null]);
    }

    private function moveUnits(Institution $from, Institution $to): void
    {
        foreach ($from->units as $unit) {
            if ($to->units()->where('slug', $unit->slug)->exists()) {
                $unit->slug .= '-'.$from->id;
            }$unit->institution_id = $to->id;
            $unit->save();
        }
    }

    private function moveCareers(Institution $from, Institution $to): void
    {
        foreach (DB::table('institution_career')->where('institution_id', $from->id)->get() as $offering) {
            $existing = DB::table('institution_career')->where('institution_id', $to->id)->where('career_id', $offering->career_id)->first();
            if ($existing) {
                if (! $existing->is_active && $offering->is_active) {
                    DB::table('institution_career')->where('id', $existing->id)->update(['is_active' => true]);
                }
            } else {
                DB::table('institution_career')->where('id', $offering->id)->update(['institution_id' => $to->id]);
            }
        }
    }

    private function groups(): array
    {
        return [
            ['name' => 'Instituto Técnico Superior de Comercio y Administración ESAE', 'slug' => 'instituto-tecnico-superior-de-comercio-y-administracion-esae', 'acronym' => 'ESAE', 'primary' => 'instituto-tecnico-superior-de-comercio-y-administracion-esae', 'members' => ['instituto-tecnico-superior-de-comercio-y-administracion-esae', 'instituto-tecnico-esae-la-paz', 'instituto-superior-comercio-insco-esae-oruro']],
            ['name' => 'Instituto Comercial Superior INCOS', 'slug' => 'incos', 'acronym' => 'INCOS', 'primary' => 'incos', 'members' => ['incos', 'incos-la-paz', 'instituto-tecnico-nacional-de-comercio-incos-3', 'instituto-comercial-superior-tarija-incos', 'instituto-tecnico-incos-potosi', 'instituto-tecnico-incos-pando', 'instituto-tecnico-incos-beni', 'instituto-tecnico-incos-guayaramerin', 'instituto-tecnico-incos-santa-ana']],
            ['name' => 'FATESCIPOL', 'slug' => 'fatescipol', 'acronym' => 'FATESCIPOL', 'primary' => 'fatescipol-el-alto', 'members' => ['fatescipol', 'fatescipol-el-alto', 'fatescipol-caracollo', 'fatescipol-potosi', 'fatescipol-sucre', 'fatescipol-tarija', 'fatescipol-cochabamba', 'fatescipol-santa-cruz']],
            ['name' => 'Universidad Católica Boliviana San Pablo', 'slug' => 'universidad-catolica-boliviana-san-pablo', 'acronym' => 'UCB', 'primary' => 'universidad-catolica-boliviana-san-pablo-la-paz', 'members' => ['universidad-catolica-boliviana-san-pablo', 'universidad-catolica-boliviana-san-pablo-la-paz', 'universidad-catolica-boliviana-san-pablo-cochabamba', 'universidad-catolica-boliviana-santa-cruz', 'universidad-catolica-boliviana-tarija']],
            ['name' => 'Universidad de Aquino Bolivia', 'slug' => 'universidad-de-aquino-bolivia', 'acronym' => 'UDABOL', 'primary' => 'universidad-de-aquino-bolivia-santa-cruz', 'members' => ['universidad-de-aquino-bolivia', 'universidad-de-aquino-bolivia-santa-cruz', 'universidad-de-aquino-bolivia-cochabamba']],
            ['name' => 'Universidad Privada Boliviana', 'slug' => 'universidad-privada-boliviana', 'acronym' => 'UPB', 'primary' => 'universidad-privada-boliviana-la-paz', 'members' => ['universidad-privada-boliviana', 'universidad-privada-boliviana-la-paz', 'universidad-privada-boliviana-campus-cochabamba']],
            ['name' => 'Universidad Privada del Valle', 'slug' => 'universidad-privada-del-valle', 'acronym' => 'UNIVALLE', 'primary' => 'universidad-privada-del-valle-cochabamba', 'members' => ['universidad-privada-del-valle', 'universidad-privada-del-valle-cochabamba', 'universidad-privada-del-valle-la-paz', 'universidad-privada-del-valle-trinidad']],
            ['name' => 'Universidad Privada Domingo Savio', 'slug' => 'universidad-privada-domingo-savio', 'acronym' => 'UPDS', 'primary' => 'universidad-privada-domingo-savio-santa-cruz', 'members' => ['universidad-privada-domingo-savio', 'universidad-privada-domingo-savio-santa-cruz', 'universidad-privada-domingo-savio-sucre', 'universidad-privada-domingo-savio-tarija', 'universidad-privada-domingo-savio-potosi', 'universidad-privada-domingo-savio-oruro']],
            ['name' => 'Universidad Privada Franz Tamayo', 'slug' => 'universidad-privada-franz-tamayo', 'acronym' => 'UNIFRANZ', 'primary' => 'universidad-privada-franz-tamayo-la-paz', 'members' => ['universidad-privada-franz-tamayo', 'universidad-privada-franz-tamayo-la-paz', 'universidad-privada-franz-tamayo-santa-cruz']],
            ['name' => 'Instituto Tecnológico INFOCAL', 'slug' => 'instituto-tecnologico-infocal', 'acronym' => 'INFOCAL', 'primary' => 'instituto-tecnologico-infocal-tupuraya-cochabamba', 'members' => ['instituto-tecnologico-infocal', 'instituto-tecnologico-infocal-tupuraya-cochabamba', 'instituto-tecnologico-infocal-arocagua-cochabamba', 'instituto-tecnologico-infocal-santa-cruz', 'instituto-tecnologico-infocal-pando']],
            ['name' => 'Instituto Tecnológico Avelino Siñani de Mizque', 'slug' => 'instituto-tecnologico-avelino-sinani-de-mizque', 'acronym' => null, 'primary' => 'instituto-tecnologico-avelino-sinani-de-mizque', 'members' => ['instituto-tecnologico-avelino-sinani-de-mizque', 'instituto-tecnologico-avelino-sinani-de-mizque-subsede-mina-asientos']],
            ['name' => 'Escuela Militar de Ingeniería', 'slug' => 'escuela-militar-de-ingenieria', 'acronym' => 'EMI', 'primary' => 'escuela-militar-de-ingenieria-la-paz', 'members' => ['escuela-militar-de-ingenieria', 'escuela-militar-de-ingenieria-la-paz']],
            ['name' => 'Universidad Central', 'slug' => 'universidad-central', 'acronym' => 'UNICEN', 'primary' => 'universidad-central-cochabamba', 'members' => ['universidad-central', 'universidad-central-cochabamba']],
            ['name' => 'Universidad Técnica Privada Cosmos', 'slug' => 'universidad-tecnica-privada-cosmos', 'acronym' => 'UNITEPC', 'primary' => 'universidad-tecnica-privada-cosmos-cochabamba', 'members' => ['universidad-tecnica-privada-cosmos', 'universidad-tecnica-privada-cosmos-cochabamba']],
        ];
    }
}
