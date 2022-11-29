<?php $typeTopics = require($_SERVER['DOCUMENT_ROOT'].'/settings/topic_type.php');?>
<main class="container">
    <div class="px-4 py-5 my-5">
        <h1 class="display-5 fw-bold text-center">Поиск</h1>
        <div class="list-group w-auto" style="margin-bottom: 2vh;">
        <?php if($data['allTopics']->num_rows == 0):?>
          <h2 class="text-center">Не найдено подходящих топиков :( Посмотрите в <a href="/f">топиках тем</a> или измените запрос!</h2>
        <?php else:?>
          <h2 class="text-center">Найденные темы</h2>
        <?php foreach ($data['allTopics'] as $kay):?>
            <a href="/f/<?php echo $kay["unitUrl"]?>/<?php echo $kay["topicId"]?>" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
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
</main>