<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class condition extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table='conditions';
    protected $fillable=['genero','salario_ini','salario_end'];

    /*public function conditions_tag(){
        return $this->belongsToMany(conditions_tags::class);
    }*/

    public function tags(){
        return $this->belongsToMany(tags::class,'condition_tag','condition_id','tag_id');
    }
}
