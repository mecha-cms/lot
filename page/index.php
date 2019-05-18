<?php

Hook::set('*.content', function($content) {
    if (strpos($content, '[connect:') === false) {
        return $content;
    }
    return str_replace('[connect:', '**Related:** [link:', $content);
}, 1.8);

Hook::set('*.content', function($content) {
    if (strpos($content, '[') === false) return $content;
    return preg_replace_callback('#[‌]?\[[‌]?\[[‌]?/?[‌]?[^\n]+?[‌]?\][‌]?\][‌]?#', function($m) {
        return str_replace('‌', "", $m[0]);
    }, $content);
}, 2.1);

if (Plugin::exist('candy')) {
    // Add `%{asset}%` candy
    Hook::set('plugin.state.candy', function($a) {
        $a['v']['asset'] = $_SERVER['HTTP_HOST'] === 'localhost' ? To::URL(ASSET) : 'https://mecha-cms.github.io/lot/asset';
        return $a;
    });
}

// Add static `time` field automatically
Hook::set('set', function() use($site) {
    $page = $GLOBALS['page'];
    if ($page && $page->exist) {
        $time = Path::F($page->path) . DS . 'time.data';
        if (!$site->is('error') && !File::exist($time)) {
            File::set($page->time)->saveTo($time);
        }
    }
});