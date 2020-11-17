<?php

namespace App\Controller;

use App\Models\Inscripcion;
use App\Models\Materia;
use App\Models\User;
use Clases\Respuesta;
use Clases\Token;


class InscripcionController
{
    public function Add($request, $response, $args)
    {
        $id=$args['id'];
        $materia=Materia::find($id);

        $token=$request->getHeader('token');
        $payload=Token::ValidarToken($token[0]);
        if($payload!=null)
        {
            $alumno=$payload->id;
        }else{
            $response->getBody()->write(json_encode("No existe el token"));
        }
        
        if($materia!=null)
        {
            if(Inscripcion::HayCupos($materia)==true)
            {
                $inscripcion=new Inscripcion;
                $inscripcion->id_alumno=$alumno;
                $inscripcion->id_materia=$materia->id;
             
                $rta = $inscripcion->save();
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
        $rta=Inscripcion::where('id_materia', $id)
        ->get();

        $materia=Materia::where('id', $id)
        ->first();

        if($materia!=null)
        {
            if(count($rta)>0 )
            {
                $response->getBody()->write(json_encode($rta));
            }else
            {
                $rta=Respuesta::MostrarRespuestas("ERROR", "No hay alumnos inscriptos" );
                $response->getBody()->write(json_encode($rta));
            }
        }else
        {
            $rta=Respuesta::MostrarRespuestas("ERROR", "No existe la materia" );
            $response->getBody()->write(json_encode($rta));
        }

        return $response;
    }
}
?>