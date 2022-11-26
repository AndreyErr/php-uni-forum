<?php if($data['userstatusdig'] == -1): // Пользователь не существует?>
  <h2 style="color: #696969; padding: 20px;">Пользователь не существует или удалён :(</h2>
<?php else:?>
  <?php if($data['user']['login'] == $data['decodedMyLogin']): // Пользователь владелец страницы?>
    <h2>Привет, <?php echo $data['user']['name']?>, чем займёмся сегодня?</h2>
  <?php else: // Пользователь не владелец страницы?>
    <h2>Немного о @<?php echo $data['user']['login']?></h2>
  <?php endif;?>
  <hr>
  <?php if(!is_object($data['lastTopics'])):?>
  <h4>Здесь пусто, но скоро появятся последние темы!</h4>
  <?php else:?>
  <h4>Последние темы:</h4>
  <div class="row row-cols-1 row-cols-md-2 g-4">
  <?php foreach ($data['lastTopics'] as $kay):?>
    <div class="col">
      <div class="card">
        <div class="card-header">
          <?php echo $kay['name']?>
        </div>
        <div class="card-body">
          <h5 class="card-title"><?php echo $kay['topicName']?></h5>
          <a href="/f/<?php echo $kay['unitUrl']?>/<?php echo $kay['topicId']?>" class="btn btn-primary">Посмотреть</a>
        </div>
        <div class="card-footer text-muted">
          <?php echo $kay['createDate']?>
        </div>
      </div>
    </div>
  <?php endforeach;?>
    </div>
    <?php endif;?>
  </div>
  <br><hr>
<?php endif;?>