<?php

require "DB.class.php";


    class Position {

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

        function editPosition($ename){
            $name = $this->getName();

            $sql = "UPDATE server_position
                    SET name = ?
                    WHERE name=?";

            $this->db->Add_insert_delete_Query($sql,
                   array($ename,$name),
                  array(PDO::PARAM_STR,PDO::PARAM_STR));


        }

        /**
        * Desc: Function to Delete Teams
        */

        function deletePosition(){

             $sql = "DELETE
                     FROM server_position
                     WHERE name = ?";

             $name = $this->getName();
             $this->db->Add_insert_delete_Query($sql,array($name),array(PDO::PARAM_STR));

        }

       /**
        * Desc: Function to Add Teams
        */
        function addPosition(){

            $name = $this->getName();

            $sql = "INSERT INTO server_position (name)
                             VALUES (?)";

            $this->db->Add_insert_delete_Query($sql,
                   array($name),
                   array(PDO::PARAM_STR));


        }

    /**
    * Desc: Function to Display new Teams
    */
    function ViewPosition(){

            $sql = "SELECT name
                     FROM  server_position";


            $data = $this->db->doQuery($sql,array(),array());

            foreach ($data as &$value){

            $name = $value["name"];
            $name1 = str_replace(' ', '', $name);
            $pos_name =$name1."name";

            $value["name"] = "<input type='radio' name='name'  value='$name'/>
                                     <input type='text' name='$pos_name' value='$name'/>";

           }

            return $data;
    }

        /**
    * Desc: Function to validate user addition
    * Param: username
    * returns : true if user exists and flase if doesnot exists
    */

    function ValidatePosition($name){

             $sql = "SELECT 1 FROM server_position where name = ?";
             $value = array($name);
             $bind = array(PDO::PARAM_STR);
            return VS::Validate($sql,$value,$bind);


    }

    }


?>