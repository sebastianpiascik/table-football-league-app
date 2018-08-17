<?php


require_once(dirname(dirname(__FILE__)) . '/config/config.php');
require_once(TEMPLATES_PATH . "/partials/header.php");

if(isset($_GET['clearDatabase'])){
    $db->clearDatabase();
    header("Location: http://" . $_SERVER['SERVER_NAME'] . "/views/participants.php");
}

?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form__element">
            <input type="text" name="nick" id="nick" placeholder="Nazwa gracza">
            <button class="button--small" type="submit" name="btnCreateParticipant" id="btnCreateParticipant">Dodaj uczestnika
            </button>
        </div>
    </form>


    <div class="breakline"></div>
    <h2>Uczestnicy:</h2>

<?php

if (isset($_POST['btnCreateParticipant']))
    createParticipant($db);

if (isset($_POST['btnGenerateTeams']))
    generateTeams($db);

?>

    <div class="breakline"></div>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?page=participants" method="post">
        <div class="form__element">
            <button class="button--small" type="submit" name="btnGenerateTeams" id="btnGenerateTeams">Generuj drużyny</button>
        </div>
    </form>


<?php

function createParticipant($db){
    $participant = new Participant($db);
    $participant->setNick(htmlspecialchars(strip_tags($_POST['nick'])));

    if ($participant->create())
        echo "<div class='alert alert-success'>Dodano uczestnika</div>";
    else
        echo "<div class='alert alert-danger'>Nie można dodać uczestnika.</div>";

    printParticipants($db, $participant);
}

function printParticipants($db, $participant)
{

    $result = $db->getDataTable($participant->getTableName());

    $index = 1;

    while ($row = $result->fetch()) {
        echo '<p>' . $index++ . '. ' . $row['nick'] . '</p>';
    }
}

function generateTeams($db)
{

    /*
    * Get all participants id
    */

    $result = $db->getDataTable('participant');

    $participants = array();

    while ($row = $result->fetch()) {
        $participants[] = $row['id'];
    }

    // Make team array

    $team_array = array();

    foreach ($participants as $value) {
        for ($i = 0; $i < count($participants); $i++) {
            if ($value !== $participants[$i]) {
                if (!in_array(array_reverse(array($value, $participants[$i])), $team_array)) {
                    $team_array[] = array($value, $participants[$i]);
                }
            }
        }
    }
    // Make game array

    $game_array = array();

    foreach ($team_array as $value) {
        foreach ($team_array as $value2) {
            if (!in_array(array_reverse(array($value, $value2)), $game_array)) {
                if (!in_array($value2[0], $value)) {
                    if (!in_array($value2[1], $value)) {
                        $game_array[] = array($value, $value2);
                    }
                }
            }
        }
    }

    foreach ($game_array as $game) {
        $lastTeamTableId=1;
        for($i = 0;$i < 2; $i++){
            $t = new Team($db);
            $t->setParticipant1($game[$i][0]);
            $t->setParticipant2($game[$i][1]);
            $t->create();
            $lastTeamTableId = $db->getLastRecordId($t->getTableName());
        }
        $g = new Game($db);
        $g->setTeam1($lastTeamTableId - 1);
        $g->setTeam2($lastTeamTableId);
        $g->create();
    }

    header("Location: http://" . $_SERVER['SERVER_NAME'] . "/views/league.php");

}

require_once(TEMPLATES_PATH . "/partials/footer.php");

?>