<?php

require "DB.class.php";

   if(!isset($_SESSION)){
           session_start();
       }

class User {

    private $username;
    private $team;
    private $role;
    private $league;
    private $password;
    private $db;

    // constructor of User Class

    function __construct($username="",$role="",$team= "",$league= "",$password = "php"){

       $this->db = new DB(DB_HOST, DB_USER, DB_PASS, DB_NAME) ;
       $this->username =$username;
       $this->password =$password;
       $this->role =$role;
       $this->team = $team;
       $this->league =$league;

    }

    // getter Methods
    function getUserName() {
        return $this->username;
    }

    function getTeam() {
        return $this->team;
    }

    function getRole() {
        return $this->role;
    }

    function getLeague() {
        return $this->league;
    }

    function getPassword() {
        return $this->password;
    }


    function setUserName($name) {
         $this->username =$name;
    }


    function setTeam($team) {
        $this->team = $team;
    }

    function setRole($role) {
        $this->role = $role;
    }

    function setLeague($league) {
       $this->league = $league;
    }

    function setPassword($password) {
        $this->password = $password;
    }
   /**
    * Desc: Function to Update users
    * Param: variable that are required to update
    */
    function editUsers($user){


         $username = $this->getUserName();
         $role = $this->getRole();
         $team = $this->getTeam();
         $league = $this->getLeague();

         $role_id =  $this->db->getInstance("server_roles",$role);

         $team_id;
         $league_id;
         if(!empty($team)){

                          $team_id =  $this->db->getInstance("server_team",$team);
           }
         if(!empty($league)){

                           $league_id  = $this->db->getInstance("server_league",$league);
          }
          $team_id  = !empty($team_id)   ? $team_id  : NULL;
          $league_id = !empty($league_id)   ? $league_id   : NULL ;

          $sql = "UPDATE server_user
                    SET username=?, role=?, team=?,league=?
                    WHERE username=?";

          $this->db->Add_insert_delete_Query($sql,array($user,$role_id,$team_id,$league_id,$username),
             array(PDO::PARAM_STR,PDO::PARAM_INT,PDO::PARAM_INT,PDO::PARAM_INT,PDO::PARAM_STR));
        // $this->db->editUsers($this->getUserName(),$user,$this->getRole(),$this->getTeam(),$this->getLeague());

    }
     /**
    * Desc: Function to Delete users
    */
    function deleteUsers(){

        $sql = "DELETE
                 FROM server_user
                 WHERE username = ?";

        $username = $this->getUserName();
        $this->db->Add_insert_delete_Query($sql,array($username),array(PDO::PARAM_STR));



    }

    function addUsers(){



         $username = $this->getUserName();

         $role = $this->getRole();
         $team = $this->getTeam();
         $league = $this->getLeague();
         $role_id =  $this->db->getInstance("server_roles",$role);

         $team_id;
         $league_id;
         if(!empty($team)){

                          $team_id =  $this->db->getInstance("server_team",$team);
           }
         if(!empty($league)){

                           $league_id  = $this->db->getInstance("server_league",$league);
          }
          $team_id  = !empty($team_id)   ? $team_id  : NULL;
          $league_id = !empty($league_id)   ? $league_id   : NULL ;

          $password1 = $this->getPassword();
          $password = password_hash($password1, PASSWORD_DEFAULT);

           $sql = "INSERT INTO server_user (username, password, role, team,league)
                             VALUES (?,?,?,?,?)";

          $this->db->Add_insert_delete_Query($sql,array($username,$password,$role_id,$team_id,$league_id),
             array(PDO::PARAM_STR,PDO::PARAM_STR,PDO::PARAM_INT,PDO::PARAM_INT,PDO::PARAM_INT));


    }

     /**
    * Desc: Function to View  users
    * Param: no Params
    * returns : Table With populates Users
    */

    function ViewUsers(){

      if($_SESSION["role"] == 1 ){

              $sql =  "SELECT u.username,r.name as role,t.name as team,l.name as league
                                                     FROM server_user as u
                                               LEFT JOIN server_team  as t
                                               ON t.id  = u.team
                                               JOIN  server_roles as r
                                               ON r.id  = u.role
                                               LEFT JOIN  server_league as l
                                               ON l.id  = u.league
                                               "  ;

                 $data = $this->db->doQuery($sql,array(),array());
        }
        if($_SESSION["role"] == 2){

                 $sql =  "SELECT u.username,r.name as role,t.name as team,l.name as league
                                                     FROM server_user as u
                                               RIGHT JOIN server_team  as t
                                               ON t.id  = u.team
                                               JOIN  server_roles as r
                                               ON r.id  = u.role
                                               LEFT JOIN  server_league as l
                                               ON l.id  = u.league
                                               where r.id BETWEEN ? and ?"  ;
                 $intial = 3;
                 $final = 4;

                 $data = $this->db->doQuery($sql,array($intial,$final),array(PDO::PARAM_INT,PDO::PARAM_INT));


        }

        if($_SESSION["role"] == 3 ||$_SESSION["role"] == 4){

                  $sql =  "SELECT u.username,r.name as role,t.name as team
                                                     FROM server_user as u
                                               JOIN server_team  as t
                                               ON t.id  = u.team
                                               JOIN  server_roles as r
                                               ON r.id  = u.role
                                               LEFT JOIN  server_league as l
                                               ON l.id  = u.league
                                               where r.id BETWEEN ? and ?  and t.id = ?"  ;
                 $intial = 3;
                 $final = 5;
                 $team = $_SESSION["team"];

                 $data = $this->db->doQuery($sql,array($intial,$final,$team),
                          array(PDO::PARAM_INT,PDO::PARAM_INT,PDO::PARAM_INT));


        }

          if($_SESSION["role"] == 5){

                  $sql =  "SELECT u.username,r.name as role,t.name as team
                                              FROM server_user as u
                                               JOIN server_team  as t
                                               ON t.id  = u.team
                                               JOIN  server_roles as r
                                               ON r.id  = u.role
                                               where t.id = ? "  ;
                 $intial = $_SESSION["team"];


                 $data = $this->db->doQuery($sql,array($intial),array(PDO::PARAM_INT));


        }


          if($_SESSION["role"] <5){
         foreach ($data as &$value){

        $username = $value["username"];
        $role = $value["role"];
        $role_name = $username."role";

        if( !empty($value["team"])){
           $team = $value["team"];
           $team_name =  $username."team";
        }
        $user_name =  $username."user";
        if( !empty($value["league"])){
             $league = $value["league"];
             $league_name =  $username."league";

        }




        $value["username"] = "<input type='radio' name='username' value='$username'>
                              <input type='text' name='$user_name' value='$username' readonly>";
        //$value["role"] = FN::arrangeDropdown($role,$role_name,"server_roles","role");;
        //$roles = $db->getInstances("server_roles");

        $value["role"] = "<select name=$role_name>";


                $role_id = $_SESSION["role"] ;
                $sql = "SELECT name  FROM server_roles where id >= ?";
                $db_array = $this->db->doQuery($sql,array($role_id),array(PDO::PARAM_INT));

                $select = FN::drop_down($db_array,$role, "role");

                 foreach($select as $row){


                      $value["role"] = $value["role"].$row;

                }
                $value["role"] = $value["role"]."</select>" ;


        if( !empty($value["team"])){

              $team = $value["team"];
               $value["team"] =  FN::arrangeDropdown($team,$team_name,"server_team","team");

        }


        if( !empty($value["league"])){

              $league = $value["league"];

              $value["league"] = FN::arrangeDropdown($league,$league_name,"server_league","league");

        }


    }
    }


        return $data;

    }

    /**
    * Desc: Function to validate user addition
    * Param: username
    * returns : true if user exists and flase if doesnot exists
    */

    function ValidateUsers($name){

             $sql = "SELECT 1 FROM server_user where username = ?";
             $value = array($name);
             $bind = array(PDO::PARAM_STR);
            return VS::Validate($sql,$value,$bind);


    }

}


?>