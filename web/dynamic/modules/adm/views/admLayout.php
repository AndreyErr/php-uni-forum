<main class="d-flex flex-nowrap mt-0" style="min-height: 80vh;">
  <div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark" style="width: 280px;">
    <a href="/adm" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
      <span class="fs-4">Админ панель</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
      <li class="nav-item"><a href="/adm" class="nav-link text-white" aria-current="page">Главная</a></li>
      <?php if(chAccess("ban")): ?>
      <li><a href="/adm/users" class="nav-link text-white">Пользователи</a></li>
      <?php endif; ?>
      <li><a href="/u" class="nav-link text-white">В профиль</a></li>
    </ul>
  </div>
  <div class="container">

    <?php echo $content;?>
    
  </div>
</main>
