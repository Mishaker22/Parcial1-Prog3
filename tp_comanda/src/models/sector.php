<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Controller\MateriaController;

class Sector extends Model
{
     public $timestamps = false;
     
    public static function ValidarCuatrimestre($cuatri)
    {
        $retorno = false;
        if($cuatri==1 || $cuatri==2 ||$cuatri==3 || $cuatri==4)
        {
            $retorno=true;
        }
        return $retorno;
    }
    public static function ExisteMateria($id)
    {
        $retorno=false;
        if($id!=null)
        {
            $retorno=true;
        }
        return $retorno;
    }
}
?>