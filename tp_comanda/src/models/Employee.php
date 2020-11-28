<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Controller\EmployeeController;

class Employee extends Model
{
    public $timestamps = false;
    public static function CodificarClave($clave)
    {
        $claveCifrada=password_hash($clave, PASSWORD_DEFAULT);
        return $claveCifrada;
    }
    public static function EsUsuarioExistente($email, $users)
    {
        $retorno=false;
        $user=Employee::where('email', $email)->first();
        $user1=Employee::where('usuario',$users)->first();

        if ($user) 
        {
            $retorno=true;
        }
        if($user1)
        {
            $retorno=true;
        }
        return $retorno;
    }
    function is_valid_name($user)
    {
        return (false !== strpos($user, " "));
        //return (false !== filter_var($str, FILTER_VALIDATE_EMAIL));
    }
    public static function ValidarCampos($email, $user)
    { 
        $retorno=false;
        if(strlen($email)>3 && strlen($user)>3)
        {
            $retorno=true;
        }
        return $retorno;
    }
    public static function ValidarClave($clave)
    { 
        $retorno=false;
        if (strlen($clave)>=4)
        {
            $retorno=true;
        }
        return $retorno;
    }
    public static function AsignarSector($tipo)
    {
       switch($tipo)
       {
           case "cocinero":
            $sector=3;
           break;
           case "bartender":
            $sector=1;
           break;
           case "cervecero":
            $sector=2;
           break;
           case "socio":
            $sector=5;
           break;
           case "mozo":
            $sector=6;
           break;
       }
       return $sector;
    }
}
?>