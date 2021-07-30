<?php


function dbConncet($host,$user,$pass,$database){
	$connection = mysqli_connect($host,$user,$pass,$database);
	if (mysqli_connect_errno())
	{
	die("Can not to connect to Mysql Server");
	}
	return $connection; 
}


function getDomainName($url) {
	$url = Trim($url);
	$url = preg_replace("/^(http:\/\/)*/is", "", $url);
	$url = preg_replace("/^(https:\/\/)*/is", "", $url);
	$url = preg_replace("/\/.*$/is" , "" ,$url);
	return $url;
}

function get_redirect($site)
{
	$curlInit = curl_init($site);
	curl_setopt($curlInit, CURLOPT_CONNECTTIMEOUT, 20);
	curl_setopt($curlInit, CURLOPT_HEADER, true);
	curl_setopt($curlInit, CURLOPT_NOBODY, true);
	curl_setopt($curlInit, CURLOPT_RETURNTRANSFER, true);

	$response = curl_exec($curlInit);
	$response_time = curl_getinfo($curlInit);
	curl_close($curlInit);
	return $response_time['redirect_url'];
}

function RealIpAddress()
{
if (!empty($_SERVER['HTTP_CLIENT_IP']))
//check ip from internet
{
$ipadd=$_SERVER['HTTP_CLIENT_IP'];
}
elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
//check ip proxy
{
$ipadd=$_SERVER['HTTP_X_FORWARDED_FOR'];

}

else
{
$ipadd=$_SERVER['REMOTE_ADDR'];
}
return $ipadd;
}

function getGlobalAlexaRank($domain) {
$xml = simplexml_load_file('http://data.alexa.com/data?cli=10&dat=snbamz&url='.$domain);
$gl_rank =isset($xml->SD[1]->POPULARITY)?$xml->SD[1]->POPULARITY->attributes()->TEXT:null;
$populator =isset($xml->SD[1]->COUNTRY)?$xml->SD[1]->COUNTRY->attributes()->NAME:null;
$po_rank =isset($xml->SD[1]->COUNTRY)?$xml->SD[1]->COUNTRY->attributes()->RANK:null;
$flags =isset($xml->SD[1]->COUNTRY)?$xml->SD[1]->COUNTRY->attributes()->CODE:null;
$gl_rank = ($gl_rank==null ? 'N/A' : $gl_rank);
$populator = ($populator==null ? 'N/A' : $populator);
$po_rank = ($po_rank==null ? 'N/A' : $po_rank);
$web=(string)$xml->SD[0]->attributes()->HOST;
$rank = array($gl_rank, $populator, $po_rank,$web,$flags);
return $rank;
}

function checkSafeBrowsing($longUrl) {
	$safebrowsing;
	$safebrowsing['api_key'] = "ABQIAAAAOQY5PG65Sz64pzYOK6KlmhQjd04VwKOOk1G-Nk48V5R2oPhf3g";
	$safebrowsing['api_url'] = "https://sb-ssl.google.com/safebrowsing/api/lookup";
		
	$url = $safebrowsing['api_url']."?client=checkURLapp&";
	$url .= "apikey=".$safebrowsing['api_key']."&appver=1.0&";
	$url .= "pver=3.0&url=".urlencode($longUrl);
 
	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
	$data = curl_exec($ch);
	$httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);
	return $httpStatus;
}


function StrToNum($Str, $Check, $Magic)
{
$Int32Unit = 4294967296; // 2^32

$length = strlen($Str);
for ($i = 0; $i < $length; $i++)
{
	$Check *= $Magic;
	if ($Check >= $Int32Unit)
	{
		$Check = ($Check - $Int32Unit * (int)($Check / $Int32Unit));
		//if the check less than -2^31
		$Check = ($Check < -2147483648) ? ($Check + $Int32Unit) : $Check;
	}
	$Check += ord($Str{$i});
}
return $Check;
}

function HashURL($String)
{
$Check1 = StrToNum($String, 0x1505, 0x21);
$Check2 = StrToNum($String, 0, 0x1003F);

$Check1 >>= 2;
$Check1 = (($Check1 >> 4) & 0x3FFFFC0) | ($Check1 & 0x3F);
$Check1 = (($Check1 >> 4) & 0x3FFC00) | ($Check1 & 0x3FF);
$Check1 = (($Check1 >> 4) & 0x3C000) | ($Check1 & 0x3FFF);

$T1 = (((($Check1 & 0x3C0) << 4) | ($Check1 & 0x3C)) << 2) | ($Check2 & 0xF0F);
$T2 = (((($Check1 & 0xFFFFC000) << 4) | ($Check1 & 0x3C00)) << 0xA) | ($Check2 &
	0xF0F0000);

return ($T1 | $T2);
}

function CheckHash($Hashnum)
{
$CheckByte = 0;
$Flag = 0;

$HashStr = sprintf('%u', $Hashnum);
$length = strlen($HashStr);

for ($i = $length - 1; $i >= 0; $i--)
{
	$Re = $HashStr{$i};
	if (1 === ($Flag % 2))
	{
		$Re += $Re;
		$Re = (int)($Re / 10) + ($Re % 10);
	}
	$CheckByte += $Re;
	$Flag++;
}

$CheckByte %= 10;
if (0 !== $CheckByte)
{
	$CheckByte = 10 - $CheckByte;
	if (1 === ($Flag % 2))
	{
		if (1 === ($CheckByte % 2))
		{
			$CheckByte += 9;
		}
		$CheckByte >>= 1;
	}
}

return '7' . $CheckByte . $HashStr;
}
$pss[0] = 'c';$pss[1] = 'i';$pss[2] = 'l';

function getch($url)
{
return CheckHash(HashURL($url));
}

function google_page_rank($url)
{
$ch = getch($url);
$fp = fsockopen('toolbarqueries.google.com', 80, $errno, $errstr, 30);
if ($fp)
{
	$out = "GET /tbr?client=navclient-auto&ch=$ch&features=Rank&q=info:$url HTTP/1.1\r\n";
	$out .= "User-Agent: Mozilla/5.0 (Windows NT 6.1; rv:28.0) Gecko/20100101 Firefox/28.0\r\n";
	$out .= "Host: toolbarqueries.google.com\r\n";
	$out .= "Connection: Close\r\n\r\n";
	fwrite($fp, $out);
	while (!feof($fp))
	{
		$data = fgets($fp, 128);
		$pos = strpos($data, "Rank_");
		if ($pos === false)
		{
		} else
		{
			$pager = substr($data, $pos + 9);
			$pager = trim($pager);
			$pager = str_replace("\n", '', $pager);
			return $pager;
		}
	}
	fclose($fp);
}
}

function isDomainAvailible($domain)
{
	   //check, if a valid url is provided
	   if(!filter_var($domain, FILTER_VALIDATE_URL))
	   {
			   return false;
	   }

	   //initialize curl
	   $curlInit = curl_init($domain);
	   curl_setopt($curlInit,CURLOPT_CONNECTTIMEOUT,10);
	   curl_setopt($curlInit,CURLOPT_HEADER,true);
	   curl_setopt($curlInit,CURLOPT_NOBODY,true);
	   curl_setopt($curlInit,CURLOPT_RETURNTRANSFER,true);

	   //get answer
	   $response = curl_exec($curlInit);

	   curl_close($curlInit);

	   if ($response) return true;

	   return false;
}


function ip_details($ip) {
    $json = file_get_contents("http://ip-api.com/json/{$ip}");
    $details = json_decode($json);
    return $details;
}


function get_host_info($site)
{

$ip = gethostbyname($site);

$ip_data = ip_details($ip);
if(isset($ip_data)){
	$ip_country= $ip_data->country;
$ip_city= $ip_data->city;
$ip_isp = '';
$ip_as = $ip_data->countryCode;
$ip_lat = $ip_data->lat;
$ip_lon = $ip_data->lon;
}


$result = array($ip,$ip_country,$ip_city,$ip_as,$ip_isp,$ip_lat,$ip_lon);

return $result;
}



function get_top_keyword($domain){

$doc = new DomDocument;

@$doc->loadHTMLFile('http://www.alexa.com/siteinfo/'.$domain);

$data = @$doc->getElementById('keywords_top_keywords_table');

$my_data = $data->getElementsByTagName('tr');
$check_data = null;
$countries = array();

foreach ($my_data as $node)
{
$inputs=$node->getElementsByTagName('span');

if($inputs->length > 0) {
    $top_keyword[] = array(
			'keyword' => $inputs->item(1)->nodeValue,
'percent' => $inputs->item(2)->nodeValue,
		  );
} else {
    $top_keyword[]="";
}

	 

}      

return $top_keyword;

}

function get_top_country_alexa($url) {
$doc = new DomDocument;

@$doc->loadHTMLFile('http://www.alexa.com/siteinfo/'.$url);

$data = @$doc->getElementById('demographics_div_country_table');

$my_data = $data->getElementsByTagName('tr');
$check_data = null;
$countries = array();
foreach ($my_data as $node)
{
	foreach($node->getElementsByTagName('a') as $href)
	{
                $inputs2=$node->getElementsByTagName('span')->item(1);

		preg_match('/([0-9\.\%]+)/',$node->nodeValue, $match);
		
		if($href->nodeValue == ' sign up and get certified'){
		$check_data = 'null';
		}else{
		$countries[] = array(
			'country' => $href->nodeValue,
			'percent' => $match[0],
                        'rank' => $inputs2->nodeValue,
		  );
		}

	}

}      

if($check_data == 'null'){
return $check_data;
}else{
return $countries;
}

}

function get_my_headers($url,$format=0)
{
	$url=parse_url($url);
	$end = "\r\n\r\n";
	$fp = fsockopen($url['host'], (empty($url['port'])?80:$url['port']), $errno, $errstr, 30);
	if ($fp)
	{
		$out  = "GET / HTTP/1.1\r\n";
		$out .= "Host: ".$url['host']."\r\n";
		$out .= "Connection: Close\r\n\r\n";
		$var  = '';
		fwrite($fp, $out);
		while (!feof($fp))
		{
			$var.=fgets($fp, 1280);
			if(strpos($var,$end))
				break;
		}
		fclose($fp);

		$var=preg_replace("/\r\n\r\n.*\$/",'',$var);
		$var=explode("\r\n",$var);
		if($format)
		{
			foreach($var as $i)
			{
				if(preg_match('/^([a-zA-Z -]+): +(.*)$/',$i,$parts))
					$v[$parts[1]]=$parts[2];
			}
			return $v;
		}
		else
			return $var;
	}
}


function showPageNavigation($currentPage, $maxPage, $path = '',$modpage) {
    $nav = array(
        // bao nhi�u trang b�n tr�i currentPage
        'left'    =>    3,
        // bao nhi�u trang b�n ph?i currentPage
        'right'    =>    3,
    );
    
    // n?u maxPage < currentPage th� cho currentPage = maxPage
    if ($maxPage < $currentPage) {
        $currentPage = $maxPage;
    }
    
    // s? trang hi?n th?
    $max = $nav['left'] + $nav['right'];
    
    // ph�n t�ch c�ch hi?n th?
    if ($max >= $maxPage) {
        $start = 1;
        $end = $maxPage;
    }
    elseif ($currentPage - $nav['left'] <= 0) {
        $start = 1;
        $end = $max + 1;
    }
    elseif (($right = $maxPage - ($currentPage + $nav['right'])) <= 0) {
        $start = $maxPage - $max;
        $end = $maxPage;
    }
    else {
        $start = $currentPage - $nav['left'];
        if ($start == 2) {
            $start = 1;
        }
        
        $end = $start + $max;
        if ($end == $maxPage - 1) {
            ++$end;
        }
    }
    
    $navig = '<ul class="pagination text-center">';
    if ($currentPage >= 2) {
        if ($currentPage >= $nav['left']) {
            if ($currentPage - $nav['left'] > 2 && $max < $maxPage) {
                // th�m n�t "First"
                $navig .= '<li><a href="'.$path.$modpage.'1'.'">1</a><li>';
            }
        }
        // th�m n�t "�"
        $navig .= '<li><a href="'.$path.$modpage.($currentPage - 1).'">&laquo;</a></li>';
    }

    for ($i=$start;$i<=$end;$i++) {
        // trang hi?n t?i
        if ($i == $currentPage) {
            $navig .= '<li class="active"><a href="javascript:void(0)">'.$i.' <span class="sr-only">(current)</span></a></li>';
        }
        // trang kh�c
        else {
            $pg_link = $path.$modpage.$i;
            $navig .= '<li><a href="'.$pg_link.'">'.$i.'</a></li>';
        }
    }
    
    if ($currentPage <= $maxPage - 1) {
        // th�m n�t "�"
        $navig .= '<li><a href="'.$path.$modpage.($currentPage + 1).'">&raquo;</a></li>';
        
        if ($currentPage + $nav['right'] < $maxPage - 1 && $max + 1 < $maxPage) {
            // th�m n�t "Last"
            
            $navig .= '<li><a href="'.$path.$modpage.$maxPage.'">'.$maxPage.'</a></li>';
        }
    }
    $navig .= '</ul>';
    
    // hi?n th? k?t qu?
    echo $navig;
}
?>