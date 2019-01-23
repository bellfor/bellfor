<div class="container-Produkte">
              <div class="name-menues">
			  <?php if(!empty($heading_title)) {
                echo  $heading_title;
			   } else {
				echo  'Bellfor Produkte';
			   }?>
              </div>
  <ul>
  <?php foreach ($categories as $category) {
  $category['name'] = '<span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span>'.$category['name'];
  ?>
  <li>
  <?php if ($category['category_id'] == $category_id) { ?>
  <a href="<?php echo $category['href']; ?>" class="active"><?php echo $category['name']; ?></a>
  <?php if ($category['children']) { ?>
  <?php foreach ($category['children'] as $child) { ?>
  <?php if ($child['category_id'] == $child_id) { ?>
  <a href="<?php echo $child['href']; ?>" class="active">&nbsp;&nbsp;&nbsp;- <?php echo $child['name']; ?></a>
  <?php } else { ?>
  <a href="<?php echo $child['href']; ?>">&nbsp;&nbsp;&nbsp;- <?php echo $child['name']; ?></a>
  <?php } ?>
  <?php } ?>
  <?php } ?>
  <?php } else { ?>
  <a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
  <?php } ?>
  </li>
  <?php } ?>
      <li><a href="https://www.cbd-elixier.de/" target="_blank"><span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span><?php echo $cbd_shop; ?></a></li>
  </ul>
</div>
