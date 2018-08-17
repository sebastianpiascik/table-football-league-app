<?php


require_once(dirname(dirname(__FILE__)) . '/config/config.php');
require_once(TEMPLATES_PATH . "/partials/header.php");

?>

    <h2>Tabela meczy: </h2>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Drużyna 1</th>
                <th>Wynik</th>
                <th>Drużyna 2</th>
            </tr>
            <?php

            $team = new Team($db);
            $participant = new Participant($db);

            $games = $db->getDataTable('game');

            $index = 0;

            while ($single_game = $games->fetch()) {

                $team1Participants = $team->getParticipantID($single_game['team_1_id']);
                $team2Participants = $team->getParticipantID($single_game['team_2_id']);


                $team1_score = '';
                $team2_score = '';
                if(! empty($single_game['result'])){
                    $team1_score = explode("-", $single_game['result'])[0];
                    $team2_score = explode("-", $single_game['result'])[1];
                }


                echo '<tr>';
                echo '<td>' . ++$index . '<input name="game_id[]" type="number" value="' . $single_game["id"] . '" hidden> </td>';
                echo '<td>' . $participant->getNickById($team1Participants["participant_1_id"]) . ' i ' . $participant->getNickById($team1Participants["participant_2_id"]) . '</td>';
                echo '<td><input name="team1_id[]" type="number" value="' . $single_game["team_1_id"] . '" hidden><input class="result" type="number" name="team1_score[]" id="team1_score" value="' . $team1_score . '"> : <input class="result" type="number" name="team2_score[]" id="team2_score" value="' . $team2_score . '"><input name="team2_id[]" type="number" value="' . $single_game["team_2_id"] . '" hidden></td>';
                echo '<td>' . $participant->getNickById($team2Participants["participant_1_id"]) . ' i ' . $participant->getNickById($team2Participants["participant_2_id"]) . '</td>';
                echo '</tr>';
            }

            ?>
        </table>
        <div class="form__element">
            <button type="submit" name="btnSaveScore" id="btnSaveScore">Zapisz wyniki</button>
        </div>
    </form>


<?php

if (isset($_POST['btnSaveScore'])) {

    /*
     * Index - amount of
     */

    $reloadPage = true;
    for ($i = 0; $i < $index; $i++) {

        if (! empty($_POST['team1_score'][$i]) && ! empty($_POST['team2_score'][$i])) {

            if($_POST['team1_score'][$i] == $_POST['team2_score'][$i]){
                $reloadPage=false;
                echo "Nie ma remisów ! Gramy dalej.";
            } else{

                $game = new Game($db);

                $game->setId($_POST['game_id'][$i]);

                $game->setResult($_POST['team1_score'][$i] . '-' . $_POST['team2_score'][$i]);
                if ($_POST['team1_score'][$i] > $_POST['team2_score'][$i]) {
                    $game->setWinner($_POST['team1_id'][$i]);
                } else{
                    $game->setWinner($_POST['team2_id'][$i]);
                }


                $game->saveResults();
            }

        }

    }

    if($reloadPage){
        echo("<script>location.href = 'http://".$_SERVER['SERVER_NAME']."/views/league.php';</script>");
//        header("Location: http://" . $_SERVER['SERVER_NAME'] . "/views/league.php");
//        exit();
    }


}
?>


<div class="breakline"></div>

<h2>Tabela wyników</h2>

<table border="1">
    <tr>
        <th>Uczestnik</th>
        <th>Ilość punktów</th>
    </tr>
    <?php

    $games = $db->getDataTable('game');
    $winners = array();
    while ($single_game = $games->fetch()){
        if(! empty($single_game['winner']))
            $winners[] = $team->getParticipantID($single_game['winner']);

    }
//    print_r($winners);

    $result = $db->getDataTable('participant');
    $participants = array();
    while ($row = $result->fetch()) {
        $participants[] = $row['id'];
    }

    $participantPointsArray = array();

    $points = 0;
    foreach ($participants as $p) {
        foreach ($winners as $team_winner){
            for ($i=0; $i<2; $i++){
                if($team_winner[$i] == $p){
                    $points++;
                }
            }
        }
        $participantPointsArray[] = array($p, $points);
        $points=0;
    }

    usort($participantPointsArray, function($a, $b) {
        return $b[1] - $a[1];
    });

    foreach ($participantPointsArray as $pp){

        echo '<tr>';
        echo '<td>'. $participant->getNickById($pp[0]) .'</td>';
        echo '<td>'.$pp[1].'</td>';
        echo '</tr>';

    }

    ?>
</table>

<?php

require_once(TEMPLATES_PATH . "/partials/footer.php");

?>

