<?
use BeeJee\MVCFramework as Framework;

abstract class Controller {
  public $layout = 'default';

  public function __construct() {
    $framework = Framework::getInstance();
    $this->framework = $framework;
  }

  public function name() {
    return substr(static::class, 0, -strlen('Controller'));
  }

  protected function viewPath(string $viewName) {
    $root = $_SERVER['DOCUMENT_ROOT'];

    return $root . '/views/' . strtolower($this->name()) . '/' . strtolower($viewName) . '.php';
  }

  protected function layoutPath() {
    $root = $_SERVER['DOCUMENT_ROOT'];

    return $root . '/views/layouts/' . strtolower($this->layout) . '.php';
  }

  public function action(string $actionName = null, array $params = []) {
    if(empty($actionName)) {
      $actionName = 'default';
    }

    $methodName = strtolower($actionName) . 'Action';

    if(!method_exists($this, $methodName)) {
      return header('Location: /404');
    }

    $this->$methodName($params);
  }

  protected function render(string $viewName, array $params = []) {
    extract($params);

    ob_start();
    include($this->viewPath($viewName));
    $content = ob_get_clean();

    $this->renderPage($content);
  }

  protected function renderPage(string $content) {
    include($this->layoutPath());
  }
}

?>