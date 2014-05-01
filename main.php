<?php
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$realfile = substr($_SERVER['SCRIPT_URL'],1);
$cont = finfo_file($finfo, $realfile);
header("Content-type: " . $cont);
finfo_close($finfo);
if(!file_exists("visits.json"))
{
file_put_contents("visits.json",json_encode(
Array("total" => 0,
"ips" => Array()
)));
}
$json = o2a(json_decode(file_get_contents("visits.json")));
$json['total']= $json['total']+1;
$json['ips'][$_SERVER['REMOTE_ADDR']][time()]['date'] = date("m-d-Y H:i:s");
$json['ips'][$_SERVER['REMOTE_ADDR']][time()]['user_agent'] = $_SERVER["HTTP_USER_AGENT"];
$json['ips'][$_SERVER['REMOTE_ADDR']]['total'] = $json['ips'][$_SERVER['REMOTE_ADDR']]['total']+1;
$json['ips'][$_SERVER['REMOTE_ADDR']][time()]['request_url'] = $_SERVER['REQUEST_URI'];
$json['ips'][$_SERVER['REMOTE_ADDR']][time()]['UDID'] = $_SERVER['HTTP_X_UNIQUE_ID'];
//$json['ips'][$_SERVER['REMOTE_ADDR']][time()]['_SERVER'] = $_SERVER;
file_put_contents("visits.json",json_encode($json));
echo file_get_contents($realfile);
function o2a($d) {if (is_object($d)) {$d = get_object_vars($d);}if (is_array($d)) {return array_map(__FUNCTION__, $d);}else {return $d;}}
