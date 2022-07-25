<?php

namespace App\Http\Controllers\detail_user_tags;

use Illuminate\Http\Request;
use App\Core\CrudController;
use App\Models\detail_user_tags;
use App\Services\detail_user_tags\detail_user_tagsService;
/** @property detail_user_tagsService $service */
class detail_user_tagsController extends CrudController
{
    public function __construct(detail_user_tagsService $service)
    {
        parent::__construct($service);
    }

    public function deletetagsrelation(Request $request)
    {
      $detail=detail_user_tags::where('id_user',$request->id_user)->where('id_tags',$request->id_tags)->first();
      $detail->delete();
      return response()->json(['message' => 'deleted'],200);
    }
}
