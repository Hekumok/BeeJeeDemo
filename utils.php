<?

function startsWith($haystack, $needle) {
  return substr_compare($haystack, $needle, 0, strlen($needle)) === 0;
}

function endsWith($haystack, $needle) {
  return substr_compare($haystack, $needle, -strlen($needle)) === 0;
}

function mergeQuery($params) {
  $uri = $_SERVER['REQUEST_URI'];
  $urlData = parse_url($uri);
  parse_str($urlData['query'], $origParams);

  return array_merge($origParams, $params);
}