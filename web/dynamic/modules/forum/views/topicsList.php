<?php $tupe = require($_SERVER['DOCUMENT_ROOT'].'/settings/theme_type.php');?>
<main class="container">
  <div class="px-4 py-5 my-5 text-center">
    <h1 class="display-5 fw-bold"><?php echo $data["aboutMainTopic"]["name"]?></h1>
    <div class="col-lg-6 mx-auto">
      <p class="lead mb-4"><?php echo $data["aboutMainTopic"]["descr"]?></p>
      <?php if(array_key_exists('status', $_COOKIE)):?>
      <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
        <?php if(decode($_COOKIE['status']) == 2):?>
        <button type="button" class="btn btn-primary btn-lg px-4 gap-3" data-bs-toggle="modal" data-bs-target="#ModalChMain">Изменить</button>
        <div class="modal fade" tabindex="-1" id="ModalChMain" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-sm-down">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Изменить главную тему "<?php echo $data["aboutMainTopic"]["name"]?>"</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/f/a/changeMain" method="post">
                <fieldset>
                    <legend class="text-center">Тема для подтем!</legend>
                    <label for="name">URL (только для чтения):</label>
                    <div class="form-group"> 
                    <input class="form-control" type="text" name="url" value="<?php echo $data["aboutMainTopic"]["topicName"]?>" readonly/>  
                    </div> 
                    <label for="name">Тема:</label>
                    <div class="form-group"> 
                    <input class="form-control" type="text" name="name" maxlength="30" value="<?php echo $data["aboutMainTopic"]["name"]?>" required/>  
                    <div id="passwordHelpBlock" class="form-text">Название должно быть в длинну не меньше 3 и не больше 20. <b class="text-danger">Поле должно содержать 1-2 слова! URL не изменится!</b></div>
                    </div> 
                    <label for="icon">Иконка (установлена <?php echo $data["aboutMainTopic"]["icon"]?>):</label>
                    <div class="form-group"> 
                    <input class="form-control" type="text" name="icon" value="<?php echo htmlspecialchars($data["aboutMainTopic"]["icon"])?>" maxlength="70"/>  
                    <div id="passwordHelpBlock" class="form-text">Брать иконки <a href="https://fontawesome.com/search?o=r&m=free" target="_blank">ЗДЕСЬ</a> и вставлять их код полностью по примеру <br><code>&lt;i class="fa-solid fa-hippo"&gt;&lt;/i&gt;</code></div>
                    </div> 
                    <label for="descr">Описание:</label>
                    <div class="form-group"> 
                    <input class="form-control" type="text" name="descr" value="<?php echo $data["aboutMainTopic"]["descr"]?>" maxlength="400">
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
        <button type="button" class="btn btn-danger btn-lg px-4 gap-3" data-bs-toggle="modal" data-bs-target="#ModalDelMain">Удалить</button>
        <div class="modal fade" tabindex="-1" id="ModalDelMain" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-sm-down">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Вы уверены, что хотите безвозвратно удалить главную тему "<?php echo $data["aboutMainTopic"]["name"]?>"</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Будет удалена эта тема и все подтемы!</p>
                <form method="post" action="/f/a/deleteMain"><button type="submit" class="btn btn-outline-secondary btn-lg px-4 btn-danger text-light">Удалить</button></form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
            </div>
            </div>
        </div>
        </div>
        <?php endif;?> 







        <button type="button" class="btn btn-success btn-lg px-4 gap-3" data-bs-toggle="modal" data-bs-target="#ModalAddTheme">Создать педтему в "<?php echo $data["aboutMainTopic"]["name"]?>"</button>
        <div class="modal fade" tabindex="-1" id="ModalAddTheme" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-sm-down">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Создать подтему в главной теме "<?php echo $data["aboutMainTopic"]["name"]?>"</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Будет удалена эта тема и все подтемы!</p>
                <form action="/f/a/addTheme/<?php echo $data["aboutMainTopic"]["topicName"]?>" method="post" id="app" enctype="multipart/form-data">
                <fieldset>
                    <legend class="text-center">Тема для подтем!</legend> 
                    <label for="name">Название (вопрос коротко):</label>
                    <div class="form-group"> 
                    <input class="form-control" type="text" name="name" maxlength="70" placeholder=" Что такое '<?php echo $data["aboutMainTopic"]["name"]?>'?" required/>  
                    <div id="passwordHelpBlock" class="form-text">Название должно быть в длинну не меньше 3 и не больше 70.</div>
                    </div>
                    <label for="type">Тип:</label>
                    <div class="form-group"> 
                    <select class="form-select" aria-label="Default select example" name="type">

                      <?php $c = 0; foreach ($tupe as $kay){$c++;}; $i = 1; while ($i <= $c):?>
                      
                      <option value="<?php echo $i?>"><?php echo $tupe[$i]?></option>
                      
                      <?php $i++; endwhile;?>

                    </select>  

                    <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Первое сообщение:</label>
                    <textarea class="form-control" name="text" v-model="input" @blur="focus = false" :value="input" @input="update" id="input" rows="3" placeholder="Ваше сообщение. Можно использовать разметку md!" required></textarea>
                    <div id="passwordHelpBlock" class="form-text">Текст должен быть в длинну не меньше 1 и не больше 1000. Можно использовать разметку md!</div>
                    </div>
                    <div class="mb-3">
                    <label class="form-label" for="inputGroupFile01">Файлы к сообщению:</label>
                    <input type="file" name="messageFiles[]" class="form-control" id="inputGroupFile01" multiple>
                    <div id="passwordHelpBlock" class="form-text">Текст должен быть в длинну не меньше 1 и не больше 1000. Можно использовать разметку md!</div>
                    </div>
                    <p class="lead">Как будет выглядеть:</p>
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
      <nav aria-label="breadcrumb">
    </div>
  </div>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/f">Форум</a></li>
    <li class="breadcrumb-item active" aria-current="page"><?php echo $data["aboutMainTopic"]["name"]?></li>
  </ol>
</nav>
  <h2>Последние темы</h2>
  <div class="list-group w-auto" style="margin-bottom: 2vh;">
    <a href="#" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
      <img src="https://github.com/twbs.png" alt="twbs" width="32" height="32" class="rounded flex-shrink-0">
      <div class="d-flex gap-2 w-100 justify-content-between">
        <div>
          <span class="badge rounded-pill text-bg-secondary">Danger</span>
          <h6 class="mb-0">List group item heading</h6>
          <p class="mb-0 opacity-75">Some placeholder content in a paragraph.</p>
          <p class="mb-0 opacity-75">@sfdsgfsdg - 254 сообщений</p>
        </div>
        <small class="opacity-50 text-nowrap"><span class="badge rounded-pill text-bg-danger">Danger</span> now</small>
      </div>
    </a>
    <a href="#" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
      <img src="https://github.com/twbs.png" alt="twbs" width="32" height="32" class="rounded flex-shrink-0">
      <div class="d-flex gap-2 w-100 justify-content-between">
        <div>
          <h6 class="mb-0">List group item heading</h6>
          <p class="mb-0 opacity-75">Some placeholder content in a paragraph.</p>
          <p class="mb-0 opacity-75">@sfdsgfsdg - 254 сообщений</p>
        </div>
        <small class="opacity-50 text-nowrap">now</small>
      </div>
    </a>
  </div>

</main>