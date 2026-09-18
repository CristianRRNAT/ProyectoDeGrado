<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CareerSource extends Model
{
    protected $fillable = ['career_id', 'source_name', 'source_url', 'source_year', 'notes', 'checked_at'];
    protected function casts(): array { return ['checked_at' => 'datetime']; }
    public function career(): BelongsTo { return $this->belongsTo(Career::class); }
}
