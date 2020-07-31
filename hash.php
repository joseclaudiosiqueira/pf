<?php
/*
 * insere o conf
 */
require_once $_SERVER['DOCUMENT_ROOT'] . (substr($_SERVER['DOCUMENT_ROOT'], -1) === '/' ? '' : '/') . 'pf/conf/conf.php';


echo base64_encode($_GET['s']) . '<br>';
echo base64_decode($_GET['s']) . '<br>';
echo sha1($_GET['s']);


//echo $converter->decode($_GET['s']). '<br>';
//echo $converter->encode($_GET['s']). '<br>';
//echo sha1($_GET['s']) . '<br>';
//echo $converter->decode($converter->encode($_GET['s'])). '<br>';