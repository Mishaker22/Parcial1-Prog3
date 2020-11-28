<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Pedido extends Model{

    public $timestamps = false;

    public static function generarCodigo(){
        return substr(md5(time()),0,5);
    }

    public static function ValidarEstadoPendiente($estado)
    {
        $retorno=false;
        if($estado=="PENDIENTE")
        {
            $retorno=true;
        }
        return $retorno;
    }
    public static function ValidarEstadoPreparacion($estado)
    {
        $retorno=false;
        if($estado=="EN PREPARACION")
        {
            $retorno=true;
        }
        return $retorno;
    }
    
}