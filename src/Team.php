<?php

class Team
{
    private $table_name = 'team';
    protected $db;
    private $participant1;
    private $participant2;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function create(){
        $result = $this->db->query('INSERT INTO ' . $this->table_name . '(participant_1_id,participant_2_id) VALUES("' . $this->participant1 . '","' . $this->participant2 . '")');

        if($result)
            return true;
        else
            return false;

    }

    public function getParticipantID($team_id){
        return $this->db->query('SELECT participant_1_id, participant_2_id FROM ' . $this->table_name . ' WHERE id=' . $team_id)->fetch();
    }

    /**
     * @return string
     */
    public function getTableName()
    {
        return $this->table_name;
    }

    /**
     * @param mixed $participant1
     */
    public function setParticipant1($participant1)
    {
        $this->participant1 = $participant1;
    }

    /**
     * @param mixed $participant2
     */
    public function setParticipant2($participant2)
    {
        $this->participant2 = $participant2;
    }
}