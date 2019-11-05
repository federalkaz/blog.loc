<?php
/*
 * Route list file
 */
return [
    '' => 'main/index', // actionIndex в MainController
    'post/([a-z]+)/([0-9]+)' => 'post/view/$1/$2',
    'post/([0-9]+)' => 'post/index', // actionIndex в PostController
    'post-manager' => 'postManager/index', // actionIndex в PostManagerController
];