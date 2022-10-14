<?php

namespace App\Http\Controllers\lottery;

use App\Http\Controllers\Controller;
use App\Models\lottery;
use App\Http\Requests\StorelotteryRequest;
use App\Http\Requests\UpdatelotteryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class LotteryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            DB::beginTransaction();
            $response = lottery::with(['getcondition','getcondition.tags'])->get();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'data' => [
                    'code'   => $e->getCode(),
                    'title'  => [__('error en index')],
                    'errors' => $e->getMessage(),
                ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return ["list"=>$response,"total"=>count($response)];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorelotteryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $id =  $this->createLottery($request);

            $response = lottery::where('id', $id)->first();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'data' => [
                    'code'   => $e->getCode(),
                    'title'  => [__('Erron al guardar sorteo')],
                    'errors' => $e->getMessage(),
                ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            "message"       => "Nuevo sorteo creado",
            "response"      => $response,
        ]);
    }

    protected function createLottery($request)
    {
        $lottery = new lottery();
        $lottery->number_winners= $request->number_winners;
        $lottery->conditions_id = $request->conditions_id;
        $lottery->save();

        return $lottery->id;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\lottery  $lottery
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            DB::beginTransaction();
            $response = lottery::with(['getcondition','getcondition.tags'])
            ->where('id',$id)->first();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'data' => [
                    'code'   => $e->getCode(),
                    'title'  => [__('error en show')],
                    'errors' => $e->getMessage(),
                ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return ["list"=>$response];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatelotteryRequest  $request
     * @param  \App\Models\lottery  $lottery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $lottery = lottery::where('id', '=', $id)->first();
        if (!$lottery) {
            return response()->json([
                "errors" => [
                    "message" => "No existe esta sorteo",
                ]
            ], 422);
        }

        //$response;
        try {
            DB::beginTransaction();

            $lottery = lottery::findOrFail($id);
            $this->updateLottery($lottery, $request);

            $response = lottery::where('id', $id)->first();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'data' => [
                    'code'   => $e->getCode(),
                    'title'  => [__('Error al editar')],
                    'errors' => $e->getMessage(),
                ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            "message"       => "Sorteo editado",
            "response"      => $response,
        ]);
    }

    protected function updateLottery($lottery, $request)
    {
        $lottery->number_winners= $request->number_winners ?$request->number_winners:$lottery->number_winners;
        $lottery->conditions_id= $request->conditions_id ?$request->conditions_id:$lottery->conditions_id;
        $lottery->update();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\lottery  $lottery
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            DB::beginTransaction();

            $lottery= lottery::findOrFail($id);
               $lottery->delete();
            DB::commit();
            }catch(\Exception $e){
            DB::rollBack();
            return response()->json([
                'data' => [
                    'code'   => $e->getCode(),
                    'title'  => [__('fallo al eliminar sorteo')],
                    'errors' => $e->getMessage(),
                ]
              ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
            return response()->json([
              "message"       => "sorteo eliminado",
             ]);
    }
}