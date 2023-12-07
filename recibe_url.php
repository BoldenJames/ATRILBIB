<?php
    $url_req = $_REQUEST['urle'];

    $command = exec(command: "python ./meTADAo.py $url_req");
    echo $command;

    
?>