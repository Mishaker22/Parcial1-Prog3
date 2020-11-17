<?php

namespace App\Controller;

use App\Models\Materia;
use Clases\Respuesta;
use Clases\Token;


class MateriaController
{
    public function GetAll($request, $response, $args) {

        $rta=Materia::where('id','>',0)->get();
        $response->getBody()->write(json_encode($rta));
        return $response;
    }
    public function GetOne($request, $response, $args) 
    {
        $ArrayDeParametros = $request->getParsedBody();

        $user=User::where('legajo', $ArrayDeParametros['legajo'])
        ->where('email',$ArrayDeParametros['email'])
        ->get();
        if($user)
        {
            $respuesta=new Respuesta();
            $payload = array("legajo" => $ArrayDeParametros['legajo']);
            $retorno = Token::CrearToken($payload);
            $rta=Respuesta::MostrarRespuestas($respuesta->estado, "Usuario:  $user Token: $retorno" );
        }

        $response->getBody()->write(json_encode($rta));
        return $response;
    }
    
    public function Add($request, $response, $args)
    {
        $ArrayDeParametros = $request->getParsedBody();
        
        if(Materia::ValidarCampos($ArrayDeParametros)==false)
        {
            $rta=Respuesta::MostrarRespuestas("ERROR", "Debe completar los campos" );
            $response->getBody()->write(json_encode($rta));
        }else
        {
            if(Materia::ValidarCuatrimestre($ArrayDeParametros['cuatrimestre'])==true)
            {
                $materia=new Materia;
                $materia->nombre=$ArrayDeParametros['materia'];
                $materia->cuatrimestre=$ArrayDeParametros['cuatrimestre'];
                $materia->cupos=$ArrayDeParametros['cupos'];  
                $rta = $materia->save();
                $response->getBody()->write(json_encode($rta));
            }else {
                $rta=Respuesta::MostrarRespuestas("ERROR", "Cuatrimestre invalido debe ingresar 1,2,3 o 4" );
                $response->getBody()->write(json_encode($rta));
            }
            
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