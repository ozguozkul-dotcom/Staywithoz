<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$countFile = '/tmp/count.txt';
$ipFile = '/tmp/ips.json';

$userIP = $_SERVER['REMOTE_ADDR'];
$today = date('Y-m-d');

if (!file_exists($countFile)) {
    file_put_contents($countFile, '0');
}
if (!file_exists($ipFile)) {
    file_put_contents($ipFile, '{}');
}

$ips = json_decode(file_get_contents($ipFile), true);
if (!isset($ips[$today])) {
    $ips[$today] = [];
}

if (!in_array($userIP, $ips[$today])) {
    $ips[$today][] = $userIP;
    $count = (int)file_get_contents($countFile);
    $count++;
    file_put_contents($countFile, $count);
    file_put_contents($ipFile, json_encode($ips));
}

echo json_encode(['count' => (int)file_get_contents($countFile)]);
?>
