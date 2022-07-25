<?php
/**
 * Created by PhpStorm.
 * User: zippyttech
 */

namespace App\Repositories\register_user;

use App\Core\CrudRepository;
use App\Models\register_user;

/** @property register_user $model */
class register_userRepository extends CrudRepository
{

    public function __construct(register_user $model)
    {
        parent::__construct($model);
    }

    public function _index($request = null, $user = null)
    {
        $user=register_user::with('tags')->get();

        return $user;
    }

    public function _show($id)
    {
        $user=register_user::with('tags')->find($id);

        return  $user;
    }

}
