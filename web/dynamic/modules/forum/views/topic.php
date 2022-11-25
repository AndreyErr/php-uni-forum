          <div class="up">
            <article>
            <div class="p-4 p-md-5 mb-4 rounded text-bg-dark">
    <div class=" px-0">
      <h1 class="display-4"><?php echo $data["topicData"]["topic_name"]?></h1>
      <hr>
      <p class="lead mb-0"><?php echo $data["typeTopic"][$data["topicData"]["type"]]?> от <a href="/u/<?php echo $data["topicData"]["login"]?>" class="text-light" style="text-decoration: none;">@<?php echo $data["topicData"]["login"]?></a></p>
    </div>
  </div>
  <div class="px-1 py-1 my-1 text-center">
  <button type="button" class="btn btn-primary btn-sm px-4 gap-3" data-bs-toggle="modal" data-bs-target="#ModalChMain">Изменить</button>
        <div class="modal fade" tabindex="-1" id="ModalChMain" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-sm-down">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Изменить тему "<?php echo $data["topicData"]["topic_name"]?>"</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/f/a/changeTopic/<?php echo $data["topicData"]["topic_id"]?>" method="post">
                <fieldset>
                  <label for="name">Главная тема (только для чтения):</label>
                    <div class="form-group"> 
                    <input class="form-control" type="text" name="mainTopicSrc" value="<?php echo $data["mainTopicSrc"]?>" readonly/>
                    <div id="passwordHelpBlock" class="form-text">Изменить её нельзя, для изменения пересоздайте топик в нужной теме!</div>  
                    </div> 
                    <label for="name">Название:</label>
                    <div class="form-group"> 
                    <input class="form-control" type="text" name="name" maxlength="30" value="<?php echo $data["topicData"]["topic_name"]?>" required/>  
                    <div id="passwordHelpBlock" class="form-text">Название должно быть в длинну не меньше 3 и не больше 70. Можно использовать: a-z A-Z а-я А-Я 1-9 пробел !?-</div>
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
  <button type="button" class="btn btn-danger btn-sm px-4 gap-3" data-bs-toggle="modal" data-bs-target="#ModalDelMain">Удалить</button>
        <div class="modal fade" tabindex="-1" id="ModalDelMain" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-sm-down">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Вы уверены, что хотите безвозвратно удалить тему "<?php echo $data["topicData"]["topic_name"]?>"</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Будет удалена эта тема и все подтемы!</p>
                <form method="post" action="/f/a/deleteTopic/<?php echo $data["topicData"]["topic_id"]?>"><button type="submit" class="btn btn-outline-secondary btn-lg px-4 btn-danger text-light">Удалить</button></form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
            </div>
            </div>
        </div>
        </div></div>
  <section class="summary">
                <div class="summary-item">
                    <h5 class="item-title">
                      <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                          <li class="breadcrumb-item"><a href="/f">Форум</a></li>
                          <li class="breadcrumb-item"><a href="/f/<?php echo $data["mainTopicSrc"]?>"><?php echo $data["mainTopic"]?></a></li>
                          <li class="breadcrumb-item active" aria-current="page"><?php echo $data["topicData"]["topic_name"]?></li>
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
                  <div class="card-profile"><a class="card-profile__photo" href="#"><img class="profile-photo__img" src="https://s1.1zoom.ru/big7/984/Canada_Parks_Lake_Mountains_Forests_Scenery_Rocky_567540_2560x1600.jpg"/></a><a class="card-profile__info" href="#"><span class="profile-info__name">Son Goku</span><span class="profile-info__username">@supersaiyan_goku</span></a></div>
                  <div class="card-message">
                    <p v-html="markdownToHtml" id="mes"></p><div class="card-message-stamp"><span class="time">Дата</span><a href="#" class="upvo">&#5169;</a> 221 <a href="#" class="dowvo">&#5167;</a></div>
                    <script type="application/javascript">
                      var vm = new Vue({
                          el: '#mes',
                          data(){
                            return{
                              markdown: "**Lorem ipsum** dolor sit amet consectetur adipisicing elit. Quam, optio minima, **[Vue.js guide](https://vuejs.org/v2/guide)** aut cupiditate voluptatem voluptatum enim nostrum at, sequi tempore dolorem magni impedit sunt. `aelkjflskeef` ___kshagklahdfgk___",
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
                  <div class="card-profile"><a class="card-profile__photo" href="#"><img class="profile-photo__img" src="https://s1.1zoom.ru/big7/984/Canada_Parks_Lake_Mountains_Forests_Scenery_Rocky_567540_2560x1600.jpg"/></a><a class="card-profile__info" href="#"><span class="profile-info__name">Son Goku</span><span class="profile-info__username">@supersaiyan_goku</span></a></div>
                  <div class="card-message">
                    <p v-html="markdownToHtml" id="mes1"></p><a class="card-message-stamp" href="#"><span class="time">1:05 PM</span>&nbsp;&ndash;&nbsp;<span class="date">December 1, 2017</span></a>
                    <script type="application/javascript">
                      var vm = new Vue({
                          el: '#mes1',
                          data(){
                            return{
                              markdown: "**Lorem ipsum** dolor sit amet consectetur adipisicing elit. Quam, optio minima, **[Vue.js guide](https://vuejs.org/v2/guide)** aut cupiditate voluptatem voluptatum enim nostrum at, sequi tempore dolorem magni impedit sunt.  ```aaaaaaaaaaaaaa```  <br> ```aaaaaaaaaaaaaa```.",
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
                <div class="card">
                    <div class="card-profile"><a class="card-profile__photo" href="#"><img class="profile-photo__img" src="https://s1.1zoom.ru/big7/984/Canada_Parks_Lake_Mountains_Forests_Scenery_Rocky_567540_2560x1600.jpg"/></a><a class="card-profile__info" href="#"><span class="profile-info__name">Son Goku</span><span class="profile-info__username">@supersaiyan_goku</span></a></div>
                    <div class="card-message">
                      <p>Shout out to the homie <a href="#">Yajirobe</a>&nbsp;for keeping it &#x1F4AF;. Always coming through with the Senzu Beans &#x2615; for the fam.</p><a class="card-message-stamp" href="#"><span class="time">1:05 PM</span>&nbsp;&ndash;&nbsp;<span class="date">December 1, 2017</span></a>
                    </div>
                  </div>
              </div>

              <hr><h5 style="margin-top: 35px;">Добавть свой ответ:</h5>
              <form id="app">
                <!-- <div class="markdownWrapper" id="app">
    
                  <textarea v-model="input" @blur="focus = false" :value="input" @input="update" id="input" class="form-control"></textarea>
                  <div v-html="compiledMarkdown" class="compiledMarkdown" v-show="!focus" @click="setFocus()"></div>
                  
                </div>
                <p class="text-muted text-center"><strong>Note:</strong> Click on the text above to edit the markdown.</p> -->
                
                <div class="mb-3">
                  <label for="exampleFormControlTextarea1" class="form-label">Example textarea</label>
                  <textarea class="form-control" v-model="input" @blur="focus = false" :value="input" @input="update" id="input" rows="3" placeholder="Click on the text above to edit the markdown."></textarea>
                </div>
                <div class="input-group mb-3">
                  <label class="input-group-text" for="inputGroupFile01">Upload</label>
                  <input type="file" class="form-control" id="inputGroupFile01" multiple>
                </div>
                <input class="btn btn-primary" type="button" value="Input">
                <p class="lead">Как будет выглядеть:</p>
                <div v-html="compiledMarkdown" class="compiledMarkdown" v-show="!focus" @click="setFocus()"></div>
              </form>

              <script type="application/javascript">
              var vm = new Vue({
                el: '#app',
                data: {
                  focus: false,
                  input: '### Markdown Demo \r\n**Lorem ipsum** dolor sit amet consectetur adipisicing elit. Quam, optio minima, **[Vue.js guide](https://vuejs.org/v2/guide)** aut cupiditate voluptatem voluptatum enim nostrum at, sequi tempore dolorem magni impedit sunt.'
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
              <div class="col-md-4">
                <div class="position-sticky" style="top: 6rem;">
                  <div class="p-4 mb-3 bg-light rounded">
                    <h4 class="fst-italic"><?php echo $data["typeTopic"][$data["topicData"]["type"]]?></h4>
                    <p class="mb-0"><?php echo $data["topicData"]["topic_name"]?></p>
                  </div>
                  
                  <div class="my-3 p-3 bg-body rounded shadow-sm">
                    <h6 class="border-bottom pb-2 mb-0">Задал вопрос</h6>
                    <a href='/u/<?php echo $data["topicData"]["login"]?>' style="text-decoration: none;"><div class="d-flex text-muted pt-3">
                    <img src="/files/img/avatar/<?php echo $_COOKIE['photo']; ?>.png" alt="X" width="72" height="72" class="img-responsive rounded-circle img-top" style="margin-right: 10px;">
                      <p class="pb-3 mb-0 small lh-sm border-bottom">
                        <strong class="d-block text-gray-dark">@<?php echo $data["topicData"]["login"]?></strong>
                        <?php echo $data["topicData"]["rating"]?>
                      </p>
                    </div></a>
                    <h6 class="border-bottom pb-2 mb-0 my-3">Дал ответ</h6>
                    <a href='/u/<?php echo $data["topicData"]["login"]?>' style="text-decoration: none;"><div class="d-flex text-muted pt-3">
                    <img src="/files/img/avatar/<?php echo $_COOKIE['photo']; ?>.png" alt="X" width="72" height="72" class="img-responsive rounded-circle img-top" style="margin-right: 10px;">
                      <p class="pb-3 mb-0 small lh-sm border-bottom">
                        <strong class="d-block text-gray-dark">@<?php echo $data["topicData"]["login"]?></strong>
                        <?php echo $data["topicData"]["rating"]?>
                      </p>
                    </div></a>
                    <h6 class="border-bottom pb-2 mb-0 my-3">Топ пользователей в обсуждении</h6>
                    <div class="d-flex text-muted pt-3">
                      <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#e83e8c"/><text x="50%" y="50%" fill="#e83e8c" dy=".3em">32x32</text></svg>
                
                      <p class="pb-3 mb-0 small lh-sm border-bottom">
                        <strong class="d-block text-gray-dark">@username</strong>
                        Some more representative placeholder content, related to this other user. Another status update, perhaps.
                      </p>
                    </div>
                    <div class="d-flex text-muted pt-3">
                      <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#6f42c1"/><text x="50%" y="50%" fill="#6f42c1" dy=".3em">32x32</text></svg>
                
                      <p class="pb-3 mb-0 small lh-sm border-bottom">
                        <strong class="d-block text-gray-dark">@username</strong>
                        This user also gets some representative placeholder content. Maybe they did something interesting, and you really want to highlight this in the recent updates.
                      </p>
                    </div>
                  </div>
                </div>
              </div>
              </div>
              </main>