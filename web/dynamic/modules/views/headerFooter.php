<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="author" content="a9165185808@gmail.com">
        <meta name="viewport" content="width=device-width" />
        <link rel="icon" type="image/png" href="/src/img/siteImg/ico.png">
        <title><?php echo $path ?></title><!-------ИЗМЕНИТЬ-ПУТЬ------------------------------------>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet">
        <link href="/src/css/lib/bootstrap.min.css" rel="stylesheet">
        <link href="/src/css/main.css" rel="stylesheet">
        <?php if(array_key_exists('css', $data)){
          foreach($data['css'] as &$value){
          echo '<link href="/src/css/'.$value.'.css" rel="stylesheet">';
        }
        }?>
        <?php if(array_key_exists('jsUpSrc', $data)){
          foreach($data['jsUpSrc'] as &$value){
            echo '<script src="'.$value.'"></script>';
        }
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
                    <a class="nav-link" href="#">Link</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link active" href="#">Link</a>
                  </li>
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Link</a>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="#">Action</a></li>
                      <li><a class="dropdown-item" href="#">Another action</a></li>
                      <li><hr class="dropdown-divider"></li>
                      <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                  </li>
                </ul>
              </div>
<?php if(array_key_exists('login', $_COOKIE)): // Шапка для авторизированных ?>
              <div class="collapse navbar-collapse justify-content-end" id="navbarScroll">
                <ul class="navbar-nav navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                  <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="#">Home</a>
                  </li>
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">@<? echo decode($_COOKIE['login'])?></a>
                    <ul class="dropdown-menu">
                      <li class="dropdown-item">Последние темы:</li>
                      <li><a class="dropdown-item" href="#">Action</a></li>
                      <li><a class="dropdown-item" href="#">Another action</a></li>
                      <li><hr class="dropdown-divider"></li>
                      <li><a class="dropdown-item" href="/u">Моя страница</a></li>
                      <li><a class="dropdown-item" href="/user/a/exit">Выход</a></li>
                    </ul>
                  </li>
                  <li class="nav-item navbar-brand">
                    <a href="/u" class="d-block">
                        <img src="../files/img/avatar/<?php echo $_COOKIE['photo']; ?>.png" alt="X" width="32" height="32" class="rounded-circle">
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
              <li class="nav-item"><a href="/about" class="nav-link px-2 text-muted">О форуме</a></li>
            </ul>
            <p class="text-center text-muted">&copy; IT forum, 2022</p>
          </footer>

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <script src="/src/js/lib/bootstrap.min.js"></script>
        <script src="/src/js/lib/bootstrap.bundle.min.js"></script>
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
    </body>
</html>