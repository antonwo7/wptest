<?php

function get_current_url()
{
    global $wp;

    $params = $_SERVER['QUERY_STRING'] == '' ? '' : '?' . $_SERVER['QUERY_STRING'];

    return home_url($wp->request) . $params;
}