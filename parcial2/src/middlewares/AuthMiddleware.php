<?php

namespace App\Middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use App\Controller\MateriaController;
use Slim\Psr7\Response;
use Clases\Token;
use Clases\Respuesta;

class AuthMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler)
    {
        $token=$request->getHeader('token');
        $payload=Token::ValidarToken($token[0]);

        if($payload==null)
        {
            $response=new Response();
            $rta=array("rta"=>"No autorizado. ingrese un token valido");
            $response->getBody()->write(json_encode($rta));
            return $response;
        }else
        {
            
                $response = $handler->handle($request);
                $existingContent = (string) $response->getBody();
                $rta = new Response();
                $rta->getBody()->write($existingContent);
                return $rta;
            
            
        }
        
    }
}
?>