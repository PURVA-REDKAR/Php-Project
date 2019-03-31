<?php

 require_once "DB.class.php";
  class Team {

     private $awaycolor;
     private $homecolor;
     private $league;
     private $mascot;
     private $maxplayers;
     private $name;
     private $picture;
     private $season;
     private $sport;
     private $db;
         // constructor of User Class

    function __construct($awaycolor="",$homecolor="",$league= "",$mascot= "",$maxplayers = "",$name= "",
                        $picture= "",$season = "",$sport= ""){

       $this->db = new DB(DB_HOST, DB_USER, DB_PASS, DB_NAME) ;
       $this->awaycolor =$awaycolor;
       $this->homecolor =$homecolor;
       $this->league =$league;
       $this->mascot = $mascot;
       $this->maxplayers =$maxplayers;
       $this->name =$name;
       $this->season =$season;
       $this->sport =$sport;
       $this->picture = $picture;
    }

     // getter Methods
    function getAwayColor() {
        return $this->awaycolor;
    }

    function getHomeColor() {
        return $this->homecolor;
    }

    function getleague() {
        return $this->league;
    }

    function getMascot() {
        return $this->mascot;
    }

    function getMaxPlayers() {
        return $this->maxplayers;
    }

    function getName() {
        return $this->name;
    }

    function getPicture() {
        return $this->picture;
    }

    function getSeason() {
        return $this->season;
    }

    function getSport() {
        return $this->sport;
    }
         // getter Methods
    function setAwayColor($awaycolor) {
         $this->awaycolor = $awaycolor;
    }

    function setHomeColor($homecolor) {
        $this->homecolor = $homecolor;
    }

    function setleague($league) {
         $this->league = $league;
    }

    function setMascot($mascot) {
         $this->mascot = $mascot;
    }

    function setPicture($picture) {
         $this->picture = $picture;
    }

    function setMaxPlayers($maxplayers) {
         $this->maxplayers = $maxplayers;
    }

    function setName($name) {
         $this->name =$name;
    }

    function setSeason($season) {
         $this->season = $season;
    }

    function setSport($sport) {
        $this->sport = $sport;
    }

    /**
    * Desc: Function to Update Teams
    * Param: New Value for updation
    */
    function editTeams($name){

       $awaycolor = $this->getAwayColor();
       $homecolor = $this->getHomeColor();
       $league = $this->getleague();
       $mascot = $this->getMascot();
       $maxplayers = $this->getMaxPlayers();
       $uname = $this->getName();
       $picture = $this->getPicture();
       $season = $this->getSeason();
       $sport = $this->getSport();


       $league_id  = $this->db->getInstance("server_league",$league);
       $sport_id  = $this->db->getInstance("server_sport",$sport);
       $season_id  = $this->db->getInstance("server_season",$season,"description");


       $sql = "UPDATE server_team
               SET awaycolor = ?,homecolor=?,league=?,mascot =?,maxplayers =?,name=?,season=?,sport=?
               WHERE name=?";

       $this->db->Add_insert_delete_Query($sql,
                  array($awaycolor,$homecolor,$league_id,$mascot,$maxplayers,$name,$season_id,$sport_id,$uname),
             array(PDO::PARAM_STR,PDO::PARAM_STR,PDO::PARAM_INT,PDO::PARAM_STR,PDO::PARAM_STR,PDO::PARAM_STR,PDO::PARAM_INT,PDO::PARAM_INT,PDO::PARAM_STR));

    }

    /**
    * Desc: Function to Delete Teams
    */

    function deleteTeams(){

        $sql = "DELETE
                 FROM server_team
                 WHERE name = ?";

       $name = $this->getName();
        $this->db->Add_insert_delete_Query($sql,array($name),array(PDO::PARAM_STR));



    }

     /**
    * Desc: Function to Add new Teams
    */
    function addTeams(){



       $awaycolor = $this->getAwayColor();
       $homecolor = $this->getHomeColor();
       $league = $this->getleague();
       $mascot = $this->getMascot();
       $maxplayers = $this->getMaxPlayers();
       $name = $this->getName();
       $picture = $this->getPicture();
       $season = $this->getSeason();
       $sport = $this->getSport();

       $league_id  = $this->db->getInstance("server_league",$league);
       $sport_id  = $this->db->getInstance("server_sport",$sport);
       $season_id  = $this->db->getInstance("server_season",$season,"description");




           $sql = "INSERT INTO server_team (awaycolor ,homecolor,league,mascot,maxplayers,name,picture,season,sport )
                             VALUES (?,?,?,?,?,?,?,?,?)";

          $this->db->Add_insert_delete_Query($sql,
             array($awaycolor,$homecolor,$league_id,$mascot,$maxplayers,$name,$picture,$season_id,$sport_id),
                   array(PDO::PARAM_STR,PDO::PARAM_STR,PDO::PARAM_INT,PDO::PARAM_STR,PDO::PARAM_STR,PDO::PARAM_STR,PDO::PARAM_STR,PDO::PARAM_INT,PDO::PARAM_INT,PDO::PARAM_STR));


    }

    /**
    * Desc: Function to Display new Teams
    */
    function ViewTeams(){

       if($_SESSION["role"] == 1 ){

                $sql = "SELECT t.name as team, t.mascot ,sp.name as sport, l.name as league ,s.description as season ,t.picture, t.homecolor,t.awaycolor,t.maxplayers
                        FROM server_team as t
                        LEFT JOIN server_season  as s
                        ON s.id  = t.season
                        LEFT JOIN  server_league as l
                        ON l.id  = t.league
                        LEFT JOIN  server_sport as sp
                        ON sp.id  = t.sport" ;

                 $data = $this->db->doQuery($sql,array(),array());

       }

         if($_SESSION["role"] == 2){

              $leg = $_SESSION["league"];

                $sql = "SELECT t.name as team, t.mascot ,sp.name as sport, l.name as league ,s.description as season ,t.picture, t.homecolor,t.awaycolor,t.maxplayers
                        FROM server_team as t
                        LEFT JOIN server_season  as s
                        ON s.id  = t.season
                        LEFT JOIN  server_league as l
                        ON l.id  = t.league
                        LEFT JOIN  server_sport as sp
                        ON sp.id  = t.sport
                        where t.league = ?" ;


                 $data = $this->db->doQuery($sql,array($leg),array(PDO::PARAM_INT));

           }

         if($_SESSION["role"] >= 3 ){

              $team = $_SESSION["team"];

                $sql = "SELECT t.name as team, t.mascot ,sp.name as sport, l.name as league ,s.description as season ,t.picture, t.homecolor,t.awaycolor,t.maxplayers
                        FROM server_team as t
                        LEFT JOIN server_season  as s
                        ON s.id  = t.season
                        LEFT JOIN  server_league as l
                        ON l.id  = t.league
                        LEFT JOIN  server_sport as sp
                        ON sp.id  = t.sport
                        where t.id = ?" ;


                 $data = $this->db->doQuery($sql,array($team),array(PDO::PARAM_INT));

           }

            if($_SESSION["role"] < 5 && ($_SESSION["page"] != 'Teams.php')){
               foreach ($data as &$value){

                       $team = $value["team"];
                       $team1 = str_replace(' ', '', $team);
                       $user_name =$team1."team";

                       $mascot = $value["mascot"];
                       $mascot_name = $team1."mascot";

                       $sport = $value["sport"];
                       $sport_name =  $team1."sport";

                      $awaycolor = $value["awaycolor"];
                      $awaycolor_name =  $team1."awaycolor";

                      $homecolor =   $value["homecolor"];
                      $homecolor_name =  $team1."homecolor";

                      $league =   $value["league"];
                      $league_name =  $team1."league";

                      $maxplayers =   $value["maxplayers"];
                      $maxplayers_name =  $team1."maxplayers";

                      $picture =   $value["picture"];
                      $picture_name =  $team1."picture";

                      $season =   $value["season"];
                      $season_name =  $team1."season";


                     $value["team"] = "<input type='radio' name='team' value='$team'>
                                     <input type='text' name='$user_name' value='$team'>";

                     $value["mascot"] = "<input type='text' name='$mascot_name' value='$mascot'>";

                     $value["sport"] =  FN::arrangeDropdown($sport,$sport_name,"server_sport","sport");



                     $value["awaycolor"] = "<input type='text' name='$awaycolor_name' value='$awaycolor'>";

                     $value["homecolor"] = "<input type='text' name='$homecolor_name' value='$homecolor'>";

                     $value["league"] = FN::arrangeDropdown($league,$league_name,"server_league","league");

                     $value["maxplayers"] = "<input type='text' name='$maxplayers_name' value='$maxplayers'>";

                     $value["picture"] = "<img src='$picture' name='$picture_name' alt='$team' height='42' width='42'>";
                      //<img src="smiley.gif" alt="Smiley face" height="42" width="42">
                     $value["season"] = FN::arrangeDropdown($season,$season_name,"server_season","season","description");



               }

           }
           else{
                   
                    foreach ($data as &$value){
                      $team = $value["team"];
                       $picture =   $value["picture"];
                       $team1 = str_replace(' ', '', $team);
                      $picture_name =  $team1."picture";

                    $value["picture"] = "<img src='$picture' name='$picture_name' alt='$team' height='42' width='42'>";

                    }


               }





        return $data;
    }
    function ValidateTeam($name){

             $sql = "SELECT 1 FROM server_team where name = ?";
             $value = array($name);
             $bind = array(PDO::PARAM_STR);
            return VS::Validate($sql,$value,$bind);


    }
 

  }

?>
