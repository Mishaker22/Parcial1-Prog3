<?php

namespace App\Controller;

use App\Models\Cliente;
use Clases\Respuesta;
use Clases\Token;


class ClienteController
{
    public function Add($request, $response, $args)
    {
        $ArrayDeParametros = $request->getParsedBody();
        
        if(Cliente::ValidarCampos($ArrayDeParametros['email'], $ArrayDeParametros['usuario'])==true)
        {
            
            if(Cliente::EsUsuarioExistente($ArrayDeParametros['email'],$ArrayDeParametros['usuario'])==true)
            {
                $rta=Respuesta::MostrarRespuestas("ERROR", "El correo o el nombre ya existe" );
                $response->getBody()->write(json_encode($rta));
            }else
            {
                
                if(Cliente::is_valid_name($ArrayDeParametros['usuario'])==true)
                {
                    $rta=Respuesta::MostrarRespuestas("ERROR", "El nombre es invalido, no debe contener espacios" );
                    $response->getBody()->write(json_encode($rta));
                    
                }else{
                    if(Cliente::ValidarClave($ArrayDeParametros['clave'])==true)
                    {
                        $user=new Cliente;
                        $user->email=strtolower($ArrayDeParametros['email']);
                        $user->usuario=strtolower($ArrayDeParametros['usuario']);
                        $user->nombre=strtolower($ArrayDeParametros['nombre']);
                        $clave=Cliente::CodificarClave($ArrayDeParametros['clave']);
                        $user->clave=($clave); 
                        $rta = $user->save();
                        $response->getBody()->write(json_encode($rta));
                    }else
                    {
                        $rta=Respuesta::MostrarRespuestas("ERROR", "La clave debe tener por lo menos 4 caracteres" );
                        $response->getBody()->write(json_encode($rta));
                    }  
                }
                
            }
        }else
        {
            $rta=Respuesta::MostrarRespuestas("ERROR", "Debe completar los campos" );
            $response->getBody()->write(json_encode($rta));
        }
        
        return $response;
    }
    public function GetOne($request, $response, $args) 
    {
        $ArrayDeParametros = $request->getParsedBody();

        $user=Cliente::where('usuario', $ArrayDeParametros['email'])->first();
        $user2=Cliente::where('email',$ArrayDeParametros['email'])->first();
        
        if($user !=null)
        {   
            
            if(password_verify($ArrayDeParametros['clave'], $user['clave']))
            {
                
                $respuesta=new Respuesta();
                
                $payload = array(
                    "id" => $user->id,
                );
                $retorno = Token::CrearToken($payload);
                $rta=Respuesta::MostrarRespuestas($respuesta->estado, "Usuario:  $user Token: $retorno" ); 
            }else 
            {

                $rta=Respuesta::MostrarRespuestas("ERROR", "La clave no coincide" );
            }
                     
        }elseif($user2 !=null)
        {
            $clave=password_verify($ArrayDeParametros['clave'], $user2['clave']);
            
            if($clave)
            {
                $respuesta=new Respuesta();
                $payload = array(
                    "id" => $user2->id,
                    "tipo" => $user2->tipo,
                );
                $retorno = Token::CrearToken($payload);
                $rta=Respuesta::MostrarRespuestas($respuesta->estado, "Usuario:  $user2 Token: $retorno" ); 
            }else 
            {
                $rta=Respuesta::MostrarRespuestas("ERROR", "La clave no coincide" );
            }
        }
        else
        {
            $rta=Respuesta::MostrarRespuestas("Error", "Usuario no existente" );
        }
        $response->getBody()->write(json_encode($rta));

        return $response;
    }
    
}
?>