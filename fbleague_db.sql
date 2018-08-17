DROP TABLE game;

DROP TABLE participant;

DROP TABLE team;

CREATE TABLE game
  (
    id           int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    winner       int ,
	result       VARCHAR(20),
    team_1_id    int NOT NULL ,
    team_2_id    int NOT NULL
  ) ;


CREATE TABLE participant
  ( 
	id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	nick VARCHAR(100),
	points int DEFAULT 0
  ) ;


CREATE TABLE team
  (
    id               int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    participant_1_id int NOT NULL ,
    participant_2_id int NOT NULL
  ) ;


ALTER TABLE game ADD CONSTRAINT game_team_1 FOREIGN KEY ( team_1_id ) REFERENCES team ( id ) ;

ALTER TABLE game ADD CONSTRAINT game_team_2 FOREIGN KEY ( team_2_id ) REFERENCES team ( id ) ;

ALTER TABLE team ADD CONSTRAINT team_participant_1 FOREIGN KEY ( participant_1_id ) REFERENCES participant ( id ) ;

ALTER TABLE team ADD CONSTRAINT team_participant_2 FOREIGN KEY ( participant_2_id ) REFERENCES participant ( id ) ;
