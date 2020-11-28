<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Controller\ClienteController;

class Cliente extends Model
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
        $user=Cliente::where('email', $email)->first();
        $user1=Cliente::where('usuario',$users)->first();

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
}
?>