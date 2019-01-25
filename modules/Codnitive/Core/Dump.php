<?php 

function dump($var, bool $print_r = true)
{
    echo '<pre>';
    $print_r ? print_r($var) : var_dump($var);
    echo '</pre>';
}
