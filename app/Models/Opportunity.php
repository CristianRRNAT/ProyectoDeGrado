<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Opportunity extends Model
{
    protected $guarded = [];
    protected function casts(): array { return ['cost_amount'=>'decimal:2','start_date'=>'date','deadline'=>'date','verified_at'=>'datetime','is_verified'=>'boolean','is_active'=>'boolean']; }
}
