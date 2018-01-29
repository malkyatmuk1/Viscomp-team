<?php

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
            if($text[$j] == ")") { $is_ok = false; break; }
            $current_url .= $text[$j];
        }

        if(!$is_ok) continue;
        array_push($ret, $current_url);
    }

    $current_domain_name = get_domain_name($url);
    if($current_domain_name[strlen($current_domain_name) - 1] != '/') $current_domain_name .= '/';

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
            if($text[$j] == ")") { $is_ok = false; break; }
            $current_url .= $text[$j];
        }

        $current_url = $current_domain_name . $current_url;

        if(!$is_ok) continue;
        array_push($ret, $current_url);
    }

    $ret = array_unique($ret);
    return $ret;
}

$initial_url = "";
$list_of_urls = array();
$steps = 0;
$used = array();

function dfs($url)
{
	global $initial_url, $list_of_urls, $steps, $used; 

	if($steps >= 100) return;
	if(array_key_exists($url, $used)) return;
	
	$steps++;
	$used[$url] = true;
		
	if(get_domain_name($url) != $initial_url)
	{
		$list_of_urls[get_domain_name($url)] = true;
		return;
	}

	$adj = get_links_from_page($url);
	foreach($adj as $v)
		dfs($v);
}

function is_page_bad($url)
{
	global $initial_url, $list_of_urls, $steps, $used; 
	
	$initial_url = get_domain_name($url);
	$list_of_urls = array();
	$steps = 0;
	$used = array();

	dfs($url);

	/*foreach($list_of_urls as $lnk => $val)
		echo $lnk . "\n";
	*/

	if(count($list_of_urls) >= 10) return true;
	else return false;
}

is_page_bad("https://stackoverflow.com/questions/141108/how-to-find-the-foreach-index");

 ?>
