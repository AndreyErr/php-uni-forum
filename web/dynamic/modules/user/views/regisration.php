<main class="container px-4 py-5 my-5">
    <div class="row">
        <div class="col-md-6">
            <form action="/user/a/reg" method="post" id="formReg">
            <fieldset><legend class="text-center">Регистрация</legend>
            <label for="name"><span class="req">* </span> Имя: </label>
            <div class="form-group">
                <input type="text" name="name" id="name" maxlength="25" class="form-control" placeholder="Андрей"/> 
                <div id="passwordHelpBlock" class="form-text">Его не увидят другие пользователи, но мы сможем к вам обращаться.</div>                           
                <i class="fas fa-check-circle"></i>
                <i class="fas fa-exclamation-circle"></i>
                <small></small>
            </div>
            <label for="login"><span class="req">* </span> Логин: </label>
            <div class="form-group"> 	
                <input type="text" name="login" id="login" maxlength="20" class="form-control" placeholder="andreyerr"/> 
                <div id="passwordHelpBlock" class="form-text">На английском. Так же можно использовать цифры. Вас будут знать по этому логину.</div> 
                <i class="fas fa-check-circle"></i>
                <i class="fas fa-exclamation-circle"></i>
                <small></small>
            </div>
            <label for="pass"><span class="req">* </span> Пароль: </label>
            <div class="form-group"> 
                <input class="form-control" type="password" name="pass" id="pass" maxlength="20"/>  
                <div id="passwordHelpBlock" class="form-text">Пароль должен бфть в длинну не меньше 5 и не больше 16, содеррить цифры, буквы и спец символ (@#$%^&*).</div>
                <i class="fas fa-check-circle"></i>
                <i class="fas fa-exclamation-circle"></i>
                <small></small>
            </div>   
            <label for="pass2"><span class="req">* </span> Повторить пароль: </label>
            <div class="form-group"> 
                <input class="form-control" type="password" name="pass2" id="pass2" maxlength="20"/>  
                <i class="fas fa-check-circle"></i>
                <i class="fas fa-exclamation-circle"></i>
                <small></small>
            </div>        
            <label for="email"><span class="req">* </span> Email: </label> 
            <div class="form-group">
                <input class="form-control mb-3" type="email" name="email" id="email" maxlength="40" />   
                <div id="passwordHelpBlock" class="form-text"></div> 
                <i class="fas fa-check-circle"></i>
                <i class="fas fa-exclamation-circle"></i>
                <small></small>
            </div>
            <button type="submit" class="btn btn-primary mb-3">Регистрация</button>
            </fieldset>
            </form>
        </div>
        <div class="col-md-6">
            <h1 class="page-header">Регистрация на форум</h1>
            <p>Вы в одном шаге от обсуждения мира IT qwerty123# Зарегестрируйтесь и получите полноый доступ к IT forum. Здесь вы сможете получить ответы на свои вопросы в сфере технологий и пообщаться на актуальные темы с сообществом.</p> 
            <img src="/src/img/mainTop<?php echo $data['upImage']?>.png" class="d-block mx-lg-auto img-fluid" alt="Bootstrap Themes" width="700" height="500" loading="lazy">                   
        </div>           
    </div>
</main>