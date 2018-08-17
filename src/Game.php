<?php

class Game
{
    private $table_name = 'game';
    protected $db;
    private $id;
    private $team1;
    private $team2;
    private $result;
    private $winner;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function create(){
        $result = $this->db->query('INSERT INTO ' . $this->table_name . '(team_1_id,team_2_id) VALUES("' . $this->team1 . '","' . $this->team2 . '")');

        if($result)
            return true;
        else
            return false;

    }

    public function saveResults(){
        $this->db->query('UPDATE ' . $this->table_name . ' SET winner='.$this->getWinner().', result="'.$this->getResult().'" WHERE id='.$this->getId());
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTableName()
    {
        return $this->table_name;
    }

    /**
     * @param mixed $team1
     */
    public function setTeam1($team1)
    {
        $this->team1 = $team1;
    }

    /**
     * @return mixed
     */
    public function getTeam1()
    {
        return $this->team1;
    }

    /**
     * @param mixed $team2
     */
    public function setTeam2($team2)
    {
        $this->team2 = $team2;
    }

    /**
     * @return mixed
     */
    public function getTeam2()
    {
        return $this->team2;
    }

    /**
     * @param mixed $result
     */
    public function setResult($result)
    {
        $this->result = $result;
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @return mixed
     */
    public function getWinner()
    {
        return $this->winner;
    }

    /**
     * @param mixed $winner
     */
    public function setWinner($winner)
    {
        $this->winner = $winner;
    }
}