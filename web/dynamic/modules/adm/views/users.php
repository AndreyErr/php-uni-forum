<div class="my-3 p-3 bg-body rounded shadow-sm">
  <h6 class="border-bottom pb-2 mb-0">Пользователи <?php echo $data['allUsers']['COUNT(userId)'];?></h6>
  <?php foreach ($data['users'] as $kay): // Вывод всех пользователей?>
  <div class="d-flex text-muted pt-3">
    <div class="pb-3 mb-0 small lh-sm border-bottom w-100">
      <div class="d-flex justify-content-between">
        <strong class="text-gray-dark"><?php echo $kay['name']?></strong>

          <?php // Подбор цвета иконки в зависимости от статуса
          if($kay['status'] == 0) $color = "primary";
          else $color = "warning";
          ?>

        <span class="badge text-bg-<?php echo $color;?>"><?php echo $kay['status'];?> - <?php echo $data['statuses'][$kay['status']];?></span>
      </div>
      <span class="d-block"><b>@<?php echo $kay['login']?></b> | <i class="fa-solid fa-calendar-days"></i> <?php echo $kay['regdate']?> | <i class="fa-solid fa-star"></i> <?php echo $kay['userRating']?></span><br>
      <a href="/u/<?php echo $kay['login']?>"><button type="button" class="btn btn-primary btn-sm">Посмотреть</button></a>

        <?php // Подбор цвета кнопки в зависимости от статуса
        if($kay['loginUser'] == NULL) $color = "success";
        else $color = "danger";

      if($kay['loginUser'] == NULL && $kay['status'] != view::specialDataGet('STATUS_UNBAN') && $kay['login'] != view::specialDataGet('UNBAN_LOGIN')): // Кнопка в зависимости от статуса?>

      <a href="/adm/a/ban/<?php echo $kay['login']?>"><button type="button" class="btn btn-<?php echo $color?> btn-sm">Заблокировать <i class="fa-solid fa-ban"></i></button></a>
      <?php elseif($kay['status'] != view::specialDataGet('STATUS_UNBAN') && $kay['login'] != view::specialDataGet('UNBAN_LOGIN')):?>
      <a href="/adm/a/unban/<?php echo $kay['login']?>"><button type="button" class="btn btn-danger btn-sm">Разблокировать <i class="fa-solid fa-scale-unbalanced-flip"></i></button></a>
      <?php endif;?>
    </div>
  </div>
  <?php endforeach;?>
</div>