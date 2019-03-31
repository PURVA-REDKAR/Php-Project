<?php

     require "Team.class.php";
    require "FN.class.php";
    require "Players.Class.php";


    $team = new Players();

    $data =$team->ViewPlayer();

    echo FN::build_table( $data );


?>