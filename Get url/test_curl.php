<?php
function get_data($url) {
	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0(X11; Linux x86_64;rv:10.0) Gecko/20100101 Firefox/10.0');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array('custom-header-name: custom-header-value','another-custom-header: another value')); //setting custom header
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}
$var= get_data("https://www.google.bg/search?q=miro&start=10");
//echo htmlspecialchars($var);var_dump(
preg_match_all('~<a(.*?)href="http([^"]+)"(.*?)>~', $var, $matches);
$i=0;
$p=0;
$links[100];
$j=0;
//while ($i<=sizeof($matches[2])) {
	
	
	for($i=0;$i<sizeof($matches[2]);$i++)
	{
		$pieces = explode("http", $matches[2][i]);
		for ($j=0; $j <sizeof($pieces); $j++) { 
			$links[$p]=$pieces[$j];
			$p++;

		}
	
	}
	echo var_dump($links);
	/*for ($s=0; $s < sizeof($pieces); $s++) { 
			$links[$s]=$pieces[$p];
			$p = $p + 2;
	}
    echo var_dump($links);
	$i++;
}

echo var_dump($matches[2]);
*/
?>
