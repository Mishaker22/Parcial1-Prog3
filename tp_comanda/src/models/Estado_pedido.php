<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Estado_pedido extends Model{

    public $timestamps = false;
    public static function ValidarEstadosPreparacion($estado)
    {
        $retorno=false;
        if($estado=="EN PREPARACION")
        {
            $retorno=true;
        }
        return $retorno;
    }
    
    
}