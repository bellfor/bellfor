<?php if ($reviews) { ?>
<?php foreach ($reviews as $review) { ?>
  <div class="rating-item">
    <div class="stars">
      <?php for ($i = 1; $i <= 5; $i++) { ?>
      <?php if ($review['rating'] < $i) { ?>
      <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
      <?php } else { ?>
      <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
      <?php } ?>
      <?php } ?>
    </div>
    <div class="rating-text-container">
      <div class="caption-meta-container">
          <dl>
            <dt>Verfasser: </dt>
            <dd><?php echo $review['author']; ?></dd>
          </dl>
          <dl>
            <dt>Datum: </dt>
            <dd><?php echo $review['date_added']; ?></dd>
          </dl>
        </div>
        <div class="comment">
          <?php echo $review['text']; ?>
        </div>
    </div>
  </div>
 <?php } ?>
<div class="text-right"><?php echo $pagination; ?></div>
<?php } else { ?>
<p><?php echo $text_no_reviews; ?></p>
<?php } ?>