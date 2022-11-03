<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Core\CrudModel;

class register_user extends CrudModel
{
    protected $guarded = ['id'];
    protected $table='register_user';
    protected $fillable=['dni','name','email','fec_nacimiento','genero','instagram','nacionality'
    ,'phone','play','number','salario','pais','estado','city','victory', 'confirmation_phone'];

    public function tags()
    {
        return $this->belongsToMany(tags::class,'detail_user_tag','id_user','id_tags');
    }

    public function scopeFiltro($query, $request)
    {
        return $query
        ->when($request->name, function ($query, $name) {
            return $query->where('name', 'like', "%$name%");
        })
        ->when($request->email, function ($query, $email) {
            return $query->where('email', 'ilike', "%$email%");
        })
        ->when($request->dni, function ($query, $dni) {
            return $query->where('dni', 'ilike', "%$dni%");
        })
        ->when($request->city, function ($query, $city) {
            return $query->where('city', 'ilike', "%$city%");
        });
    }
}
