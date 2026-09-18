<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AcademicArea extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'icon', 'color', 'is_active'];
    protected function casts(): array { return ['is_active' => 'boolean']; }
    public function careers(): HasMany { return $this->hasMany(Career::class); }
}
