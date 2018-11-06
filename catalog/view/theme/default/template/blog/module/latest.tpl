<h3 class="header_last_articles"><?php echo $heading_title; ?></h3>
<div class="row last_articles">
  <?php foreach ($articles as $article) { ?>
    <div class="article_item article_item_list">
      <div class="wrapper_description_article wrapper_description_article_latest_fix">
        <div class="article_head_with_img">
          <?php if ($article['thumb']) { ?>
            <a class="img" href="<?php echo $article['href']; ?>">
              <img src="<?php echo $article['thumb']; ?>"
                   alt="<?php echo $article['name']; ?>"
                   title="<?php echo $article['name']; ?>"
                   class="img-responsive"/>
            </a>
          <?php } ?>
          <h4><a class="article_name" href="<?php echo $article['href']; ?>"><?php echo $article['name']; ?></a></h4>
        </div>

        <div class="caption">
          <p class="description"><?php echo $article['description_latest']; ?></p>
        </div>
      </div>
      <div class="date_views">
        <span><?php echo $article['date_added'];?></span>
        <span><?php echo $text_views; ?> <?php echo $article['viewed'];?></span>
      </div>
      <div class="wrap_functionality">
        <?php if ($configblog_review_status) { ?>
          <div class="rating_wrap rating_last_articles">
            <?php for ($i = 1; $i <= 5; $i++) { ?>
              <?php if ($article['rating'] < $i) { ?>
                <span class="fa fa-stack star-<?php echo $i; ?>">
                    <i class="fa fa-star-o fa-stack-2x"></i><!-- Empty star -->
                  </span>
              <?php } else { ?>
                <span class="fa fa-stack star-<?php echo $i; ?>">
                    <i class="fa fa-star fa-stack-2x"></i><!-- full star -->
                    <i class="fa fa-star-o fa-stack-2x"></i>
                 </span>
              <?php } ?>
            <?php } ?>
          </div>
        <?php } ?>
        <div class="button-group">
          <button type="button" onclick="location.href = ('<?php echo $article['href']; ?>');">
            <i class="fa fa-share"></i>
            <span class="hidden-xs hidden-sm hidden-md"><?php echo $button_more; ?></span>
          </button>
        </div>
      </div>
    </div>
  <?php } ?>
</div>
