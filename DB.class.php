<?php

require_once "/home/MAIN/pr3044/Sites/756/HW_5/db_conn.php";


 class DB {


         private $dbh;
         private $server   = ""; //database server
         private $user     = ""; //database login name
         private $pass     = ""; //database login password
         private $database = ""; //database name
         private $pre      = ""; //table prefix
         private $error;         //error

         private $affected_rows = 0; //number of rows affected by SQL query
         private $insert_id;         //last insert id
         function __construct( $host="localhost", $user="pr3044", $pass="Purva@123", $database="pr3044" ) {

                try {

                     $this->dbh = new PDO("mysql:host=$host;dbname=$database", $user,$pass);

                     //change error reporting
                     $this->dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

                }
                catch (PDOException $e) {

                      echo $e->getMessage();
                      die();
                }
         }


        function doQuery($sql,$values,$bindParams){

                try{
                     $count =1;
                    $stmt = $this->dbh->prepare($sql);
                    for ($i = 0; $i < count($values); $i++) {

                                 $stmt->bindParam($count,$values[$i],$bindParams[$i]);
                                 $count++;
                        }


                     $stmt->execute();
                    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                     return $data;
                }
                catch (PDOException $e) {

                     echo $e->getMessage();
                     die();
                }

        }
        function Add_insert_delete_Query($sql,$values,$bindParams){

                try{
                     $count =1;
                    $stmt = $this->dbh->prepare($sql);


                    for ($i = 0; $i < count($values); $i++) {

                                 $stmt->bindParam($count,$values[$i],$bindParams[$i]);
                                 $count++;
                        }

                    $stmt->execute();
                  //  $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                   //  return $data;
                }
                catch (PDOException $e) {

                     echo $e->getMessage();
                     die();
                }

        }


        function deleteSport($name){

                try{

                    $stmt = $this->dbh->prepare("DELETE
                                           FROM server_sport
                                           WHERE name = :name");
                    $stmt->bindParam(":name",$name,PDO::PARAM_STR);
                    $stmt->execute();

                }
                catch (PDOException $e) {

                     echo $e->getMessage();
                     die();
                }

        }


      /* function getInstances($tablename) {

               try {

                  $data = array();
                  $stmt = $this->dbh->prepare(" SELECT name
                                                FROM $tablename");
                  $stmt->execute();
                  $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                  return $data;
                }
                catch (PDOException $e) {
                   echo $e->getMessage();
                   die();
                }
        }  */

        function getInstance($tablename,$name,$condtion = "name") {

               try {
                  $id="";
                  $data = array();
                  $stmt = $this->dbh->prepare("SELECT * FROM $tablename where $condtion = :name");
                  $stmt->bindParam(":name",$name,PDO::PARAM_STR);
                  $stmt->execute();
                  $data = $stmt->fetchAll();
                  foreach ($data as $value){
                       $id  = $value["id"];
                  }

                  return $id;
                }
                catch (PDOException $e) {
                    require "Log.class.php";
                                $log = new Log();
                                $log->lfile('logfile.txt');
                                $log->lwrite("Exception OCCURED  $e->getMessage()");
                   echo $e->getMessage();
                   die();
                }
        }

       /* function insertSports($username) {
            try {
                     $sql = "INSERT INTO server_sport (name)
                               VALUES (:name)";
                     $stmt = $this->dbh->prepare($sql);
                     $stmt->bindParam(":name",$username,PDO::PARAM_STR);
                     $stmt->execute();
                }
            catch (PDOException $e) {
                   echo $e->getMessage();
                   die();
                }



        }  */

     /*   function insertUsers($username,$password,$role, $team ,$league) {

               try {

                     $password = password_hash($password, PASSWORD_DEFAULT);

                     $role_id =  $this->getInstance("server_roles",$role);

                     $team_id;
                     $league_id;
                     if(!empty($team)){
                          echo "team".$team;

                          $team_id =  $this->getInstance("server_team",$team);
                          echo "team".$team_id;
                     }
                     if(!empty($league)){

                           echo "league".$league;
                           $league_id  = $this->getInstance("server_league",$league);
                           echo "league_id".$league_id;

                     }
                     //INSERT INTO table_name (column1, column2, column3, ...)
                    //  ..VALUES (value1, value2, value3, ...);

                     $sql = "INSERT INTO server_user (username, password, role, team,league)
                             VALUES (:username,:password,:role,:team,:league)";
                     $stmt = $this->dbh->prepare($sql);
                     $stmt->bindParam(":username",$username,PDO::PARAM_STR);
                     $stmt->bindValue(":password",$password,PDO::PARAM_STR);
                     $stmt->bindValue(":role",$role_id,PDO::PARAM_INT);
                     $stmt->bindValue(":team",  !empty($team_id)   ? $team_id   : NULL, PDO::PARAM_INT);
                     $stmt->bindValue(":league",  !empty($league_id)   ? $league_id   : NULL, PDO::PARAM_INT);
                     $stmt->execute();

                }
                catch (PDOException $e) {
                   echo $e->getMessage();
                   die();
                }
        }
          */

     /*   function  schedulededits($sport,$sport_edit,$description,$description_edit,
                        $league,$league_edit,$ateam,$ateam_edit,$hteam,$hteam_edit,$hscore,$ascore,$scheduled,$comp){

                try{
                 $league_updt_id =  $this->getInstance("server_league",$league_edit);
                 $league_id_ori =  $this->getInstance("server_league",$league);

                 $sport_id =  $this->getInstance("server_sport",$sport_edit);
                 $sport_id_ori =  $this->getInstance("server_sport",$sport);

                 $season_id =  $this->getInstance("server_season",$description_edit,"description");
                 $season_id_ori =  $this->getInstance("server_season",$description,"description");

                 $ateam_id =  $this->getInstance("server_team",$ateam_edit);
                 $ateam_id_ori =  $this->getInstance("server_team",$ateam);

                 $hteam_id =  $this->getInstance("server_team",$hteam_edit);
                 $hteam_id_ori =  $this->getInstance("server_team",$hteam);

                 $sql  ="UPDATE server_schedule
                        SET  sport=? , league = ? ,season = ?, hometeam =? ,awayteam =? ,homescore =? ,awayscore =? ,scheduled=?, completed = ?
                        WHERE  sport=? and league = ? and season = ? and hometeam =? and awayteam =? ";

                 $values = array($sport_id,$league_updt_id,$season_id,$hteam_id,$ateam_id,$hscore,$ascore,$scheduled,$comp,
                                 $sport_id_ori,$league_id_ori, $season_id_ori,$hteam_id_ori,$ateam_id_ori);
                $bindParams = array(PDO::PARAM_INT,PDO::PARAM_INT,PDO::PARAM_INT,PDO::PARAM_INT,PDO::PARAM_INT,PDO::PARAM_INT,PDO::PARAM_INT,
                PDO::PARAM_STR,PDO::PARAM_BOOL,PDO::PARAM_INT,PDO::PARAM_INT,PDO::PARAM_INT,PDO::PARAM_INT,PDO::PARAM_INT);
                 $this->Add_insert_delete_Query($sql,$values,$bindParams);

                 }
              catch (PDOException $e) {

                    echo $e->getMessage();
                    die();

                }

        }  */
      /*  function editSLS($league,$sport,$season,$league_updt,$sport_updt,$season_updt) {

               try {


                 $league_updt_id =  $this->getInstance("server_league",$league_updt);
                 $league_id_ori =  $this->getInstance("server_league",$league);

                 $sport_id =  $this->getInstance("server_sport",$sport_updt);
                 $sport_id_ori =  $this->getInstance("server_sport",$sport);

                 $season_id =  $this->getInstance("server_season",$season_updt,"description");
                 $season_id_ori =  $this->getInstance("server_season",$season,"description");


                $sql = "UPDATE server_slseason
                             SET league=?, season=?, sport=?
                             WHERE league=? and season=? and sport=?";
                $stmt = $this->dbh->prepare($sql);
                $stmt->bindValue(1,$league_updt_id,PDO::PARAM_INT);
                $stmt->bindValue(2,$sport_id,PDO::PARAM_INT);
                $stmt->bindValue(3,$season_id ,PDO::PARAM_INT);
                $stmt->bindValue(4,$league_id_ori,PDO::PARAM_INT);
                $stmt->bindValue(5,$sport_id_ori,PDO::PARAM_INT);
                $stmt->bindValue(6,$season_id_ori,PDO::PARAM_INT);
                $stmt->execute();


                   }
               catch (PDOException $e) {

                    echo $e->getMessage();
                    die();

                }


         }
           */

      /*  function editUsers($username,$user_edit,$role, $team ,$league) {

               try {



                     $role_id =  $this->getInstance("server_roles",$role);

                     $team_id;
                     $league_id;
                     if(!empty($team)){

                          $team_id =  $this->getInstance("server_team",$team);
                     }
                     if(!empty($league)){

                           $league_id  = $this->getInstance("server_league",$league); ;

                     }

                     $sql = "UPDATE server_user
                             SET username=:user_edit, role=:role, team=:team,league=:league
                             WHERE username=:username";
                     $stmt = $this->dbh->prepare($sql);
                     $stmt->bindValue(":user_edit",$user_edit,PDO::PARAM_STR);
                     $stmt->bindValue(":role",$role_id,PDO::PARAM_INT);
                     $stmt->bindValue(":team",  !empty($team_id)   ? $team_id   : NULL, PDO::PARAM_INT);
                     $stmt->bindValue(":league",  !empty($league_id)   ? $league_id   : NULL, PDO::PARAM_INT);
                     $stmt->bindParam(":username",$username,PDO::PARAM_STR);
                     $stmt->execute();

                }
                catch (PDOException $e) {
                   echo $e->getMessage();
                   die();
                }
        }  */

       /* function editSports($name,$name_edit) {

               try {


                     $sql = "UPDATE server_sport
                             SET name=:user_edit
                             WHERE name=:name";
                     $stmt = $this->dbh->prepare($sql);
                     $stmt->bindValue(":user_edit",$name_edit,PDO::PARAM_STR);
                     $stmt->bindParam(":name",$name,PDO::PARAM_STR);
                     $stmt->execute();

                }
                catch (PDOException $e) {
                   echo $e->getMessage();
                   die();
                }
        } */
    }
?>