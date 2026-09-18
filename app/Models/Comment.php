<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Comment extends Model
{
    protected $guarded=[];
    protected function casts(): array { return ['reviewed_at'=>'datetime']; }
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function institution(): BelongsTo { return $this->belongsTo(Institution::class); }
    public function likedBy(): BelongsToMany { return $this->belongsToMany(User::class, 'comment_likes')->withTimestamps(); }
    public function reviewer(): BelongsTo { return $this->belongsTo(User::class,'reviewed_by'); }
}
