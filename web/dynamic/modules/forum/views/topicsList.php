<?php $typeTopics = require($_SERVER['DOCUMENT_ROOT'].'/settings/topic_type.php');?>
<main class="container">
  <div class="px-4 py-5 my-5 text-center">
    <h1 class="display-5 fw-bold"><?php echo $data["aboutUnit"]["name"]?></h1>
    <div class="col-lg-6 mx-auto">
      <p class="lead mb-4"><?php echo $data["aboutUnit"]["descr"]?></p>
      <?php if(array_key_exists('status', $_COOKIE)):?>
      <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
        <?php if(chAccess("unit")):?>
        <button type="button" class="btn btn-primary btn-sm px-4 gap-3" data-bs-toggle="modal" data-bs-target="#ModalChUnit">Изменить</button>
        <div class="modal fade" tabindex="-1" id="ModalChUnit" aria-hidden="true">
          <div class="modal-dialog modal-fullscreen-sm-down">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Изменить главную тему "<?php echo $data["aboutUnit"]["name"]?>"</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
            <div class="modal-body">
              <form action="/f/a/changeUnit" method="post">
                <fieldset>
                  <legend class="text-center">Тема для топиков!</legend>
                  <label for="name">URL (только для чтения):</label>
                  <div class="form-group"> 
                    <input class="form-control" type="text" name="url" value="<?php echo $data["aboutUnit"]["unitUrl"]?>" readonly/>  
                  </div> 
                  <label for="name">Тема:</label>
                  <div class="form-group"> 
                    <input class="form-control" type="text" name="name" maxlength="30" value="<?php echo $data["aboutUnit"]["name"]?>" required/>  
                  <div id="passwordHelpBlock" class="form-text">Название должно быть в длинну не меньше 3 и не больше 20. <b class="text-danger">Поле должно содержать 1-2 слова! URL не изменится!</b></div>
                  </div> 
                  <label for="icon">Иконка (установлена <?php echo $data["aboutUnit"]["icon"]?>):</label>
                  <div class="form-group"> 
                    <input class="form-control" type="text" name="icon" value="<?php echo htmlspecialchars($data["aboutUnit"]["icon"])?>" maxlength="70"/>  
                  <div id="passwordHelpBlock" class="form-text">Брать иконки <a href="https://fontawesome.com/search?o=r&m=free" target="_blank">ЗДЕСЬ</a> и вставлять их код полностью по примеру <br><code>&lt;i class="fa-solid fa-hippo"&gt;&lt;/i&gt;</code></div>
                  </div> 
                  <label for="descr">Описание:</label>
                  <div class="form-group"> 
                    <input class="form-control" type="text" name="descr" value="<?php echo $data["aboutUnit"]["descr"]?>" maxlength="400">
                  <div id="passwordHelpBlock" class="form-text">Разрешённые символы: a-z A-Z а-я А-Я 1-9 пробел -+_=/&^:;"#%!()@&,.</div>
                  </div>                 
                  <button type="submit" class="btn btn-primary mb-3 mt-3">Сохранить</button>
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                </fieldset>
              </form> 
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
            </div>
          </div>
        </div>
      </div>
      <button type="button" class="btn btn-danger btn-sm px-4 gap-3" data-bs-toggle="modal" data-bs-target="#ModalDelUnit">Удалить</button>
      <div class="modal fade" tabindex="-1" id="ModalDelUnit" aria-hidden="true">
      <div class="modal-dialog modal-fullscreen-sm-down">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title"><i class="fa-solid fa-triangle-exclamation text-danger"></i> Вы уверены, что хотите безвозвратно удалить главную тему "<?php echo $data["aboutUnit"]["name"]?>"</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <h3><i class="fa-solid fa-triangle-exclamation text-danger"></i></h3>
            <p>ВНИМАНИЕ! Это действие удалит эту тему и все её топики со всеми сообщениями и файлами! ОТМЕНИТЬ ЭТО ДЕЙСТВИЕ БУДЕТ НЕВОЗМОЖНО!</p>
            <form method="post" action="/f/a/deleteUnit/<?php echo $data["aboutUnit"]["unitId"]?>"><button type="submit" class="btn btn-outline-secondary btn-sm px-4 btn-danger text-light">Удалить</button></form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
          </div>
        </div>
      </div>
    </div>
    <?php endif;?> 

    <?php if(chAccess("topic")):?>
    <button type="button" class="btn btn-success btn-sm px-4 gap-3" data-bs-toggle="modal" data-bs-target="#ModalAddTopic">Создать топик в "<?php echo $data["aboutUnit"]["name"]?>"</button>
    <div class="modal fade" tabindex="-1" id="ModalAddTopic" aria-hidden="true">
      <div class="modal-dialog modal-fullscreen-sm-down">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Создать топик в теме "<?php echo $data["aboutUnit"]["name"]?>"</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="/f/a/addTopic/<?php echo $data["aboutUnit"]["unitUrl"]?>" method="post" id="app" enctype="multipart/form-data">
            <fieldset>
              <legend class="text-center">Обсудите какую-нибудь тему или задайте интересующий вас вопрос!</legend> 
              <label for="name">Название обсуждения / вопрос коротко:</label>
              <div class="form-group"> 
                <input class="form-control" type="text" name="name" maxlength="70" placeholder=" Что такое '<?php echo $data["aboutUnit"]["name"]?>'?" required/>  
                <div id="passwordHelpBlock" class="form-text">Название/вопрос должны быть в длинну не меньше 3 и не больше 70. Можно использовать: a-z A-Z а-я А-Я 1-9 пробел !?-</div>
              </div>
              <label for="type">Тип топика:</label>
              <div class="form-group"> 
                <select class="form-select" aria-label="Default select example" name="type">
                  <?php $c = 0; foreach ($typeTopics as $kay){$c++;}; $i = 1; while ($i <= $c):?>
                  
                  <option value="<?php echo $i?>"><?php echo $typeTopics[$i]?></option>
                  
                  <?php $i++; endwhile;?>
                </select>  
                <div id="passwordHelpBlock" class="form-text">При выборе вопроса будет отображаться самый популярный или отмеченный вами ответ!</div>
                <div class="mb-3">
                  <label for="exampleFormControlTextarea1" class="form-label">Первое сообщение:</label>
                  <textarea class="form-control" name="text" v-model="input" @blur="focus = false" :value="input" @input="update" id="input" rows="3" placeholder="Ваше сообщение. Можно использовать разметку md!" required></textarea>
                  <div id="passwordHelpBlock" class="form-text">Это обязательное первое сообщение, где вы можете полностью расписать вашу тему или вопрос! Текст должен быть в длинну не меньше 1 и не больше 1000. Можно использовать разметку md! Как она будет выглядеть можно увидеть ниже.</div>
                </div>
                <div class="mb-3">
                  <label class="form-label" for="inputGroupFile01">Файлы к сообщению:</label>
                  <input type="file" name="messageFiles[]" class="form-control" id="inputGroupFile01" multiple>



                  
                  <div id="passwordHelpBlock" class="form-text">До <?php echo view::specialDataGet('fileData/messageFiles/maxFilesCount')?> файлов включительно. Каждый файл не больше <?php echo view::specialDataGet('fileData/messageFiles/maxSize')/1024/1024 ?>мб!</div>
                  <a class="text-primary" data-bs-toggle="collapse" href="#collapseExample2" aria-controls="collapseExample2">Более подробно про загрузку</a>
                  <div class="collapse" id="collapseExample2">
                    <div class="card card-body">
                      Разрешённые типы файлов: <?php echo implode(', ', view::specialDataGet('fileData/messageFiles/extensions')) ?>
                      <?php if(view::specialDataGet('mimeTypeCheck') == true):?>
                        <hr>
                        На сайте присутствует дополнительная проверка на mime-тип файла! Она проверяет, в каком расширении он был создан. Если вы изменяли вручную расширение, и оно не подходит под список разрешённых mime-типов - файл не будет загружен!
                        <br>Список разрешённых mime-типов для аватарки: <?php echo implode(', ', view::specialDataGet('fileData/messageFiles/mimeExtensions')) ?>
                      <?php endif;?>
                    </div>
                  </div>


                
                
                </div>
                <p class="lead">Как будет выглядеть текст в сообщении:</p>
                <div v-html="compiledMarkdown" class="compiledMarkdown text-left" v-show="!focus" @click="setFocus()"></div>
              </div>
              <button type="submit" class="btn btn-primary mb-3 mt-3">Создать</button>
            </fieldset>
            </form> 
            <script type="application/javascript">
            var vm = new Vue({
              el: '#app',
              data: {
                focus: false,
                input: ''
              },
              computed: {
                compiledMarkdown: function () {
                  return marked(this.input, { sanitize: true });
                }
              },
              methods: {
                update: _.debounce(function (e) {
                  this.input = e.target.value
                }, 300),
                setFocus: function () {
                  this.focus = true;
                  document.getElementById('input').focus();
                }
              }
            });
            </script>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php endif;?> 

  <?php endif;?> 
      <nav aria-label="breadcrumb">
    </div>
  </div>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/f">Форум</a></li>
    <li class="breadcrumb-item active" aria-current="page"><?php echo $data["aboutUnit"]["name"]?></li>
  </ol>
</nav>
  <div class="list-group w-auto" style="margin-bottom: 2vh;">
  <?php if($data['allTopics']->num_rows == 0):?>
    <h2>Топиков пока нет :( <?php if(chAccess("topic")):?>Но вы можете <button type="button" class="btn btn-success btn-sm px-4 gap-3" data-bs-toggle="modal" data-bs-target="#ModalAddTopic">СОЗДАТЬ</button>!<?php endif;?></h2>
  <?php else:?>
    <h2>Последние темы</h2>
  <?php foreach ($data['allTopics'] as $kay):?>
    <a href="/f/<?php echo $data["aboutUnit"]["unitUrl"]?>/<?php echo $kay["topicId"]?>" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
      <div class="d-flex gap-2 w-100 justify-content-between">
        <div>
        <?php if($kay['type'] != 1):?>
          <span class="badge rounded-pill text-bg-secondary"><?php echo $typeTopics[$kay['type']]?></span>
          <?php endif;?>
          <h6 class="mb-0"><?php echo $kay["topicName"]?></h6>
          <p class="mb-0 opacity-75"><?php echo ($kay["login"] != NULL) ? "@".$kay["login"] : "<i>Пользователь, создавший эту тему, удалён</i>" ?> | <i class="fa-solid fa-calendar-plus"></i> <?php echo $kay["createDate"]?> | <i class="fa-solid fa-eye"></i> <?php echo $kay["viewAllTime"]?></p>
        </div>
        <?php if($data['nowDate'] == $kay["createDate"]):?>
        <small class="opacity-50 text-nowrap"><span class="badge rounded-pill text-bg-danger">Новое</span></small>
        <?php endif;?>
      </div>
    </a>
    <?php endforeach;?>
    <?php endif;?>
  </div>
  <script>
    $(document).ready(function() {
      sessionStorage.clear();
              });
  </script>
</main>