<?php
/*
if ($url->path === 'reference/variable') {
    Hook::set('*.content', function($content) use($url) {
        $content .= "\n";
        foreach (glob(PAGE . DS . $url->path . DS . '*.page') as $v) {
            $n = Path::N($v);
            if ($n === '$') continue;
            $content .= "\n - [`$" . strtr($n, '-', '_') . '`][link:/reference/variable/' . $n . ']';
        }
        return $content;
    }, 0);
}
*/