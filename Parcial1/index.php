<?php

require_once '../Parcial1/registro.php';
require_once '../Parcial1/respuestas.php';
require_once '../Parcial1/token.php';
require_once '../Parcial1/auto.php';

$method=$_SERVER['REQUEST_METHOD'];
$path=$_SERVER['PATH_INFO']??0;
$respuesta=new Respuesta();
try
{
    $auxPath = explode('/', $path)[1];
        switch('/' . $auxPath)
    {
        case '/registro':
            switch($method)
            {
                case 'POST':
                    $correo=$_POST['email'] ?? null;
                    $contraseña=$_POST['password']?? null;
                    $tipo=$_POST['tipo']?? null;
                    $imagen=$_FILES["imagen"]['name']??null;
                    $temp=$_FILES["imagen"]["tmp_name"]??null;
                    
                    if(isset($correo)&& isset($contraseña) && strlen($correo)>0 && strlen($contraseña)>0 && strlen($tipo)>0)
                    {
                        $usuario= new Registro($correo,$contraseña,$imagen,$tipo);
    
                
                            if(Registro::ValidarUsuarioRepetido($correo))
                            {
            
                                Respuesta::MostrarRespuestas("ERROR", "Usuario Repetido!. El Usuario ya fue registrado"); 
                            }
                            else
                            {
                                include_once("upload.php"); 
                                $subir = new Upload;
                                $usuario->imagen=$subir->init($imagen,$temp);
                                echo "imagen ",$usuario->imagen," ";
                                $rta=$usuario->Save($correo,$contraseña,$usuario->imagen,$tipo);
                                Respuesta::MostrarRespuestas($respuesta->estado, "Se guardo el archivo con exito"); 
                            }
                                      
                    }elseif(isset($imagen))
                    {
                        if($email=explode('/', $path)[2])
                        {
                            
                            if(Registro::ValidarUsuarioRepetido($email))
                            {
                                include_once("upload.php"); 
                                $obj=Registro::DevolverUsuario($email);
                                $subir = new Upload();
                                $obj->imagen =$subir->Move();
                                $obj->imagen=$subir->init($imagen, $temp);
                                $modUser=new Registro($obj->email,$obj->clave,$obj->imagen);
                                $rta=$modUser->Save($obj->email,$obj->clave,$obj->imagen);
                                Respuesta::MostrarRespuestas($respuesta->estado, "Se guardo el archivo con exito la nueva foto");
                            }
                        }else {
                            Respuesta::MostrarRespuestas("ERROR", "Debe cargar el correo en el path");
                        }
                        
                    }
                    else
                    {
                        Respuesta::MostrarRespuestas("ERROR"," Debe completar los campos");
                    }
                    
                    

                break;
                default:
                Respuesta::MostrarRespuestas("ERROR"," Metodo Invalido");
                break;
            }
        break;
        
        case '/login':
        
            switch($method)
            {
                case 'POST':
                    $correo=$_POST['email'] ?? null; 
                    $contraseña= $_POST['password'] ?? null; 
                    
                    if(isset($correo)&& isset($contraseña) && strlen($correo)>0 && strlen($contraseña)>0)
                    {
                        $rta=Registro::ValidarUsuario($correo,$contraseña);
                        $tipo=Registro::GetTipoUsuario($correo);
                        Respuesta::MostrarRespuestas($respuesta->estado,"Bienvenido: $tipo Token: $rta");
                    }else
                    {
                        Respuesta::MostrarRespuestas("ERROR"," Debe completar los campos");
                    }
                break;
                default:
                    Respuesta::MostrarRespuestas("ERROR"," Metodo Invalido");
                break;
            }
        break;
        case '/ingreso':
            switch($method)
            {
                case 'POST':
                    if (Registro::ValidarTipoUsuario('user')) 
                    {
                        $headers=getallheaders();
                        $patente=$_POST['patente']?? null;
                        $Token=$headers["token"]??"";
                        $payload = Token::ValidarToken($Token);
                        if(isset($patente)&&strlen($patente)>0)
                        {
                            $auto=new Auto($patente, time(), $payload);
                            $rta=$auto->Save($patente);
                            Respuesta::MostrarRespuestas($respuesta->estado, "Se guardo el archivo con exito");
                        }
                    }
                break;
                case 'GET':

                    $headers=getallheaders();
                    $Token=$headers["token"]??"";
                    $payload = Token::ValidarToken($Token);

                    if($payload !=null)
                    {
                        Archivos::MostrarListasFormatoJson("archivosGuardados/autos.json");
                    }else 
                    {
                        Respuesta::MostrarRespuestas("ERROR", " Token Invalido!!");
                    }
                break;
                default:
                Respuesta::MostrarRespuestas("ERROR", " Metodo Invalido");
                break;
            }  
        break;
        case '/retiro':
            switch($method)
            {
                case 'POST':

                    $headers=getallheaders();
                    $nombreDocente=$_POST['nombre']?? null;
                    $legajo=$_POST['legajo']?? null;
                    $Token=$headers["token"]??"";
                    $payload = Token::ValidarToken($Token);

                    if($payload !=null)
                    {
                        if(isset($nombreDocente) && isset($legajo) && strlen($nombreDocente)>0 && strlen($legajo)>0)
                        {
                            $nuevoDocente=new Profesor($nombreDocente,$legajo);
                            if(Profesor::ValidarLegajoRepetido($legajo)==false)
                            {
                                $rta=$nuevoDocente->Save();
                                Respuesta::MostrarRespuestas($respuesta->estado, "Se guardo el archivo con exito");
                            }
                            else
                            {
                                Respuesta::MostrarRespuestas("ERROR"," Legajo repetido, Intente con otro");
                            }
                        }else 
                        {
                            Respuesta::MostrarRespuestas("ERROR"," Debe completar los campos");
                        }
                    }else {
                        Respuesta::MostrarRespuestas("ERROR"," Token Invalido!!");
                    }
                break;
                case 'GET':
                    $headers=getallheaders();
                    $Token=$headers["token"]??"";
                    $payload = Token::ValidarToken($Token);

                    if($payload !=null)
                    {
                        Archivos::MostrarListasFormatoJson("archivosGuardados/profesor.json");
                        
                    }else 
                    {
                        Respuesta::MostrarRespuestas("ERROR"," Token Invalido!!");
                    }
                break;
                default:
                Respuesta::MostrarRespuestas("ERROR", " Metodo Invalido");
                break;
            }  
        break;  
        case '/asignacion':
            switch($method)
            {
                case 'POST':

                    $headers=getallheaders();
                    $LegajoDocente=$_POST['legajo']?? null;
                    $idMateria=$_POST['id']?? null;
                    $turno=$_POST['turno']?? null;
                    strtolower($turno);
                    $Token=$headers["token"]??"";
                    $payload = Token::ValidarToken($Token);
                    
                    if($payload != null)
                    {
                        if(isset($LegajoDocente)&& isset($idMateria) && isset($turno) && strlen($LegajoDocente)>0 && strlen($idMateria)>0 && strlen($turno)>0)
                        {
                            if(Asignacion::AsignarTurno($turno))
                            {
                                if(Profesor::ValidarLegajoRepetido($LegajoDocente)&& Materia::ValidarMateriaRepetida($idMateria))
                                {
                                    $asignacion=new Asignacion($LegajoDocente,$idMateria,$turno);
                                    if(Asignacion::ValidarAsignacionRepetida($asignacion)==false)
                                    {
                                        $rta=$asignacion->Save();
                                        Respuesta::MostrarRespuestas($respuesta->estado, "Se guardo el archivo con exito");
                                    }else
                                    {
                                        Respuesta::MostrarRespuestas("ERROR","No se puede guardar el mismo profesor, con la misma materia y turno");
                                    }
                                }else
                                {
                                    Respuesta::MostrarRespuestas("ERROR","El profesor o la materia no existen!");
                                }
                            }else {
                                
                                Respuesta::MostrarRespuestas("ERROR","Turnos: mañana/noche");
                            }
                        }else {
                            
                            Respuesta::MostrarRespuestas("ERROR","Debe completar los campos");
                        }
                    }else
                    {
                        Respuesta::MostrarRespuestas("ERROR"," Token Invalido!!");
                    }
                break;
                case 'GET':
                    $headers=getallheaders();
                    $Token=$headers["token"]??"";
                    $payload = Token::ValidarToken($Token);

                    if($payload !=null)
                    {
                        Archivos::MostrarListasFormatoJson("archivosGuardados/materias-profesores.json");
                    }else 
                    {
                        Respuesta::MostrarRespuestas("ERROR"," Token Invalido!!");
                    }
                break;
                default:
                Respuesta::MostrarRespuestas("ERROR", " Metodo Invalido");
                break;

            }
        break;
        default:
        Respuesta::MostrarRespuestas("ERROR", " La ruta no existe");
        break;
        
    }
}catch(Exception $e){

}



?>