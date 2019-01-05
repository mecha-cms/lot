<?php
/*
Hook::set('*.title', function($title) {
    if (strpos($this->path, PAGE . DS . 'reference' . DS . 'variable' . DS) !== 0) {
        return $title;
    }
    return '<code>$' . strtr($this->slug, '-', '_') . '</code>';
});

Hook::set('*.description', function($description) {
    if (strpos($this->path, PAGE . DS . 'reference' . DS . 'variable' . DS) !== 0) {
        return $description;
    }
    return $this->get('@description', false);
}, 0);

Hook::set('*.content', function($content) {
    if (strpos($this->path, PAGE . DS . 'reference' . DS . 'variable' . DS) !== 0) {
        return $content;
    }
    $tags = [];
    $s = "";
    if ($example = $this->get('@example', false)) {
        $s .= "\n\n**Example:**\n\n~~~ .php\n" . $example . "\n~~~";
    }
    if ($version = $this->get('@version', false)) {
        foreach ($version as &$v) {
            $v = explode('.', $v === 'current' ? Mecha::version : $v);
            $v = '<mark class="tag tag-version" title="version">' . implode('.', array_pad($v, 3, '0')) . '</mark>';
        }
        $tags = concat($tags, $version);
        unset($v);
    }
    $content = '<span class="tags">' . implode(' ', $tags) . "</span>\n\n" . $content . $s;
    $content .= "\n\n### Next&hellip;\n";
    foreach (glob(dirname($this->path) . DS . '*.page') as $v) {
        $n = Path::N($v);
        if ($n === '$') continue;
        $content .= $n === $this->slug ? "\n - `$" . strtr($n, '-', '_') . '`' : "\n - [`$" . strtr($n, '-', '_') . '`][link:/reference/variable/' . $n . ']';
    }
    return $content;
}, 0);*/