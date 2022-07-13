<?php
/**
 * Created by PhpStorm.
 * User: zippyttech
 */

namespace App\Services\detail_user_tags;


use App\Core\CrudService;
use App\Repositories\detail_user_tags\detail_user_tagsRepository;

/** @property detail_user_tagsRepository $repository */
class detail_user_tagsService extends CrudService
{

    protected $name = "detail_user_tags";
    protected $namePlural = "detail_user_tags";

    public function __construct(detail_user_tagsRepository $repository)
    {
        parent::__construct($repository);
    }

}