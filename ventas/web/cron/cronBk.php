<?php	
	require_once('mailer/class.phpmailer.php');
	require_once('mailer/class.smtp.php');
	
	$db = new PDO('mysql:host=localhost:3306;dbname=rfc_alerta','root','mysqlcointer');
	
	file_put_contents("exigibles.csv",file_get_contents("http://omawww.sat.gob.mx/cifras_sat/Documents/Exigibles.csv"));
	file_put_contents("firmes.csv",file_get_contents("http://omawww.sat.gob.mx/cifras_sat/Documents/Firmes.csv"));
	file_put_contents("noLocalizados.csv",file_get_contents("http://omawww.sat.gob.mx/cifras_sat/Documents/No%20localizados.csv"));
	
	$aExigibles = array();
	$aFirmes = array();
	$aNoLocalizados = array();
	
	$sql = $db->prepare('SELECT * FROM rfc WHERE borrado = 0');
	$sql->execute();
	$rfcs = $sql->fetchAll(PDO::FETCH_ASSOC);
	
	$exigibles = array_map('str_getcsv', file("exigibles.csv"));
    array_shift($exigibles);
	
	foreach( $exigibles as $k=>$v ){
		foreach( $rfcs as $rfc ){
			if( in_array($rfc['rfc'],$v) ){
				$sql = $db->prepare('SELECT * FROM cat_patentes WHERE id = '.$rfc['patente']);
				$sql->execute();
				$patente = $sql->fetchAll(PDO::FETCH_ASSOC);
				$aExigibles[$k] = $v;
				$aExigibles[$k][] = $rfc['razon_social'];
				$aExigibles[$k][] = $patente[0]['patente'];
				$aExigibles[$k][] = $rfc['descripcion'];
				$aExigibles[$k][] = $rfc['agente_aduanal'];
			}
		}
	}
	
	$sql = $db->prepare('SELECT * FROM exigibles GROUP BY fecha_hora_registro');
	$sql->execute();
	$cuantos = $sql->fetchAll(PDO::FETCH_ASSOC);
	
	if( count($cuantos) === 2 ){
		$primero = $cuantos[0]['fecha_hora_registro'];
		$segundo = $cuantos[1]['fecha_hora_registro'];
		if( $primero < $segundo ){
			$sql = $db->prepare('DELETE FROM exigibles WHERE fecha_hora_registro = "'.$primero.'"');
			$sql->execute();
		}else{
			$sql = $db->prepare('DELETE FROM exigibles WHERE fecha_hora_registro = "'.$segundo.'"');
			$sql->execute();
		}
	}
	
	foreach( $exigibles as $k=>$v ){
		if( $v[0] != "" ){
			$data[] = '("'.utf8_encode($v[0]).'", '.'"'.str_replace('"','',utf8_encode($v[1])).'", "'.trim($v[2]).'", "'.$v[3].'", "'.date_format(date_create_from_format('d/m/Y', $v[4]), 'Y-m-d').'", "'.utf8_encode($v[5]).'")';
		}
	}
	
	$sql = $db->prepare('INSERT INTO exigibles (rfc,razon_social,tipo_persona,supuesto,fecha_primera_publicacion,entidad_federativa) VALUES '.implode(',',$data));
	$sql->execute();
	
	$firmes = array_map('str_getcsv', file("firmes.csv"));
    array_shift($firmes);
	
	foreach( $firmes as $k=>$v ){
		foreach( $rfcs as $rfc ){
			if( in_array($rfc['rfc'],$v) ){
				$sql = $db->prepare('SELECT * FROM cat_patentes WHERE id = '.$rfc['patente']);
				$sql->execute();
				$patente = $sql->fetchAll(PDO::FETCH_ASSOC);
				$aFirmes[$k] = $v;
				$aFirmes[$k][] = $rfc['razon_social'];
				$aFirmes[$k][] = $patente[0]['patente'];
				$aFirmes[$k][] = $rfc['descripcion'];
				$aFirmes[$k][] = $rfc['agente_aduanal'];
			}
		}
	}
	
	$sql = $db->prepare('SELECT * FROM firmes GROUP BY fecha_hora_registro');
	$sql->execute();
	$cuantos = $sql->fetchAll(PDO::FETCH_ASSOC);
	
	if( count($cuantos) === 2 ){
		$primero = $cuantos[0]['fecha_hora_registro'];
		$segundo = $cuantos[1]['fecha_hora_registro'];
		if( $primero < $segundo ){
			$sql = $db->prepare('DELETE FROM firmes WHERE fecha_hora_registro = "'.$primero.'"');
			$sql->execute();
		}else{
			$sql = $db->prepare('DELETE FROM firmes WHERE fecha_hora_registro = "'.$segundo.'"');
			$sql->execute();
		}
	}
	
	foreach( $firmes as $k=>$v ){
		if( $v[0] != "" ){
			$data[] = '("'.utf8_encode($v[0]).'", '.'"'.str_replace('"','',utf8_encode($v[1])).'", "'.trim($v[2]).'", "'.$v[3].'", "'.date_format(date_create_from_format('d/m/Y', $v[4]), 'Y-m-d').'", "'.utf8_encode($v[5]).'")';
		}
	}
	
	$sql = $db->prepare('INSERT INTO firmes (rfc,razon_social,tipo_persona,supuesto,fecha_primera_publicacion,entidad_federativa) VALUES '.implode(',',$data));
	$sql->execute();
	
	$noLocalizados = array_map('str_getcsv', file("noLocalizados.csv"));
    array_shift($noLocalizados);
	
	foreach( $noLocalizados as $k=>$v ){
		foreach( $rfcs as $rfc ){
			if( in_array($rfc['rfc'],$v) ){
				$sql = $db->prepare('SELECT * FROM cat_patentes WHERE id = '.$rfc['patente']);
				$sql->execute();
				$patente = $sql->fetchAll(PDO::FETCH_ASSOC);
				$aNoLocalizados[$k] = $v;
				$aNoLocalizados[$k][] = $rfc['razon_social'];
				$aNoLocalizados[$k][] = $patente[0]['patente'];
				$aNoLocalizados[$k][] = $rfc['descripcion'];
				$aNoLocalizados[$k][] = $rfc['agente_aduanal'];
			}
		}
	}
	
	$sql = $db->prepare('SELECT * FROM no_localizados GROUP BY fecha_hora_registro');
	$sql->execute();
	$cuantos = $sql->fetchAll(PDO::FETCH_ASSOC);
	
	if( count($cuantos) === 2 ){
		$primero = $cuantos[0]['fecha_hora_registro'];
		$segundo = $cuantos[1]['fecha_hora_registro'];
		if( $primero < $segundo ){
			$sql = $db->prepare('DELETE FROM no_localizados WHERE fecha_hora_registro = "'.$primero.'"');
			$sql->execute();
		}else{
			$sql = $db->prepare('DELETE FROM no_localizados WHERE fecha_hora_registro = "'.$segundo.'"');
			$sql->execute();
		}
	}
	
	foreach( $noLocalizados as $k=>$v ){
		if( $v[0] != "" ){
			$data[] = '("'.utf8_encode($v[0]).'", '.'"'.str_replace('"','',utf8_encode($v[1])).'", "'.trim($v[2]).'", "'.$v[3].'", "'.date_format(date_create_from_format('d/m/Y', $v[4]), 'Y-m-d').'", "'.utf8_encode($v[5]).'")';
		}
	}
	
	$sql = $db->prepare('INSERT INTO no_localizados (rfc,razon_social,tipo_persona,supuesto,fecha_primera_publicacion,entidad_federativa) VALUES '.implode(',',$data));
	$sql->execute();
	
	if( !empty($aExigibles) || !empty($aFirmes) || !empty($aNoLocalizados)  ){
		$mensaje = "";
		
		$sql = $db->prepare('SELECT correo FROM correos_alerta WHERE borrado = 1');
		$sql->execute();
		$correos = $sql->fetchAll(PDO::FETCH_COLUMN);
		
		if( !empty($aExigibles) ){
			$mensaje .= "<p><b>Los siguientes RFC se encontraron en la lista de Exigibles:</b></p>";
			$mensaje .= "<ul>";
				foreach( $aExigibles as $aExigible ){					
					$mensaje .= "<li><b>".$aExigible[0]."</b></li>";
					$mensaje .= "<ul>";
						$mensaje .= "<li><b>Razón Social:</b> ".$aExigible[1]."</li>";
						$mensaje .= "<li><b>Patente:</b> ".$aExigible[7]."</li>";
						$mensaje .= "<li><b>Agente Aduanal:</b> ".$aExigible[9]."</li>";
						$mensaje .= "<li><b>Descripcion:</b> ".$aExigible[8]."</li>";
						$mensaje .= "<li><b>Tipo de persona:</b> ".$aExigible[2]."</li>";
						$mensaje .= "<li><b>Fecha de primera publicación:</b> ".date_format(date_create_from_format('Y-m-d', $aExigible[4]), 'd/m/Y')."</li>";
						$mensaje .= "<li><b>Entidad Federativa:</b> ".$aExigible[5]."</li>";
					$mensaje .= "</ul>";
				}
			$mensaje .= "</ul>";
		}
		
		if( !empty($aFirmes) ){
			$mensaje .= "<p><b>Los siguientes RFC se encontraron en la lista de Firmes:</b></p>";
			$mensaje .= "<ul>";
				foreach( $aFirmes as $aFirme ){					
					$mensaje .= "<li><b>".$aFirme[0]."</b></li>";
					$mensaje .= "<ul>";
						$mensaje .= "<li><b>Razón Social:</b> ".$aFirme[1]."</li>";
						$mensaje .= "<li><b>Patente:</b> ".$aFirme[7]."</li>";
						$mensaje .= "<li><b>Agente Aduanal:</b> ".$aFirme[9]."</li>";
						$mensaje .= "<li><b>Descripcion:</b> ".$aFirme[8]."</li>";
						$mensaje .= "<li><b>Tipo de persona:</b> ".$aFirme[2]."</li>";
						$mensaje .= "<li><b>Fecha de primera publicación:</b> ".date_format(date_create_from_format('Y-m-d', $aFirme[4]), 'd/m/Y')."</li>";
						$mensaje .= "<li><b>Entidad Federativa:</b> ".$aFirme[5]."</li>";
					$mensaje .= "</ul>";
				}
			$mensaje .= "</ul>";
		}
		
		if( !empty($aNoLocalizados) ){
			$mensaje .= "<p><b>Los siguientes RFC se encontraron en la lista de Firmes:</b></p>";
			$mensaje .= "<ul>";
				foreach( $aNoLocalizados as $aNoLocalizado ){					
					$mensaje .= "<li><b>".$aNoLocalizado[0]."</b></li>";
					$mensaje .= "<ul>";
						$mensaje .= "<li><b>Razón Social:</b> ".$aNoLocalizado[1]."</li>";
						$mensaje .= "<li><b>Patente:</b> ".$aNoLocalizado[7]."</li>";
						$mensaje .= "<li><b>Agente Aduanal:</b> ".$aNoLocalizado[9]."</li>";
						$mensaje .= "<li><b>Descripcion:</b> ".$aNoLocalizado[8]."</li>";
						$mensaje .= "<li><b>Tipo de persona:</b> ".$aNoLocalizado[2]."</li>";
						$mensaje .= "<li><b>Fecha de primera publicación:</b> ".date_format(date_create_from_format('Y-m-d', $aNoLocalizado[4]), 'd/m/Y')."</li>";
						$mensaje .= "<li><b>Entidad Federativa:</b> ".$aNoLocalizado[5]."</li>";
					$mensaje .= "</ul>";
				}
			$mensaje .= "</ul>";
		}
		
		$mail = new PHPMailer(true);
			
		try{
			$mail -> IsSMTP();
			$mail -> SMTPAuth = true;
			$mail -> CharSet = "UTF-8";
			$mail -> Host = "mail.claa.org.mx";
			$mail -> Port=26;
			$mail -> IsHTML(true);
			$mail -> Timeout = 120;
			$mail -> Username = "alertas@claa.org.mx";
			$mail -> Password = "Al3rtas2018#";
			$mail -> SetFrom("alertas@claa.org.mx", "CLAA Alertas");
			
			if( is_array($correos) && !empty($correos) ){
				foreach( $correos as $correo ){
					$mail -> AddAddress($correo);
				}
			}
			$mail -> Subject = "Alerta Exigibles";
			$mail -> MsgHTML($mensaje);
			
			$mail -> Send();
		}catch (phpmailerException $e) {
		  echo $e->errorMessage();
		} catch (Exception $e) {
		  echo $e->getMessage();
		}
	}
	
	$db = NULL;
	
	unlink("exigibles.csv");
	unlink("firmes.csv");
	unlink("noLocalizados.csv");
?>