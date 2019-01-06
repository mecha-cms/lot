<?php static::header(); ?>
<article>
  <header><h2><?php echo $page->title; ?></h2></header>
  <div><?php echo $page->content; ?></div>
  <footer>
    <ul class="metas">
      <?php if (Plugin::exist('view')): ?>
      <li><svg class="icon" viewBox="0 0 24 24"><path d="M3,22V8H7V22H3M10,22V2H14V22H10M17,22V14H21V22H17Z"></path></svg> <span><?php echo $page->view; ?></span></li>
      <?php endif; ?>
      <?php if (Extend::exist('poll')): ?>
      <li><a href=""><svg class="icon" viewBox="0 0 24 24"><path d="M23,10C23,8.89 22.1,8 21,8H14.68L15.64,3.43C15.66,3.33 15.67,3.22 15.67,3.11C15.67,2.7 15.5,2.32 15.23,2.05L14.17,1L7.59,7.58C7.22,7.95 7,8.45 7,9V19A2,2 0 0,0 9,21H18C18.83,21 19.54,20.5 19.84,19.78L22.86,12.73C22.95,12.5 23,12.26 23,12V10M1,21H5V9H1V21Z"></path></svg> <span>47</span></a></li>
      <?php endif; ?>
      <?php if (Extend::exist('comment')): ?>
      <?php $c = Extend::state('comment', 'anchor')[2]; ?>
      <li><a href="<?php echo HTTP::get($c) ? HTTP::query([$c => false]) : HTTP::query([$c => 1]) . '#' . $c; ?>"><svg class="icon" viewBox="0 0 24 24"><path d="M9,22A1,1 0 0,1 8,21V18H4A2,2 0 0,1 2,16V4C2,2.89 2.9,2 4,2H20A2,2 0 0,1 22,4V16A2,2 0 0,1 20,18H13.9L10.2,21.71C10,21.9 9.75,22 9.5,22V22H9Z"></path></svg> <span><?php echo $page->comments->text; ?></span></a></li>
      <?php endif; ?>
      <li class="nav">
        <?php if ($s = $pager->previous): ?>
        <a href="<?php echo $s; ?>" rel="prev"><svg class="icon" viewBox="0 0 24 24"><path d="M 15.4135,16.5841L 10.8275,11.9981L 15.4135,7.41207L 13.9995,5.99807L 7.99951,11.9981L 13.9995,17.9981L 15.4135,16.5841 Z"></path></svg></a>
        <?php else: ?>
        <span><svg class="icon" viewBox="0 0 24 24"><path d="M 15.4135,16.5841L 10.8275,11.9981L 15.4135,7.41207L 13.9995,5.99807L 7.99951,11.9981L 13.9995,17.9981L 15.4135,16.5841 Z"></path></svg></span>
        <?php endif; ?>
        <?php if ($s = $pager->next): ?>
        <a href="<?php echo $s; ?>" rel="next"><svg class="icon" viewBox="0 0 24 24"><path d="M 8.58527,16.584L 13.1713,11.998L 8.58527,7.41198L 9.99927,5.99798L 15.9993,11.998L 9.99927,17.998L 8.58527,16.584 Z"></path></svg></a>
        <?php else: ?>
        <span><svg class="icon" viewBox="0 0 24 24"><path d="M 8.58527,16.584L 13.1713,11.998L 8.58527,7.41198L 9.99927,5.99798L 15.9993,11.998L 9.99927,17.998L 8.58527,16.584 Z"></path></svg></span>
        <?php endif; ?>
      </li>
    </ul>
  </footer>
  <?php if (Extend::exist('comment') && HTTP::get($c) && $site->is('page')): ?>
  <?php static::comments(); ?>
  <?php endif; ?>
</article>
<?php if ($site->is('reference')): ?>
<?php static::aside(); ?>
<?php endif; ?>
<?php static::footer(); ?>