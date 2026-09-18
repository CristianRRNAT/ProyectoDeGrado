<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Career extends Model
{
    protected $fillable = ['academic_area_id', 'name', 'slug', 'alternative_names', 'degree_level', 'is_traditional', 'duration_text', 'duration_min_years', 'duration_max_years', 'reference_title', 'riasec_primary', 'riasec_secondary', 'summary', 'description', 'study_focus', 'specializations', 'learning_paths', 'professional_field', 'economic_scope', 'social_scope', 'international_scope', 'cover_image', 'icon', 'gallery_images', 'source_url', 'verified_at', 'is_active'];
    protected function casts(): array { return ['alternative_names' => 'array', 'gallery_images' => 'array', 'specializations' => 'array', 'learning_paths' => 'array', 'duration_min_years' => 'decimal:1', 'duration_max_years' => 'decimal:1', 'verified_at' => 'datetime', 'is_traditional' => 'boolean', 'is_active' => 'boolean']; }
    public function academicArea(): BelongsTo { return $this->belongsTo(AcademicArea::class); }
    public function sources(): HasMany { return $this->hasMany(CareerSource::class); }
    public function institutions(): BelongsToMany { return $this->belongsToMany(Institution::class, 'institution_career')->withPivot(['institution_unit_id', 'degree_level', 'modality', 'schedule', 'academic_regime', 'duration_text', 'labor_demand', 'labor_demand_notes', 'enrollment_cost', 'monthly_cost', 'currency', 'admission_requirements', 'details_source_url', 'details_verified_at', 'is_active'])->withTimestamps(); }
}
