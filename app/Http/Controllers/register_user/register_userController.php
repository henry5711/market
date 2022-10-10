<?php

namespace App\Http\Controllers\register_user;

use Illuminate\Http\Request;
use App\Core\CrudController;
use App\Models\register_user;
use App\Services\register_user\register_userService;
/** @property register_userService $service */
class register_userController extends CrudController
{
    public function __construct(register_userService $service)
    {
        parent::__construct($service);
    }

    public function filter(Request $request){
        $filter=register_user::filtro($request);
        if(isset($request->order)){
         $filter=$filter->orderBy($request->order)->get();
        }
        else{
            $filter=$filter->get();
        }

        return ["list"=>$filter];
    }
}
