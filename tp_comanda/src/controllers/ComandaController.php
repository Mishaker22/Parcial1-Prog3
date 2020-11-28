<?php

namespace App\Controller;

use App\Models\Comanda;
use App\Models\Employee;
use App\Models\Producto;
use App\Models\Pedido;
use App\Models\Pendiente;
use App\Models\Estado_pedido;
use App\Models\Mesa;
use App\Models\Cliente;
use Clases\Respuesta;
use Clases\Token;


class ComandaController
{
    public function Add($request, $response, $args)
    {
        $id=$args['id'];
        $cliente=Cliente::find($id);
        $ArrayDeParametros = $request->getParsedBody();

        $token=$request->getHeader('token');
        $payload=Token::ValidarToken($token[0]);
        if($payload!=null)
        {
            $alumno=$payload->id;
        }else{
            $response->getBody()->write(json_encode("No existe el token"));
        }
        $mesaDisponible = Mesa::where('id_estado',5)->first();
        $meseros = Employee::where('tipo',"mozo")->get();
        
        if(count($meseros)>1)
        {
            foreach ($meseros as &$value) {
                $arrayMeseros[]=$value;   
            }
            $mesero=$arrayMeseros[array_rand($arrayMeseros)];
           
        }else
        {
            $mesero = Employee::where('tipo',"mozo")->first();
        }
        if($cliente!=null)
        {
            if($mesaDisponible!=null)
            {
                if($mesero!=null)
                {
                    foreach ($ArrayDeParametros as &$valor) {
                        $producto = Producto::where('item',$valor)->first();
                        if($rta0=Producto::ValidarCampos($valor)==false)
                        {
                            $rta=Respuesta::MostrarRespuestas("ERROR", "debe completar los campos" );
                            $response->getBody()->write(json_encode($rta));
                        }else
                        {
                            if($rta1=Producto::ExisteProducto($valor)==false)
                            {
                                $rta=Respuesta::MostrarRespuestas("ERROR", "El producto $valor No existe en la base de datos" );
                                $response->getBody()->write(json_encode($rta));     
                            }else{
                                if($rta2=Producto::HayCantidad($producto)==false)
                                {
                                    $rta=Respuesta::MostrarRespuestas("ERROR", "ya no hay unidades" );
                                    $response->getBody()->write(json_encode($rta));
                                }else{
                                    Pendiente::AsignarProducto($valor);
                                }
                            }
                        }
                    }
                    
                    if($rta0==false)
                    {
                        if($rta1==false)
                        {
                            if($rta2==false)
                            {
                                
                                $mesero->operaciones=$mesero->operaciones+1;
                                $mesero->save();
                                $mesaDisponible->id_estado=1;
                                $mesaDisponible->save();
                                $pedido=new Pedido;
                                $codigo=Pedido::GenerarCodigo();
                                $pedido->id_cliente=$cliente->id;
                                $pedido->id_mesero=$mesero->id;
                                foreach ($ArrayDeParametros as  &$value) {
                                    $arrayItems[]=$value;
                                }
                                $cadenaItems=implode(";",$arrayItems);
                                $pedido->items=$cadenaItems;
                                $pedido->codigo_mesa=$mesaDisponible->codigo;
                                $pedido->codigo_pedido=$codigo;
                                $pedido->estado="PENDIENTE";
                                $rta=$pedido->save();
                                $rta=Respuesta::MostrarRespuestas("Exitoso", "codigo de pedido: $codigo codigo de mesa: $mesaDisponible->codigo " );
                                $response->getBody()->write(json_encode($rta));
                            }
                        }
                    }
                }else
                {
                    $rta=Respuesta::MostrarRespuestas("ERROR", "El mesero no existe" );
                    $response->getBody()->write(json_encode($rta));
                }
            }else{
                $rta=Respuesta::MostrarRespuestas("ERROR", "No hay mesas disponibles" );
                $response->getBody()->write(json_encode($rta));
            }
        }else
        {
            $rta=Respuesta::MostrarRespuestas("ERROR", "El cliente no esta registrado" );
            $response->getBody()->write(json_encode($rta));
        }
        
    
        return $response;
    }
    public function PrepararPedido($request, $response, $args)
    {
        $id=$args['id_pedido'];
        $pedido=Pedido::find($id);

        $ArrayDeParametros = $request->getParsedBody();

        $token=$request->getHeader('token');
        $payload=Token::ValidarToken($token[0]);
        if($payload!=null)
        {
            $empleado=$payload->id;
        }else{
            $response->getBody()->write(json_encode("No existe el token"));
        }

        if($pedido != null)
        {
            if(Pedido::ValidarEstadoPendiente($pedido->estado)==true)
            {
                
                    if(Estado_pedido::ValidarEstadosPreparacion($ArrayDeParametros["estado"]))
                    {
                        $estadoPedidos=new Estado_pedido;
                        $estadoPedidos->id_pedido=$pedido->id;
                        $items=explode(";",$pedido->items);
                        foreach ($items as &$value) {
                            $time=Producto::AsignarTiempoPreparacion($value);
                            $aux0=Producto::where('item',$value)->first();
                            $pendiente=Pendiente::where('id_item',$aux0->id)->first();
                            $pendiente->delete();
                        }
                    
                    $estadoPedidos->tiempo=$time;
                    $estadoPedidos->estado=$ArrayDeParametros["estado"];
                    $rta=$estadoPedidos->save();
                    $pedido->estado=$ArrayDeParametros["estado"];
                    $rta=$pedido->save();
                    $mesa=Mesa::where('codigo', $pedido->codigo_mesa)->first();
                    $mesa->id_estado=2;
                    $mesa->save();
                    $response->getBody()->write(json_encode($rta));
                }else
                {
                    $rta=Respuesta::MostrarRespuestas("ERROR", "Debe prepararse el pedido (EN PREPARACION)" );
                    $response->getBody()->write(json_encode($rta));
                }
                
            }else
            {
                $rta=Respuesta::MostrarRespuestas("ERROR", "El pedido no se encuentra pendiente" );
                $response->getBody()->write(json_encode($rta));
            }
        }else{
            $rta=Respuesta::MostrarRespuestas("ERROR", "El Pedido no existe" );
            $response->getBody()->write(json_encode($rta));
        }
        return $response;
    }
    public function ListoParaServir($request, $response, $args)
    {
        $id=$args['id_pedido'];
        $pedido=Pedido::find($id);

        $ArrayDeParametros = $request->getParsedBody();

        $token=$request->getHeader('token');
        $payload=Token::ValidarToken($token[0]);
        if($payload!=null)
        {
            $empleado=$payload->id;
        }else{
            $response->getBody()->write(json_encode("No existe el token"));
        }

        if($pedido != null)
        {
            if(Pedido::ValidarEstadoPreparacion($pedido->estado)==true)
            {
                $estados=Estado_pedido::where('id_pedido', $pedido->id)->first();
                $pedido->estado=$ArrayDeParametros['estado'];
                $pedido->save();
                $estados->estado=$ArrayDeParametros['estado'];
                $estados->tiempo="00:00:00";
                $rta=$estados->save();

                $mesa=Mesa::where('codigo', $pedido->codigo_mesa)->first();
                $mesa->id_estado=3;
                $mesa->save();
                $response->getBody()->write(json_encode($rta));
            }else
            {
                $rta=Respuesta::MostrarRespuestas("ERROR", "El pedido no se encuentra En preparacion" );
                $response->getBody()->write(json_encode($rta));
            }
        }else{
            $rta=Respuesta::MostrarRespuestas("ERROR", "El Pedido no existe" );
            $response->getBody()->write(json_encode($rta));
        }
        return $response;
    }
    public function GetAllSocios($request, $response, $args)
    {
        $rta=Estado_pedido::where('id','>',0)->get();//o get()
        $response->getBody()->write(json_encode($rta));
        return $response;
    }
    public function GetAllPendientes($request, $response, $args)
    {
        $rta=Pendiente::where('id','>',0)->get();//o get()
        $response->getBody()->write(json_encode($rta));
        return $response;
    }
    public function GetOneCliente($request, $response, $args)
    {
        $c_mesa=$args['codigo_mesa'];
        $c_pedido=$args['codigo_pedido'];

        $pedido=Pedido::where('codigo_mesa',$c_mesa)
        ->where('codigo_pedido',$c_pedido)
        ->first();
        
        $tiempo=Estado_pedido::where('id_pedido', $pedido->id)->first();
        $rta="Tiempo: $tiempo->tiempo pedido: $pedido";
        $response->getBody()->write(json_encode($rta));
        return $response;
    }
    public function CobrarMesa($request, $response, $args)
    {
        $codigo=$args['codigo_mesa'];
        $pedido=Pedido::where('codigo_mesa', $codigo)->first();
        $estado=Mesa::where('codigo',$codigo)->first();
        if($estado->id_estado==3)
        {
            $precio=Producto::CalcularPrecio($pedido->items);
            $comanda=new Comanda;
            $comanda->id_pedido=$pedido->id;
            $comanda->total=$precio;
            $rta=$comanda->save();
            $estado->id_estado=4;
            $estado->save();
            $estadoPedido=Estado_pedido::where('id_pedido', $pedido->id)->first();
            $estadoPedido->estado="COBRADO";
            $estadoPedido->save();
            $pedido->estado="COBRADO";
            $pedido->save();
            $cadena="Precio: $precio";
            $response->getBody()->write(json_encode($cadena));
        }else
        {
            $rta=Respuesta::MostrarRespuestas("ERROR", "La mesa ya fue cobrada O no estan para cobrar" );
            $response->getBody()->write(json_encode($rta));
        }

        return $response;
    }
    public function CerrarMesa($request, $response, $args)
    {
        $codigo=$args['codigo_mesa'];
        $pedido=Pedido::where('codigo_mesa', $codigo)->first();
        $estado=Mesa::where('codigo',$codigo)->first();
        if($estado->id_estado==4)
        {
            $pedido->estado="PAGADO";
            $rta=$pedido->save();
            $estadoPedido=Estado_pedido::where('id_pedido', $pedido->id)->first();
            $estadoPedido->estado="PAGADO";
            $estadoPedido->save();
            $estado->id_estado=5;
            $estado->save();
            $response->getBody()->write(json_encode($rta));
        }else
        {
            $rta=Respuesta::MostrarRespuestas("ERROR", "La mesa ya esta cerrada" );
            $response->getBody()->write(json_encode($rta));
        }
        return $response;
    }
}
?>