<?php

namespace App\Checks;

use App\Models\AgenciaCobro;
use App\Models\Payment_method;
use App\Models\TermPago;
use Exception;
use Illuminate\Contracts\Container\Container;
use UKFast\HealthCheck\HealthCheck;

class SeedHealthCheck extends HealthCheck
{
    protected $name = 'Seed';

    public function status()
    {
        $problem = false;
        // try {
            $agencia = AgenciaCobro::all();
            if($agencia->count() == 0){
                $problem[] = [
                    'No existe Semilla para las Agencias de Cobro'
                ];
            }
            if((TermPago::all())->count() == 0){
                $problem[] = [
                    'No existe Semilla para los Términos de Pago'
                ];
            }
            if((Payment_method::all())->count() == 0){
                $problem[] = [
                    'No existe Semillas para los Métodos de Pago'
                ];
            }


        //-------------------------------
            if(!$problem){
                return $this->okay();
            }else{
                return $this->problem('Seed Fails',[
                     "problemas" => $problem
                     ]
                );
            }

        return $this->okay();
    }
}