<!--Верхний блок главной страницы-->
<?php if(false): // Верхний блок для авторизированных ?>
<div class="container col-xxl-9 px-4 py-5">
<div class="row flex-lg-row-reverse align-items-center g-5 py-5">
    <div class="col-10 col-sm-8 col-lg-6">
      <img src="https://fullhdpictures.com/wp-content/uploads/2016/12/Peregrine-falcon-Wallpapers-HD.jpg" class="d-block mx-lg-auto img-fluid" alt="Bootstrap Themes" width="700" height="500" loading="lazy">
    </div>
    <div class="col-lg-6">
      <h1 class="display-5 fw-bold lh-1 mb-3">Responsive left-aligned hero with image</h1>
      <p class="lead">Quickly design and customize responsive mobile-first sites with Bootstrap, the world’s most popular front-end open source toolkit, featuring Sass variables and mixins, responsive grid system, extensive prebuilt components, and powerful JavaScript plugins.</p>
      <div class="d-grid gap-2 d-md-flex justify-content-md-start">
        <button type="button" class="btn btn-primary btn-lg px-4 me-md-2">Primary</button>
        <button type="button" class="btn btn-outline-secondary btn-lg px-4">Default</button>
      </div>
    </div>
  </div>
</div>
<?php else: // Верхний блок для не авторизированных ?>
<div class="container col-xl-10 col-xxl-8 px-4 py-5">
  <div class="row align-items-center g-lg-5 py-5">
    <div class="col-lg-7 text-center text-lg-start">
      <h1 class="display-4 fw-bold lh-1 mb-3">Войти qwerty123#</h1>
      <p class="col-lg-10 fs-4">Войдите в свой аккаунт для полного доступа к IT forum.</p>
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
        <button class="w-100 btn btn-lg btn-primary" type="submit">Sign up</button>
        <hr class="my-4">
        <small class="text-muted">Нет аккаутна? <a href="/u/reg">Создайте!</a></small>
      </form>
    </div>
  </div>
</div>
<?php endif; ?>

<!--Топ обсуждения главной страницы-->
<div class="container px-4">
  <h2 class="pb-2 border-bottom">Топ обсуждения</h2>
  <div class="row align-items-md-stretch align-items-center">
    <div class="col-md-6" style="padding: 20px;">
      <div class="h-100 p-5 text-bg-dark rounded-3">
        <h2>Change the background</h2>
        <p>Swap the background-color utility and add a `.text-*` color utility to mix up the jumbotron look. Then, mix and match with additional component themes and more.</p>
        <button class="btn btn-outline-light" type="button">Example button</button>
      </div>
    </div>
    <div class="col-md-6" style="padding: 20px;">
      <div class="h-100 p-5 bg-light border rounded-3">
        <h2>Add borders</h2>
        <p>Or, keep it light and add a border for some added definition to the boundaries of your content. Be sure to look under the hood at the source HTML here as we've adjusted the alignment and sizing of both column's content for equal-height.</p>
        <button class="btn btn-outline-secondary" type="button">Example button</button>
      </div>
    </div>
  </div>
</div>
<!--Главные темы-->
<div class="container px-4 py-5" id="hanging-icons">
  <h2 class="pb-2 border-bottom">Какая тема вас беспокоит?</h2>
  <div class="row g-4 py-5 row-cols-1 row-cols-lg-3">
    <?php foreach ($data['mainTop'] as $kay):?>
    <div class="col d-flex align-items-start" style= "padding-bottom: 20px;">
      <div class="icon-square d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3">
        <?php echo $kay['icon']?>
      </div>
      <div>
        <h3 class="fs-2"><?php echo $kay['name']?></h3>
        <p><?php echo $kay['descr']?></p>
        <a href="/f/<?php echo $kay['topicName']?>" class="btn btn-primary">Посмотреть про <?php echo $kay['name']?></a>
      </div>
    </div>
    <?php endforeach;?>
    <a href="/f">
      <div class="d-grid gap-2">
        <button class="btn btn-primary" type="button">Смотреть все темы</button>
      </div>
    </a>
  </div>
</div>