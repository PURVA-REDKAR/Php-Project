<?php

 require_once "DB.class.php";
class Players {

        private $dateofbirth;
        private $firstname;
        private $jerseynumber;
        private $lastname;
        private $team;
        private $db;


        function __construct(){

              $this->db = new DB(DB_HOST, DB_USER, DB_PASS, DB_NAME) ;


        }
            // getter Methods
        function getDateOfBirth() {
             return $this->dateofbirth;
        }

        function getFirstName() {
             return $this->firstname;
        }

        function getJerseyNumber() {
             return $this->jerseynumber;
        }

        function getLastName() {
             return $this->lastname;
        }

        function getTeam() {
             return $this->team;
        }

        //setter methods
        function setDateOfBirth($dateofbirth) {
             $this->dateofbirth = $dateofbirth;
        }
       function setFirstName($firstname) {
             $this->firstname = $firstname;
        }

       function setJerseyNumber($jerseynumber) {
             $this->jerseynumber = $jerseynumber;
        }
       function setLastName($lastname) {
             $this->lastname = $lastname;
        }

        function setTeam($team) {
             $this->team = $team;
        }

         /**
         * Desc: Function to Update Position
         * Param: New Value for updation
        */
           function editPlayer($efirstname,$elastname){
            $fname = $this->getFirstName();
            $lname = $this->getLastName();
            $jerseynumber = $this->getJerseyNumber();
            $DOB = $this->getDateOfBirth();
            $team = $this->getTeam();
                
            $team_id =  $this->db->getInstance("server_team",$team);

            $sql = "UPDATE server_player
                   SET firstname=? ,lastname = ? ,jerseynumber = ?,dateofbirth=?,team = ?
                   WHERE firstname=? and lastname = ?";

            $this->db->Add_insert_delete_Query($sql,
                   array($efirstname,$elastname,$jerseynumber,$DOB,$team_id,$fname,$lname),
                   array(PDO::PARAM_STR,PDO::PARAM_STR,PDO::PARAM_INT,PDO::PARAM_STR,PDO::PARAM_INT,PDO::PARAM_STR,PDO::PARAM_STR));


        }

        /**
        * Desc: Function to Delete players
        */

        function deletePlayers(){

            $fname = $this->getFirstName();
            $lname = $this->getLastName();


                $sql  ="DELETE
                        FROM server_player
                        WHERE firstname=? and lastname = ?";
                $values = array($fname, $lname);
                $bindParam = array(PDO::PARAM_STR, PDO::PARAM_STR);
                $this->db->Add_insert_delete_Query($sql,$values,$bindParam );

        }
        /*add players
        */

        function AddPlayers(){

           $fname = $this->getFirstName();
           $lname = $this->getLastName();
           $dob = $this->getDateOfBirth();
           $jersy = $this->getJerseyNumber();
           $team = $this->getTeam();

             $team_id =  $this->db->getInstance("server_team",$team);
               $sql = "INSERT INTO server_player (firstname ,lastname , dateofbirth, jerseynumber,team)
                               VALUES (?,?,?,?,?)";

               $this->db->Add_insert_delete_Query($sql,array($fname,$lname,$dob,$jersy,$team_id),
                            array(PDO::PARAM_STR,PDO::PARAM_STR,PDO::PARAM_STR,PDO::PARAM_INT,PDO::PARAM_INT));

        }

        /**
        * Desc: Function to Delete players
        */

        function ViewPlayer(){

           if($_SESSION["role"] <= 2){

                  $sql  ="SELECT  firstname ,lastname , dateofbirth, jerseynumber ,t.name as Team
                         FROM server_player p
                         JOIN server_team  as t
                         ON t.id  = p.team";
                  $data =  $this->db->doQuery($sql,array(),array() );
            }
            if($_SESSION["role"] > 2){

                  $sql  ="SELECT  firstname ,lastname , dateofbirth, jerseynumber ,t.name as Team
                         FROM server_player p
                         JOIN server_team  as t
                         ON t.id  = p.team  where t.id = ?";

                  $team = $_SESSION["team"];
                  $data =  $this->db->doQuery($sql,array($team),array(PDO::PARAM_INT) );
            }

            if($_SESSION["role"] < 5 && ($_SESSION["page"] != 'Teams.php')){
              foreach ($data as &$value){

                  $fn = $value["firstname"];
                  $user_name =  $fn."firstname" ;
                  $ln = $value["lastname"];
                  $ln_name =  $fn."lastname";
                  $ln_ori =  $fn."lastnameori";
                  $ln_ori= str_replace(' ', '', $ln_ori);
                  $dateofbirth =  $value["dateofbirth"];
                  $jerseynumber =  $value["jerseynumber"];
                  $dateofbirth_name = $fn."dateofbirth" ;
                  $jerseynumber_name = $fn."jerseynumber" ;
                  $jerseynumber_name= str_replace(' ', '', $jerseynumber_name);
                  $user_name= str_replace(' ', '', $user_name);
                  $dateofbirth_name= str_replace(' ', '', $dateofbirth_name);
                  $ln_name= str_replace(' ', '', $ln_name);

                  $value["firstname"] = "<input type='radio' name='firstname' value='$fn'/>
                              <input type='text' name='$user_name' value='$fn' readonly/>";

                  $value["lastname"] = " <input type='hidden' name='$ln_ori' value='$ln'/>
                                 <input type='text' name='$ln_name' value='$ln'>";

                  $value["dateofbirth"] = "<input type='text' name='$dateofbirth_name' value='$dateofbirth' pattern = '^\d{4}\-(0[1-9]|1[012])\-(0[1-9]|[12][0-9]|3[01])$'>";
                  $value["jerseynumber"] = "<input type='text' name='$jerseynumber_name' value='$jerseynumber'>";

                  $ateam = $value["Team"];
                  $ateam_name =  $fn."team";
                  $ateam_name= str_replace(' ', '', $ateam_name);

                  $value["Team"] =  FN::arrangeDropdown($ateam,$ateam_name,"server_team","team");
               // $value["team"] =  FN::arrangeDropdown($team,$team_name,"server_team","team");;
               }
             }

             return $data;

        }

          function ValidatePlayers($fn,$ln){

            $sql = "SELECT 1 FROM server_player where firstname = ? and lastname = ?";
             $value = array($fn,$ln);
             $bind = array(PDO::PARAM_STR,PDO::PARAM_STR);
            return VS::Validate($sql,$value,$bind);

        }

}

?>