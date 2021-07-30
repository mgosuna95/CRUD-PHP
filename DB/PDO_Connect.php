<?php

class PDO_Connextion
{

    public function get_connetion()
    {
        include_once dirname(__FILE__) . '/../Constants.php';

        try {
            $pref = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
            $conec = new PDO(
                "mysql:host=" . DB_HOST . "; 
                dbname=" . DB_NAME, 
                DB_USER,
                DB_PASSWORD, 
                $pref);

            return $conec;
        } catch (PDOException $e) {
            print "¡Error!: " . $e->getMessage() . "<br/>";
            die();
        }

    }
}
