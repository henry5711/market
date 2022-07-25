<?php
/**
 * Created by PhpStorm.
 * User: zippyttech
 */

namespace App\Repositories\detail_user_tags;

use App\Core\CrudRepository;
use App\Models\detail_user_tags;
use App\Models\register_user;

/** @property detail_user_tags $model */
class detail_user_tagsRepository extends CrudRepository
{

    public function __construct(detail_user_tags $model)
    {
        parent::__construct($model);
    }

}
