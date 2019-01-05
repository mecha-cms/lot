<?php static::header(); ?>
<article>
  <header><h2><?php echo $page->title; ?></h2></header>
  <div><?php echo $page->content; ?></div>
  <footer><p><?php echo $page->view; ?></p></footer>
</article>
<?php static::aside(); ?>
<?php static::footer(); ?>