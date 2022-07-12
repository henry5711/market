<?php
/**
 * Created by PhpStorm.
 * User: zippyttech
 * Date: 8/1/18
 * Time: 10:01 AM
 */

namespace App\Core;


use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

//use Illuminate\Support\Facades\Storage;

class ImageService //extends TatucoService
{

    /**
     * @param $images
     * @param string $id
     * @return bool|string
     */
    public function image($images, $id = 'zippyttech')
    {
        try{
            $route_web = env('CUSTOM_URL') . '/images/';
            $now = Carbon::now()->format('Y-m-d');
            $img = $images;
            $ext = $this->get_extension($img);
            $img = str_replace('data:image/'.$ext.';base64,', '', $img);
            $data = base64_decode($img);
            $var_for = uniqid().'-'.$id.'-'.$now. '.'.$ext;
            $image = $route_web . $var_for;
            //$success = file_put_contents($file, $data);
            $success = Storage::put('public/'.$var_for, $data);
            return $success ?$image: false;
        }catch (\Exception $e){
            $er = [
                'mensaje' => $e->getMessage(),
                'linea'   => $e->getLine(),
                'archivo' => $e->getFile(),
            ];
            Log::critical($er);
            return null;
        }

    }
    /**
     * Función cargar una imagen en el servidor
     *
     * @author foskert@gmail.com
     * @param String $images
     * @param String $url
     * @param String $consta
     * @return Boolean | String
     * @version 2.0
     */
    public function image_load($images,  $url = "", $cons = "IMAGE", $code = "" ){
        try{
            $route = app()->basePath('public/images'.$url.'/');
            if(str_contains(env('APP_URL'), "https://")){
                $route_web = env('APP_URL').'/images'.$url.'/';
            }else{
                $route_web = "https://".env('APP_URL').'/images'.$url.'/';
            }
            $now = Carbon::now()->format('Ymdhmsnm');
            if (!File::exists($route)) {
               File::makeDirectory($route , 0777, true);
            }
            define('UPLOAD_DIR_'.$cons, $route);
            $img = $images;
            if($ext = $this->get_extension($img)){
                $img = str_replace('data:image/'.$ext.';base64,', '', $img);
                $data = base64_decode($img);

                $ran     = mt_rand(10000,99999);
                $var_for = $cons.$ran. '.'.$ext;

                if($cons == "IMAGE"){
                    $file = UPLOAD_DIR_IMAGE.$var_for;
                }else if($cons == "ICO"){
                    $file = UPLOAD_DIR_ICO.$var_for;
                }else if($cons == "DOC"){
                    $file = UPLOAD_DIR_DOC.$var_for;
                }else if($cons == "MEDIOS0"){
                    $file = UPLOAD_DIR_MEDIOS.$var_for;
                }
                $image = $route_web . $var_for;

                if(file_put_contents($file, $data)){
                    return $image;
                }else{
                    Log::critical( 'No se logro la cargar del documento');
                    return false;
                }
            }else{
                Log::critical( 'Formato de documento no valida');
                return false;
            }
        }catch (\Exception $e){
            Log::critical( 'SCCOREI0001 '.$file);
            return false;
        }
    }


    /**
     * @named Function valid Images
     * @param $values($images)
     * @return false|string
     */
    public function images($values){
        if(!is_array($values)){
            return null;
        }
        $i = 1;
        $image_array = [];
        foreach ($values as $value){
            $image_array[] = filter_var($value, FILTER_VALIDATE_URL) ? $value : ["image".$i => $this->image($value)];
            $i++;
        }
        return json_encode($image_array);
    }

    /**
     * @param $string
     * @return int
     * @throws Exception
     */
    public function get_extension($string)
    {
        $extension="";
        if(!empty($string)){
            $formats = ["jpg", "jpeg", "png", "gif",'icoñ..'];
            if(substr($string,0,4)=='http'){
                return $extension=3;
            }else {
                $data = $string;
                $pos = strpos($data, ';');
                $type = explode(':', substr($data, 0, $pos))[1];
                $extension = preg_split("[/]", $type);
                return $extension[1];
            }
        }else{
            return null;
        }
    }
    /**
     * permite eliminar una archivo en el directorio
     * @author foskert@gmail.com
     * @param String $document_path
     * @version 1.0
     */
    public function delete($document_path) {
        if(strpos(env('APP_URL'), "http") === false){
            $document_path = str_replace("https:\\".env('APP_URL'), "", $document_path);
        }

        $document_path = str_replace(env('APP_URL'), "", $document_path);
        //local
        if (File::exists(app()->basePath('public'.$document_path))) {
        //if (File::exists($document_path)) {
            //local
            if(unlink(app()->basePath('public'.$document_path))){
            //if(unlink($document_path)){
                return true;
            }else{
                return false;
            }
        }else{
            return true;
        }
    }
}
