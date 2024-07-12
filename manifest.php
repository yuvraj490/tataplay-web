<?php

// Created & Packed by @yuvraj824, Join @m3u_lovers on Telegram

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

$fetcherJson = file_get_contents('bpprod.json');
$fetcherData = json_decode($fetcherJson, true);
$id = $_GET['id'] ?? null;

if ($id === null) {
  echo '<h1>Error: No Channel ID provided</h1>';
  exit;
}
$channelData = null;
foreach ($fetcherData['data']['channels'] as $channel) {
  if ($channel['id'] === $id) {
    $channelData = $channel;
    break;
  }
}

if ($channelData === null) {
  echo '<h1>Error: Channel not found</h1>';
  exit;
}

$currentTimestamp = time();

$beginTimestamp = $currentTimestamp - (8 * 24 * 60 * 60);


$endTimestamp = $currentTimestamp + (2 * 24 * 60 * 60);

$beginFormatted = gmdate('Ymd\THis', $beginTimestamp);
$endFormatted = gmdate('Ymd\THis', $endTimestamp);

$manifestUrl = $channelData['manifest_url'];

$time = '?begin=' . $beginFormatted . '&end=' . $endFormatted;

$mpdurl = $manifestUrl.$time;
header("Location: $mpdurl")
?>