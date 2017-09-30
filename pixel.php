<?php


function getRealIpAddr()
{
  if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
  {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
  }
  elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
  {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
  }
  else
  {
    $ip = $_SERVER['REMOTE_ADDR'];
  }
  return $ip;
}

$record = array();
$date = new \DateTime();
$record['id'] = getRealIpAddr();
$record['date'] = $date->format('Y-m-d');
$record['time'] = $date->format('H:i:s');

try {
	$fp = fopen('data/pixel.csv', 'a+');
	fputcsv($fp, $record);
	fclose($fp);	
} catch (Exception $e) {

}

