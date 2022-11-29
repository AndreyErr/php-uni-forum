<div class="up">
  <article>
  <div class="p-4 p-md-5 mb-4 rounded text-bg-dark">
    <div class=" px-0">
      <h1 class="display-4"><?php echo $data["topicData"]["topicName"]?></h1>
      <hr>
      <p class="lead mb-0"><?php echo $data["typeTopic"][$data["topicData"]["type"]]?> от 
        <?php if($data["topicData"]["login"] != NULL): ?>
          <a href="/u/<?php echo $data["topicData"]["login"]?>" class="text-light" style="text-decoration: none;">@<?php echo $data["topicData"]["login"]?></a>
        <?php else:?>
          <strong class="d-block text-gray-dark"><i>уже удалённого пользователя</i></strong>
        <?php endif;?>
      </p>
    </div>
  </div>
<?php if(chAccess("controlTopic") || (array_key_exists('id', $_COOKIE) && $_COOKIE['id'] == $data['topicData']['userId'])):?>
  <div class="px-1 py-1 my-1 text-center">
    <button type="button" class="btn btn-primary btn-sm px-4 gap-3" data-bs-toggle="modal" data-bs-target="#ModalChTopic">Изменить топик</button>
    <div class="modal fade" tabindex="-1" id="ModalChTopic" aria-hidden="true">
      <div class="modal-dialog modal-fullscreen-sm-down">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Изменить топик "<?php echo $data["topicData"]["topicName"]?>"</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="/f/a/changeTopic/<?php echo $data["topicData"]["topicId"]?>" method="post">
              <fieldset>
                <label for="name">Раздел (только для чтения):</label>
                <div class="form-group"> 
                  <input class="form-control" type="text" name="unitSrc" value="<?php echo $data["unitSrc"]?>" readonly/>
                  <div id="passwordHelpBlock" class="form-text">Изменить её нельзя, для изменения пересоздайте топик в нужной теме!</div>  
                </div> 
                <label for="name">Название (обсуждение / вопрос):</label>
                <div class="form-group"> 
                  <input class="form-control" type="text" name="name" maxlength="30" value="<?php echo $data["topicData"]["topicName"]?>" required/>  
                  <div id="passwordHelpBlock" class="form-text">Название/вопрос должны быть в длинну не меньше 3 и не больше 70. Можно использовать: a-z A-Z а-я А-Я 1-9 пробел !?-</div>
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
    <button type="button" class="btn btn-danger btn-sm px-4 gap-3" data-bs-toggle="modal" data-bs-target="#ModalDelTopic">Удалить</button>
    <div class="modal fade" tabindex="-1" id="ModalDelTopic" aria-hidden="true">
      <div class="modal-dialog modal-fullscreen-sm-down">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title"><i class="fa-solid fa-triangle-exclamation text-danger"></i> Вы уверены, что хотите безвозвратно удалить тему "<?php echo $data["topicData"]["topicName"]?>"</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <h3><i class="fa-solid fa-triangle-exclamation text-danger"></i></h3>
            <p>ВНИМАНИЕ! Это действие удалит этот топики со всеми сообщениями и файлами! ОТМЕНИТЬ ЭТО ДЕЙСТВИЕ БУДЕТ НЕВОЗМОЖНО!</p>
            <form method="post" action="/f/a/deleteTopic/<?php echo $data["topicData"]["topicId"]?>"><button type="submit" class="btn btn-outline-secondary btn-lg px-4 btn-danger text-light">Удалить</button></form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php endif;?>
  <section class="summary">
    <div class="summary-item">
      <h5 class="item-title">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/f">Форум</a></li>
            <li class="breadcrumb-item"><a href="/f/<?php echo $data["unitSrc"]?>"><?php echo $data["unit"]?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo $data["topicData"]["topicName"]?></li>
          </ol>
        </nav>
      </h5>
    </div>
  </section>
    <section class="summary">
      <div class="summary-item">
        <h5 class="item-title">Сообщений</h5>
        <p class="item-text"><?php echo $data["topicViews"]?></p>
      </div>
      <div class="summary-item">
        <h5 class="item-title">Просмотров</h5>
        <p class="item-text"><?php echo ++$data["topicData"]["viewAllTime"]?></p>
      </div>
      <div class="summary-item">
        <h5 class="item-title">Дата публикации</h5>
        <p class="item-text"><?php echo $data["topicData"]["createDate"]?></p>
      </div>
    </section>
  </article>
</div>
            




            <main class="container">
            <div class="row g-5">
              <div class="col-md-8">

            <div class="wrapper">
            <?php if($data['messages']['topType'] != -1):?>
              <?php if($data['messages']['topType'] == 2):?>
              <p class="display-6"><strong>Самое популярное сообщение:</strong></p>
              <?php elseif($data['messages']['topType'] == 1):?>
              <p class="display-6"><strong>Ответ, помеченный автором:</strong></p>
              <?php endif;?>
                <div class="card">
                  <div class="card-profile">
                    <a class="card-profile__photo" href="<?php echo ($data['messages']['topMessage']['login'] != NULL) ? "/u/".$data['messages']['topMessage']['login'] : "#" ?>">
                      <img class="profile-photo__img img-top" src="/files/img/avatar/<?php // Отображение фото
                        
                        if($data['messages']['topMessage']['login'] == NULL) echo "nonUser";
                        elseif($data['messages']['topMessage']['photo'] == 0) echo $data['messages']['topMessage']['userId'];
                        else echo $data['messages']['topMessage']['photo'];

                        ?>.png"/>
                    </a>
                    <a class="card-profile__info" href="<?php echo ($data['messages']['topMessage']['login'] != NULL) ? "/u/".$data['messages']['topMessage']['login'] : "#" ?>">
                    <?php if($data['messages']['topMessage']['login'] != NULL): ?>
                      <span class="profile-info__name">@<?php echo $data['messages']['topMessage']['login']?></span>
                    <?php else:?>
                      <span class="profile-info__name"><i>Пользователь удалён</i></span>
                    <?php endif;?>
                      <span class="profile-info__username"><?php echo $data['messages']['topMessage']['date']?> в <?php echo $data['messages']['topMessage']['time']?></span></a></div>
                  <div class="card-message">
                  <p v-html="markdownToHtml" id="mes<?php echo $data['messages']['topMessage']['messageId']?>"></p>
                  <div class="card-message-stamp">
                    <span class="time">
                      <?php if(chAccess("topic") && $data['messages']['topMessage']['messageId'] != 1 && (chAccess("controlTopic") || ($_COOKIE['id'] == $data['messages']['topMessage']['idUser'] && $data["nowDate"] == $data['messages']['topMessage']['date']))):?>
                        <a href="/f/a/deleteMes/<?php echo $data["unitSrc"]?>/<?php echo $data["topicData"]["topicId"]?>/<?php echo $data['messages']['topMessage']['messageId']?>">Удалить</a>
                      <?php endif;?>
                      <?php if(chAccess("topic") && $data['messages']['topMessage']['messageId'] != 1 && $data['messages']['topType'] == 2 && ($_COOKIE['id'] == $data['topicData']['userId'])):?>
                        <a href="/f/a/topMes/<?php echo $data["unitSrc"]?>/<?php echo $data["topicData"]["topicId"]?>/<?php echo $data['messages']['topMessage']['messageId']?>">Лучший ответ</a>
                      <?php endif;?>
                    </span>

                    <div class="row">
                    <?php if(array_key_exists($data['messages']['topMessage']['messageId'], $data['messages']['files'])): foreach ($data['messages']['files'][$data['messages']['topMessage']['messageId']] as $kay):?>
                      <?php if($kay['type'] == "jpeg" || $kay['type'] == "jpg" || $kay['type'] == "png"):?>
                    <div class="col-sm-6">
                    <div class="card">
                      <img src="/files/forum/<?php echo $data["unitSrc"]?>/<?php echo $data["topicData"]["topicId"]?>/<?php echo $kay['fileId'].".".$kay['ext']?>" class="card-img-top">
                    </div>
                    </div>
                      <?php endif;?>
                    <?php endforeach; endif;?>
                    </div>
                    <ul class="list-group">
                    
                    <?php if(array_key_exists($data['messages']['topMessage']['messageId'], $data['messages']['files'])): foreach ($data['messages']['files'][$data['messages']['topMessage']['messageId']] as $kay):?>
                      <li class="list-group-item"><a target="_blank" href="/files/forum/<?php echo $data["unitSrc"]?>/<?php echo $data["topicData"]["topicId"]?>/<?php echo $kay['fileId'].".".$kay['ext']?>"><?php echo "Файл ".$kay['ext']?></a></li>
                    <?php endforeach; endif;?>
                    </ul>

                    <?php if(array_key_exists('login', $_COOKIE) && !array_search($data['messages']['topMessage']['messageId'].$_COOKIE['id'], $data['messages']["raiting"])):?>
                      <a href="/f/a/ratingCh/1/<?php echo $data["unitSrc"]?>/<?php echo $data["topicData"]["topicId"]?>/<?php echo $data['messages']['topMessage']['messageId']?>" class="upvo">&#5169;</a>
                    <?php endif;?>
                    <b><?php echo $data['messages']['topMessage']['rating']?></b>
                    <?php if(array_key_exists('login', $_COOKIE) && !array_search($data['messages']['topMessage']['messageId'].$_COOKIE['id'], $data['messages']["raiting"])):?>
                      <a href="/f/a/ratingCh/-1/<?php echo $data["unitSrc"]?>/<?php echo $data["topicData"]["topicId"]?>/<?php echo $data['messages']['topMessage']['messageId']?>" class="dowvo">&#5167;</a>
                    <?php endif;?>
                  </div>
                    <script type="application/javascript">
                      var vm = new Vue({
                          el: '#mes<?php echo $data['messages']['topMessage']['messageId']?>',
                          data(){
                            return{
                              markdown: "<?php echo $data['messages']['topMessage']['message']?>",
                            };
                        },
                          computed: {
                            markdownToHtml: function () {
                              return marked(this.markdown);
                            }
                          }
                        });
                      </script>
                  </div>
                </div><hr>
                <?php endif;?>



                <?php if($data['messages']['all']->num_rows == 0):?>
                <hr><p class="display-6">Это всё ~' '~</p>
                <?php else:?>
                <p class="display-6">Сообщения:</p>
                <?php foreach ($data['messages']['all'] as $kay):?>
                <div class="card">
                  <div class="card-profile">
                    <a class="card-profile__photo" href="<?php echo ($kay['login'] != NULL) ? "/u/".$kay['login'] : "#" ?>">
                      <img class="profile-photo__img img-top" src="/files/img/avatar/<?php // Отображение фото
                        
                        if($kay['login'] == NULL) echo "nonUser";
                        elseif($kay['photo'] == 0) echo $kay['userId'];
                        else echo $kay['photo'];

                        ?>.png"/>
                    </a>
                    <a class="card-profile__info" href="<?php echo ($kay['login'] != NULL) ? "/u/".$kay['login'] : "#" ?>">
                    <?php if($kay['login'] != NULL): ?>
                      <span class="profile-info__name">@<?php echo $kay['login']?></span>
                    <?php else:?>
                      <span class="profile-info__name"><i>Пользователь удалён</i></span>
                    <?php endif;?>
                      <span class="profile-info__username"><?php echo $kay['date']?> в <?php echo $kay['time']?> | <i class="fa-solid fa-star"></i> <?php echo $kay['rating']?></span>
                    </a>
                  </div>
                  <div class="card-message">
                  <p v-html="markdownToHtml" id="mes<?php echo $kay['messageId']?>"></p>
                  <div class="card-message-stamp">
                    <span class="time">
                      <?php if(chAccess("topic") && $kay['messageId'] != 1 && (chAccess("controlTopic") || ($_COOKIE['id'] == $kay['idUser'] && $data["nowDate"] == $kay['date']))):?>
                        <a href="/f/a/deleteMes/<?php echo $data["unitSrc"]?>/<?php echo $data["topicData"]["topicId"]?>/<?php echo $kay['messageId']?>">Удалить</a>
                      <?php endif;?>
                      <?php if(chAccess("topic") && $data['messages']['topType'] == 2 && $kay['messageId'] != 1 && ($_COOKIE['id'] == $data['topicData']['userId'])):?>
                        <a href="/f/a/topMes/<?php echo $data["unitSrc"]?>/<?php echo $data["topicData"]["topicId"]?>/<?php echo $kay['messageId']?>">Лучший ответ</a>
                      <?php endif;?>
                    </span>

                    <div class="row">
                    <?php if(array_key_exists($kay['messageId'], $data['messages']['files'])): foreach ($data['messages']['files'][$kay['messageId']] as $kay2):?>
                      <?php if($kay2['type'] == "jpeg" || $kay2['type'] == "jpg" || $kay2['type'] == "png"):?>
                    <div class="col-sm-6">
                    <div class="card">
                      <img src="/files/forum/<?php echo $data["unitSrc"]?>/<?php echo $data["topicData"]["topicId"]?>/<?php echo $kay2['fileId'].".".$kay2['ext']?>" class="card-img-top" style="max-height: 500px;">
                    </div>
                    </div>
                      <?php endif;?>
                    <?php endforeach; endif;?>
                    </div>
                    <ul class="list-group">
                    
                    <?php if(array_key_exists($kay['messageId'], $data['messages']['files'])): foreach ($data['messages']['files'][$kay['messageId']] as $kay2):?>
                      <li class="list-group-item"><a target="_blank" href="/files/forum/<?php echo $data["unitSrc"]?>/<?php echo $data["topicData"]["topicId"]?>/<?php echo $kay2['fileId'].".".$kay2['ext']?>"><?php echo "Файл ".$kay2['ext']?></a></li>
                    <?php endforeach; endif;?>
                    </ul>

                    <?php if(array_key_exists('login', $_COOKIE) && !array_search($kay['messageId'].$_COOKIE['id'], $data['messages']["raiting"])):?>
                      <a href="/f/a/ratingCh/1/<?php echo $data["unitSrc"]?>/<?php echo $data["topicData"]["topicId"]?>/<?php echo $kay['messageId']?>" class="upvo">&#5169;</a>
                    <?php endif;?>
                    <b><?php echo $kay['rating']?></b>
                    <?php if(array_key_exists('login', $_COOKIE) && !array_search($kay['messageId'].$_COOKIE['id'], $data['messages']["raiting"])):?>
                      <a href="/f/a/ratingCh/-1/<?php echo $data["unitSrc"]?>/<?php echo $data["topicData"]["topicId"]?>/<?php echo $kay['messageId']?>" class="dowvo">&#5167;</a>
                    <?php endif;?>
                  </div>
                    <script type="application/javascript">
                      var vm = new Vue({
                          el: '#mes<?php echo $kay['messageId']?>',
                          data(){
                            return{
                              markdown: "<?php echo $kay['message']?>",
                            };
                        },
                          computed: {
                            markdownToHtml: function () {
                              return marked(this.markdown);
                            }
                          }
                        });
                      </script>
                  </div>
                </div>
                <?php endforeach;?>
                <?php endif;?>

                <?php if(array_key_exists('login', $_COOKIE)):?>
              <hr><h5 style="margin-top: 35px;">Добавть свой ответ:</h5>
              <form action="/f/a/addMessage/<?php echo $data["topicData"]["topicId"]?>" method="post" id="app" enctype="multipart/form-data">
                <div class="form-group"> 
                  <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Первое сообщение:</label>
                    <textarea class="form-control" name="text" v-model="input" @blur="focus = false" :value="input" @input="update" id="input" rows="3" placeholder="Ваше сообщение. Можно использовать разметку md!" required></textarea>
                    <div id="passwordHelpBlock" class="form-text">Текст должен быть в длинну не меньше 1 и не больше 1000. Можно использовать разметку md!</div>
                  </div>
                  <div class="mb-3">
                    <label class="form-label" for="inputGroupFile01">Файлы к сообщению:</label>
                    <input type="file" name="messageFiles[]" class="form-control" id="inputGroupFile01" multiple>
                    <div id="passwordHelpBlock" class="form-text">До 5 файлов включительно. Каждый файл не больше 2мб! Разрешено большенство типов.</div>
                  </div>
                  <p class="lead"><b>Как будет выглядеть текст в сообщении:</b></p>
                  <div v-html="compiledMarkdown" class="compiledMarkdown text-left" v-show="!focus" @click="setFocus()"></div>
                </div>
                <button type="submit" class="btn btn-primary mb-3 mt-3 btn-lg">Написать</button>
              </form>

              <script type="application/javascript">
              var vm = new Vue({
                el: '#app',
                data: {
                  focus: false,
                  input: '' //### Markdown Demo **Lorem ipsum** dolor sit amet consectetur adipisicing elit. Quam, optio minima, **[Vue.js guide](https://vuejs.org/v2/guide)** aut cupiditate voluptatem voluptatum enim nostrum at, sequi tempore dolorem magni impedit sunt.
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
              $(window).scroll(function() {
                sessionStorage.scrollTop = $(this).scrollTop();
              });

              $(document).ready(function() {
                if (sessionStorage.scrollTop != "undefined") {
                  $(window).scrollTop(sessionStorage.scrollTop);
                }
              });
              </script>
              <?php else:?>
              <div class="text-secondary px-4 py-5 text-center">
                <div class="py-5">
                  <h1 class="display-5 fw-bold">Хотите сами что-нибудь написать?</h1>
                  <div class="col-lg-6 mx-auto">
                    <p class="fs-5 mb-4">Зарегестрируйтесь или авторизируйтесь!</p>
                    <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                      <a href="/u/reg"><button type="button" class="btn btn-primary btn-lg px-4 me-md-2 fw-bold">Регистрация</button></a>
                      <a href="/"><button type="button" class="btn btn-outline-secondary btn-lg px-4">Авторизация</button></a>
                    </div>
                  </div>
                </div>
              </div>
              <?php endif;?>
              </div></div>


              <div class="col-md-4">
                <div class="position-sticky" style="top: 6rem;">
                  <div class="p-4 mb-3 bg-light rounded">
                    <h4 class="fst-italic"><?php echo $data["typeTopic"][$data["topicData"]["type"]]?></h4>
                    <p class="mb-0"><?php echo $data["topicData"]["topicName"]?></p>
                  </div>
                  
                  <div class="my-3 p-3 bg-body rounded shadow-sm">
                    <h6 class="border-bottom pb-2 mb-0">Автор</h6>
                    <a target="_blank" href='<?php echo ($data['topicData']['login'] != NULL) ? "/u/".$data['topicData']['login'] : "#" ?>' style="text-decoration: none;"><div class="d-flex text-muted pt-3">
                    <img src="/files/img/avatar/<?php // Отображение фото
                        
                        if($data["topicData"]['login'] == NULL) echo "nonUser";
                        elseif($data["topicData"]['photo'] == 0) echo $data["topicData"]['userId'];
                        else echo $data["topicData"]['photo'];

                        ?>.png" alt="X" width="72" height="72" class="img-responsive rounded-circle img-top" style="margin-right: 10px;">
                      <p class="pb-3 mb-0 small lh-sm border-bottom">
                      <?php if($data['topicData']['login'] != NULL): ?>
                          <strong class="d-block text-gray-dark">@<?php echo $data['topicData']['login']?></strong>
                          <i class="fa-solid fa-star"></i> <?php echo $data['topicData']["userRating"]?>
                        <?php else:?>
                          <strong class="d-block text-gray-dark"><i>Пользователь удалён</i></strong>
                        <?php endif;?>
                      </p>
                    </div></a>
                    <?php if($data['messages']['topType'] == 1):?>
                    <h6 class="border-bottom pb-2 mb-0 my-3">Дал ответ</h6>
                    <a target="_blank" href='<?php echo ($data['messages']['topMessage']['login'] != NULL) ? "/u/".$data['messages']['topMessage']['login'] : "#" ?>' style="text-decoration: none;">
                      <div class="d-flex text-muted pt-3">
                        <img src="/files/img/avatar/<?php // Отображение фото
                        
                        if($data['messages']['topMessage']['login'] == NULL) echo "nonUser";
                        elseif($data['messages']['topMessage']['photo'] == 0) echo $data['messages']['topMessage']['userId'];
                        else echo $data['messages']['topMessage']['photo'];

                        ?>.png" alt="X" width="72" height="72" class="img-responsive rounded-circle img-top" style="margin-right: 10px;">
                        <p class="pb-3 mb-0 small lh-sm border-bottom">
                          <?php if($data['messages']['topMessage']['login'] != NULL): ?>
                            <strong class="d-block text-gray-dark">@<?php echo $data['messages']['topMessage']['login']?></strong>
                            <i class="fa-solid fa-star"></i> <?php echo $data['messages']['topMessage']["userRating"]?>
                          <?php else:?>
                            <strong class="d-block text-gray-dark"><i>Пользователь удалён</i></strong>
                          <?php endif;?>
                        </p>
                      </div>
                    </a>
                    <?php endif;?>
                    <hr>
                    <a class="h4 pt-2" href="/">На главную</a><br>
                    <a class="h4 pt-2" href="/f/<?php echo $data["unitSrc"]?>"><?php echo $data["unit"]?></a><br>
                    <a class="h4 pt-2" href="/f">К списку тем</a><br>
                    <a class="h4 pt-2" href="/u">В профиль</a>
                  </div>
                </div>
              </div>
              </div>
              </main>