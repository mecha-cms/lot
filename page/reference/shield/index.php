<?php

Hook::set('page.content', function($content, $lot) {
    if (!isset($lot['path']) || strpos($lot['path'], PAGE) !== 0) {
        return $content;
    }
    global $url;
    $b = Path::B($url->path);
    $NS = 'shield';
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
    if (!empty($lot['dependency_x'])) {
        $content .= N . N . '### Conflict With';
        if (!empty($lot['dependency_x']['extension'])) {
            $content .= N . N . '#### Extension' . N;
            foreach ($lot['dependency_x']['extension'] as $v) {
                $content .= N . ' - [link:/reference/extension/' . $v . ']';
            }
        }
        if (!empty($lot['dependency_x']['plugin'])) {
            $content .= N . N . '#### Plugin' . N;
            foreach ($lot['dependency_x']['plugin'] as $v) {
                $content .= N . ' - [link:/reference/extension/plugin/' . $v . ']';
            }
        }
    }
    return $content;
}, .9);