<?php
/**
 * Participant Class
 */

class Participant
{
    private $table_name = "participant";
    protected $db;
    private $nick;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function create(){
        $result = $this->db->query('INSERT INTO ' . $this->table_name . '(nick) VALUES("' . $this->nick . '")');

        if($result)
            return true;
        else
            return false;

    }

    /**
     * @return string
     */
    public function getTableName(){
        return $this->table_name;
    }

    /**
     * @return string
     */
    public function getNickById($id){
        return $this->db->query('SELECT * FROM ' . $this->table_name . ' WHERE id=' . $id)->fetch()['nick'];
    }

    /**
     * @param mixed $nick
     */
    public function setNick($nick)
    {
        $this->nick = $nick;
    }
}