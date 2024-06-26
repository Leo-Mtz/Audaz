<?php
	$nombre = $_POST['name'];
	$email = $_POST['email'];
	$telefono = $_POST['phone'];
	$mensaje = $_POST['message'];
	
    // require_once('phpmailer/PHPMailerAutoload.php');
	require_once('phpmailer/class.phpmailer.php');
	require_once('phpmailer/class.smtp.php');

	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->SMTPOptions = array(
		'ssl' => array(
		'verify_peer' => false,
		'verify_peer_name' => false,
		'allow_self_signed' => true
	));
	$mail->SMTPDebug  = 0;
	$mail->SMTPAuth = true;
	// $mail->CharSet = "UTF-8";
	$mail->Host = "mail.mezcalaudaz.mx";
	$mail->Port = 26;
	$mail->IsHTML(true);
	$mail->Username = "jose.padron@mezcalaudaz.mx";
	$mail->Password = "Mezcal2018%";
	$body = "Nombre: ".$nombre."<br>"."Email: ".$email."<br>"."Tel.: ".$telefono."<br>"."Mensaje: ".$mensaje;
	$mail->SetFrom('jose.padron@mezcalaudaz.mx'); //Remitente
	$mail->AddAddress('jose.padron@grupotic.com.mx'); //DESTINATARIO
	$mail->Subject = "MEZCAL AUDAZ";
	$mail->MsgHTML($body);

	$enviado = $mail->Send();

	if(!$enviado){
		$error = 'Error: '.$mail->ErrorInfo;
		echo'<script type="text/javascript">
			alert("No se envio----'.$error.'");
			window.location.href="http://www.mezcalaudaz.mx/store.html";
			</script>';
	}else{
		echo'<script type="text/javascript">
			alert("Mensaje enviado");
			window.location.href="http://www.mezcalaudaz.mx/store.html";
			</script>';
	}
?>