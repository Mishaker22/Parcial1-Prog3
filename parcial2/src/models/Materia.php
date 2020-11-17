<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Controller\MateriaController;

class Materia extends Model
{
     public $timestamps = false;
     public static function ValidarCampos($materia)
    { 
        $retorno=false;
        if (strlen($materia['materia'])>1 && strlen($materia['cuatrimestre'])>0 && strlen($materia['cupos']>0)) 
        {
            $retorno=true;
        }
        return $retorno;
    }
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