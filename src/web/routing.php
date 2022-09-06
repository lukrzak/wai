<?php
    $routing = [
        '/' => 'gallery',
        '/gallery' => 'gallery',
        '/gallery/addImageForm' => 'displayUploadForm',
        '/gallery/addImage' => 'upload',
        '/gallery/removeAll' => 'deleteImages',
        '/gallery/remember' => 'rememberImages',
        '/gallery/forget' => 'removeImagesFromSession',
        '/gallery/search' => 'displaySearch',
        '/gallery/search/result' => 'searchResult',
        '/gallery/remember/display' => 'displayImagesInSession',
        '/login' => 'displayLoginForm',
        '/register' => 'register',
        '/deleteUsers' => 'deleteUsers',
        '/loginUser' => 'login',
        '/logout' => 'logout'
    ];
