<?php

$allphones = array();
if ( file_exists('allphones.dat') ) $allphones = json_decode(file_get_contents('allphones.dat'), true);


//echo "<pre>";
//print_R($allphones);
//echo "</pre>";

$description = iconv('windows-1251', 'utf-8', htmlspecialchars('Sms'));
$start_time = "AUTO"; 
$end_time = "AUTO"; 
$rate = 10; 
$lifetime = 24; 
$source = 'AllService'; // Alfaname
// $source = 'InfoCentr';


if ( isset($_GET['sendRestorePass']) ) {
	
	
	$phone = trim($_GET['svphone']);
	
	if ( isset($allphones[$phone]) ) {
		
		$pass = $allphones[$phone]['pass'];
		$recipient = $phone;
		$text = 'Код '.$pass.'. Нікому не передавайте.';

		
		$user = '380666614146';
		
		$password = 'xf4992wf';
		$myXML   = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		$myXML  .= "<request>";
		$myXML  .= "<operation>SENDSMS</operation>";
		$myXML  .= '        <message start_time="'.$start_time.'" end_time="'.$end_time.'" lifetime="'.$lifetime.'" rate="'.$rate.'" desc="'.$description.'" source="'.$source.'">'."\n";
		$myXML  .= "        <recipient>".$recipient."</recipient>";
		$myXML  .= "        <body>".$text."</body>";
		$myXML  .=  "</message>";
		$myXML  .= "</request>";

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_USERPWD , $user.':'.$password);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_URL, 'http://svitsms.com/api/api.php?t='.time());
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: text/xml", "Accept: text/xml"));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $myXML);
		$response = curl_exec($ch);
		curl_close($ch);
		$xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
		$json = json_encode($xml);
		$array = json_decode($json,TRUE);
		
		
		$ret['state'] = 'ок';
		$ret['msg'] = 'Ми відправили смс-пароль на ваш мобільний телефон.';
		$ret['time'] = time();
		$ret['response'] = $response;
		//$ret['array'] = $array;
		echo json_encode($ret);
		exit();
		
		
	} else {
		
		$ret['state'] = 'error';
		$ret['msg'] = 'Вказаний номер телефону ще не підтверджений.';
		$ret['time'] = time();
		$ret['response'] = $response;
		//$ret['array'] = $array;
		echo json_encode($ret);
		exit();


		
	}
	
}	
	
	
if ( isset($_GET['gethiddenblock']) ) {
	
	$phone = trim($_GET['svphone']);
	
		$ret['state'] = 'ok';
		$ret['msg'] = 'Ваш телефон успішно підтверджено!';
		$ret['hiddenblock'] = file_get_contents('hiddenblock.html');
		
		$ret['phone'] = $phone;
		$ret['allphones'] = $allphones;
		
		//$allphones[$phone]['status'] = 'ok';
		//file_put_contents('allphones.dat', json_encode($allphones));
		
		echo json_encode($ret);
		exit();	
	
	
}
	
	
if ( isset($_GET['chk']) ) {
	
	$phone = trim($_GET['svphone']);
	$pass = trim($_GET['smspass']);
	
	if ( isset($allphones[$phone]) && $pass == $allphones[$phone]['pass'] ) {
		
		SetCookie("svphone",$phone);
		
		$ret['state'] = 'ok';
		$ret['msg'] = 'Ваш телефон успішно підтверджено!';
		$ret['hiddenblock'] = file_get_contents('hiddenblock.html');
		
		$ret['pass'] = $pass;
		$ret['phone'] = $phone;
		$ret['allphones'] = $allphones;
		
		$allphones[$phone]['status'] = 'ok';
		file_put_contents('allphones.dat', json_encode($allphones));
		
		echo json_encode($ret);
		exit();
	} else {
		
		$ret['state'] = 'error';
		$ret['msg'] = 'Не вірно введений смс-пароль!';
		
		$ret['allphones'] = $allphones;
		
		echo json_encode($ret);
		exit();
		
	}
	
		exit();
}



	
if ( isset($_GET['sendsms']) ) {
	
	$pass = rand(1000, 9999);
	
	//$recipient = $_POST['phone'];
	$recipient = trim($_GET['svphone']);
	$name=iconv('utf-8', 'windows-1251', $_POST['name-999']);
	$sms=iconv('utf-8', 'windows-1251', $_POST['sms-999']);
	$tel=iconv('utf-8', 'windows-1251', $_POST['tel-999']);
	$card= 'Èìÿ Êëèåíòà: '.$name.', òåëåôîí: '.$tel.'. ÑÌÑ: '.$sms.'';
	$text = iconv('windows-1251', 'utf-8',$card);
	$card1 = 'Êîä ïîäòâåðæäåíèÿ '.$_POST['password'].'';
	$text1 = iconv('windows-1251', 'utf-8',$card1);
	
	$user = '380666614146';
	$password = 'xf4992wf';
	
	
	
	
	
	if ( isset($allphones[$recipient]) && $allphones[$recipient]['status'] == 'ok' ) {
		
		$ret['state'] = 'ok';
		$ret['msg'] = 'Ваш телефон вже проходив авторизацію, введіть будь ласка смс-пароль, який Ви отримували раніше.';
		echo json_encode($ret);
		exit();		
	}
	
	$allphones[$recipient]['status'] = 'wait';
	$allphones[$recipient]['pass'] = trim($pass);
	
	file_put_contents('allphones.dat', json_encode($allphones));	
	
	$text = 'Код '.$pass.'. Нікому не передавайте.';
	//$text = 'password: '.$pass;
	
	
	
	

	$myXML   = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$myXML  .= "<request>";
	$myXML  .= "<operation>SENDSMS</operation>";
	$myXML  .= '        <message start_time="'.$start_time.'" end_time="'.$end_time.'" lifetime="'.$lifetime.'" rate="'.$rate.'" desc="'.$description.'" source="'.$source.'">'."\n";
	$myXML  .= "        <recipient>".$recipient."</recipient>";
	$myXML  .= "        <body>".$text."</body>";
	//$myXML  .= "        <recipient>".$recipient1."</recipient>";
	//$myXML  .= "        <body>".$text1."</body>";
	$myXML  .=  "</message>";
	$myXML  .= "</request>";

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_USERPWD , $user.':'.$password);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_URL, 'http://svitsms.com/api/api.php?t='.time());
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: text/xml", "Accept: text/xml"));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $myXML);
	$response = curl_exec($ch);
	curl_close($ch);
	$xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
	$json = json_encode($xml);
	$array = json_decode($json,TRUE);


	// [state] => No correct phones
	// Вам выслано СМС с паролем...

	if ( $array['state'] == 'No correct phones' ) {
		$ret['state'] = 'error';
		$ret['msg'] = 'Не вірно вказано телефон!';
		$ret['array'] = $array;
		echo json_encode($ret);
		exit();
	} else {
		$ret['state'] = 'ok';
		$ret['msg'] = 'Ми відправили вам смс-пароль на ваш мобільний телефон. Введіть його у відповідне поле.';
		$ret['array'] = $array;
		echo json_encode($ret);
		exit();		
	}
	
	
	
	echo "<pre>";
	//print_R($_GET);
	print_R($json);
	echo "<hr>";
	print_R($array);
	echo "<hr>";
	//print_R($myXML);
	print_R($response);
	echo "</pre>";
}


?>
