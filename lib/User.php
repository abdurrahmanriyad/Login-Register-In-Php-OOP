<?php
    include_once "Session.php";
    include "Database.php";
class User
{
    private $db;
    public function __construct(){
        $this->db = new Database();
    }
}