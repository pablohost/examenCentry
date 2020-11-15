<?php
	//*******************************
	//SOLICITO TOKEN
	//*******************************
	//recupero los datos
	$url = 'https://www.centry.cl/oauth/token';
	$client_id = '65b6c90bc86df184047084904db99264bd6bf2b7a67aea4539caa3307231d445';
	$client_secret = 'e46faf944ccaddbee6e1fca2eb0f702cb9126972bae7085a57726e5b75c80385';
	$redirect_uri = 'urn:ietf:wg:oauth:2.0:oob';
	$grant_type = 'authorization_code';
	$code = '6be71a97300ad8c0ec493a3cd8d478875a826669e9f64425f076189b02b6809c';

	$post = 'client_id='.urlencode($client_id).'&client_secret='.urlencode($client_secret).'&redirect_uri='.urlencode($redirect_uri).'&grant_type='.urlencode($grant_type).'&code='.urlencode($code);

	//curl
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_POST, TRUE);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	$output=curl_exec($ch);
	curl_close($ch);

	echo $output;
	echo '<br>';
	$json = json_decode($output, true);
	echo $json['access_token'];
	echo '<br>';

	//*******************************
	//RENUEVO TOKEN
	//*******************************
	$refresh_token = $json['refresh_token'];
	$grant_type = 'refresh_token';
	$post = 'client_id='.urlencode($client_id).'&client_secret='.urlencode($client_secret).'&redirect_uri='.urlencode($redirect_uri).'&grant_type='.urlencode($grant_type).'&refresh_token='.urlencode($refresh_token);
	//curl
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_POST, TRUE);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	$output=curl_exec($ch);
	curl_close($ch);	

	echo $output;
	echo '<br>';
	$json = json_decode($output, true);
	echo $json['access_token'];
	echo '<br>';
	echo $json['refresh_token'];
	echo '<br>';

	//*******************************
	//ACTUALIZO PRODUCTO
	//*******************************
	$headers = array(
		'Content-Type: application/json',
    	'Authorization: Bearer '.$json['access_token']
	);

	$putString = '{ "price_compare" : 9990, "name":"Pablo Adrian Gallardo Henriquez" }';
	$putData = tmpfile();
	fwrite($putData, $putString);
	fseek($putData, 0);
	
	//curl
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://www.centry.cl/conexion/v1/products/5e6121ae9c20110331be4b97.json');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_PUT, true);
	curl_setopt($ch, CURLOPT_INFILE, $putData);
	curl_setopt($ch, CURLOPT_INFILESIZE, strlen($putString));

	$output=curl_exec($ch);
	curl_close($ch);
	$json = json_decode($output, true);
	var_dump($json);
	echo '<br>';

	//*******************************
	//CONSULTO PRODUCTO
	//*******************************
	$ch = curl_init('https://www.centry.cl/conexion/v1/products/5e6121ae9c20110331be4b97.json');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	$output=curl_exec($ch);
	curl_close($ch);
	$json = json_decode($output, true);
	var_dump($json);

	//*******************************
	//ACTUALIZO VARIANTE PRODUCTO
	//*******************************
	$putString = '{ "sku" : "1010 15314", "quantity": 50 }';
	$putData = tmpfile();
	fwrite($putData, $putString);
	fseek($putData, 0);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://www.centry.cl/conexion/v1/variants/sku.json');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_PUT, true);
	curl_setopt($ch, CURLOPT_INFILE, $putData);
	curl_setopt($ch, CURLOPT_INFILESIZE, strlen($putString));
	$output=curl_exec($ch);
	curl_close($ch);
	echo $output;
	
?>