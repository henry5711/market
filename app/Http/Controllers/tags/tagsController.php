<?php

namespace App\Http\Controllers\tags;

use Illuminate\Http\Request;
use App\Core\CrudController;
use App\Services\tags\tagsService;
/** @property tagsService $service */
class tagsController extends CrudController
{
    public function __construct(tagsService $service)
    {
        parent::__construct($service);
    }
}