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
global $matches,$pieces;
$links =array();
preg_match_all('~<a(.*?)href="http([^"]+)"(.*?)>~', $var, $matches);

$length= count($matches[2]);
	for($i=0;$i<$length;$i++)
	{
		 $pieces = explode("http", $matches[2][$i]);
		for ($j=0; $j < count($pieces); $j++) {

		 		if(strpos($pieces[$j],"www.google")===false) $links[]=$pieces[$j];
		}
	}
for ($i=0; $i <count($links) ; $i++) {
	echo $links[$i],'<br>';
}
?>
