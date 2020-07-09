<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}

/*
 * verificacao do status do login
 */
class Encryption
{

    protected static $instance;

    public function encode($data)
    {
        return base64_encode($data);
    }

    // decrypt encrypted string
    public function decode($data)
    {
        return base64_decode($data);
    }

    public static function getInstance()
    {
        if (! isset(self::$instance)) {
            $c = __CLASS__; // get class name
            self::$instance = new $c(); // create new instance
        }
        return self::$instance;
    }
}