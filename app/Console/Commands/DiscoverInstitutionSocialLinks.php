<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class DiscoverInstitutionSocialLinks extends Command
{
    protected $signature = 'institutions:discover-socials';
    protected $description = 'Descubre canales sociales enlazados desde los sitios oficiales de las instituciones';

    public function handle(): int
    {
        $institutions = DB::table('institutions')
            ->where('is_active', true)
            ->whereNotNull('website')
            ->where('website', 'not like', '%facebook.com%')
            ->get(['id', 'name', 'website', 'facebook_url', 'whatsapp_url', 'tiktok_url']);

        $found = 0;
        foreach ($institutions->chunk(12) as $batch) {
            $responses = Http::pool(fn (Pool $pool) => $batch->map(fn ($institution) =>
                $pool->as((string) $institution->id)
                    ->withHeaders(['User-Agent' => 'Mozilla/5.0 OrientaBolivia/1.0'])
                    ->timeout(12)
                    ->get($institution->website)
            )->all());

            foreach ($batch as $institution) {
                $response = $responses[(string) $institution->id] ?? null;
                if (!$response || $response instanceof \Throwable || !$response->successful()) continue;

                $links = $this->socialLinks($response->body());
                $changes = array_filter([
                    'facebook_url' => $institution->facebook_url ? null : $links['facebook'],
                    'whatsapp_url' => $institution->whatsapp_url ? null : $links['whatsapp'],
                    'tiktok_url' => $institution->tiktok_url ? null : $links['tiktok'],
                ]);

                if ($changes) {
                    DB::table('institutions')->where('id', $institution->id)->update($changes + ['updated_at' => now()]);
                    $found++;
                    $this->line($institution->name.': '.implode(', ', array_keys($changes)));
                }
            }
        }

        $foundOnFacebook = $this->discoverWhatsappFromFacebook();
        $this->info("Instituciones con canales encontrados o conservados: {$found}");
        $this->info("WhatsApp adicionales encontrados en Facebook: {$foundOnFacebook}");
        return self::SUCCESS;
    }

    private function discoverWhatsappFromFacebook(): int
    {
        $institutions = DB::table('institutions')
            ->where('is_active', true)
            ->whereNotNull('facebook_url')
            ->whereNull('whatsapp_url')
            ->get(['id', 'name', 'facebook_url']);
        $found = 0;

        foreach ($institutions->chunk(8) as $batch) {
            $responses = Http::pool(fn (Pool $pool) => $batch->map(fn ($institution) =>
                $pool->as((string) $institution->id)
                    ->withHeaders(['User-Agent' => 'Mozilla/5.0 (Linux; Android 12) AppleWebKit/537.36 Chrome/124 Mobile Safari/537.36'])
                    ->timeout(15)
                    ->get($institution->facebook_url)
            )->all());

            foreach ($batch as $institution) {
                $response = $responses[(string) $institution->id] ?? null;
                if (!$response || $response instanceof \Throwable || !$response->successful()) continue;
                $whatsapp = $this->whatsappFromContent($response->body());
                if (!$whatsapp) continue;

                DB::table('institutions')->where('id', $institution->id)->update(['whatsapp_url' => $whatsapp, 'updated_at' => now()]);
                $found++;
                $this->line($institution->name.': WhatsApp encontrado en Facebook');
            }
        }

        return $found;
    }

    private function whatsappFromContent(string $html): ?string
    {
        $direct = $this->socialLinks($html)['whatsapp'];
        if ($direct) return $direct;

        $content = html_entity_decode(str_replace(['\\/', '\\u0025', '\\u0026'], ['/', '%', '&'], $html), ENT_QUOTES | ENT_HTML5);
        if (!preg_match('/whats\s*app.{0,180}?(?:(?:\+?591)[\s.\-]*)?([67](?:[\s.\-]*\d){7})/isu', $content, $match)) return null;

        $number = preg_replace('/\D/', '', $match[1]);
        return strlen($number) === 8 ? 'https://wa.me/591'.$number : null;
    }

    private function socialLinks(string $html): array
    {
        preg_match_all('~https?:(?:\\\\?/){2}[^"\'<>\\s]+~iu', $html, $matches);
        $urls = collect($matches[0] ?? [])->map(fn ($url) => html_entity_decode(str_replace('\\/', '/', rtrim($url, '\\')), ENT_QUOTES | ENT_HTML5));

        return [
            'facebook' => $urls->first(fn ($url) => str_contains($url, 'facebook.com/') && !preg_match('~/sharer|/plugins|/dialog/~i', $url)),
            'whatsapp' => $urls->first(fn ($url) => str_contains($url, 'wa.me/') || str_contains($url, 'api.whatsapp.com/')),
            'tiktok' => $urls->first(fn ($url) => preg_match('~tiktok.com/@~i', $url)),
        ];
    }
}
