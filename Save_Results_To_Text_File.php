<?php

$servername = "localhost";
  $username = "omgproekt";
  $password = "omg2018!";
  $dbname = "omgproekt";
  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error) ;
  }





 $ret = array();
function isGoogle($dom)
{
    if(strrpos($dom, ".google")|| strrpos($dom,"gstatic") || strrpos($dom,"youtube") || strrpos($dom,"blogger") || strrpos($dom, "facebook") || strrpos($dom, "schema"))return true;
    else return false;
}

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
        if($current_url != "") array_push($ret, $current_url);
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
        if($current_url != "") array_push($ret, $current_url);
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
        if($current_url != "")array_push($ret, $current_url);
    }
    $ret = array_unique($ret);
    return $ret;
}

$sql = "SELECT Name FROM ex_keywords";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
	$str_l = "";
$result = mysqli_query($conn, $sql);
$links=array();

if (mysqli_num_rows($result) > 0) 
{

	 //output data of each row
	$str_l = "";

	while($row = mysqli_fetch_assoc($result)) 
	{
		$url=$row["Name"];
		//fwrite($keywordsFile, $url . "\n" . "\n");
		$main_url="https://www.google.de/search?q=".$url."&start=10";
		$links= get_links_from_page("https://www.google.de/search?q=".$url."&start=10");
	
		//if(count($links)>0) echo "Iva e top";

		//else echo "Iva ne e tupa";
         $new_links= array();
       	 foreach($links as $link)
	 {
	    $dom = get_domain_name($link);	
            if(!isGoogle($dom))
            {
                if($dom != "") array_push($new_links, $dom);	    }

	 }

	$new_links= array_unique($new_links);
	 foreach($new_links as $link)
	 {	  
		echo $link, "\n"; 
	 }
		 
	 //echo $str_l;
	 }
	 
}


 
} else {
    	echo "0 results";
}


mysqli_close($conn);

?>
