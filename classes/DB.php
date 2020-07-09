<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}

class DB {

    public static $instance;
    public static $msg;

    public function __construct() {
        
    }

    private function __clone() {
        
    }

    public static function getInstance() {
        if (!isset(self::$instance)) {
            try {
                switch (BASE_DADOS) {
                    case 'mysql':
                        self::$instance = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
                        break;
                    case 'mssql':
                        self::$instance = new PDO('mssql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
                        break;
                    case 'pgsql':
                        self::$instance = new PDO('pgsql:dbname=' . DB_NAME . ';user=' . DB_USER . ';password=' . DB_PASS . ';host=' . DB_HOST);
                        break;
                    case 'oracle':
                        //self::$instance = new PDOOCI\PDO(DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
                        //break;
                }
                //demais atributos
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$instance->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
        return self::$instance;
    }

    public static function prepare($sql) {
        return self::getInstance()->prepare($sql);
    }

}
