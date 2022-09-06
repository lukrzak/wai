<?php

const REDIRECT_PREFIX = 'redirect:';

function dispatch($routing, $action)
{
    $controllerName = $routing[$action];
    $model = [];
    $viewName = $controllerName($model);
    buildResponse($viewName, $model);
}

function buildResponse($view, $model)
{
    if (strpos($view, REDIRECT_PREFIX) === 0) {
        $url = substr($view, strlen(REDIRECT_PREFIX));
        header("Location: " . $url);
        exit;
    } 
    else render($view, $model);
    
}

function render($viewName, $model)
{
    global $routing;
    extract($model);
    include 'views/'.$viewName.'.php';
}