<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Core\CrudModel;

class tags extends CrudModel
{
    protected $guarded = ['id'];
    protected $table='tags';
    protected $fillable=['name_tag','description','act'];

    public function user()
    {
        return $this->belongsToMany(register_user::class,'detail_user_tag','id_tags','id_user');
    }

    public function conditions_tag(){
        return $this->hasMany(conditions_tags::class);
    }


}
