<?php

require "DB.class.php";
class Season {

        private $year;
        private $description;
        private $db;

        function __construct(){

              $this->db = new DB(DB_HOST, DB_USER, DB_PASS, DB_NAME) ;


        }
            // getter Methods
        function getYear() {
             return $this->year;
        }

        function getDescription() {
             return $this->description;
        }

        function setYear($year) {
             $this->year = $year;
        }
       function setDescription($description) {
             $this->description = $description;
        }
         /**
         * Desc: Function to Update Position
         * Param: New Value for updation
        */

        function editSeason($eyear,$edescription){
            $year = $this->getYear();
            $description = $this->getdescription();

            $sql = "UPDATE server_season
                   SET year=?, description=?
                   WHERE year=? and description=?";

            $this->db->Add_insert_delete_Query($sql,
                   array($eyear,$edescription,$year,$description),
                   array(PDO::PARAM_STR,PDO::PARAM_STR,PDO::PARAM_STR,PDO::PARAM_STR));


        }
        /**
        * Desc: Function to Delete SEASONS
        */

        function deleteSeason(){

            $year = $this->getYear();
            $description = $this->getdescription();

                $sql  ="DELETE
                        FROM server_season
                        WHERE year = ? and description = ?";
                $values = array($year, $description);
                $bindParam = array(PDO::PARAM_STR, PDO::PARAM_STR);
                $this->db->Add_insert_delete_Query($sql,$values,$bindParam );

        }

        function ViewSeason(){

            $sql  ="SELECT  year,description
             FROM server_season";
            $data =  $this->db->doQuery($sql,array(),array() );
            foreach ($data as &$value){

                $year = $value["year"];
                $user_name =  $year."user";

                $description = $value["description"];
                $description_name =  $year."description";
                $description_name_ori =  $year."descriptionori";

                $value["year"] = "<input type='radio' name='year' value='$year'/>
                              <input type='text' name='$user_name' value='$year'/>";

                $value["description"] = " <input type='hidden' name='$description_name_ori' value='$description'/>
                                 <input type='text' name='$description_name' value='$description'>";
             }

             return $data;

        }

        function AddSeason(){

                  $year = $this->getYear();
                  $description = $this->getDescription();

               $sql = "INSERT INTO server_season (year,description)
                               VALUES (?,?)";

               $this->db->Add_insert_delete_Query($sql,array($year,$description),array(PDO::PARAM_STR,PDO::PARAM_STR));

        }

         function ValidateSeason($year,$description){

            $sql = "SELECT 1 FROM server_season where year = ? and description= ?";
             $value = array($year,$description);
             $bind = array(PDO::PARAM_STR,PDO::PARAM_STR);
            return VS::Validate($sql,$value,$bind);

        }



}

?>