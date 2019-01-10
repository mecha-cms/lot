<?php static::header(); ?>
<article>
  <header><h2><?php echo $page->title; ?></h2></header>
  <div><?php echo $page->content; ?></div>
  <footer>
    <ul class="metas">
      <li><svg class="icon" viewBox="0 0 24 24"><path d="M12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22C6.47,22 2,17.5 2,12A10,10 0 0,1 12,2M12.5,7V12.25L17,14.92L16.25,16.15L11,13V7H12.5Z"></path></svg> <span class="abbr" title="<?php echo $page->time->format('Y/m/d H:i:s') . ' &ndash; ' . $page->update->format('Y/m/d H:i:s'); ?>"><?php echo $page->time->format('H:i A'); ?></span></li>
      <?php if (Plugin::exist('view')): ?>
      <li><svg class="icon" viewBox="0 0 24 24"><path d="M3,22V8H7V22H3M10,22V2H14V22H10M17,22V14H21V22H17Z"></path></svg> <span><?php echo $page->view; ?></span></li>
      <?php endif; ?>
      <?php if (Extend::exist('poll')): ?>
      <li><a href=""><svg class="icon" viewBox="0 0 24 24"><path d="M23,10C23,8.89 22.1,8 21,8H14.68L15.64,3.43C15.66,3.33 15.67,3.22 15.67,3.11C15.67,2.7 15.5,2.32 15.23,2.05L14.17,1L7.59,7.58C7.22,7.95 7,8.45 7,9V19A2,2 0 0,0 9,21H18C18.83,21 19.54,20.5 19.84,19.78L22.86,12.73C22.95,12.5 23,12.26 23,12V10M1,21H5V9H1V21Z"></path></svg> <span>47</span></a></li>
      <?php endif; ?>
      <?php if (Extend::exist('comment')): ?>
      <?php $c = Extend::state('comment', 'anchor')[2]; ?>
      <li><a href="<?php echo $url->current . HTTP::query([$c => HTTP::get($c) ? false : 1]) . '#' . $c; ?>"><svg class="icon" viewBox="0 0 24 24"><path d="M9,22A1,1 0 0,1 8,21V18H4A2,2 0 0,1 2,16V4C2,2.89 2.9,2 4,2H20A2,2 0 0,1 22,4V16A2,2 0 0,1 20,18H13.9L10.2,21.71C10,21.9 9.75,22 9.5,22V22H9Z"></path></svg> <span><?php echo $page->comments->text; ?></span></a></li>
      <?php endif; ?>
      <li class="nav">
        <?php if ($s = $pager->previous): ?>
        <a href="<?php echo $s; ?>" rel="prev"><svg class="icon" viewBox="0 0 24 24"><path d="M20,11V13H8L13.5,18.5L12.08,19.92L4.16,12L12.08,4.08L13.5,5.5L8,11H20Z"></path></svg></a>
        <?php else: ?>
        <span><svg class="icon" viewBox="0 0 24 24"><path d="M20,11V13H8L13.5,18.5L12.08,19.92L4.16,12L12.08,4.08L13.5,5.5L8,11H20Z"></path></svg></span>
        <?php endif; ?>
        <?php if ($s = $pager->next): ?>
        <a href="<?php echo $s; ?>" rel="next"><svg class="icon" viewBox="0 0 24 24"><path d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z"></path></svg></a>
        <?php else: ?>
        <span><svg class="icon" viewBox="0 0 24 24"><path d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z"></path></svg></span>
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