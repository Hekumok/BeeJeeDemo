<?

class DefaultController extends Controller {
  public function defaultAction($params) {
    $perPage = 3;
    $pagesOffset = 2;
    $page = isset($params['page']) ? (intval($params['page']) ?: 1) : 1;
    $noteQuantity = NoteModel::model()->count();
    $maxPage = ceil($noteQuantity / $perPage);
    $notes = NoteModel::model()->findAll('', [], $perPage, $perPage * ($page - 1));
    $pages = [];

    for($i = max($page - $pagesOffset, 1), $max = min($page + $pagesOffset, $maxPage); $i <= $max; ++$i)
      $pages[] = $i;

    $pagination = [
      'current' => $page,
      'max' => $maxPage,
      'pages' => $pages,
    ];

    return $this->render('default', [ 'notes' => $notes, 'pagination' => $pagination ]);
  }
}

?>