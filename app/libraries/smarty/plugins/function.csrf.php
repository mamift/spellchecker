<?php

/**
 * Returns a hidden input field for the CSRF token provded by Laravel.
 * 
 * @param  [parameters] $params   [ignored]
 * @param  Smarty_Internal_Template $template [ignored]
 * @return [string] [the hidden input CSRF field]
 */
function smarty_function_csrf($params, Smarty_Internal_Template $template)
{
    return '<input name="_token" type="hidden" value="'. Session::token() .'" />';
}
