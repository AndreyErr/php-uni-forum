<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="author" content="a9165185808@gmail.com">
        <meta name="viewport" content="width=device-width" />
        <link rel="icon" type="image/png" href="/src/img/siteImg/ico.png">
        <title><?php echo $path ?></title>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet">
        <link href="/src/css/main.css" rel="stylesheet">
        <link href="/src/css/lib/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <nav class="navbar p-3 navbar-expand navbar-dark bg-dark fixed-top d-flex flex-wrap">
            <div class="container">
              <a class="navbar-brand" href="#">Navbar scroll</a>
              <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                  <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
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
                  <li class="nav-item">
                    <a class="nav-link disabled">Link</a>
                  </li>
                </ul>
              </div>
              <div class="collapse navbar-collapse justify-content-end" id="navbarScroll">
                <ul class="navbar-nav navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                  <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="#">Home</a>
                  </li>
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Link
                    </a>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="#">Action</a></li>
                      <li><a class="dropdown-item" href="#">Another action</a></li>
                      <li><hr class="dropdown-divider"></li>
                      <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="d-block">
                        <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle">
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </nav>
          <div class="noneBlock"></div>



          



          <?php echo $content ?>






          <footer class="py-3 bg-dark">
            <ul class="nav justify-content-center pb-3 mb-3">
              <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Home</a></li>
              <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Features</a></li>
              <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Pricing</a></li>
              <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">FAQs</a></li>
              <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">About</a></li>
            </ul>
            <p class="text-center text-muted">&copy; 2022 Company, Inc</p>
          </footer>

        <script src="/src/js/lib/bootstrap.min.js"></script>
        <script src="/src/js/lib/bootstrap.bundle.min.js"></script>
    </body>
</html>