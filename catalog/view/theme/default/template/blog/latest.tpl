<?php echo $header; ?>
        <div class="col-md-4 col-md-pull-3 col-sm-4 col-sm-pull-4 col-xs-12 headernavigation">
          <?php foreach ($breadcrumbs as $breadcrumb) {
            if ($breadcrumb['text']!=='<i class="fa fa-home"></i>') {
              echo '<span>»</span>';
            } ?>
            <a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-xs-12">
    <div class="main-container clearfix blog_column_fix">
      <?php echo $column_right; ?>
      <div id="content" class="col-md-9 col-xs-12 right-container ">
        <?php echo $content_top; ?>
        <h1 class="blog_header"><?php echo $heading_title; ?></h1>
        <?php if ($articles) { ?>
        <div class="blog_wrapper_functionality">
          <div class="list_grid_buttons">
            <button type="button" id="list-view" class="btn btn-default" data-toggle="tooltip"
                    title="<?php echo $text_list; ?>"><i class="fa fa-th-list"></i></button>
            <button type="button" id="grid-view" class="btn btn-default" data-toggle="tooltip"
                    title="<?php echo $text_grid; ?>"><i class="fa fa-th"></i></button>
          </div>
          <div class="sorting_articles">
            <label for="input-sort"><?php echo $text_sort; ?></label>
            <select id="input-sort" class="form-control col-sm-3" onchange="location = this.value;">
              <?php foreach ($sorts as $sorts) { ?>
                <?php if ($sorts['value'] == $sort . '-' . $order) { ?>
                  <option value="<?php echo $sorts['href']; ?>" selected="selected"><?php echo $sorts['text']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
                <?php } ?>
              <?php } ?>
            </select>
          </div>
          <div class="limit_count_articles">
            <label for="input-limit"><?php echo $text_limit; ?></label>
            <select id="input-limit" class="form-control" onchange="location = this.value;">
              <?php foreach ($limits as $limits) { ?>
                <?php if ($limits['value'] == $limit) { ?>
                  <option value="<?php echo $limits['href']; ?>" selected="selected"><?php echo $limits['text']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></option>
                <?php } ?>
              <?php } ?>
            </select>
          </div>
        </div>

        <div class="wrapper_articles">
          <?php foreach ($articles as $article) { ?>
          <div class="article_item article_item_list">
            <div class="wrapper_description_article">
              <?php if ($article['thumb']) { ?>
                <div class="image">
                  <a href="<?php echo $article['href']; ?>">
                    <img src="<?php echo $article['thumb']; ?>"
                         alt="<?php echo $article['name']; ?>"
                         title="<?php echo $article['name']; ?>"
                         class="img-responsive"/>
                  </a>
                </div>
              <?php } ?>
              <div class="caption">
                <h4><a class="article_name" href="<?php echo $article['href']; ?>"><?php echo $article['name']; ?></a></h4>
                <p class="description"><?php echo $article['description']; ?></p>
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
<!--                <button type="button">-->
<!--                  <i class="fa fa-share"></i>-->
<!--                  <span class="hidden-xs hidden-sm hidden-md">-->
<!--                    <a class="button button-more" href="--><?php //echo $article['href']; ?><!--">--><?php //echo $button_more; ?><!--</a>-->
<!--                  </span>-->
<!--                </button>-->
              </div>
            </div>
          </div>
          <?php } ?>
        </div>
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <!-- <div class="col-sm-6 text-right"><?php //echo $results; ?></div> -->
        </div>
        <?php } else { ?>
        <p><?php echo $text_empty; ?></p>
        <div class="buttons">
          <div class="pull-right"><a href="<?php echo $continue; ?>"
                                     class="btn btn-primary"><?php echo $button_continue; ?></a></div>
        </div>
        <?php } ?>
        <?php echo $content_bottom; ?></div>
<!--      --><?php //echo $column_right; ?><!--</div>-->
  </div>
</div>
</div>

<script>
  $(document).ready(function() {
    // Product List
    $('#list-view').click(function() {
      $('.article_item').attr('class', 'article_item article_item_list');
      localStorage.setItem('display', 'list');
    });
    // Product Grid
    $('#grid-view').click(function() {
      $('.article_item').attr('class', 'article_item article_item_grid');
      localStorage.setItem('display', 'grid');
    });

    if (localStorage.getItem('display') == 'list') {
      $('#list-view').trigger('click');
    } else {
      $('#grid-view').trigger('click');
    }
  });
</script>
<?php echo $footer; ?>
