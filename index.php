<?php

require_once('config/config.php');
require_once(TEMPLATES_PATH . "/partials/header.php");

?>


    <a href="/views/participants.php?clearDatabase=true"><button class="button--clear">Nowy sezon</button></a>
    <a href="/views/league.php"><button>Ostatni sezon</button></a>


<?php

require_once(TEMPLATES_PATH . "/partials/footer.php");

?>