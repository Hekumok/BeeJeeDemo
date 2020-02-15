<p><a href='/'>< На главную</a></p>
<? if($success): ?>
  <p class='text-success'>Задача успешно добавлена.</p>
<? endif; ?>
<form action="/note/create" method="POST">
  <div class="form-group">
    <label for="name" class="<?= $emptyName ? 'text-danger' : '' ?>">Имя</label>
    <div class="col-sm-7">
      <input
        type="text"
        class="form-control<?= $emptyName ? ' is-invalid' : '' ?>"
        name="name"
        id="name"
        value="<?= $_POST['name'] ?>"
        required
      >
    </div>
    <? if($emptyName): ?>
      <div class="col-sm-3">
        <small id="nameHelp" class="text-danger">
          Это поле не может быть пустым.
        </small>
      </div>
    <? endif; ?>
  </div>
  <div class="form-group">
    <label for="email" class="<?= $incorrectEmail ? 'text-danger' : '' ?>">Email</label>
    <div class="col-sm-7">
      <input
        type="email"
        class="form-control<?= $incorrectEmail ? ' is-invalid' : '' ?>"
        name="email"
        id="email"
        value="<?= $_POST['email'] ?>"
        required
      >
    </div>
    <? if($incorrectEmail): ?>
      <div class="col-sm-3">
        <small id="emailHelp" class="text-danger">
          Некорректный email.
        </small>
      </div>
    <? endif; ?>
  </div>
  <div class="form-group">
    <label for="text" class="<?= $emptyText ? 'text-danger' : '' ?>">Текст</label>
    <div class="col-sm-7">
      <textarea
        class="form-control<?= $emptyText ? ' is-invalid' : '' ?>"
        name="text"
        id="text"
        required
      ><?= $_POST['text'] ?></textarea>
    </div>
    <? if($emptyText): ?>
      <div class="col-sm-3">
        <small id="textHelp" class="text-danger">
          Это поле не может быть пустым.
        </small>
      </div>
    <? endif; ?>
  </div>
  <button type="submit" class="btn btn-primary">Создать</button>
</form>