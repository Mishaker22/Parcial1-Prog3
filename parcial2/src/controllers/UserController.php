<?php

namespace App\Controller;

use App\Models\User;
use Clases\Respuesta;
use Clases\Token;


class UserController
{
    public function GetAll($request, $response, $args) {
        //$rta=User::get();//trae todos
        //$rta=User::find(2);//trae uno
        $rta=User::where('id','>',0)->first();//o get()
        $response->getBody()->write(json_encode($rta));
        return $response;
    }
    public function GetOne($request, $response, $args) 
    {
        $ArrayDeParametros = $request->getParsedBody();

        $user=User::where('nombre', $ArrayDeParametros['email'])->first();
        $user2=User::where('email',$ArrayDeParametros['email'])->first();
        
        if($user !=null)
        {   
            
            if(password_verify($ArrayDeParametros['clave'], $user['clave']))
            {
                
                $respuesta=new Respuesta();
                
                $payload = array(
                    "id" => $user->id,
                    "tipo" => $user->tipo,
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
    
    public function Add($request, $response, $args)
    {
        $ArrayDeParametros = $request->getParsedBody();
        
        if(User::ValidarCampos($ArrayDeParametros['email'], $ArrayDeParametros['nombre'])==true)
        {
            
            if(User::EsUsuarioExistente($ArrayDeParametros['email'],$ArrayDeParametros['nombre'])==true)
            {
                $rta=Respuesta::MostrarRespuestas("ERROR", "El correo o el nombre ya existe" );
                $response->getBody()->write(json_encode($rta));
            }else
            {
                
                if(User::is_valid_name($ArrayDeParametros['nombre'])==true)
                {
                    $rta=Respuesta::MostrarRespuestas("ERROR", "El nombre es invalido, no debe contener espacios" );
                    $response->getBody()->write(json_encode($rta));
                    
                }else{
                    if(User::ValidarClave($ArrayDeParametros['clave'])==true)
                    {
                        $user=new User;
                        $user->email=strtolower($ArrayDeParametros['email']);
                        $user->nombre=strtolower($ArrayDeParametros['nombre']);
                        $clave=User::CodificarClave($ArrayDeParametros['clave']);
                        $user->clave=($clave);
                        $user->tipo=strtolower($ArrayDeParametros['tipo']);  
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
    public function Update($request, $response, $args) {
        $id=$args['id'];
        $user=User::find($id);

        $user->Nombre="Ras18";
        $user->tipo="Admon";

        $rta=$user->save();
        $response->getBody()->write(json_encode($rta));
        return $response;
    }
    public function Delete($request, $response, $args) {
        $id=$args['id'];
        $user=User::find($id);

        $rta=$user->delete();
        $response->getBody()->write(json_encode($rta));
    
        return $response;
    }
}
?>