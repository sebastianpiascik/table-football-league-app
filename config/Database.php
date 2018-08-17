<?php

class Database
{

    private $db;

    public function __construct($server, $database, $user, $password) {
        $this->db = new PDO('mysql:dbname=' . $database .';host=' . $server, $user, $password);
    }

    public function query($query) {
        return $this->db->query($query);
    }

    public function close() {
        return $this->db->close();
    }

    public function getDataTable($table_name){
        return $this->db->query('SELECT * FROM ' . $table_name);
    }

    public function clearDataTable($table_name){
        $this->db->query('Delete from ' . $table_name);
    }

    public function clearDatabase(){
        $tables = $this->db->query('SELECT table_name FROM information_schema.tables  where table_schema="table_football_league"');
        $this->db->query('SET FOREIGN_KEY_CHECKS=0');
        while($tb = $tables->fetch()){
            $this->clearDataTable($tb[0]);
        }
        $this->db->query('SET FOREIGN_KEY_CHECKS=1');
    }

    public function getLastRecordId($table_name){
        return $this->db->query('SELECT id from ' . $table_name  . ' ORDER BY id DESC LIMIT 1')->fetch()['id'];
    }

}
