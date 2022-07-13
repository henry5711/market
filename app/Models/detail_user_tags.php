<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Core\CrudModel;

class detail_user_tags extends CrudModel
{
    protected $guarded = ['id'];
    protected $table='detail_user_tag';
    protected $fillable=['id_user','id_tags'];
}
