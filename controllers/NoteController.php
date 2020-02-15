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
      'success'        => false,
      'emptyName'      => !empty($_POST) && $emptyName,
      'emptyText'      => !empty($_POST) && $emptyText,
      'incorrectEmail' => !empty($_POST) && $incorrectEmail,
    ]);
  }

  public function updateAction($params) {
    if(!isset($params['id']) || !$this->framework->user) {
      return header('Location: /');
    }

    $id = intval($params['id']);

    $note = NoteModel::model()->find('id = :id', [ 'id' => $id ]);

    if(!$note) {
      return header('Location: /');
    }

    $success = false;

    if(!empty($_POST) && !empty($_POST['text'])) {
      if($note->text != $_POST['text']) {
        $note->changed = true;
      }

      $note->text = $_POST['text'];
      $note->completed = intval(isset($_POST['completed']));

      if($note->update(['text', 'completed', 'changed'])) {
        $success = true;
      }
    }

    $this->render('update', [
      'success'   => $success,
      'note'      => $note,
      'emptyText' => !empty($_POST) && empty($_POST['text']),
    ]);
  }
}

?>