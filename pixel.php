<?php


if ($_GET["a"] === "0") {
  $record = array();
  $date = new \DateTime();
  $record['id'] = getRealIpAddr();
  $record['date'] = $date->format('Y-m-d');
  $record['time'] = $date->format('H:i:s');

  try {
    $fp = fopen('data/pixel.csv', 'a+');
    if ( !$fp ) {
      throw new Exception('File open failed.');
    }
    if (flock($fp, LOCK_EX)){
      fputcsv($fp, $record);
      flock($fp, LOCK_UN);
      fclose($fp);
    }
  } catch (Exception $e) {
    exit;
  }
} elseif ($_GET["a"] === "1") {
  try {
    $fp = fopen('data/count.txt', 'c+');
    if ( !$fp ) {
      throw new Exception('File open failed.');
    } 
    if (flock($fp, LOCK_EX)){
      $count = (int)fread($fp, filesize('data/count.txt'));
      ftruncate($fp, 0);
      fseek($fp, 0);
      fwrite($fp, ++$count);
      flock($fp, LOCK_UN);
      fclose($fp);
    }
  } catch (Exception $e) {
    exit;
  }
}

function getRealIpAddr()
{
  if (!empty($_SERVER['HTTP_CLIENT_IP']))
  {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
  }
  elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
  {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
  }
  else
  {
    $ip = $_SERVER['REMOTE_ADDR'];
  }
  return $ip;
}










