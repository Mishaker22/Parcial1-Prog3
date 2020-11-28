<?php
namespace App\Models;

use App\Models\Comanda;
use Illuminate\Database\Eloquent\Model;
use App\Controller\ProductoController;

class Producto extends Model
{
     public $timestamps = false;
     public static function ValidarCampos($productos)
    { 
        $retorno=false;
        if(strlen($productos)>0)
        {
            $retorno=true;
        }
        return $retorno;
    }
    public static function HayCantidad($producto)
    {
        $retorno=false;
        
        if($producto->cantidad >0)
        {
            $producto->cantidad --;
            $producto->save();
            $retorno=true;
        }
        return $retorno;
    }
    public static function ExisteProducto($item)
    {
        $retorno=false;
        
        $producto=Producto::where('item', $item)
        ->first();
        if($producto!=null)
        {
            $retorno=true;
        }
        return $retorno;
    }
    public static function AsignarTiempoPreparacion($producto)
    {
        $alcohol=Producto::where('sector',1)->get();
        $cerveza=Producto::where('sector',2)->get();
        $comida=Producto::where('sector',3)->get();
        $postre=Producto::where('sector',4)->get();
        
    
        $retorno=null;
        foreach($alcohol as &$valor)
        {
            if($producto==$valor["item"])
            {
                $time='00:15:00';
                $retorno=$time;
            }
        }
        foreach($cerveza as &$valor)
        {
            if($producto==$valor["item"])
            {
                $time='00:05:00';
                $retorno=$time;
            }
        }
        foreach($comida as &$valor)
        {
    
            if($producto==$valor["item"])
            {
                $time='00:30:00';
                $retorno=$time;
            }
        }
        foreach($postre as &$valor)
        {
            if($producto==$valor["item"])
            {
                $time='00:15:00';
                $retorno=$time;
            }
        }
        
        return $retorno;
    }
    public static function CalcularPrecio($item)
    {
        $items=explode(";",$item);
        $precio=0;
        foreach ($items as &$value) {
            $productos=Producto::where('item',$value)->first();
            $precio+=$productos->precio;
        }
        return $precio;
    }
}

?>