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
	$code = '0dd4797b97d6fc229ec890964b86d01ecb11db11eb035ad0e27404230c399bd7';

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

?>