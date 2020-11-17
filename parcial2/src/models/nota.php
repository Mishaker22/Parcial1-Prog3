<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Controller\MateriaController;

class Nota extends Model
{
     public $timestamps = false;
     
     public static function ValidarNota($nota)
     {
          $retorno=false;
          if($nota>0 && $nota<11)
          {
               $retorno=true;
          }
          return $retorno;
     }
}
?>