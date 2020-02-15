<?
error_reporting(~0);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

set_error_handler(function($errno, $errstr, $errfile, $errline) {
  if(!($errno & error_reporting())) {
    return;
  }

  $e = [
    'type'    => $errno,
    'message' => $errstr,
    'file'    => $errfile,
    'line'    => $errline,
  ];

  redirect($e);
});


set_exception_handler(function($e) {
  $e = [
    'type'    => $e->getCode(),
    'message' => $e->getMessage(),
    'file'    => $e->getFile(),
    'line'    => $e->getLine(),
  ];

  redirect($e);
});


register_shutdown_function(function () {
  if(!is_null($e = error_get_last())) {
    redirect($e);
  }
});

function redirect($e) {
  $now = date('d-M-Y H:i:s');
  $message = "[$now] {$e['type']}: {$e['message']} in {$e['file']} on line {$e['line']}\n";
  $error_log_name = ini_get('error_log');
  error_log($message, 3, $error_log_name);

  switch ($e['type']) {
    case 0:
    case E_ERROR:
    case E_PARSE:
    case E_CORE_ERROR:
    case E_COMPILE_ERROR:
    case E_USER_ERROR:
      // header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
      return header('Location: /error');
  }
}
?>