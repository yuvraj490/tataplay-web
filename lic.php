<?php

// Created & Packed by @yuvraj824, Join @m3u_lovers on Telegram

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

$fetcherJsonCacheFile = 'fetcher.json.cache';
$fetcherJsonCacheExpire = 10800; // Cache expires every 3 hour.

if (file_exists($fetcherJsonCacheFile) && (filemtime($fetcherJsonCacheFile) + $fetcherJsonCacheExpire > time())) {
  $fetcherJson = file_get_contents($fetcherJsonCacheFile);
} else {

  $fetcherJson = @file_get_contents('https://tplayapi.code-crafters.app/321codecrafters/fetcher.json');
  if ($fetcherJson !== false) {
    file_put_contents($fetcherJsonCacheFile, $fetcherJson);
  } else {
    http_response_code(500);
    echo '<h1>Error fetching JSON data</h1>';
    exit;
  }
}

if (isset($_GET['id'])) {
  $id = htmlspecialchars($_GET['id']);

  $jsonData = json_decode($fetcherJson, true);

  $channel = null;
  foreach ($jsonData['data']['channels'] as $c) {
    if ($c['id'] === $id) {
      $channel = $c;
      break;
    }
  }

  if ($channel) {
    $clearKey = $channel['clearkeys'][0];
    $keyParts = explode(':', $clearKey['hex']);

    echo json_encode([
      'lic_keyId' => $keyParts[0],
      'lic_key' => $keyParts[1]
    ]);
  } else {
    http_response_code(404);
    echo "error";
  }
} else {
  http_response_code(400);
  echo "error2";
}
?>