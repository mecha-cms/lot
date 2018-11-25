<?php

Hook::set('*.title', function($title) use($site) {
    $parts = explode(DS, Path::R(Path::F($this->path . ""), PAGE));
    $count = count($parts);
    $a = array_pop($parts);
    $b = array_pop($parts);
    $c = array_pop($parts);
    if ($count > 2) {
        if ($c === 'class') {
            $static = $this->get('@static', false);
            $title = '<code>$' . h($b, '_');
            $title .= $static ? ($static === 2 ? '{::,-&gt;}' : '::') : '-&gt;';
            $title .= strtr(strpos($a, '.') === 0 ? '__' . c(substr($a, 1)) : c($a), ' ', '_') . '()</code>';
        } else {
            // TODO
            $title = '<code>' . f2c($a) . '</code>';
        }
    }
    if ($site->is('pages') && $icon = $this->get('@icon', false)) {
        $title = '<svg viewBox="0 0 24 24" width="24" height="24"><path d="' . $icon . '"></path></svg> ' . $title;
    }
    return $title;
}, 2.1);

Hook::set('*.description', function($description) {
    if (!$description) {
        $description = $this->get('@description', false);
    }
    return $description;
}, 0);

Hook::set('*.content', function($content) {
    $parts = explode(DS, Path::R(Path::F($this->path . ""), PAGE));
    $count = count($parts);
    $a = array_pop($parts);
    $b = array_pop($parts);
    $c = array_pop($parts);
    $tags = [];
    $static = $this->get('@static', false);
    if ($version = $this->get('@version', false)) {
        foreach ($version as &$v) {
            $v = explode('.', $v === 'current' ? Mecha::version : $v);
            $v = '<mark class="tag tag-version" title="version">' . implode('.', array_pad($v, 3, '0')) . '</mark>';
        }
        $tags = concat($tags, $version);
        unset($v);
    }
    if ($static) {
        $tags[] = '<mark class="tag tag-static" title="method">static</mark>';
    }
    $parent = dirname($this->path) . '.';
    $parent = File::exist([
        $parent . 'page',
        $parent . 'archive'
    ]);
    $parent = Page::open($parent);
    if ($p = $parent->get('@parent', false)) {
        $tags[] = '<mark class="tag tag-parent" title="parent">' . f2c($p) . '</mark>';
    }
    if ($interface = $parent->get('@interface', false)) {
        $tags = concat($tags, map($interface, function($v) {
            return '<mark class="tag tag-interface" title="interface">' . f2c($v) . '</mark>';
        }));
    }
    sort($tags);
    $lot = $this->get('@lot') ?: [""];
    $s = "";
    if ($count > 3) {
        foreach ((array) $lot as $v) {
            $s .= "~~~ .php.xmp\n";
            $s .= $static ? f2c($parent->get('slug', false)) . '::' : '$' . h($parent->get('slug', false), '_') . '->';
            $m = strtr(strpos($this->get('slug', false), '.') === 0 ? '__' . c(substr($this->get('slug', false), 1)) : c($this->get('slug', false)), ' ', '_');
            $s .= $m . '(' . $v . ");\n";
            if ($static === 2) {
                $s .= '$' . h($parent->get('slug', false), '_') . '->' . $m . '(' . $v . ");\n";
            }
            $s .= "~~~\n\n";
        }
    }
    $content = implode(' ', $tags) . "\n\n" . $s . $content;
    if ($count > 3) {
        if ($example_description = $this->get('@example-description', false)) {
            $content .= "\n\n" . $example_description;
        }
        if ($example = $this->get('@example', false)) {
            $content .= "\n\n**Example:**\n\n~~~ .php\n" . $example . "\n~~~";
        }
        if ($example_note = $this->get('@example-note', false)) {
            $content .= "\n\n> **Note:** " . str_replace("\n", "\n> ", $example_note);
        }
        if ($result_description = $this->get('@result-description', false)) {
            $content .= "\n\n" . $result_description;
        }
        if ($result = $this->get('@result', false)) {
            $content .= "\n\n**Result:**\n\n~~~ .php\n" . $result . "\n~~~";
        }
        if ($result_note = $this->get('@result-note', false)) {
            $content .= "\n\n> **Note:** " . str_replace("\n", "\n> ", $result_note);
        }
    }
    if ($count > 2) {
        $path = Path::F($this->path . "");
        if ($c === 'class') {
            $path = dirname($path);
        }
        if ($glob = glob($path . DS . '{,.}[!.,!..]*.page', GLOB_BRACE)) {
            $content .= "\n\n### " . ($c === 'class' ? 'Next&hellip;' : 'Methods') . "\n";
            foreach ($glob as $v) {
                if (basename($v) === '$.page') {
                    continue;
                }
                $p = new Page($v);
                $content .= "\n - ";
                $content .= $v === $this->path ? $p->title : "[" . $p->title . '](' . $p->url . ')';
            }
        }
    }
    return $content;
}, 0);