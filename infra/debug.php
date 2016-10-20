<?php 
/* FUNCAO UTIL PARA DEBUG */

function xd($obj) {
    $debug = debug_backtrace();
    $calledLine = $debug[0]['line'];
    $calledFile = $debug[0]['file'];
    echo "<div style='background-color:#7B68EE; border:1px #666666 solid; text-align:left;'>";
    echo "<pre>";
    echo "{$calledFile} - {$calledLine}<br/><br/>";
    print_r($obj);
    echo "</pre>";
    echo "</div>";
    die();
}

/* FUNCAO UTIL PARA DEBUG SEM  DIE */

function x($obj) {
    $debug = debug_backtrace();
    $calledLine = $debug[0]['line'];
    $calledFile = $debug[0]['file'];
    echo "<div style='background-color:#0000CD; border:1px #666666 solid; text-align:left;'>";
    echo "<pre>";
    echo "{$calledFile} - {$calledLine}<br/><br/>";
    print_r($obj);
    echo "</pre>";
    echo "</div>";
}