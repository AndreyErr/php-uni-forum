<div class="container col-xxl-9 px-4 py-5">
<div class="row flex-lg-row-reverse align-items-center g-5 py-5">
    <div class="col-10 col-sm-8 col-lg-6">
      <img src="https://fullhdpictures.com/wp-content/uploads/2016/12/Peregrine-falcon-Wallpapers-HD.jpg" class="d-block mx-lg-auto img-fluid" alt="Bootstrap Themes" width="700" height="500" loading="lazy">
    </div>
    <div class="col-lg-6">
      <h1 class="display-5 fw-bold lh-1 mb-3">Responsive left-aligned hero with image</h1>
      <p class="lead">Quickly design and customize responsive mobile-first sites with Bootstrap, the world’s most popular front-end open source toolkit, featuring Sass variables and mixins, responsive grid system, extensive prebuilt components, and powerful JavaScript plugins.</p>
      <div class="d-grid gap-2 d-md-flex justify-content-md-start">
        <button type="button" class="btn btn-primary btn-lg px-4 me-md-2">Primary</button>
        <button type="button" class="btn btn-outline-secondary btn-lg px-4">Default</button>
      </div>
    </div>
  </div>
</div>





<div class="container px-4">
  <h2 class="pb-2 border-bottom">Топ обсуждения</h2>
  <div class="row align-items-md-stretch align-items-center">
    <div class="col-md-6" style="padding: 20px;">
      <div class="h-100 p-5 text-bg-dark rounded-3">
        <h2>Change the background</h2>
        <p>Swap the background-color utility and add a `.text-*` color utility to mix up the jumbotron look. Then, mix and match with additional component themes and more.</p>
        <button class="btn btn-outline-light" type="button">Example button</button>
      </div>
    </div>
    <div class="col-md-6" style="padding: 20px;">
      <div class="h-100 p-5 bg-light border rounded-3">
        <h2>Add borders</h2>
        <p>Or, keep it light and add a border for some added definition to the boundaries of your content. Be sure to look under the hood at the source HTML here as we've adjusted the alignment and sizing of both column's content for equal-height.</p>
        <button class="btn btn-outline-secondary" type="button">Example button</button>
      </div>
    </div>
  </div>
</div>











<div class="container px-4 py-5" id="hanging-icons">
  <h2 class="pb-2 border-bottom">Какая тема вас беспокоит?</h2>
  <div class="row g-4 py-5 row-cols-1 row-cols-lg-3">


    <?php foreach ($data['mainTop'] as $kay):?>
    <div class="col d-flex align-items-start" style= "padding-bottom: 20px;">
      <div class="icon-square d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3">
        <?php echo $kay['icon']?>
      </div>
      <div>
        <h3 class="fs-2"><?php echo $kay['name']?></h3>
        <p><?php echo $kay['descr']?></p>
        <a href="/forum/<?php echo $kay['topicName']?>" class="btn btn-primary">Посмотреть про <?php echo $kay['name']?></a>
      </div>
    </div>
    <?php endforeach;?>

    <div class="col d-flex align-items-start" style= "padding-bottom: 20px;">
      <div class="icon-square text-bg-light d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3">
        <i class="fa-solid fa-house"></i>
      </div>
      <div>
        <h3 class="fs-2">Featured title</h3>
        <p>Paragraph of text beneath the heading to explain the heading. We'll add onto it with another sentence and probably just keep going until we run out of words.</p>
        <a href="#" class="btn btn-primary">
          Primary button
        </a>
      </div>
    </div>
  </div>
</div>