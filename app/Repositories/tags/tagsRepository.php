<?php
/**
 * Created by PhpStorm.
 * User: zippyttech
 */

namespace App\Repositories\tags;

use App\Core\CrudRepository;
use App\Models\tags;

/** @property tags $model */
class tagsRepository extends CrudRepository
{

    public function __construct(tags $model)
    {
        parent::__construct($model);
    }

}