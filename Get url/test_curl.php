<?php
function get_data($url) {
	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0(X11; Linux x86_64;rv:10.0) Gecko/20100101 Firefox/10.0');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	//curl_setopt($curl, CURLOPT_HTTPHEADER, array('custom-header-name: custom-header-value','another-custom-header: another value')); //setting custom header
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}
$var= get_data("https://www.google.bg/search?q=miro&start=10");
global $matches,$pieces,$matches2;
$links =array();
preg_match_all('~<cite(.*?)class="_Rm">(.*?)</cite>~', $var, $matches);

$length= count($matches[1]);
    for ($i=0; $i < $length; $i++) { 
	echo $matches[2][$i],'<br>';
    }

    echo $length;





?>
