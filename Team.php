
<?php

    require "FN.class.php";
    require "Team.class.php";
    require "Validate.class.php";

     FN::session_check();
   // $db = new DB(DB_HOST, DB_USER, DB_PASS, DB_NAME) ;
    $teams = new Team();
    if(!empty( $_GET )){
                 //check if user wants to add results
                if(isset($_GET['add'])){

                 $_SESSION["page"] = 'AddTeam.php' ;
                 header("Location: template.php");

           }
           //get all the post variables
             $team =  $_GET["team"];
             $team1 = str_replace(' ', '', $team);
             $user_name =$team1."team";
             $team_edit =  $_GET[$user_name];


             $mascot_name = $team1."mascot";
             $mascot = $_GET[$mascot_name];

             $sport_name =  $team1."sport";
             $sport = [$sport_name];

             $awaycolor_name =  $team1."awaycolor";
             $awaycolor = $_GET[$awaycolor_name];

             $homecolor_name =  $team1."homecolor";
             $homecolor =   $_GET[$homecolor_name];

             $league_name =  $team1."league";
             $league =   $_GET[$league_name];

             $maxplayers_name =  $team1."maxplayers";
             $maxplayers =   $_GET[$maxplayers_name];



             $season_name =  $team1."season";
             $season =   $_GET[$season_name];

              //set all the submitted get variables  to object and sanitize them

            $teams->setLeague($league);
            $teams->setAwayColor(VS::Sanitize($awaycolor));
            $teams->setHomeColor(VS::Sanitize($homecolor));
            $teams->setMascot(VS::Sanitize($mascot));
            $teams->setMaxPlayers(VS::Sanitize($maxplayers));
            $teams->setName(VS::Sanitize($team));
            $teams->setSeason($season);
            $teams->setSport($sport[0]);

            if(isset($_GET['delete'])){
                  $teams->deleteTeams();
            }
              //validate and update
           if(isset($_GET['edit'])){

               if (is_numeric($maxplayers)){
                   if(!empty($team)){

                           $teams->editTeams($team_edit);

                    }
                    else{
                    echo '<div class="error">Please enter team name</div>';
                }

                }
                else{
                    echo '<div class="error">Please check values entered (Maxnumber should be number)</div>';
                }
            }


    }


    $data = $teams->ViewTeams();

    echo FN::build_form_add_del_edit($data);


?>
