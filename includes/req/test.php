<?php
$delete = "6,drug,2023-01-01,2 times a day,5000";

$data = file("cart.txt");
$out = array();

foreach ($data as $line) {
    if (trim($line) != $delete) {
        $out[]  = $line;
    }
}

$fp = fopen("cart.txt", "w+");
flock($fp, LOCK_EX);
foreach ($out as $line) {
    fwrite($fp,  $line);
}
flock($fp, LOCK_UN);
fclose($fp);
