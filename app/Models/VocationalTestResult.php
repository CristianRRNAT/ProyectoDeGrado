<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VocationalTestResult extends Model
{
    protected $fillable = ['user_id', 'test_version', 'profile_code', 'answers', 'scores', 'recommended_career_ids', 'interpretation'];
    protected function casts(): array { return ['answers' => 'array', 'scores' => 'array', 'recommended_career_ids' => 'array']; }
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
}
