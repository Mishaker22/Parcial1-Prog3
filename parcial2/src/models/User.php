<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Controller\UserController;

class user extends Model
{
    public $timestamps = false;
    public static function CodificarClave($clave)
    {
        $claveCifrada=password_hash($clave, PASSWORD_DEFAULT);
        return $claveCifrada;
    }
    public static function EsUsuarioExistente($email, $nombre)
    {
        $retorno=false;
        $user=User::where('email', $email)->first();
        $user1=User::where('nombre',$nombre)->first();

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
    function is_valid_name($name)
    {
        return (false !== strpos($name, " "));
        //return (false !== filter_var($str, FILTER_VALIDATE_EMAIL));
    }
    public static function ValidarCampos($email, $nombre)
    { 
        $retorno=false;
        if(strlen($email)>3 && strlen($nombre)>3)
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
}
?>