<?php
//include '../clases/usuario.php';
use \Firebase\JWT\JWT;
Use App\Middlewares\AuthMiddleware;
Use App\Middlewares\JsonMiddleware;
Use App\Middlewares\TiposMiddleware;
Use App\Middlewares\AdminMiddleware;
Use App\Middlewares\ClienteMiddleware;
Use App\Middlewares\PreparadoresMiddleware;
Use App\Middlewares\MeseroMiddleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Slim\Exception\HttpNotFoundException;
use Slim\Middleware\ErrorMiddleware;
use App\Controller\ComandaController;
use App\Controller\EmployeeController;
use App\Controller\ClienteController;

use Config\Database;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();
$app->setBasePath("/tp_comanda/public");

//$app->addRoutingMiddleware();
new Database; 

$app->group('/staff_registro', function (RouteCollectorProxy $group) {
    $group->post('[/]', EmployeeController::class .":Add")->add(new TiposMiddleware);
});
$app->group('/clientes_registro', function (RouteCollectorProxy $group) {
    $group->post('[/]', ClienteController::class .":Add");
});

//$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$app->group('/login_staff', function (RouteCollectorProxy $group) {
    $group->post('[/]', EmployeeController::class .":GetOne");
    $group->delete('/{id}', EmployeeController::class .":Delete")->add(new AdminMiddleware);
});
$app->group('/login_cliente', function (RouteCollectorProxy $group) {
    $group->post('[/]', ClienteController::class .":GetOne");
});
$app->group('/pendientes', function (RouteCollectorProxy $group) {
    $group->get('[/]', ComandaController::class .":GetAllPendientes")->add(new PreparadoresMiddleware);
})->add(new AuthMiddleware);

$app->group('/alto_pedido', function (RouteCollectorProxy $group) {
    $group->post('[/{id}]', ComandaController::class .":Add")->add(new MeseroMiddleware); 
})->add(new AuthMiddleware);

$app->group('/preparar_pedido', function (RouteCollectorProxy $group) {
    $group->post('/{id_pedido}', comandaController::class .":PrepararPedido")->add(new MeseroMiddleware); 
    
})->add(new AuthMiddleware);

$app->group('/listo_para_servir', function (RouteCollectorProxy $group) {
    $group->post('/{id_pedido}', comandaController::class .":ListoParaServir")->add(new PreparadoresMiddleware);
    
})->add(new AuthMiddleware);
$app->group('/get_all_socios', function (RouteCollectorProxy $group) {
    $group->get('[/]', comandaController::class .":GetAllSocios")->add(new AdminMiddleware);
    
})->add(new AuthMiddleware);
$app->group('/get_one_cliente', function (RouteCollectorProxy $group) {
    $group->get('/{codigo_mesa}/{codigo_pedido}', comandaController::class .":GetOneCliente");
    
})->add(new AuthMiddleware);
$app->group('/cobrar_mesa', function (RouteCollectorProxy $group) {
    $group->post('/{codigo_mesa}', comandaController::class .":CobrarMesa")->add(new MeseroMiddleware);
    
})->add(new AuthMiddleware);
$app->group('/cerrar_mesa', function (RouteCollectorProxy $group) {
    $group->post('/{codigo_mesa}', comandaController::class .":CerrarMesa")->add(new AdminMiddleware);
    
})->add(new AuthMiddleware);

$app->add(new JsonMiddleware);
$app->addBodyParsingMiddleware();
$app->run();


?>