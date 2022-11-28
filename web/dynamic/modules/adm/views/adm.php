<?php $status = require($_SERVER['DOCUMENT_ROOT'].'/settings/status.php');?>

<h2>Админ панель</h2>
<hr>
<?php if(chAccess("changeStatus")): ?>
<h4>Изменить статус пользователя</h4>
<form class="p-4 p-md-5 border rounded-3 bg-light text-center" action="/adm/a/changeStatus" method="post">
  <div class="form-floating mb-3">
    <input type="text" class="form-control" id="floatingInput" name="login" placeholder="Login" required>
    <label for="floatingInput">Логин</label>
  </div>
  <select class="form-select" aria-label="Default select example" name="stat">

      <?php $c = -1; foreach ($status as $kay){$c++;}; $i = 0; while ($i < $c):?>

      <option value="<?php echo $i?>"><?php echo $status[$i]?></option>

      <?php $i++; endwhile;?>

  </select>
  <button class="w-100 btn btn-lg btn-primary" type="submit">Изменить</button>
</form>
<?php endif; ?>