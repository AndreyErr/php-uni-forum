          <div class="up">
            <article>
            <div class="p-4 p-md-5 mb-4 rounded text-bg-dark">
    <div class=" px-0">
      <h1 class="display-4">Title of a longer featured blog post</h1>
      <p class="lead mb-0">Тип, Автор, дата</p>
    </div>
  </div>
  <section class="summary">
                <div class="summary-item">
                    <h5 class="item-title">
                      <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                          <li class="breadcrumb-item"><a href="#">Home</a></li>
                          <li class="breadcrumb-item"><a href="#">Library</a></li>
                          <li class="breadcrumb-item active" aria-current="page">Data</li>
                        </ol>
                      </nav>
                    </h5>
                </div>
            </section>
                <section class="summary">
                    <div class="summary-item">
                        <h5 class="item-title">Reading Time</h5>
                        <p class="item-text">6 Mins</p>
                    </div>
                    <div class="summary-item">
                        <h5 class="item-title">View</h5>
                        <p class="item-text">1288 Views</p>
                    </div>
                    <div class="summary-item">
                        <h5 class="item-title">Publish Date</h5>
                        <p class="item-text">27.02.2022</p>
                    </div>
                </section>
            </article>
            </div>
            




            <main class="container">
            <div class="row g-5">
              <div class="col-md-8">

            <div class="wrapper">
              <p class="display-6"><strong>Самый популярный ответ:</strong></p>
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
                </div>
                <hr><p class="lead">Остальные ответы:</p>
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
                    <h4 class="fst-italic">About</h4>
                    <p class="mb-0">Customize this section to tell your visitors a little bit about your publication, writers, content, or something else entirely. Totally up to you.</p>
                  </div>
                  
                  <div class="my-3 p-3 bg-body rounded shadow-sm">
                    <h6 class="border-bottom pb-2 mb-0">Recent updates</h6>
                    <div class="d-flex text-muted pt-3">
                      <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#007bff"/><text x="50%" y="50%" fill="#007bff" dy=".3em">32x32</text></svg>
                
                      <p class="pb-3 mb-0 small lh-sm border-bottom">
                        <strong class="d-block text-gray-dark">@username</strong>
                        Some representative placeholder content, with some information about this user. Imagine this being some sort of status update, perhaps?
                      </p>
                    </div>
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
                    <small class="d-block text-end mt-3">
                      <a href="#">All updates</a>
                    </small>
                  </div>
                </div>
              </div>
              </div>
              </main>