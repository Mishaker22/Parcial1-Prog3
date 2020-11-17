<?php

namespace App\Controller;

use App\Models\Nota;
use App\Models\Materia;
use App\Models\User;
use Clases\Respuesta;
use Clases\Token;


class NotaController
{
    public function Update($request, $response, $args)
    {
        $id=$args['id'];
        $materia=Materia::find($id);
        $ArrayDeParametros = $request->getParsedBody();
        $alumno=User::find($ArrayDeParametros['idAlumno']);

        $token=$request->getHeader('token');
        $payload=Token::ValidarToken($token[0]);
        if($payload!=null)
        {
            $docente=$payload->id;
        }else{
            $response->getBody()->write(json_encode("No existe el token"));
        }
        
        if($materia!=null)
        {
            if($alumno!=null)
            {
                if(Nota::ValidarNota($ArrayDeParametros['nota'])==true)
                {
                    $nota=new Nota;
                    $nota->id_profesor=$docente;
                    $nota->id_alumno=$ArrayDeParametros['idAlumno'];
                    $nota->id_materia=$materia->id;
                    $nota->nota=$ArrayDeParametros['nota'];
                    $rta=$nota->save();
                    $response->getBody()->write(json_encode($rta));
                }else
                {
                    $rta=Respuesta::MostrarRespuestas("ERROR", "Nota fuera de rango" );
                    $response->getBody()->write(json_encode($rta));
                }
                
            }else
            {
                $rta=Respuesta::MostrarRespuestas("ERROR", "Alumno no existente" );
                $response->getBody()->write(json_encode($rta));
            }
        }else
        {
            $rta=Respuesta::MostrarRespuestas("ERROR", "La materia no existe" );
            $response->getBody()->write(json_encode($rta));
        }

    
        return $response;
    }
    public function GetAll($request, $response, $args) {

        $id=$args['id'];
        $rta=Nota::where('id_materia', $id)->get();
        $materia=Materia::where('id', $id)->first();
        if($materia!=null)
        {
            if(count($rta)>0)
            {
                $response->getBody()->write(json_encode($rta));
            }else
            {
                $rta=Respuesta::MostrarRespuestas("ERROR", "No hay notas en esta materia" );
                $response->getBody()->write(json_encode($rta));
            }
        }else
        {
            $rta=Respuesta::MostrarRespuestas("ERROR", "La materia no existe" );
            $response->getBody()->write(json_encode($rta));
        }
        return $response;
    }
}
?>