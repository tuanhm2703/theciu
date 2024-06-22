<?php

function route($name, $parameters = [], $absolute = true)
{
    $route = app('url')->route($name, $parameters, $absolute). "/";
    $route = remove_admin_trailing_slash($route);
    return remove_trailing_slash($route);
}
