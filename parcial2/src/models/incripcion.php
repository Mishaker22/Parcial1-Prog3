<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Controller\MateriaController;

class Inscripcion extends Model
{
     public $timestamps = false;
     
     public static function HayCupos($materia)
    {
        $retorno=false;
        
        if($materia->cupos >0)
        {
            $materia->cupos --;
            $materia->save();
            $retorno=true;
        }
        return $retorno;
    }
}
?>