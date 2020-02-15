<?

class DefaultController extends Controller {
  public function defaultAction($params) {
    $perPage = 3;
    $pagesOffset = 2;
    $page = isset($params['page']) ? (intval($params['page']) ?: 1) : 1;
    $noteQuantity = NoteModel::model()->count();
    $maxPage = ceil($noteQuantity / $perPage);

    $pages = [];

    for($i = max($page - $pagesOffset, 1), $max = min($page + $pagesOffset, $maxPage); $i <= $max; ++$i)
      $pages[] = $i;

    $pagination = [
      'current' => $page,
      'max' => $maxPage,
      'pages' => $pages,
    ];

    $orderDirs = ['ASC', 'DESC'];
    $orders = [ 'name' => [ 'text' => 'Имя' ], 'email' => [ 'text' => 'Email' ], 'completed' => [ 'text' => 'Статус' ] ];
    $orderBy = isset($orders[$params['orderBy']]) ? $params['orderBy'] : null;
    $orderDir = $orderBy && in_array(strtoupper($params['orderDir']), $orderDirs) ? strtoupper($params['orderDir']) : $orderDirs[0];

    foreach($orders as $key => $order) {
      $orders[$key]['dir'] = $orderBy == $key ? $orderDir : $orderDirs[0];
      $orders[$key]['active'] = $orderBy == $key;
    }

    $notes = NoteModel::model()->findAll('', [], $orderBy ? [ 'by' => $orderBy, 'dir' => $orderDir ] : [], $perPage, $perPage * ($page - 1));

    return $this->render('default', [ 'notes' => $notes, 'pagination' => $pagination, 'orders' => $orders, 'orderDirs' => $orderDirs ]);
  }
}

?>