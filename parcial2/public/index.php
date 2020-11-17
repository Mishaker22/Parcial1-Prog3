<?php
//include '../clases/usuario.php';
use \Firebase\JWT\JWT;
Use App\Middlewares\AuthMiddleware;
Use App\Middlewares\JsonMiddleware;
Use App\Middlewares\TiposMiddleware;
Use App\Middlewares\AdminMiddleware;
Use App\Middlewares\DocenteMiddleware;
Use App\Middlewares\DirectivasMiddleware;
Use App\Middlewares\AlumnoMiddleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Slim\Exception\HttpNotFoundException;
use Slim\Middleware\ErrorMiddleware;
use App\Controller\MateriaController;
use App\Controller\UserController;
use App\Controller\NotaController;
use App\Controller\InscripcionController;

use Config\Database;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();
$app->setBasePath("/parcial2/public");

//$app->addRoutingMiddleware();
new Database; 

$app->group('/users', function (RouteCollectorProxy $group) {
    $group->post('[/]', UserController::class .":Add")->add(new TiposMiddleware);
    $group->get('/{id}[/{edad}]', UserController::class .":GetOne");
    $group->get('[/]', UserController::class .":GetAll");
    $group->put('/{id}', UserController::Class .":Update");
    $group->delete('/{id}', UserController::class .":Delete"); 
});//->add(new UserMiddleware)->add(new AuthMiddleware);
//$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$app->post('[/login]', UserController::class .":GetOne");
$app->add(new JsonMiddleware);

$app->group('/materia', function (RouteCollectorProxy $group) {
    $group->post('[/]', MateriaController::class .":Add")->add(new AdminMiddleware);
    $group->get('[/]', MateriaController::class .":GetAll");
    $group->put('/{id}', UserController::Class .":Update");
    $group->delete('/{id}', UserController::class .":Delete"); 
})->add(new AuthMiddleware);

$app->group('/inscripcion', function (RouteCollectorProxy $group) {
    $group->post('/{id}', InscripcionController::class .":Add")->add(new AlumnoMiddleware);
    $group->get('/{id}', InscripcionController::class .":GetAll")->add(new DirectivasMiddleware);
    
})->add(new AuthMiddleware);

$app->group('/notas', function (RouteCollectorProxy $group) {
    $group->put('/{id}', NotaController::class .":Update")->add(new DocenteMiddleware);
    $group->get('/{id}', NotaController::class .":GetAll");
    
})->add(new AuthMiddleware);

$app->add(new JsonMiddleware);
$app->addBodyParsingMiddleware();
$app->run();


?>