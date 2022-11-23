<main class="container">
<?php if(!array_key_exists('login', $_COOKIE)): // Верхний блок для авторизированных ?>
<div class="container px-4 py-5" id="featured-3" style="background-color: #4682B421; margin-top: 50px; border-radius: 15px;">
    <h2 class="pb-2 border-bottom">Больше возможностей при регистрации</h2>
    <div class="row g-4 py-5 row-cols-1 row-cols-lg-3">
      <div class="feature col">
        <div class="feature-icon d-inline-flex align-items-center justify-content-center fs-2 mb-3">
          <i class="fa-solid fa-comments"></i>
        </div>
        <h3 class="fs-2">Общение</h3>
        <p>Общайтесь с сообществом сайта и помогайте решать свои и их вопросы.</p>
      </div>
      <div class="feature col">
        <div class="feature-icon d-inline-flex align-items-center justify-content-center fs-2 mb-3">
          <i class="fa-solid fa-star"></i>
        </div>
        <h3 class="fs-2">Влияние на посты</h3>
        <p>Понравился пост или нет? ставьте свою отметку, выводя тот или иной пост в топ.</p>
      </div>
      <div class="feature col">
        <div class="feature-icon d-inline-flex align-items-center justify-content-center fs-2 mb-3">
          <i class="fa-regular fa-chart-bar"></i>
        </div>
        <h3 class="fs-2">Создание своих тем</h3>
        <p>Есть интересующая вас тема, которой нет на сайте? Добавьте ёе!</p>
      </div>
    </div>
    <a href="/u/reg">
      <div class="d-grid gap-2">
        <button class="btn btn-primary" type="button">Регистрация</button>
      </div>
    </a>
  </div>
  <?php endif; ?>









          
          
  <!--Главные темы-->
  <div class="container px-4 py-5" id="hanging-icons">
    <h2 class="pb-2 border-bottom">Все главные темы <?php if(array_key_exists('status', $_COOKIE) && decode($_COOKIE['status']) == 2):?><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalPass">Добавить главную тему</button><?php endif;?></h2>
    <?php if(array_key_exists('status', $_COOKIE) && decode($_COOKIE['status']) == 2):?>
    <div class="modal fade" tabindex="-1" id="ModalPass" aria-hidden="true">
      <div class="modal-dialog modal-fullscreen-sm-down">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Добавить главную тему</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="/f/a/addMain" method="post">
              <fieldset>
                <legend class="text-center">Тема для подтем!</legend>
                <label for="name">Тема:</label>
                <div class="form-group"> 
                  <input class="form-control" type="text" name="name" maxlength="30" required/>  
                  <div id="passwordHelpBlock" class="form-text">Название должно быть в длинну не меньше 3 и не больше 20. <b class="text-danger">Поле должно содержать 1-2 слова, так как оно будет отображаться в url!</b></div>
                </div> 
                <label for="icon">Иконка:</label>
                <div class="form-group"> 
                  <input class="form-control" type="text" name="icon" maxlength="70"/>  
                  <div id="passwordHelpBlock" class="form-text">Брать иконки <a href="https://fontawesome.com/search?o=r&m=free" target="_blank">ЗДЕСЬ</a> и вставлять их код полностью по примеру <br><code>&lt;i class="fa-solid fa-hippo"&gt;&lt;/i&gt;</code></div>
                </div> 
                <label for="descr">Описание:</label>
                <div class="form-group"> 
                  <textarea class="form-control" type="text" name="descr" maxlength="400"></textarea>
                  <div id="passwordHelpBlock" class="form-text">Разрешённые символы: a-z A-Z а-я А-Я 1-9 пробел -+_=/&^:;"#%!@&,.</div>
                </div>                 
                <button type="submit" class="btn btn-primary mb-3 mt-3">Добавить</button>
              </fieldset>
            </form> 
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
          </div>
        </div>
      </div>
    </div>
    <?php endif;?>                
    <div class="row g-4 py-5 row-cols-1 row-cols-lg-3">
      <?php foreach ($data['mainTop'] as $kay):?>
      <div class="col d-flex align-items-start" style="padding-bottom: 10px;">
        <div class="icon-square text-bg-light d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3">
          <?php echo $kay['icon']?>
        </div>
        <div>
          <h3 class="fs-2"><?php echo $kay['name']?></h3>
          <p><?php echo $kay['descr']?>.</p>
          <a href="/f/<?php echo $kay['topicName']?>" class="btn btn-primary">Посмотреть про <?php echo $kay['name']?></a>
        </div>
      </div>
      <?php endforeach;?>
      <div class="col d-flex align-items-start"  style= "padding-bottom: 20px;">
        <div class="icon-square text-bg-light d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3">
          <i class="fa-solid fa-house"></i>
        </div>
        <div>
          <h3 class="fs-2">Featured title</h3>
          <p>Paragraph of text beneath the heading to explain the heading. We'll add onto it with another sentence and probably just keep going until we run out of words.</p>
          <a href="#" class="btn btn-primary">
            Primary button
          </a>
        </div>
      </div>
    </div>
  </div>
</main>