<?php
/**
 * Created by PhpStorm.
 * User: zippyttech
 */

namespace App\Services\tags;


use App\Core\CrudService;
use App\Repositories\tags\tagsRepository;

/** @property tagsRepository $repository */
class tagsService extends CrudService
{

    protected $name = "tags";
    protected $namePlural = "tags";

    public function __construct(tagsRepository $repository)
    {
        parent::__construct($repository);
    }

}