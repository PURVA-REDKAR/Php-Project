<?php

require "DB.class.php";
class Sports {

        private $name;
        private $db;

        function __construct($name=""){

              $this->db = new DB(DB_HOST, DB_USER, DB_PASS, DB_NAME) ;
              $this->name =$name;

        }
            // getter Methods
        function getName() {
             return $this->name;
        }

       function setName($name) {
             $this->name = $name;
        }


         /**
         * Desc: Function to Update Position
         * Param: New Value for updation
        */

        function editSports($ename){
            $name = $this->getName();

            $sql = "UPDATE server_sport
                    SET name = ?
                    WHERE name=?";

            $this->db->Add_insert_delete_Query($sql,
                   array($ename,$name),
                  array(PDO::PARAM_STR,PDO::PARAM_STR));


        }

        /**
        * Desc: Function to Delete server_sport
        */

        function deleteSport(){

             $sql = "DELETE
                     FROM server_sport
                     WHERE name = ?";

             $name = $this->getName();
             $this->db->Add_insert_delete_Query($sql,array($name),array(PDO::PARAM_STR));

        }

       /**
        * Desc: Function to Add server_sport
        */
        function addSports(){

            $name = $this->getName();

            $sql = "INSERT INTO server_sport (name)
                             VALUES (?)";

            $this->db->Add_insert_delete_Query($sql,
                   array($name),
                   array(PDO::PARAM_STR));


        }

    /**
    * Desc: Function to Display new server_sport
    */
    function ViewSports(){

            $sql = "SELECT name  FROM server_sport";

             $this->db->Add_insert_delete_Query($sql,
                   array(),
                   array());

            $data = $this->db->doQuery($sql,array(),array());

            foreach ($data as &$value){

                  $name = $value["name"];
                  $user_name =  $name."user";

               $value["name"] = "<input type='radio' name='name' value='$name'>
                              <input type='text' name='$user_name' value='$name'>";
             }

            return $data;
    }

     /**
    * Desc: Function to validate user addition
    * Param: username
    * returns : true if user exists and flase if doesnot exists
    */

    function ValidateSport($name){

             $sql = "SELECT 1 FROM server_sport where name = ?";
             $value = array($name);
             $bind = array(PDO::PARAM_STR);
            return VS::Validate($sql,$value,$bind);


    }




}


?>