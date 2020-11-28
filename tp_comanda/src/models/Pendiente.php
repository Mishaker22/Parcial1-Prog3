<?php
namespace App\Models;

use App\Models\Employee;
use App\Models\Producto;
use Clases\Respuesta;
use Illuminate\Database\Eloquent\Model;

class Pendiente extends Model{

    public $timestamps = false;

    public static function AsignarProducto($producto)
    {
        if(Pendiente::SepararProductosPorSector($producto)!=null)
        {
            $aux=Pendiente::SepararProductosPorSector($producto);
            
            $pendientes=new Pendiente;
            $pendientes->id_item=$aux["id"];
            $empleado=Pendiente::AsignarEmpleado($aux["sector"]);
            $pendientes->id_empleado=$empleado;
            $pendientes->estado="PENDIENTE";
            $pendientes->save();
        }
    }
    public static function AsignarEmpleado($sector)
    {
        switch ($sector) {
            case 1: 
                $bartender=Employee::where('tipo',"bartender")->get();
                if($bartender!=null)
                {
                    if(count($bartender)>1)
                    {
                        foreach ($bartender as &$value) {
                            $arrayBartender[]=$value;   
                        }
                        $seleccion=$arrayBartender[array_rand($arrayBartender)];
                        $bartender=Employee::where('id',$seleccion['id'])->first();
                        $bartender->operaciones=$bartender->operaciones+1;
                        $bartender->save();
                        $retorno=$seleccion["id"];
                    }else{
                        $bartender=Employee::where('tipo',"bartender")->first();
                        $bartender->operaciones=$bartender->operaciones+1;
                        $bartender->save();
                        $retorno=$bartender["id"];
                    }
                }else
                {
                    $rta=Respuesta::MostrarRespuestas("ERROR", "No hay bartender en la base de datos" );
                    $retorno=$rta;
                }
            break;
            case 2:
                $cervecero=Employee::where('tipo',"cervecero")->get();
                if($cervecero!=null)
                {
                    if(count($cervecero)>1)
                    {
                        foreach ($cervecero as &$value) {
                            $arrayCervecero[]=$value;   
                        }
                        $seleccion=$arrayCervecero[array_rand($arrayCervecero)];
                        $cervecero=Employee::where('id',$seleccion['id'])->first();
                        $cervecero->operaciones=$cervecero->operaciones+1;
                        $cervecero->save();
                        $retorno=$seleccion["id"];
                    }else{
                        $cervecero=Employee::where('tipo',"cervecero")->first();
                        $cervecero->operaciones=$cervecero->operaciones+1;
                        $cervecero->save();
                        $retorno=$cervecero["id"];
                    }
                }else
                {
                    $rta=Respuesta::MostrarRespuestas("ERROR", "No hay cerveceros en la base de datos" );
                    $retorno=$rta;
                }
            break;
            case 3:
                $cocinero=Employee::where('tipo',"cocinero")->get();
                if($cocinero!=null)
                {
                    if(count($cocinero)>1)
                    {
                        foreach ($cocinero as &$value) {
                            $arraycocinero[]=$value;   
                        }
                        $seleccion=$arraycocinero[array_rand($arraycocinero)];
                        $cocinero=Employee::where('id',$seleccion['id'])->first();
                        $cocinero->operaciones=$cocinero->operaciones+1;
                        $cocinero->save();
                        $retorno=$seleccion["id"];
                    }else{
                        $cocinero=Employee::where('tipo',"cocinero")->first();
                        $cocinero->operaciones=$cocinero->operaciones+1;
                        $cocinero->save();
                        $retorno=$cocinero["id"];
                    }
                }else
                {
                    $rta=Respuesta::MostrarRespuestas("ERROR", "No hay cocineros en la base de datos" );
                    $retorno=$rta;
                }
            
            break;
            case 4:
                $cocinero=Employee::where('tipo',"cocinero")->get();
                if($cocinero!=null)
                {
                    if(count($cocinero)>1)
                    {
                        foreach ($cocinero as &$value) {
                            $arraycocinero[]=$value;   
                        }
                        $seleccion=$arraycocinero[array_rand($arraycocinero)];
                        $cocinero=Employee::where('id',$seleccion['id'])->first();
                        $cocinero->operaciones=$cocinero->operaciones+1;
                        $cocinero->save();
                        $retorno=$seleccion["id"];
                    }else{
                        $cocinero=Employee::where('tipo',"cocinero")->first();
                        $cocinero->operaciones=$cocinero->operaciones+1;
                        $cocinero->save();
                        $retorno=$cocinero["id"];
                    }
                }else
                {
                    $rta=Respuesta::MostrarRespuestas("ERROR", "No hay cocineros en la base de datos" );
                    $retorno=$rta;
                }
            break;
        }
        return $retorno;
    }
    public static function SepararProductosPorSector($producto)
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
                $aux=Producto::find($valor["id"]);
                $retorno=$aux;
            }
        }
        foreach($cerveza as &$valor)
        {
            if($producto==$valor["item"])
            {
                $retorno=$valor;
            }
        }
        foreach($comida as &$valor)
        {
    
            if($producto==$valor["item"])
            {
                $aux=Producto::find($valor["id"]);
                $retorno=$aux;
            }
        }
        foreach($postre as &$valor)
        {
            if($producto==$valor["item"])
            {
                $retorno=$valor;
            }
        }
        
        return $retorno;
    }
    
}