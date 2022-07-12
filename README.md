## Esqueleto para la construcción de APIS

## Versión

Laravel: 8 (framework)

PHP: 7.4

DockerFile:

    - Servidor: NGinx
    - SO: Alpine 3.13
    - Almacenamiento: public/images (permisos 777)

## Comando

> `php artisan generator:crud Model`

genera el Controlador, Repositorio, Servicio, Modelo y las Rutas necesarias para el CRUD. Existen dos formas de borrado, el método `_delete` hace un borrado lógico (es necesario el campo "deleted" en la tabla) y el método `_destroy` que hace un borrado físico del registro.

Todos los Modelos estan creados con el GlobalScope `DeletedScope` que trae exclusivamente los modelos que estan sin borrado lógico.

## Pasos para actualizar un proyecto previo de Lumen a Laravel

1. Clonar el repositorio
2. En el repositorio clonado, eliminar la carpeta `.git`.
3. Copiar la carpeta `.git` del proyecto que se a actualizar al repositorio clonado.
4. Copiar el archivo `.gitlab-ci.yml` del proyecto que se va a actualizar al repositorio clonado.
5. Reemplazar las carpetas `App\Repositories`, `App\Services`, `App\Models`, `database\migrations` por las correspondientes (Si se tienen otras carpetas para reemplazar se puede hacer, teniendo mucho cuidado de no interferir en la lógica, NO MOVER CARPETAS)
6. Copiar todo el contenido del archivo de rutas del proyecto a actualizar y pegarlo en el archivo `routes\api.php`. Se deben de cambiar todas las rutas al formato de Laravel:

```php
//Todo lo que está como
$router-> 
// Se sustituye por
Route::
-----------
//Los middleware, prefix, namespace y demás 
$router->group(['prefix' => 'api'], function (Router $router) {
    $router->get(.....);
});
// se debe reemplazar de la siguiente manera
Route::prefix('api')->group(function(){
    Router::get(.....);
})
// Esto se aplica también a las rutas con Middleware, namespace y demás

----------
//Los punteros a los controladores deben de cambiarse
$router->get('news', 'News\NewsController@_index');
//por
Route::get('news', [App\Http\Controllers\News\NewsController::class, '_index']);
//También funciona con
use App\Http\Controllers\News\NewsController;
...
Route::get('news', [NewsController::class, '_index'])
```
