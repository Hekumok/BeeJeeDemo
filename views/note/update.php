<p><a href='/'>< На главную</a></p>
<? if($success): ?>
  <p class='text-success'>Задача успешно изменена.</p>
<? endif; ?>
<form action="/note/update?id=<?= $note->id ?>" method="POST">
  <div class="form-group">
    <label for="name">Имя</label>
    <div class="col-sm-7">
      <input
        type="text"
        class="form-control"
        id="name"
        value="<?= $note->name ?>"
        disabled
      >
    </div>
  </div>
  <div class="form-group">
    <label for="email">Email</label>
    <div class="col-sm-7">
      <input
        type="email"
        class="form-control"
        id="email"
        value="<?= $note->email ?>"
        disabled
      >
    </div>
  </div>
  <div class="form-group">
    <label for="text" class="<?= $emptyText ? 'text-danger' : '' ?>">Текст</label>
    <div class="col-sm-7">
      <textarea
        class="form-control<?= $emptyText ? ' is-invalid' : '' ?>"
        name="text"
        id="text"
        required
      ><?= $note->text ?></textarea>
    </div>
    <? if($emptyText): ?>
      <div class="col-sm-3">
        <small id="textHelp" class="text-danger">
          Это поле не может быть пустым.
        </small>
      </div>
    <? endif; ?>
  </div>
  <div class="form-group form-check">
    <input type="checkbox" class="form-check-input" name="completed" id="completed" <?= $note->completed ? 'checked' : '' ?>>
    <label class="form-check-label" for="completed">Выполнена</label>
  </div>
  <div class="form-group form-check">
    <input type="checkbox" class="form-check-input" id="changed" disabled <?= $note->changed ? 'checked' : '' ?>>
    <label class="form-check-label" for="changed">Изменена</label>
  </div>
  <button type="submit" class="btn btn-primary">Изменить</button>
</form>