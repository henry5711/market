<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Core\CrudModel;

class register_user extends CrudModel
{
    protected $guarded = ['id'];
    protected $table='register_user';
    protected $fillable=['dni','name','email','fec_nacimiento','genero','instagram','nacionality'
    ,'phone','play','number','salario','pais','estado','city','victory'];

    public function tags()
    {
        return $this->belongsToMany(tags::class,'detail_user_tag','id_user','id_tags');
    }
}
