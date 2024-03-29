<!DOCTYPE html>
<html lang="ru">
  <head>
      <meta charset="utf-8">
      <meta name="author" content="a9165185808@gmail.com">
      <meta name="viewport" content="width=device-width" />
      <link rel="icon" type="image/png" href="/src/img/siteImg/ico.png">
      <title><?php echo $name ?></title>
      <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet">
      <link href="/src/css/lib/bootstrap.min.css" rel="stylesheet">
      <link href="/src/css/main.css" rel="stylesheet">
      <?php if(array_key_exists('css', $data)){
        foreach($data['css'] as &$value)
          echo '<link href="/src/css/'.$value.'.css" rel="stylesheet">';
      }?>
      <?php if(array_key_exists('jsUpSrc', $data)){
        foreach($data['jsUpSrc'] as &$value)
          echo '<script src="'.$value.'"></script>';
      }?>
  </head>
  <body>
    <!--Шапка-->
    <nav class="navbar p-3 navbar-expand navbar-dark bg-dark fixed-top d-flex flex-wrap">
      <div class="container">
        <a class="navbar-brand" href="/">IT forum</a>
        <div class="collapse navbar-collapse" id="navbarScroll">
          <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="/f">Форум</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="https://github.com/AndreyErr/php-uni-forum" target="_blank">GitHub</a>
            </li>
          </ul>
        </div>
        <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search" action="/f/find" method="POST">
          <input type="search" class="form-control" placeholder="Поиск топика" name="find" aria-label="Search">
        </form>
        <?php if(array_key_exists('login', $_COOKIE)): // Шапка для авторизированных ?>
        <div class="collapse navbar-collapse justify-content-end" id="navbarScroll">
          <ul class="navbar-nav navbar-nav-scroll" style="--bs-scroll-height: 100px;">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">@<? echo decode($_COOKIE['login'])?></a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/u">Моя страница</a></li>
                <li><a class="dropdown-item" href="/user/a/exit">Выход</a></li>
                <?php if(chAccess("adm")):?>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="/adm">Админ парель</a></li>
                <?php endif;?>
              </ul>
            </li>
            <li class="nav-item navbar-brand">
              <a href="/u" class="d-block">
                <img src="<?php echo view::specialDataGet('fileData/avatar/folder').$_COOKIE['photo']; ?>.png" alt="X" width="32" height="32" class="img-responsive rounded-circle mx-auto img-top">
              </a>
            </li>
          </ul>
        </div>
        <?php else: // Шапка для не авторизированных  ?>
        <div class="text-end">
          <a href="/"><button type="button" class="btn btn-outline-light me-2">Войти</button></a>
          <a href="/u/reg"><button type="button" class="btn btn-warning">Регистрация</button></a>
        </div>
        <?php endif; ?>
      </div>
    </nav>
    <div class="noneBlock"></div>
    <!--Основное тело-->
        
    <?php echo $message ?>
    <?php echo $content ?>
        
    <!--Подвал-->
    <footer class="footer py-3 bg-dark mt-auto">
      <ul class="nav justify-content-center pb-3 mb-3">
        <li class="nav-item"><a href="/" class="nav-link px-2 text-muted">Главная</a></li>
        <li class="nav-item"><a href="/f" class="nav-link px-2 text-muted">Форум</a></li>
      </ul>
      <p class="text-center text-muted">&copy; IT forum, 2022</p>
    </footer>
    <?php if(array_key_exists('jsSrc', $data)){
      foreach($data['jsSrc'] as &$value){
      echo '<script src="'.$value.'"></script>';
    }
    }?>
    <?php if(array_key_exists('js', $data)){
      foreach($data['js'] as &$value){
      echo '<script src="/src/js/'.$value.'.js"></script>';
    }
    }?>
    <script src="/src/js/lib/bootstrap.min.js"></script>
    <script src="/src/js/lib/bootstrap.bundle.min.js"></script>
  </body>
</html>