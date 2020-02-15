<?

class AdminController extends Controller {
  public function loginAction() {
    if($this->framework->user) {
      return header('Location: /');
    }

    if(!isset($_POST['login']) || !isset($_POST['password'])) {
      return $this->render('default');
    }

    $admin = AdminModel::model()->find('login = :login', [ 'login' => $_POST['login'] ]);

    if(!$admin) {
      return $this->render('default', [ 'error' => 'incorrectLogin' ]);
    }

    if(!password_verify($_POST['password'], $admin->password)) {
      return $this->render('default', [ 'error' => 'incorrectPassword' ]);
    }

    $_SESSION['login'] = $_POST['login'];

    return header('Location: /');
  }

  public function logoutAction() {
    setcookie(session_name(), "", time() - 3600);
    session_destroy();
    session_write_close();

    return header('Location: /');
  }
}

?>