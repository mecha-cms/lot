<?php static::header(); ?>
<?php foreach ($pages as $page): ?>
<article>
  <header><h3><a href="<?php echo $page->link ?: $page->url; ?>"><?php echo $page->title; ?></a></h3></header>
  <div><?php echo $page->description; ?></div>
</article>
<?php endforeach; ?>
<?php static::pager('step'); ?>
<?php static::footer(); ?>