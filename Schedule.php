<?php


    require "FN.class.php";
    require "Schedule.class.php";

    FN::session_check();  
    $schedule = new Schedule();

    $data =$schedule->ViewSchedule();

    echo FN::build_form_add_del_edit($data);


?>