<?php

Hook::set('*.title', function($title) {
    if (strpos($this->path, PAGE . DS . 'reference' . DS . 'function' . DS) === 0) {
        return '`' . strtr($this->slug, '.-', "\\_") . '`';
    }
    return $title;
}, 1.9);