<?php

namespace App\Http\Controllers\register_user;

use Illuminate\Http\Request;
use App\Core\CrudController;
use App\Services\register_user\register_userService;
/** @property register_userService $service */
class register_userController extends CrudController
{
    public function __construct(register_userService $service)
    {
        parent::__construct($service);
    }
}