<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Institution extends Model
{
    protected $fillable = ['department_id', 'name', 'slug', 'acronym', 'institution_type', 'ownership', 'payment_type', 'description', 'cost_notes', 'schedule_notes', 'is_single_program', 'specialty_areas', 'campuses', 'city', 'address', 'latitude', 'longitude', 'phone', 'email', 'website', 'whatsapp_url', 'facebook_url', 'tiktok_url', 'source_url', 'verified_at', 'is_verified', 'is_active'];
    protected function casts(): array { return ['latitude' => 'decimal:7', 'longitude' => 'decimal:7', 'specialty_areas' => 'array', 'campuses' => 'array', 'is_single_program' => 'boolean', 'verified_at' => 'datetime', 'is_verified' => 'boolean', 'is_active' => 'boolean']; }
    public function department(): BelongsTo { return $this->belongsTo(Department::class); }
    public function getRouteKeyName(): string { return 'slug'; }
    public function units(): HasMany { return $this->hasMany(InstitutionUnit::class)->orderBy('sort_order')->orderBy('name'); }
    public function comments(): HasMany { return $this->hasMany(Comment::class); }
    public function careers(): BelongsToMany { return $this->belongsToMany(Career::class, 'institution_career')->withPivot(['institution_unit_id', 'degree_level', 'modality', 'schedule', 'academic_regime', 'duration_text', 'labor_demand', 'labor_demand_notes', 'enrollment_cost', 'monthly_cost', 'currency', 'admission_requirements', 'details_source_url', 'details_verified_at', 'is_active'])->withTimestamps(); }
}
