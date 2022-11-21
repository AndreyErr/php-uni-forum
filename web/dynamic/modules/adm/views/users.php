<div class="my-3 p-3 bg-body rounded shadow-sm">
  <h6 class="border-bottom pb-2 mb-0">Пользователи <?php echo $data['allUsers']['COUNT(id)'];?></h6>
  <?php foreach ($data['users'] as $kay):?>
  <div class="d-flex text-muted pt-3">
    <div class="pb-3 mb-0 small lh-sm border-bottom w-100">
      <div class="d-flex justify-content-between">
        <strong class="text-gray-dark"><?php echo $kay['name']?></strong>

        <?php 
        $status = require($_SERVER['DOCUMENT_ROOT'].'/config/status.php');
        if($kay['status'] == 0) $color = "primary";
        else $color = "warning";
        ?>

        <span class="badge text-bg-<?php echo $color;?>"><?php echo $status[$kay['status']];?></span>
      </div>
      <span class="d-block">@<?php echo $kay['login']?> | <?php echo $kay['regdate']?></span>
      <a href="/u/<?php echo $kay['login']?>"><button type="button" class="btn btn-primary btn-sm">Посмотреть</button></a>
      <?php 
      if($kay['loginUser'] == NULL) $color = "success";
      else $color = "danger";
      if($kay['loginUser'] == NULL):?>
      <a href="/adm/act/ban/<?php echo $kay['login']?>"><button type="button" class="btn btn-<?php echo $color?> btn-sm">Заблокировать</button></a>
      <?php else:?>
      <a href="/adm/act/unban/<?php echo $kay['login']?>"><button type="button" class="btn btn-danger btn-sm">Разблокировать</button></a>
      <?php endif;?>
    </div>
  </div>
  <?php endforeach;?>
</div>

  <!-- <ul class="pagination pagination-sm">
    <li class="page-item active"><span class="page-link">1</span></li>
    <li class="page-item"><a class="page-link" href="#">2</a></li>
    <li class="page-item"><a class="page-link" href="#">3</a></li>
  </ul> -->