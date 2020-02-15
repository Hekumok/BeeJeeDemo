<p>
  <h3>
    Сортировать по:
    <? foreach($orders as $key => $order): ?>
      <a
        href="?<?= http_build_query(mergeQuery([
          'orderBy' => $key,
          'orderDir' => $order['active'] ? $orderDirs[1 - array_search($order['dir'], $orderDirs)] : $order['dir'],
        ])) ?>"
        class="btn btn-<?= $order['active'] ? 'primary' : 'secondary' ?> btn-default"
        role="button"
        aria-pressed="true"
      ><?= $order['text'] ?> <i class="mdi mdi-arrow-<?= $order['dir'] == 'ASC' ? 'up' : 'down' ?>-bold" aria-hidden="true"></i></a>
    <? endforeach; ?>
  </h3>
</p>
<? foreach($notes as $note): ?>
  <div class="card my-2">
  <div class="card-body">
    <h5 class="card-title"><?= htmlspecialchars($note->name, ENT_QUOTES) . ' : ' . htmlspecialchars($note->email, ENT_QUOTES) ?></h5>
    <p class="card-text"><?= htmlspecialchars($note->text, ENT_QUOTES) ?></p>
    <? if($note->completed): ?>
      <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Выполнена">
        <i class="mdi mdi-checkbox-marked-circle-outline" aria-hidden="true"></i>
      </button>
    <? endif; ?>
    <? if($note->changed): ?>
      <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Изменена администратором">
        <i class="mdi mdi-account-edit" aria-hidden="true"></i>
      </button>
    <? endif; ?>
    <? if($this->framework->user): ?>
      <a href="/note/update?id=<?= $note->id ?>" class="btn btn-primary float-right">Редактировать</a>
    <? endif; ?>
  </div>
</div>
<? endforeach; ?>
<nav aria-label="pagination" class="float-right">
  <ul class="pagination">
    <? if($pagination['current'] > 1): ?>
      <li class="page-item">
        <a class="page-link" href="?<?= http_build_query(mergeQuery([ 'page' => 1 ])) ?>"><<</a>
      </li>
    <? endif; ?>
    <? foreach($pagination['pages'] as $page): ?>
      <li class="page-item<?= $page == $pagination['current'] ? ' active' : '' ?>">
        <a class="page-link" href="?<?= http_build_query(mergeQuery([ 'page' => $page ])) ?>"><?= $page ?></a>
      </li>
    <? endforeach; ?>
    <? if($pagination['current'] < $pagination['max']): ?>
      <li class="page-item">
        <a class="page-link" href="?<?= http_build_query(mergeQuery([ 'page' => $pagination['max'] ])) ?>">>></a>
      </li>
    <? endif; ?>
  </ul>
</nav>
<a class="btn btn-primary" href="/note/create" role="button">Добавить</a>