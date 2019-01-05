<aside>
  <ul>
    <li><strong><?php echo a_if($path = 'reference/class', 'Class'); ?></strong>
      <?php if (is_current($path)): ?>
      <ul>
        <?php foreach (glob(PAGE . DS . $path . DS . '{,.}[!.,!..]*.page', GLOB_BRACE) as $v): ?>
        <?php $v = basename($v, '.page'); ?>
        <?php if ($v === '$') continue; ?>
        <li><code><?php echo a_if($path . '/' . $v, f2c($v)); ?></code>
          <?php if (is_current($path . '/' . $v)): ?>
          <ul>
            <?php foreach (glob(PAGE . DS . $path . '/' . $v . DS . '{,.}[!.,!..]*.page', GLOB_BRACE) as $vv): ?>
            <?php $vv = basename($vv, '.page'); ?>
            <?php if ($vv === '$') continue; ?>
            <li><code><?php echo a_if($path . '/' . $v . '/' . $vv, strpos($vv, '.') === 0 ? '__' . c(substr($vv, 1)) : c($vv)); ?></code></li>
            <?php endforeach; ?>
          </ul>
          <?php endif; ?>
        </li>
        <?php endforeach; ?>
      </ul>
      <?php endif; ?>
    </li>
    <li><strong><?php echo a_if($path = 'reference/constant', 'Constant'); ?></strong>
      <?php if (is_current($path)): ?>
      <ul>
        <?php foreach (glob(PAGE . DS . $path . DS . '{,.}[!.,!..]*.page', GLOB_BRACE) as $v): ?>
        <?php $v = basename($v, '.page'); ?>
        <?php if ($v === '$') continue; ?>
        <li><code><?php echo a_if($path . '/' . $v, strtoupper(strtr($v, '.-', "\\_"))); ?></code></li>
        <?php endforeach; ?>
      </ul>
      <?php endif; ?>
    </li>
    <li><strong><?php echo a_if($path = 'reference/extension', 'Extension'); ?></strong>
      <?php if (is_current($path)): ?>
      <ul>
        <?php foreach (glob(PAGE . DS . $path . DS . '{,.}[!.,!..]*.page', GLOB_BRACE) as $v): ?>
        <?php $v = basename($v, '.page'); ?>
        <?php if ($v === '$') continue; ?>
        <li><code><?php echo a_if($path . '/' . $v, $v); ?></code>
          <?php if ($v === 'plugin' && is_current($path . '/' . $v)): ?>
          <ul>
            <?php foreach (glob(PAGE . DS . $path . '/' . $v . DS . '{,.}[!.,!..]*.page', GLOB_BRACE) as $vv): ?>
            <?php $vv = basename($vv, '.page'); ?>
            <?php if ($vv === '$') continue; ?>
            <li><code><?php echo a_if($path . '/' . $v . '/' . $vv, $vv); ?></code></li>
            <?php endforeach; ?>
          </ul>
          <?php endif; ?>
        </li>
        <?php endforeach; ?>
      </ul>
      <?php endif; ?>
    </li>
    <li><strong><?php echo a_if($path = 'reference/file', 'File'); ?></strong></li>
    <li><strong><?php echo a_if($path = 'reference/function', 'Function'); ?></strong>
      <?php if (is_current($path)): ?>
      <ul>
        <?php foreach (glob(PAGE . DS . $path . DS . '{,.}[!.,!..]*.page', GLOB_BRACE) as $v): ?>
        <?php $v = basename($v, '.page'); ?>
        <?php if ($v === '$') continue; ?>
        <li><code><?php echo a_if($path . '/' . $v, strtr($v, '.-', "\\_")); ?></code></li>
        <?php endforeach; ?>
      </ul>
      <?php endif; ?>
    </li>
    <li><strong><?php echo a_if($path = 'reference/panel', 'Panel'); ?></strong></li>
    <li><strong><?php echo a_if($path = 'reference/shield', 'Shield'); ?></strong></li>
    <li><strong><?php echo a_if($path = 'reference/variable', 'Variable'); ?></strong>
      <?php if (is_current($path)): ?>
      <ul>
        <?php foreach (glob(PAGE . DS . $path . DS . '{,.}[!.,!..]*.page', GLOB_BRACE) as $v): ?>
        <?php $v = basename($v, '.page'); ?>
        <?php if ($v === '$') continue; ?>
        <li><code><?php echo a_if($path . '/' . $v, '$' . strtr($v, '.-', "\\_")); ?></code></li>
        <?php endforeach; ?>
      </ul>
      <?php endif; ?>
    </li>
  </ul>
</aside>