<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lottery extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table='lotteries';
    protected $fillable=['number_winners','conditions_id'];

    public function getcondition()
    {
    return $this->hasOne(condition::class, 'id', 'conditions_id');
    }
}
