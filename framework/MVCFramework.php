<?
namespace BeeJee;

include_once($_SERVER['DOCUMENT_ROOT'] . '/utils.php');

function pathToModel($modelName) {
  $path = $modelName == 'Model' ? '' : $_SERVER['DOCUMENT_ROOT'] . '/models/';

  return $path . $modelName . '.php';
}

function pathToController($controllerName) {
  $path = $controllerName == 'Controller' ? '' : $_SERVER['DOCUMENT_ROOT'] . '/controllers/';

  return $path . $controllerName . '.php';
}

spl_autoload_register(function($className) {
  if(\endsWith($className, 'Model')) {
    include_once(pathToModel($className));
  }

  if(\endsWith($className, 'Controller')) {
    include_once(pathToController($className));
  }
});

class MVCFramework {
  private static $instance = null;
  protected static $beforeRouteHandler = null;

  protected function __clone() {}

  protected function __construct() {
    $this->initDB();
  }

  protected function initDB() {
    $dsn = 'mysql:host=localhost;dbname=beejee';
    $username = 'hekumok';
    $password = 'Lil1love';
    $options = [
      \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
      \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
      \PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    $this->db = new \PDO($dsn, $username, $password, $options);
  }

  public function beforeRoute($func) {
    if(is_callable($func)) {
      $this->beforeRouteHandler = $func;
    }
  }

  protected function getRouterData() {
    $uri = $_SERVER['REQUEST_URI'];
    $urlData = parse_url($uri);
    $path = trim($urlData['path'], '/');
    $pathParts = explode('/', $path);
    parse_str($urlData['query'], $params);

    return [
      'controllerName' => $pathParts[0],
      'actionName' => $pathParts[1],
      'params' => $params,
    ];
  }

  public function run() {
    $data = $this->getRouterData();

    $controllerName = ucfirst(strtolower($data['controllerName'])) ?: 'Default';
    $controllerClassName = $controllerName . 'Controller';

    if(!file_exists(pathToController($controllerClassName))) {
      return header('Location: /404');
    }

    if(is_callable($this->beforeRouteHandler)) {
      call_user_func($this->beforeRouteHandler, $this);
    }

    $controller = new $controllerClassName;
    $controller->action($data['actionName'], $data['params']);
  }

  public static function getInstance() {
    if(!static::$instance) {
      static::$instance = new static;
    }

    return static::$instance;
  }
}

?>