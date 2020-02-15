<?

class NoteController extends Controller {
  public function createAction() {
    $emptyName = empty($_POST['name']);
    $emptyText = empty($_POST['text']);
    $incorrectEmail = !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

    if(!empty($_POST) && !$emptyText && !$emptyName && !$incorrectEmail) {
      $model = NoteModel::model()->create([ 'email' => $_POST['email'], 'text' => $_POST['text'], 'name' => $_POST['name'] ]);

      if($model) {
        unset($_POST);

        return $this->render('create', [ 'success' => true, 'emptyName' => false, 'emptyText' => false, 'incorrectEmail' => false ]);
      }
    }

    $this->render('create', [
      'success' => false,
      'emptyName' => !empty($_POST) && $emptyName,
      'emptyText' => !empty($_POST) && $emptyText,
      'incorrectEmail' => !empty($_POST) && $incorrectEmail,
    ]);
  }
}

?>