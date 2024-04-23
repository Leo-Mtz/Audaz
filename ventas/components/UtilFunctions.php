<?php

namespace app\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use app\models\Log;
 
class UtilFunctions extends Component
{
	public function log($usuario, $accion, $hizo){
		$log = new Log();
		$log->usuario = $usuario;
		$log->fecha_hora_acceso = date('Y-m-d h:i:s');
		$log->fecha_hora_fin = date('Y-m-d h:i:s');
		$log->accion = $accion;
		$log->hizo = $hizo;
		
		$log->save(false);
	} 
	
	public static function showDebug( $str ){
		echo "<pre>";
		print_r($str);
		die();
	}
}

?>