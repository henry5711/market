<?php

namespace App\Http\Controllers\lottery;

use App\Http\Controllers\Controller;
use App\Models\lottery;
use App\Http\Requests\StorelotteryRequest;
use App\Http\Requests\UpdatelotteryRequest;
use App\Models\condition;
use App\Models\register_user;
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
            $response = lottery::with(['getcondition', 'getcondition.tags'])->get();

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

        return ["list" => $response, "total" => count($response)];
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

        return response()->json(array(
            'success' => true,
            'message' => 'sorteo creado',
            'value'   => $response,
        ));
    }

    protected function createLottery($request)
    {
        $lottery = new lottery();
        $lottery->number_winners = $request->number_winners;
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
            $response = lottery::with(['getcondition', 'getcondition.tags'])
                ->where('id', $id)->first();

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

        return ["list" => $response];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatelotteryRequest  $request
     * @param  \App\Models\lottery  $lottery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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

        return response()->json(array(
            'success' => true,
            'message' => 'sorteo editado',
            'value'   => $response,
        ));
    }

    protected function updateLottery($lottery, $request)
    {
        $lottery->number_winners = $request->number_winners ? $request->number_winners : $lottery->number_winners;
        $lottery->conditions_id = $request->conditions_id ? $request->conditions_id : $lottery->conditions_id;
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
        try {
            DB::beginTransaction();

            $lottery = lottery::findOrFail($id);
            $lottery->delete();
            DB::commit();
        } catch (\Exception $e) {
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

    public function showWiners($id)
    {
        $sorteo = lottery::where('id', $id)->first();
        $filter = condition::where('id', $sorteo->conditions_id)->first();

        $winers = register_user::when($filter->genero, function ($query, $genero) {
            return $query->where('genero', 'like', "%$genero%");
        })
            ->when($filter->salario, function ($query, $salario) {
                return $query->where('salario', 'like', "%$salario%");
            })
            ->when($filter->pais, function ($query, $pais) {
                return $query->where('pais', 'ilike', "%$pais%");
            })
            ->when($filter->estado, function ($query, $estado) {
                return $query->where('estado', 'ilike', "%$estado%");
            })
            ->when($filter->city, function ($query, $city) {
                return $query->where('city', 'ilike', "%$city%");
            })->limit($sorteo->number_winners)->get();

        if (count($winers) > 0) {
           foreach($winers as $winner){
                $up=register_user::where('id',$winner->id)->first();
                $up->victory=true;
                $up->save();
           }
           return $winers;
        }
        else{
            return response()->json(array(
                'success' => false,
                'message' => 'no hay ganadores en este sorteo'
            ));
        }

    }
}
