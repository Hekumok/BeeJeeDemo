<?

session_start();

include_once('error_handler.php');
include_once('framework/MVCFramework.php');
include_once('db.php');

$framework = BeeJee\MVCFramework::getInstance();
$framework->setDB($db);
$framework->beforeRoute(function($framework) {
  $framework->user = null;

  if(!isset($_SESSION['login'])) {
    return;
  }
  $admin = AdminModel::model()->find('login = :login', [ 'login' => $_SESSION['login'] ]);

  if(!$admin) {
    return;
  }

  $framework->user = $admin;
});
$framework->run();

?>