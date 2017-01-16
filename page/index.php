<?php

Hook::set('page.content', function($content) {
    if (strpos($content, '[connect:') === false) {
        return $content;
    }
    return str_replace('[connect:', '**Related:** [link:', $content);
}, .8);

if (Extend::exist('block')) {
    // add `[[asset]]` block
    Block::set('asset', function($content) use($url) {
        return Block::replace('asset', $url->host === 'localhost' ? To::url(ASSET) : 'https://mecha-cms.github.io/lot.page/asset', $content);
    });
}

// add static `time` field automatically
Hook::set('shield.before', function() use($site) {
    if ($page = Lot::get('page')) {
        $time = Path::F($page->path) . DS . 'time.data';
        if ($site->type === 'page' && !File::exist($time)) {
            File::write($page->time)->saveTo($time);
        }
    }
});