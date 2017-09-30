<?php


$filename = "data/counter.txt";
$number = file_get_contents($filename); 
$file = fopen($filename, 'a+'); 
if (flock($file, LOCK_EX)) { 
    ftruncate($file, 0);
    fwrite($file, $number+1); 
    flock($file, LOCK_UN); 
} 
fclose($file); 


$fp = fopen("data/counter2.txt", "r+");

while(flock($fp, LOCK_EX)) {  // acquire an exclusive lock
    // waiting to lock the file
}

$counter = intval(fread($fp, filesize("data/counter2.txt")));
$counter++;

ftruncate($fp, 0);      // truncate file
fwrite($fp, $counter);  // set your data
fflush($fp);            // flush output before releasing the lock
flock($fp, LOCK_UN);    // release the lock

fclose($fp);
