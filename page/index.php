<?php

Hook::set('page.content', function($content) {
    if (strpos($content, '[connect:') === false) {
        return $content;
    }
    return str_replace('[connect:', '**Related:** [link:', $content);
}, 1.8);

Hook::set('page.content', function($content) {
    if (strpos($content, '[') === false) return $content;
    return preg_replace_callback('#[‌]?\[[‌]?\[[‌]?/?[‌]?[^\n]+?[‌]?\][‌]?\][‌]?#', function($m) {
        return str_replace(S, "", $m[0]);
    }, $content);
}, 2.1);

// Add static `time` field automatically
Hook::set('set', function() use($site) {
    $page = $GLOBALS['page'];
    if ($page && $page->exist) {
        $time = Path::F($page->path) . DS . 'time.data';
        if (!$site->is('error') && !File::exist($time)) {
            $file = new File($time);
            $file->set($page->time);
            $file->save(0600);
        }
    }
});