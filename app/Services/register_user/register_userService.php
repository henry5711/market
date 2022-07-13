<?php
/**
 * Created by PhpStorm.
 * User: zippyttech
 */

namespace App\Services\register_user;


use App\Core\CrudService;
use App\Models\register_user;
use App\Repositories\register_user\register_userRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/** @property register_userRepository $repository */
class register_userService extends CrudService
{

    protected $name = "register_user";
    protected $namePlural = "register_users";

    public function __construct(register_userRepository $repository)
    {
        parent::__construct($repository);
    }

    public function _store(Request $request)
    {
        $verifi=register_user::where('dni',$request->dni)->first();
        $vericorreo=register_user::where('email',$request->email)->first();
        if(isset($verifi) or isset($vericorreo)){
            return response()->json(['error' => true, 'message' => "ya existe este usuario"],400);
        }
        else{
            return parent::_store($request);
        }
    }

}
