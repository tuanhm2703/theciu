<?php

function route($name, $parameters = [], $absolute = true)
{
    return app('url')->route($name, $parameters, $absolute). "/";
}
