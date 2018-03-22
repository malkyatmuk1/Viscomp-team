<?php
/*
function isGoogle($dom)
{
	if(strrpos($dom, "google"))return true;
	else return false;
}
*/
function get_domain_name($url)
{
	$ret = "";
	$cnt_lines = 0;
	$chars = str_split($url);

	foreach($chars as $let)
	{
		$ret .= $let;
		if($let == '/') $cnt_lines++;
		if($cnt_lines == 3) break;
	}

	return $ret;
}

function get_links_from_page($url)
{
	if(strlen($url) == 0) return array();

	$text = file_get_contents($url, false);
	$ret = array();

	$length_of_string = strlen($text);

	for($i = 0; $i < $length_of_string; $i++)
	{
		if($text[$i] != 'h') continue;
		if($text[$i + 1] != 't') continue;
		if($text[$i + 2] != 't') continue;
		if($text[$i + 3] != 'p') continue;
		if($text[$i + 4] != 's') continue;
		if($text[$i + 5] != ':') continue;

		$current_url = "";
		$is_ok = true;
		for($j = $i; $j < $length_of_string; $j++)
		{
			if($text[$j] == "\"") break;
			if($text[$j] == "'") break;
			if($text[$j] == ")") { $is_ok = false; break; }
			$current_url .= $text[$j];
		}

		if(!$is_ok) continue;
		array_push($ret, $current_url);
	}

	for($i = 0; $i < $length_of_string; $i++)
	{
		if($text[$i] != 'h') continue;
		if($text[$i + 1] != 't') continue;
		if($text[$i + 2] != 't') continue;
		if($text[$i + 3] != 'p') continue;
		if($text[$i + 4] != ':') continue;

		$current_url = "";
		$is_ok = true;
		for($j = $i; $j < $length_of_string; $j++)
		{
			if($text[$j] == "\"") break;
			if($text[$j] == "'") break;
			if($text[$j] == ")") { $is_ok = false; break; }
			$current_url .= $text[$j];
		}

		if(!$is_ok) continue;
		array_push($ret, $current_url);
	}

	$current_domain_name = get_domain_name($url);
	if($current_domain_name[strlen($current_domain_name) - 1] != '/') $current_domain_name .= '/';
	if($url[strlen($url) - 1] == '/') substr_replace($url, "", -1);

	for($i = 0; $i < $length_of_string; $i++)
	{
		if($text[$i] != 'h') continue;
		if($text[$i + 1] != 'r') continue;
		if($text[$i + 2] != 'e') continue;
		if($text[$i + 3] != 'f') continue;
		if($text[$i + 4] != '=') continue;

		$current_url = "";
		$is_ok = true;
		for($j = $i + 6; $j < $length_of_string; $j++)
		{
			if($text[$j] == "\"") break;
			if($text[$j] == "'") break;
			if($text[$j] == ")") { $is_ok = false; break; }
			$current_url .= $text[$j];
		}

		if(strlen($current_url) == 0 || $current_url[0] != '/') continue;
		$current_url = $url . $current_url;

		if(!$is_ok) continue;
		array_push($ret, $current_url);
	}

	$ret = array_unique($ret);
	return $ret;
}
function get_data($url)
 {
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
$links =array();
$links= get_links_from_page("https://www.google.bg/search?q=miro&start=10");
global $matches,$pieces;s

preg_match_all('~<cite class= "_Rm">([^"]+)"(.*?)</cite>~', $var, $matches);

$length= count($links);
	/*for($i=0;$i<$length;$i++)
	{
		 $pieces = explode("http", $matches[2][$i]);
		for ($j=0; $j < count($pieces); $j++) {

		 		if(strpos($pieces[$j],"www.google")===false) $links[]=$pieces[$j];
		}
	}
	*/
for ($i=0; $i <$length ; $i++) {
	$dom=get_domain_name($links[$i]);
	echo $dom,'<br>';
}
	/*
	if (!isGoogle($dom)) {
		echo $dom,'<br>';
	}
*/
?>
