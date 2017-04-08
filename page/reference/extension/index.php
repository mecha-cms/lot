<?php

Hook::set('page.content', function($content, $lot) {
    global $url;
    $b = Path::B($url->path);
    $NS = Path::B(Path::D($url->path)) === 'plugin' ? 'extend.plugin' : 'extend';
    if (!isset($lot['dependency']) || $lot['dependency'] !== false) {
        $content = '[Download Latest Version]([[url]]/2016/d/mecha-cms/' . $NS . '.' . $b . '/archive/master.zip) {.button}' . N . N . $content;
    }
    if (!empty($lot['dependency']) && $lot['dependency'] !== true) {
        $content .= N . N . '### Dependency';
        if (!empty($lot['dependency']['extension'])) {
            $content .= N . N . '#### Extension' . N;
            foreach ($lot['dependency']['extension'] as $v) {
                $content .= N . ' - [link:/reference/extension/' . $v . ']';
            }
        }
        if (!empty($lot['dependency']['plugin'])) {
            $content .= N . N . '#### Plugin' . N;
            foreach ($lot['dependency']['plugin'] as $v) {
                $content .= N . ' - [link:/reference/extension/plugin/' . $v . ']';
            }
        }
    }
    return $content;
}, .9);