<?php

require "DB.class.php";
require "Validate.class.php";


    class Schedule {

      private $awayscore;
      private $awayteam;
      private $completed;
      private $homescore;
      private $hometeam;
      private $league;
      private $scheduled;
      private $season;
      private $sport;
      private $db;

       function __construct(){

              $this->db = new DB(DB_HOST, DB_USER, DB_PASS, DB_NAME) ;

        }

        function getAwayScore() {
             return $this->awayscore;
        }

        function getAwayTeam() {
             return $this->awayteam;
        }

        function getCompleted() {
             return $this->completed;
        }

       function getHomeScore() {
             return $this->homescore;
        }

        function getHomeTeam() {
             return $this->hometeam;
        }

        function getLeague() {
             return $this->league;
        }

        function getScheduled() {
             return $this->scheduled;
        }

        function getSeason() {
             return $this->season;
        }

        function getSport() {
             return $this->sport;
        }


        function setAwayScore($awayscore) {
            $this->awayscore = $awayscore;
        }

        function setAwayTeam($awayteam) {
             $this->awayteam = $awayteam;
        }

        function setCompleted($completed) {
             $this->completed = $completed;
        }

       function setHomeScore($homescore) {
             $this->homescore = $homescore;
        }

        function setHomeTeam($hometeam) {
              $this->hometeam = $hometeam;
        }

        function setLeague($league) {
              $this->league = $league;
        }

        function setScheduled($scheduled) {
              $this->scheduled =$scheduled;
        }

        function setSeason($season) {
             $this->season =$season;
        }

        function setSport($sport) {
             $this->sport = $sport;
        }

        /**
         * Desc: Function to Update Position
         * Param: New Value for updation
        */
        function editSchedule($sport_edit,$description_edit,$league_edit,$ateam_edit,$hteam_edit){


              $awayscore =$this->getAwayScore();
              $awayteam  =$this->getAwayTeam();
              $completed =$this->getCompleted();
              $homescore =$this->getHomeScore();
              $hometeam  = $this->getHomeTeam();
              $league    = $this->getLeague();
              $scheduled  = $this->getScheduled();
              $description = $this->getSeason();
              $sport     =  $this->getSport();

              $league_updt_id =  $this->db->getInstance("server_league",$league_edit);
              $league_id_ori =  $this->db->getInstance("server_league",$league);

              $sport_id =  $this->db->getInstance("server_sport",$sport_edit);
              $sport_id_ori =  $this->db->getInstance("server_sport",$sport);

              $season_id =  $this->db->getInstance("server_season",$description_edit,"description");
              $season_id_ori =  $this->db->getInstance("server_season",$description,"description");

              $ateam_id =  $this->db->getInstance("server_team",$ateam_edit);
              $ateam_id_ori =  $this->db->getInstance("server_team",$awayteam);

               $hteam_id =  $this->db->getInstance("server_team",$hteam_edit);
               $hteam_id_ori =  $this->db->getInstance("server_team",$hometeam);


               $sql  ="UPDATE server_schedule
                        SET  sport=? , league = ? ,season = ?, hometeam =? ,awayteam =? ,homescore =? ,awayscore =? ,scheduled=?, completed = ?
                        WHERE  sport=? and league = ? and season = ? and hometeam =? and awayteam =? ";

               $values = array($sport_id,$league_updt_id,$season_id,$hteam_id,$ateam_id,$homescore,$awayscore,$scheduled,$completed,
                                 $sport_id_ori,$league_id_ori, $season_id_ori,$hteam_id_ori,$ateam_id_ori);
                 $bindParams = array(PDO::PARAM_INT,PDO::PARAM_INT,PDO::PARAM_INT,PDO::PARAM_INT,PDO::PARAM_INT,PDO::PARAM_INT,PDO::PARAM_INT,
                    PDO::PARAM_STR,PDO::PARAM_BOOL,PDO::PARAM_INT,PDO::PARAM_INT,PDO::PARAM_INT,PDO::PARAM_INT,PDO::PARAM_INT);

                 $this->db->Add_insert_delete_Query($sql,$values,$bindParams);

         }

        /**
        * Desc: Function to Delete Schedule
        */

        function deleteSchedule(){

              $league      = $this->getLeague();
              $scheduled   = $this->getScheduled();
              $description = $this->getSeason();
              $sport       =  $this->getSport();
              $ateam        = $this->getAwayTeam();
              $hteam       =  $this->getHomeTeam();

               $sport_id =  $this->db->getInstance("server_sport",$sport);
               $season_id =  $this->db->getInstance("server_season",$description,"description");
               $league_id =  $this->db->getInstance("server_league",$league);
               $ateam_id =  $this->db->getInstance("server_team",$ateam);
               $hteam_id =  $this->db->getInstance("server_team",$hteam);

                $sql = "DELETE FROM server_schedule
                    WHERE sport=? and league = ? and season = ? and hometeam =? and awayteam =?  ";

                $this->db->Add_insert_delete_Query($sql,array($sport_id,$league_id,$season_id,$hteam_id,$ateam_id),array(PDO::PARAM_INT,PDO::PARAM_INT,PDO::PARAM_INT,PDO::PARAM_INT,PDO::PARAM_INT));



        }

        /**
        * Desc: Function to Add Schedule
        */
        function addSchedule(){


             $awayscore = $this->getAwayScore();

             $homescore =$this->getHomeScore();

             $scheduled = $this->getScheduled();

             $completed = $this->getCompleted();

             $season = $this->getSeason();

             $sports = $this->getSport();

             $hometeam = $this->getHomeTeam();

             $awayteam = $this->getAwayTeam();

             $league =$this->getLeague();


             $league_id  = $this->db->getInstance("server_league",$league);
             $sport_id  = $this->db->getInstance("server_sport",$sports);
             $season_id  = $this->db->getInstance("server_season",$season,"description");
               $ateam_id =  $this->db->getInstance("server_team",$awayteam);
               $hteam_id =  $this->db->getInstance("server_team",$hometeam);

             $sql = "INSERT INTO server_schedule (awayscore,homescore,scheduled,completed,season,sport,
                                                hometeam,awayteam,league )
                                             VALUES ( ?,?,?,?,?,?,?,?,?)";
            $value = array($awayscore,$homescore,$scheduled,$completed,$season,$sports,
                                                $hteam_id,$ateam_id,$league);
            $bindParams= array(PDO::PARAM_INT,PDO::PARAM_INT,PDO::PARAM_STR,PDO::PARAM_BOOL,
                               PDO::PARAM_INT,PDO::PARAM_INT,PDO::PARAM_INT,PDO::PARAM_INT,PDO::PARAM_INT);
           $this->db->Add_insert_delete_Query($sql,$value,$bindParams) ;

        }

        /**
        * Desc: Function to Display Schedule
        */
        function ViewSchedule(){



             if($_SESSION["role"] == 1 ){

                       $sql  ="SELECT sport.name as sport ,awayscore ,team1.name as awayteam ,completed ,homescore ,
                              team2.name as hometeam ,league.name as league,scheduled,season.description as description
                              FROM server_schedule s
                              LEFT JOIN server_league league ON s.league = league.id
                              LEFT JOIN server_season season ON s.season =season.id
                              LEFT JOIN server_team team1 ON s.awayteam =team1.id
                              LEFT JOIN server_team team2 ON s.hometeam =team2.id
                              LEFT JOIN server_sport sport ON s.sport =sport.id";

                        $data =  $this->db->doQuery($sql,array(),array() );

            }
            if($_SESSION["role"] == 2){

               $leg = $_SESSION["league"];

                       $sql  ="SELECT sport.name as sport ,awayscore ,team1.name as awayteam ,completed ,homescore ,
                              team2.name as hometeam ,league.name as league,scheduled,season.description as description
                              FROM server_schedule s
                              LEFT JOIN server_league league ON s.league = league.id
                              LEFT JOIN server_season season ON s.season =season.id
                              LEFT JOIN server_team team1 ON s.awayteam =team1.id
                              LEFT JOIN server_team team2 ON s.hometeam =team2.id
                              LEFT JOIN server_sport sport ON s.sport =sport.id
                              WHERE league.id= ?";

                        $data =  $this->db->doQuery($sql,array($leg),array(PDO::PARAM_INT) );



            }

            if($_SESSION["role"] > 3){

                 $team_r = $_SESSION["team"];


                   $sql  ="SELECT sport.name as sport ,awayscore ,team1.name as awayteam ,completed ,homescore ,
                              team2.name as hometeam ,league.name as league,scheduled,season.description as description
                              FROM server_schedule s
                              LEFT JOIN server_league league ON s.league = league.id
                              LEFT JOIN server_season season ON s.season =season.id
                              LEFT JOIN server_team team1 ON s.awayteam =team1.id
                              LEFT JOIN server_team team2 ON s.hometeam =team2.id
                              LEFT JOIN server_sport sport ON s.sport =sport.id
                              WHERE team1.id = ? OR team2.id = ?" ;

                        $data =  $this->db->doQuery($sql,array($team_r,$team_r),array(PDO::PARAM_INT,PDO::PARAM_INT));

            }

           if($_SESSION["role"] < 5 && ($_SESSION["page"] != 'Schedule.php')){
           foreach ($data as &$value){

                 $sport = $value["sport"];
                 $user_name =  $sport."user";

                 $value["sport"] =  "<input type='radio' name='sport' value='$sport'>";
                 $value["sport"] .= FN::arrangeDropdown($sport,$user_name,"server_sport","sport");

                  $description = $value["description"];
                  $description_name =  $sport."description";
                  $description_ori =  $sport."descriptionori";

                  $value["description"] = " <input type='hidden' name='$description_ori' value='$description'/> ";
                  $value["description"] .= FN::arrangeDropdown($description,$description_name,"server_season","season","description");


                  $league = $value["league"];
                  $league_name =  $sport."league";
                  $league_ori =  $sport."leagueori";
                  $league_ori= str_replace(' ', '', $league_ori);
                  $league_name= str_replace(' ', '', $league_name);

                  $value["league"] = " <input type='hidden' name='$league_ori' value='$league'/> ";
                  $value["league"] .= FN::arrangeDropdown($league,$league_name,"server_league","league");

                  $ateam = $value["awayteam"];
                  $ateam_name =  $sport."awayteam";
                  $ateam_ori =  $sport."awayteamori";
                  $ateam_ori= str_replace(' ', '', $ateam_ori);
                  $ateam_name= str_replace(' ', '', $ateam_name);

                  $value["awayteam"] = " <input type='hidden' name='$ateam_ori' value='$ateam'/> ";
                  $value["awayteam"] .=  FN::arrangeDropdown($ateam,$ateam_name,"server_team","awayteam");


                  $hteam = $value["hometeam"];
                  $hteam_name =  $sport."hometeam";
                  $hteam_ori =  $sport."hometeamori";
                  $hteam_ori= str_replace(' ', '', $hteam_ori);
                  $hteam_name= str_replace(' ', '', $hteam_name);

                  $value["hometeam"] = " <input type='hidden' name='$hteam_ori' value='$hteam'/> ";
                  $value["hometeam"] .=   FN::arrangeDropdown($hteam,$hteam_name,"server_team","hometeam");


                  $hscore = $value["homescore"];
                  $hscore_name =  $sport."homescore" ;
                  $value["homescore"] = "<input type='text' name='$hscore_name' value='$hscore'>";

                 $ascore = $value["awayscore"];
                 $ascore_name =  $sport."awayscore" ;
                 $value["awayscore"] = "<input type='text' name='$ascore_name' value='$ascore'>";

                 $scheduled = $value["scheduled"];
                 $scheduled_name =  $sport."scheduled" ;
                 $value["scheduled"] = "<input type='text' name='$scheduled_name' value='$scheduled'>";

                 $ascore = $value["completed"];
                 $ascore_name =  $sport."completed" ;
                 $value["completed"] = "<input type='text' name='$ascore_name' value='$ascore'>";


            }

          }
        return $data;

        }
         function ValidateSchedule($home,$away){

                  $ateam_id =  $this->db->getInstance("server_team",$away);
                  $hteam_id =  $this->db->getInstance("server_team",$home);


                  $sql = "SELECT 1 FROM server_schedule
                    WHERE  hometeam = ? and awayteam = ?";
                  $value = array($hteam_id,$ateam_id);
                  $bind = array(PDO::PARAM_INT,PDO::PARAM_INT);
                  $hw = VS::Validate($sql,$value,$bind);

                  $sql = "SELECT 1 FROM server_schedule
                    WHERE  awayteam = ? and hometeam = ?";
                   $value = array($ateam_id,$hteam_id);
                  $bind = array(PDO::PARAM_INT,PDO::PARAM_INT);
                   $wh =  VS::Validate($sql,$value,$bind);
                 if($hw == 1 || $wh == 1){
                              return "1";
                 }else{
                              return "0";
                 }


         }


    }

?>