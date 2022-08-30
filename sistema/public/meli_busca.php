<?php
include("functions.php");
if(isset($_GET['chave']) && !empty($_GET['chave'])) {
	$chave = $_GET['chave'];
	$chave = str_replace(" ","_",preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim($chave))));


	
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_URL => "https://api.mercadolibre.com/sites/MLB/search?q={$chave}",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'GET',
	));

	$response = curl_exec($curl);

	$json = json_decode($response);
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
<title>API - Mercado Livre</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="stylesheet" href="bootstrap.min.css" />
<script style="text/javascript" src="bootstrap.min.js"></script>
<script style="text/javascript" src="jquery.min.js"></script>
<style>
	html {
    font-size: 12px;
	} 
	pre {
		display: none;
	}
</style>
</head>
<body>
<div class="container">

<br/>
<form method="GET" >
	<input type="text" name="chave" placeholder="Pesquisar" border-radius="10" />

	<input type="submit" value="Pesquisar" />
</form><br/><br/>

<table class="table">
	<tr>
		<th></th>
		<th>Vendedor</th>
		<th>Estado/Cidade</th>
		<th>Anúncio</th>		
		<th>Preço</th>
		<th>Vendas</th>
		<th>Faturamento</th>
	</tr>
	<?php
	foreach($json->results AS $r) {
		$curl2 = curl_init();

		curl_setopt_array($curl2, array(
		CURLOPT_URL => "https://api.mercadolibre.com/users/{$r->seller->id}",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'GET',
		));

		$response2 = curl_exec($curl2);
		$json2 = json_decode($response2);

		echo "<pre>";
		echo "<tr>";
		echo "<td>"."<img width='75' src='$r->thumbnail'/>"."</td>";
		echo "<td>".$json2->nickname."</td>";
		echo "<td>".$r->address->state_name."/".$r->address->city_name."</td>";
		echo "<td>"."<a href='$r->permalink' target='blank'>$r->title</a>"."</td>";		
		echo "<td>"."R$ ".number_format($r->price,2,",",".")."</td>";
		echo "<td>".$r->sold_quantity."</td>";
		$evenue = somar($r->price, $r->sold_quantity);
		echo "<td>"."R$ ".number_format($evenue,2,",",".")."</td>";
		echo "</tr>";
		echo "</pre>";
		curl_close($curl);
	}
	
	?>
</table><br/><br/>
</div>
</body>
</html>