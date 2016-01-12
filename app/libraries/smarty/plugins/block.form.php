<?php

/**
 * Incomplete implementation; need to figure out all the Form::open() parameter combinations
 * 
 * @param  [array]                   $params   [description]
 * @param  [mixed]                   $content  [description]
 * @param  Smarty_Internal_Template $template [description]
 * @param  [boolean]                   &$repeat  [description]
 *
 * @return [type]                             [description]
 */
function smarty_block_form($params, $content, Smarty_Internal_Template $template, &$repeat)
{
    $url = $params['url'];
    $method = $params['method'];
    $route = $params['route'];
    $action = $params['action'];
    $files = $params['files'];

    $opts_1 = array(
        'url' => $url,
        'method' => $method
    );

    $opts_2 = array(
        'route' => $route
    );

    $opts_3 = array(
        'action' => $action
    );

    $optsToPass = array();

    if (!empty($url))

    if ($repeat) {
        echo Form::open();
    } else {
        echo $content;
        echo Form::close();
    }
}