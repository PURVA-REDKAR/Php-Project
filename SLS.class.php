<?php

require "DB.class.php";
 require "Validate.class.php";

 class SLS {

   private $sports;
   private $league;
   private $season;

    function __construct(){
       $this->db = new DB(DB_HOST, DB_USER, DB_PASS, DB_NAME) ;
     }

    function getSports() {
             return $this->sports;
    }

    function getLeague() {
             return $this->league;
    }

    function getSeason() {
             return $this->season;
    }

    function setSports($sports) {
             $this->sports = $sports;
    }

    function setSeason($season) {
             $this->season = $season;
    }

    function setLeague($league) {
             $this->league = $league;
    }

    /**
     * Desc: Function to SLS Position
     * Param: New Value for SLS
    */

    function editSLS($esports,$eseason,$eleague){


            $sports = $this->getSports();
            $season = $this->getSeason();
            $league = $this->getLeague();

            $league_id  = $this->db->getInstance("server_league",$league);
            $sport_id  = $this->db->getInstance("server_sport",$sports);
            $season_id  = $this->db->getInstance("server_season",$season,"description");


            $league_id_e  = $this->db->getInstance("server_league",$eleague);
            $sport_id_e  = $this->db->getInstance("server_sport",$esports);
            $season_id_e  = $this->db->getInstance("server_season",$eseason,"description");

            $sql = "UPDATE server_slseason
                    SET sport = ? , season= ?, league =?
                    WHERE sport = ? and season= ? and league =?";

            $this->db->Add_insert_delete_Query($sql,
                   array($sport_id_e,$season_id_e,$league_id_e,$sport_id,$season_id,$league_id),
                  array(PDO::PARAM_INT,PDO::PARAM_INT,PDO::PARAM_INT,PDO::PARAM_INT,PDO::PARAM_INT,PDO::PARAM_INT));


        }

        /**
        * Desc: Function to Delete Teams
        */

        function deleteSLS(){
                              
                $sports = $this->getSports();
                $season = $this->getSeason();
                $league = $this->getLeague();


                $league_id  = $this->db->getInstance("server_league",$league);
                $sport_id  = $this->db->getInstance("server_sport",$sports);
                $season_id  = $this->db->getInstance("server_season",$season,"description");



                $sql  ="DELETE
                        FROM server_slseason
                        WHERE league = ? and season = ? and sport = ?";
                $values = array($league_id, $season_id ,$sport_id);
                $bindParam = array(PDO::PARAM_INT, PDO::PARAM_INT,PDO::PARAM_INT);
                $this->db->Add_insert_delete_Query($sql,$values,$bindParam );

        }


        /**
        * Desc: Function to ADD sls
        */

        function addSLS(){

                $sports = $this->getSports();
                $season = $this->getSeason();
                $league = $this->getLeague();

                $league_id  = $this->db->getInstance("server_league",$league);
                $sport_id  = $this->db->getInstance("server_sport",$sports);
                $season_id  = $this->db->getInstance("server_season",$season,"description");

                $sql = "INSERT INTO server_slseason (league, season, sport)
                             VALUES (?,?,?)";

                $this->db->Add_insert_delete_Query($sql,
                   array($league_id, $season_id ,$sport_id),
                   array(PDO::PARAM_INT, PDO::PARAM_INT,PDO::PARAM_INT));

        }

        /**
        * Desc: Function to View sls
        */

        function ViewSLS(){

         $sql  ="SELECT le.name as league ,sp.name as sport ,s.description as season
                FROM server_slseason sls
                LEFT JOIN server_league le ON sls.league = le.id
                LEFT JOIN server_season s ON sls.season =s.id
                LEFT JOIN server_sport sp ON sls.sport =sp.id";

         $data =  $this->db->doQuery($sql,array(),array() );

        foreach ($data as &$value){
             $league = $value["league"];
             $league_name = $league."league";
             $league_name = str_replace(' ', '', $league_name);

             $sport = $value["sport"];
             $sport_name =  $league."sport";
             $sport_ori =  $league."sportori";
             $sport_ori = str_replace(' ', '', $sport_ori);
             $sport_name = str_replace(' ', '', $sport_name);

             $season = $value["season"];
             $season_name =  $league."season";
             $season_ori =  $league."seasonori";
             $season_ori = str_replace(' ', '', $season_ori);
             $season_name= str_replace(' ', '', $season_name);

             $value["league"] = "<input type='radio' name='league' value='$league'></input>";
             $value["league"] .= "<select name='$league_name'>";
             $sql = "SELECT name  FROM server_league";
             $leagues = $this->db->doQuery($sql,array(),array());
             $select = FN::drop_down($leagues,$league,"league");

            foreach($select as $row){
               $value["league"] = $value["league"].$row;

            }

            $value["league"].= "</select> ";


            $value["sport"] = " <input type='hidden' name='$sport_ori' value='$sport'/>" ;
            $value["sport"] .= "<select name='$sport_name'>";
            $sql = "SELECT name  FROM server_sport";
            $sports = $this->db->doQuery($sql,array(),array());
            $select = FN::drop_down($sports,$sport,"sport");
            foreach($select as $row){
               $value["sport"] = $value["sport"].$row;
            }


            $value["season"] = " <input type='hidden' name='$season_ori' value='$season'/> ";
            $value["season"] .= "<select name='$season_name'>";
            $sql = "SELECT description  FROM server_season";
            $seasons = $this->db->doQuery($sql,array(),array());
            $select = FN::drop_down($seasons,$season,"season","description");
            foreach($select as $row){
               $value["season"] = $value["season"].$row;

             }
           }

           return $data;

        }


         function ValidateSLS($season,$sports,$league){

               $league_id  = $this->db->getInstance("server_league",$league);
                $sport_id  = $this->db->getInstance("server_sport",$sports);
                $season_id  = $this->db->getInstance("server_season",$season,"description");

            $sql = "SELECT 1 FROM server_slseason
                    WHERE league = ? and season = ? and sport = ?";
             $value = array($league_id,$sport_id,$season_id);
             $bind = array(PDO::PARAM_INT,PDO::PARAM_INT,PDO::PARAM_INT);
            return VS::Validate($sql,$value,$bind);

         }



 }


?>