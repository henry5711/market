<?php

namespace App\Http\Controllers\conditions;

use App\Models\condition;
use App\Http\Requests\StoreconditionsRequest;
use App\Http\Requests\UpdateconditionsRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class ConditionsController extends Controller
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
            $response = condition::with(['tags'])->get();

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
     * @param  \App\Http\Requests\StoreconditionsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $id =  $this->createCondition($request);

            $response = condition::where('id', $id)->first();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'data' => [
                    'code'   => $e->getCode(),
                    'title'  => [__('Erron al guardar condicion')],
                    'errors' => $e->getMessage(),
                ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json(array(
            'success' => true,
            'message' => 'condicion creada',
            'value'   => $response,
        ));
    }

    protected function createCondition($request)
    {
        $condition               = new condition();
        $condition->genero   = $request->genero;
        $condition->salario_ini         = $request->salario_ini;
        $condition->salario_end = $request->salario_end;
        $condition->save();

        if(isset($request->tags)){
                $condition->tags()->sync($request->tags);
        }

        return $condition->id;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\conditions  $conditions
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            DB::beginTransaction();
            $response = condition::with(['tags'])
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
     * @param  \App\Http\Requests\UpdateconditionsRequest  $request
     * @param  \App\Models\conditions  $conditions
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $condition = condition::where('id', '=', $id)->first();
        if (!$condition) {
            return response()->json([
                "errors" => [
                    "message" => "No existe esta condicion",
                ]
            ], 422);
        }

        //$response;
        try {
            DB::beginTransaction();

            $condition = condition::findOrFail($id);
            $this->updateConditions($condition, $request);

            $response = condition::where('id', $id)->first();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'data' => [
                    'success' => false,
                    'code'   => $e->getCode(),
                    'title'  => [__('Error al editar')],
                    'errors' => $e->getMessage(),
                ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json(array(
            'success' => true,
            'message' => 'condicion editada',
            'value'   => $response,
        ));
    }

    protected function updateConditions($condition, $request)
    {
        $condition->genero= $request->genero ?$request->genero:$condition->genero;
        $condition->salario_ini= $request->salario_ini ?$request->salario_ini: $condition->salario_ini;
        $condition->salario_end= $request->salario_end ?$request->salario_end : $condition->salario_end;
        $condition->update();

        if(isset($request->tags)){
                $condition->tags()->sync($request->tags);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\conditions  $conditions
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            DB::beginTransaction();

            $condition = condition::findOrFail($id);
               $condition->delete();
            DB::commit();
            }catch(\Exception $e){
            DB::rollBack();
            return response()->json([
                'data' => [
                    'code'   => $e->getCode(),
                    'title'  => [__('fallo al eliminar condicion')],
                    'errors' => $e->getMessage(),
                ]
              ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
            return response()->json([
              "message"       => "Condicion eliminada",
             ]);
    }

}
