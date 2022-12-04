<!--Верхний блок главной страницы-->
<?php if(array_key_exists('login', $_COOKIE)): // Верхний блок для авторизированных ?>
<div class="container col-xxl-9 px-4 py-5">
  <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
    <div class="col-10 col-sm-8 col-lg-6">
      <img src="/src/img/mainTop<?php echo $data['upImage']?>.png" class="d-block mx-lg-auto img-fluid" alt="Bootstrap Themes" width="700" height="500" loading="lazy">
    </div>
    <div class="col-lg-6">
      <h1 class="display-5 fw-bold lh-1 mb-3">Добро пожаловать на IT forum</h1>
      <p class="lead">Здесь вы сможете получить ответы на свои вопросы в сфере технологий и пообщаться на актуальные темы с сообществом.</p>
      <div class="d-grid gap-2 d-md-flex justify-content-md-start">
        <a href="/f"><button type="button" class="btn btn-primary btn-lg px-4 me-md-2">На форум</button></a>
        <a href="/u"><button type="button" class="btn btn-outline-secondary btn-lg px-4">В аккаунт</button></a>
      </div>
    </div>
  </div>
</div>
<?php else: // Верхний блок для не авторизированных ?>
<div class="container col-xl-10 col-xxl-8 px-4 py-5">
  <div class="row align-items-center g-lg-5 py-5">
    <div class="col-lg-7 text-center text-lg-start">
      <h1 class="display-4 fw-bold lh-1 mb-3">Войти</h1>
      <p class="col-lg-10 fs-4">Войдите в свой аккаунт для полного доступа к IT forum. Здесь вы сможете получить ответы на свои вопросы в сфере технологий и пообщаться на актуальные темы с сообществом.</p>
    </div>
    <div class="col-md-10 mx-auto col-lg-5">
      <form class="p-4 p-md-5 border rounded-3 bg-light text-center" action="/user/a/authorize" method="post">
        <div class="form-floating mb-3">
          <input type="text" class="form-control" id="floatingInput" name="login" placeholder="Login" required>
          <label for="floatingInput">Логин</label>
        </div>
        <div class="form-floating mb-3">
          <input type="password" class="form-control" id="floatingPassword" name="pass" placeholder="Password" required>
          <label for="floatingPassword">Пароль</label>
        </div>
        <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" id="rememb" name="rememb" value="yes">
          <label class="form-check-label" for="rememb">Запомнить меня в этом браузере</label>
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Войти</button>
        <hr class="my-4">
        <small class="text-muted">Нет аккаутна? <a href="/u/reg">Создайте!</a></small>
      </form>
    </div>
  </div>
</div>
<?php endif; ?>

<?php if(is_object($data['recomendedTopics'])): // Рекомендации, если они есть ?>
<!--Топ обсуждения главной страницы-->
<div class="container px-4">
  <h2 class="pb-2 border-bottom">Топ темы</h2>
  <div class="row align-items-md-stretch align-items-center">
    <?php foreach ($data['recomendedTopics'] as $kay):?>
    <div class="col-md-6" style="padding: 20px;">
      <div class="h-100 p-5 text-bg-dark rounded-3">
        <h2><?php echo $kay['topicName']?></h2>
        <p>Просмотров: <?php echo $kay['viewAllTime']?> | Находится в разделе "<?php echo $kay['name']?>"</p>
        <a href="/f/<?php echo $kay['unitUrl']?>/<?php echo $kay['topicId']?>"><button class="btn btn-outline-light" type="button">Посмотреть тему</button></a>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</div>
<?php endif; ?>
<!--Главные темы-->
<div class="container px-4 py-5" id="hanging-icons">
  <h2 class="pb-2 border-bottom">Какой раздел вас интересует?</h2>
  <div class="row g-4 py-5 row-cols-1 row-cols-lg-3">
    <?php foreach ($data['mainTop'] as $kay):?>
    <div class="col d-flex align-items-start" style= "padding-bottom: 20px;">
      <div class="icon-square d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3">
        <?php echo $kay['icon']?>
      </div>
      <div>
        <h3 class="fs-2"><?php echo $kay['name']?></h3>
        <p><?php echo $kay['descr']?></p>
        <a href="/f/<?php echo $kay['unitUrl']?>" class="btn btn-primary">Посмотреть про <?php echo $kay['name']?></a>
      </div>
    </div>
    <?php endforeach;?>
  </div>
  <a href="/f">
      <div class="d-grid gap-2">
        <button class="btn btn-primary" type="button">Смотреть все разделы</button>
      </div>
    </a>
</div>