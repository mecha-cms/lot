<?php

$chops = explode('/', $url->path);

if ($chops) {
    Config::set('is.' . $chops[0], true);
}

Asset::set(__DIR__ . DS . 'asset' . DS . 'css' . DS . 'site.css', 20);

if ($site->is('page')) {
    Asset::set('//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.13.1/styles/nord.min.css', 20.1);
    Asset::set('//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.13.1/highlight.min.js', 20);
    Asset::set('//cdnjs.cloudflare.com/ajax/libs/highlightjs-line-numbers.js/2.6.0/highlightjs-line-numbers.min.js', 20.1);
    Asset::script('!function(e){var o="querySelectorAll",l="forEach";e[o]("pre code:not(.txt)")[l](function(e){hljs.highlightBlock(e)}),e[o]("pre code")[l](function(e){hljs.lineNumbersBlock(e,{singleLine:!0})})}(document);', 20);
}

function a_if($path, $t) {
    if (is_current($path)) {
        return '<span>' . $t . '</span>';
    }
    return '<a href="' . trim($GLOBALS['URL']['$'] . '/' . $path, '/') . '">' . $t . '</a>';
}

function is_current($path) {
    return strpos($GLOBALS['URL']['path'] . '/', $path . '/') === 0;
}

function get_version($name) {
    return HTTP::fetch($GLOBALS['URL']['$'] . '/git/version/mecha-cms/' . $name);
}

Hook::set('*.title', function($title) {
    if ($this->get('type', false) === 'Markdown' && $path = $this->path) {
        if (strpos($path, PAGE . DS . 'reference' . DS . 'class' . DS) === 0) {
            $name = Path::N($path);
            $class = f2c($name);
            $chops = explode(DS, Path::R($path, PAGE . DS . 'reference' . DS . 'class'));
            if (count($chops) > 1) {
                $class = f2c(basename(dirname($path)));
                $method = strpos($name, '.') === 0 ? '__' . c(substr($name, 1)) : c($name);
                $static = $this->get('@static', false);
                return '`' . ($static ? $class : '$' . c2f($class, '/', '_')) . ($static ? ($static === 2 ? '{::,->}' : '::') : '->') . $method . '()`';
            }
            return '`' . $class . '`';
        } else if (strpos($path, PAGE . DS . 'reference' . DS . 'constant' . DS) === 0) {
            return '`' . strtoupper(strtr(Path::N($path), '.-', "\\_")) . '`';
        } else if (strpos($path, PAGE . DS . 'reference' . DS . 'function' . DS) === 0) {
            return '`' . strtr(Path::N($path), '.-', "\\_") . '`';
        } else if (strpos($path, PAGE . DS . 'reference' . DS . 'variable' . DS) === 0) {
            return '`$' . strtr(Path::N($path), '.-', "\\_") . '`';
        }
    }
    return $title;
}, 0);

Hook::set('*.content', function($content) {
    $path = $this->path;
    if ($this->get('type', false) !== 'Markdown') {
        return $content;
    }
    $prefix = "";
    if ($description = $this->get('@description', false)) {
        $prefix .= '> ' . $description . "\n\n";
    } else if ($description = $this->get('description', false)) {
        $prefix .= '> ' . $description . "\n\n";
    }
    if ($path && (
        strpos($path, PAGE . DS . 'reference' . DS . 'class' . DS) === 0 ||
        strpos($path, PAGE . DS . 'reference' . DS . 'constant' . DS) === 0 ||
        strpos($path, PAGE . DS . 'reference' . DS . 'function' . DS) === 0 ||
        strpos($path, PAGE . DS . 'reference' . DS . 'variable' . DS) === 0
    )) {
        $tags = [];
        $static = $this->get('@static', false);
        $abstract = $this->get('@abstract', false);
        $parent = $this->get('@parent', false);
        $interface = $this->get('@interface', false);
        if ($version = $this->get('@version', false)) {
            foreach ((array) $version as $v) {
                if ($v === 'current') {
                    $tags[] = '<mark class="tag tag-version tag-version-current" title="version">' . Mecha::version . '</mark>';
                } else {
                    $v = explode('.', $v);
                    $v = array_pad($v, 3, '0');
                    $tags[] = '<mark class="tag tag-version" title="version">' . implode('.', $v) . '</mark>';
                }
            }
        }
        if ($static) {
            $tags[] = '<mark class="tag tag-static" title="static">static</mark>';
        }
        if ($abstract) {
            $tags[] = '<mark class="tag tag-abstract" title="abstract">abstract</mark>';
        }
        if ($interface) {
            foreach ((array) $interface as $v) {
                $tags[] = '<mark class="tag tag-interface" title="interface">' . f2c($v) . '</mark>';
            }
        }
        if ($parent) {
            $tags[] = '<mark class="tag tag-parent" title="parent">' . f2c($parent) . '</mark>';
        }
        $prefix .= '<p class="tags">' . implode("", $tags) . "</p>\n\n";
        if ($param = $this->get('@lot', false)) {
            $prefix .= "~~~ .php.xmp\n";
            $class = f2c(basename(dirname($path)));
            $method = Path::N($path);
            $method = strtr(strpos($method, '.') === 0 ? '__' . c(substr($method, 1)) : c($method), ' ', '_');
            $return = $this->get('@return', false);
            $return = $return ? ': ' . $return : "";
            foreach ((array) $param as $v) {
                $prefix .= ($static ? $class : '$' . c2f($class, '/', '_')) . ($static ? '::' : '->') . $method . '(' . $v . ')' . $return . ";\n";
            }
            if ($static === 2) {
                $prefix .= "~~~\n\n~~~ .php.xmp\n";
                foreach ((array) $param as $v) {
                    $prefix .= '$' . c2f($class, '/', '_') . '->' . $method . '(' . $v . ')' . $return . ";\n";
                }
            }
            $prefix .= "~~~\n\n";
        }
        if ($example = $this->get('@example', false)) {
            $prefix .= "**Example:**\n\n";
            if ($example_description = $this->get('@example-description', false)) {
                $prefix .= $example_description . "\n\n";
            }
            $prefix .= "~~~ " . ($this->get('@example-language', false) ?: '.php') . "\n";
            $prefix .= $example . "\n";
            $prefix .= "~~~\n\n";
            if ($example_note = $this->get('@example-note', false)) {
                $prefix .= '> **Note:** ' . $example_note . "\n\n";
            }
        }
        if ($result = $this->get('@result', false)) {
            $prefix .= "**Result:**\n\n";
            if ($result_description = $this->get('@result-description', false)) {
                $prefix .= $result_description . "\n\n";
            }
            $prefix .= "~~~ " . ($this->get('@result-language', false) ?: '.php') . "\n";
            $prefix .= $result . "\n";
            $prefix .= "~~~\n\n";
            if ($result_note = $this->get('@result-note', false)) {
                $prefix .= '> **Note:** ' . $result_note . "\n\n";
            }
        }
    }
    return $prefix . $content;
}, 0);

Hook::set('*.content', function($content) {
    if (strpos($content, '</pre>') !== false) {
        return preg_replace_callback('#<pre(\s[^<>]*?)?>\s*<code(\s[^<>]*?)?>([\s\S]*?)</code>\s*</pre>#', function($m) {
            $m[3] = preg_replace_callback('#\b[A-Z][\\\\\w]*(?=[,:;()])#', function($m) {
                $name = c2f($m[0]);
                if (file_exists(PAGE . DS . 'reference' . DS . 'class' . DS . $name . '.page')) {
                    return '<a href="' . $GLOBALS['URL']['$'] . '/reference/class/' . $name . '">' . $m[0] . '</a>';
                }
                return $m[0];
            }, $m[3]);
            return '<pre' . $m[1] . '><code' . $m[2] . '>' . $m[3] . '</code></pre>';
        }, $content);
    }
    return $content;
}, 2.1);

if (is_current('reference/extension')) {
    Hook::set('*.content', function($content, $lot) {
        if (!$this->path || strpos($this->path, PAGE . DS . 'reference' . DS . 'extension' . DS) !== 0) {
            return $content;
        }
        $N = isset($this->name) ? $this->name : Path::N($this->path);
        $NS = basename(dirname($this->path)) === 'plugin' ? 'extend.plugin' : 'extend';
        $stats = include ROOT . DS . 'stats.php';
        $releases = include ROOT . DS . 'releases.php';
        $i = 'https://github.com/mecha-cms/' . $NS . '.' . $N . '/archive/master.zip';
        $i = isset($stats[$i]) ? $stats[$i] : 0;
        $j = 0;
        $k = basename(strtr($NS, '.', '/'));
        if (!empty($releases[$k][$N])) {
            $j = 'https://github.com/mecha-cms/' . $NS . '.' . $N . '/archive/v' . $releases[$k][$N] . '.zip';
            $j = isset($stats[$i]) ? $stats[$i] : 0;
        }
        // $i += $j;
        if ($this->dependency === null || $this->dependency !== false) {
            $s = "";
            $s .= N . '<div class="buttons">';
            if (!empty($releases[$k][$N])) {
                $s .= '<a class="button stable" href="http://127.0.0.1/r/git:mecha-cms/' . $NS . '.' . $N . '/archive/v' . $releases[$k][$N] . '.zip" title="' . $j . ' Downloads"><svg class="icon" viewBox="0 0 24 24"><path d="M5,20H19V18H5M19,9H15V3H9V9H5L12,16L19,9Z"></path></svg> Download Version ' . $releases[$k][$N] . '</a> ';
            }
            $s .= '<a class="button" href="http://127.0.0.1/r/git:mecha-cms/' . $NS . '.' . $N . '/archive/master.zip" title="' . $i . ' Downloads"><svg class="icon" viewBox="0 0 24 24"><path d="M5,20H19V18H5M19,9H15V3H9V9H5L12,16L19,9Z"></path></svg> Download Development Version</a>';
            $s .= '</div>';
            $content = $s . N . N . $content;
        }
        if (!empty($this->dependency) && $this->dependency !== true) {
            $content .= N . N . '### Dependency';
            if (!empty($this->dependency['extension'])) {
                $content .= N . N . '#### Extension' . N;
                foreach ($this->dependency['extension'] as $v) {
                    $content .= N . ' - [link:/reference/extension/' . str_replace('.', '-', $v) . ']';
                }
            }
            if (!empty($this->dependency['plugin'])) {
                $content .= N . N . '#### Plugin' . N;
                foreach ($this->dependency['plugin'] as $v) {
                    $content .= N . ' - [link:/reference/extension/plugin/' . str_replace('.', '-', $v) . ']';
                }
            }
        }
        if (!empty($this->dependency_x)) {
            $content .= N . N . '### Conflict With';
            if (!empty($this->dependency_x['extension'])) {
                $content .= N . N . '#### Extension' . N;
                foreach ($this->dependency_x['extension'] as $v) {
                    $content .= N . ' - [link:/reference/extension/' . str_replace('.', '-', $v) . ']';
                }
            }
            if (!empty($this->dependency_x['plugin'])) {
                $content .= N . N . '#### Plugin' . N;
                foreach ($this->dependency_x['plugin'] as $v) {
                    $content .= N . ' - [link:/reference/extension/plugin/' . str_replace('.', '-', $v) . ']';
                }
            }
        }
        return $content;
    }, .9);
}

Route::set('r/%*%', function($path = "") {
    $data = File::open($f = ROOT . DS . 'stats.php')->import();
    if (strpos($path, 'git:') === 0) {
        $k = 'https://github.com/' . substr($path, 4);
        $data[$k] = isset($data[$k]) ? ($data[$k] + 1) : 1;
        File::export($data)->saveTo($f, 0600);
        Guardian::kick($k);
    }
    Guardian::kick("");
});

Hook::set('route.enter', function() use($site, $url) {
    $path = PAGE . DS . ($site->is('pages') ? $url->path : Path::D($url->path));
    if ($path = File::exist([
        $path . '.page',
        $path . '.archive'
    ])) {
        $description = Page::open($path)->get('description', $site->description);
        $description = t($description, '<p>', '</p>');
        Config::set('description', $description);
    }
});