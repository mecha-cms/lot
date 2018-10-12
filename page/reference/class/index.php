<?php

Hook::set('page.title', function($title) {
    if ($this->icon) {
        return '<svg viewBox="0 0 24 24" width="24" height="24"><path d="' . $this->icon . '"></path></svg> ' . $title;
    }
    return $title;
});