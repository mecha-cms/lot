<?php

Hook::set('page.content', function($content) {
    if (strpos($content, '[connect:') === false) {
        return $content;
    }
    return str_replace('[connect:', '**Related:** [link:', $content);
}, 1.8);

if (Plugin::exist('candy')) {
    // Add `%{asset}%` candy
    Hook::set('plugin.state.candy', function($a) {
        $a['v']['asset'] = $_SERVER['HTTP_HOST'] === 'localhost' ? To::url(ASSET) : 'https://mecha-cms.github.io/lot/asset';
        return $a;
    });
}

// Add static `time` field automatically
Hook::set('shield.enter', function() use($site) {
    if ($page = Lot::get('page')) {
        $time = Path::F($page->path) . DS . 'time.data';
        if ($site->is !== '404' && !File::exist($time)) {
            File::write($page->time)->saveTo($time);
        }
    }
});