<?php

Hook::set('page.input', function($data) {
    if (!empty($data['content']) && strpos($data['content'], '[connect:') !== false) {
        $data['content'] = str_replace('[connect:', '**Related:** [link:', $data['content']);
    }
    return $data;
}, .9);

if (Extend::exist('block')) {
    // add `[[asset]]` block
    Block::set('asset', function($content) use($url) {
        return Block::replace('asset', $url->host === 'localhost' ? To::url(ASSET) : 'https://mecha-cms.github.io/lot.page/asset', $content);
    });
}

// add static `time` field automatically
Hook::set('shield.before', function() {
    extract(Lot::get(null, []));
    $time = Path::D($page->path) . DS . $page->slug . DS . 'time.data';
    if ($site->type === 'page' && !File::exist($time)) {
        File::write($page->time)->saveTo($time);
    }
});