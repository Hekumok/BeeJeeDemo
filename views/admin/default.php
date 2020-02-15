<?
$incorrectLogin = $error == 'incorrectLogin';
$incorrectPassword = $error == 'incorrectPassword';
?>
<form action="/admin/login/" method="POST">
  <div class="form-group">
    <label for="login" class="<?= $incorrectLogin ? 'text-danger' : '' ?>">Логин</label>
    <div class="col-sm-7">
      <input
        type="text"
        class="form-control<?= $incorrectLogin ? ' is-invalid' : '' ?>"
        name="login"
        id="login"
        value="<?= $_POST['login'] ?>"
        required
      >
    </div>
    <? if($incorrectLogin): ?>
    <div class="col-sm-3">
      <small id="loginHelp" class="text-danger">
        Такого пользователя не существует.
      </small>
    </div>
  <? endif; ?>
  </div>
  <div class="form-group">
    <label for="password" class="<?= $incorrectPassword ? 'text-danger' : '' ?>">Пароль</label>
    <div class="col-sm-7">
      <input
        type="text"
        class="form-control<?= $incorrectPassword ? ' is-invalid' : '' ?>"
        name="password"
        id="password"
        required
      >
    </div>
    <? if($incorrectPassword): ?>
    <div class="col-sm-3">
      <small id="passwordHelp" class="text-danger">
        Неверный пароль.
      </small>
    </div>
  <? endif; ?>
  </div>
  <button type="submit" class="btn btn-primary">Войти</button>
</form>