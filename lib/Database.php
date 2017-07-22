<?php

/**
 * Created by PhpStorm.
 * User: primez
 * Date: 7/21/17
 * Time: 10:56 PM
 */
class Database
{
   private $db_host = 'localhost';
   private $db_user = 'root';
   private $db_pass = 'root';
   private $db_name = 'php-login-register-oop';
   public $pdo;
   public function __construct(){
      if(!isset($this->pdo)){
         try{
            $connetion = new PDO("mysql:host=".$this->db_host."; dbname=".$this->db_name, $this->db_user, $this->db_pass);
            $connetion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $connetion->exec("SET CHARACTER SET utf8");
            $this->pdo = $connetion;
         }catch(PDOException $e){
            die("Failed to connect with database". $e->getMessage());
         }
      }
   }
}