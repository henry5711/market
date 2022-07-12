<?php

namespace App\Checks;

use App\Models\AgenciaCobro;
use App\Models\Payment_method;
use App\Models\TermPago;
use Exception;
use Illuminate\Contracts\Container\Container;
use UKFast\HealthCheck\HealthCheck;

class VariablesGlobalesHealthCheck extends HealthCheck
{
    protected $name = 'variables_globales';

    public function status()
    {
        $problem = false;
        // try {
           if(env('APP_URL') == null){
                $problem[] = [
                    'la variable APP_URL no está configurada'
                ];
            }
            $problem[] = env('QUEUE_DRIVER') != 'database' ?
                            [
                                'La variable QUEUE_DRIVER debe estar en \'database\' '
                            ] : false;

            if(env('QUEUE_CONNECTION') != 'database'){
                $problem[] = [
                    'La variable QUEUE_CONNECTION debe estar en \'database\' '
                ];
            }

        //-------------------------------
            if($problem){
                return $this->problem('Seed Fails',[
                     "problemas" => $problem
                     ]
                );
            }

        return $this->okay([
            'APP_URL' => env('APP_URL'),
            'QUEUE_CONNECTION' => env('QUEUE_CONNECTION'),
            'QUEUE_DRIVER' => env('QUEUE_DRIVER')
        ]);
    }
}
