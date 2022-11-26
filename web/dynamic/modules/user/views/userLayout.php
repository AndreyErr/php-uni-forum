<div class="container" style="padding-top: 0vh;">
  <div class="row profile">
    <div class="col-md-3">
      <div class="profile-sidebar">
        <div class="profile-userpic">
          <img src="/files/img/avatar/<?php // Отображение фото

            if($data['userstatusdig'] == -1) echo "nonUser";
            else if($data['user']['photo'] == 0) echo $data['user']['user_id'];
            else echo $data['user']['photo'];
          
          ?>.png" class="img-responsive rounded mx-auto d-block" alt="" >
        </div>
        <div class="profile-usertitle">
          <div class="profile-usertitle-name">

            <?php if($data['userstatusdig'] != -1) echo '@'.$data['user']['login']; // Отображение логина?>

            <?php if($data['bloclstat'] == 1) echo ' (заблокирован)'; // Отображение логина?>

          </div>
        <div class="profile-usertitle-job"><?php

           echo $data['userstatus'] // Отображение статуса

        ?></div>
      </div>

      <?php if($data['userstatusdig'] != -1): // Запрет отображения для несуществующего пользователя?>

        <?php if($data['user']['name'] == $data['decodedMyLogin'] || (array_key_exists('status',$_COOKIE) && decode($_COOKIE['status']) == 2)): // Отображение кнопок под фото?>

          <div class="profile-userbuttons">

            <?php if($data['userstatusdig'] == 2): // Отображение если пользователь страницы - админ?>

              <a href="/adm"><button type="button" class="btn btn-success btn-sm">Админ панель</button></a>

            <?php endif; // Отображение если пользователь страницы - админ?>

            <?php if(decode($_COOKIE['status']) == 2 && $data['userstatusdig'] != 2): // Отображение кнопок управления?>
                
                <?php // Подбор цвета иконки в зависимости от статуса
                $status = require($_SERVER['DOCUMENT_ROOT'].'/settings/status.php');
                if($data['bloclstat'] == 0) echo '<a href="/adm/a/ban/'.$data['user']['login'].'"><button type="button" class="btn btn-warning btn-sm">Заблок</button></a>';
                else echo '<a href="/adm/a/unban/'.$data['user']['login'].'"><button type="button" class="btn btn-primary btn-sm">Разблок</button></a>';
                ?>

            <?php endif; // Отображение кнопок управления?>

            <a href="/user/a/exit" class="btn"><button type="submit" class="btn btn-danger btn-sm">Выход</button></a>
          </div>

        <?php endif; // Отображение кнопок под фото?>

        <?php if($data['user']['login'] == $data['decodedMyLogin']): // Отображение настроек?>

        <div class="profile-usermenu">
          <ul class="list-group list-group-flush">
            <h4 class="list-group-item">Настройки</h4>
            <a href="#" class="list-group-item list-group-item-action" data-bs-toggle="modal" data-bs-target="#ModalName">Сменить имя</a>
            <div class="modal fade" tabindex="-1" id="ModalName" aria-hidden="true">
              <div class="modal-dialog modal-fullscreen-sm-down">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Сменить имя</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form action="/user/a/changeName" method="post">
                      <fieldset>
                        <legend class="text-center">Сейчас ваше имя - <?php echo $data['user']['name']?>.</legend>
                        <label for="name">Новое имя: </label>
                        <div class="form-group">
                          <input type="text" name="name" id="name" maxlength="25" class="form-control" placeholder="<?php echo $data['user']['name']?>" required/> 
                          <div id="passwordHelpBlock" class="form-text">Его не увидят другие пользователи, но мы сможем к вам обращаться.</div>                           
                        </div>
                        <button type="submit" class="btn btn-primary mb-3">Сохранить изменения</button>                 
                      </fieldset>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                  </div>
                </div>
              </div>
            </div>
            <a href="#" class="list-group-item list-group-item-action" data-bs-toggle="modal" data-bs-target="#ModalPass">Сменить пароль</a>
            <div class="modal fade" tabindex="-1" id="ModalPass" aria-hidden="true">
              <div class="modal-dialog modal-fullscreen-sm-down">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Сменить пароль</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form action="/user/a/changePass" method="post">
                      <fieldset>
                        <legend class="text-center">Запомните новый пароль. qwerty123#</legend>
                        <label for="pass">Старый пароль: </label>
                        <div class="form-group"> 
                          <input class="form-control" type="password" name="oldPass" id="pass" maxlength="20" required/>  
                          <div id="passwordHelpBlock" class="form-text">Пароль должен быть в длинну не меньше 5 и не больше 16, содеррить цифры, буквы и спец символ (@#$%^&*).</div>
                        </div>   
                        <label for="pass">Новый пароль: </label>
                        <div class="form-group"> 
                          <input class="form-control" type="password" name="pass" id="pass" maxlength="20" required/>  
                          <div id="passwordHelpBlock" class="form-text">Пароль должен быть в длинну не меньше 5 и не больше 16, содеррить цифры, буквы и спец символ (@#$%^&*).</div>
                        </div>   
                        <label for="pass2">Повторить новый пароль: </label>
                        <div class="form-group"> 
                          <input class="form-control" type="password" name="pass2" id="pass2" maxlength="20" required/>  
                        </div>
                        <button type="submit" class="btn btn-primary mb-3 mt-3">Сохранить изменения</button>
                      </fieldset>
                    </form> 
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                  </div>
                </div>
              </div>
            </div>
            <a href="#" class="list-group-item list-group-item-action" data-bs-toggle="modal" data-bs-target="#ModalImg">Сменить аватарку</a>
            <div class="modal fade" tabindex="-1" id="ModalImg" aria-hidden="true">
              <div class="modal-dialog modal-fullscreen-sm-down">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Сменить аватарку</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form action="/user/a/updatePhoto" method="post" enctype="multipart/form-data">
                      <fieldset>
                        <legend class="text-center">Загрузите вашу новую аватарку.</legend>
                        <label for="name">Новая авотарка: </label>
                        <div class="form-group">
                          <input type="file" class="form-control" id="customFile" name="avatar" required>
                          <div id="passwordHelpBlock" class="form-text">Тип: png, jpg, jpeg<br>Размер: не более 2 мб<br>Лучше аватарку загружать в виде квадрата т.к. она именно так будет отображаться на сайте.</div>                           
                        </div>
                        <button type="submit" class="btn btn-primary mb-3">Сохранить изменения</button>
                      </fieldset>
                    </form>
                    <form method="post" action="/user/a/deletePhoto" class="btn"><button type="submit" class="btn btn-danger mb-3">Удалить аватарку</button></form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                  </div>
                </div>
              </div>
            </div>
            <a href="#" class="list-group-item list-group-item-action" data-bs-toggle="modal" data-bs-target="#ModalEmail">Сменить почту</a>
            <div class="modal fade" tabindex="-1" id="ModalEmail" aria-hidden="true">
              <div class="modal-dialog modal-fullscreen-sm-down">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Сменить почту</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form action="/user/a/changeEmail" method="post">
                      <fieldset>
                        <legend class="text-center">Ваша новая почта.</legend>
                        <label for="email"><span class="req">* </span> Новый email: </label> 
                        <div class="form-group">
                            <input class="form-control mb-3" type="email" name="email" id="email" maxlength="40" required/>   
                            <div id="passwordHelpBlock" class="form-text"></div> 
                        </div>
                        <button type="submit" class="btn btn-primary mb-3">Сохранить изменения</button>
                      </fieldset>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                  </div>
                </div>
              </div>
            </div>
            <a href="#" class="list-group-item list-group-item-action" style="color: red;" data-bs-toggle="modal" data-bs-target="#ModalDelete">Удалить аккаунт</a>
            <div class="modal fade" tabindex="-1" id="ModalDelete" aria-hidden="true">
              <div class="modal-dialog modal-fullscreen-sm-down">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Удаление аккаунта</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <p>Это действие удалит ваш аккаунт без возможности востановления! НО все ваши сообщения и темы останутся в истории сайта!</p>
                    <div class="d-grid gap-2 col-6 mx-auto">
                      <hr>
                      <form method="post" action="/user/a/deleteAcc" class="btn btn-danger"><button class="btn" type="submit">Удалить</button></form>
                      <hr>
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                  </div>
                </div>
              </div>
            </div>
          </ul>
        </div>
        <hr>

        <?php endif;  // Отображение настроек?>
        
        <div class="portlet light">
        <div class="row list-separated profile-stat">
          <div class="col-md-4 col-sm-4 col-xs-6">
            <div class="uppercase profile-stat-title"><?php echo $data['user']['user_rating']?></div>
            <div class="uppercase profile-stat-text">Рейтинг</div>
          </div>
          <div class="col-md-4 col-sm-4 col-xs-6">
            <div class="uppercase profile-stat-title">51</div>
            <div class="uppercase profile-stat-text">Сообщений</div>
          </div>
          <div class="col-md-4 col-sm-4 col-xs-6">
            <div class="uppercase profile-stat-title">61</div>
            <div class="uppercase profile-stat-text">Тем</div>
          </div>
        </div>
        </div>  

      <?php endif; // Запрет отображения для несуществующего пользователя?>   

    </div>
  </div>
  <div class="col-md-9">
    <div class="profile-content">
              
      <?php echo $content ?>
                
    </div>
  </div>
</div>
</div>