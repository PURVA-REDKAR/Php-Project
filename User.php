
<?php

require "FN.class.php";
require "User.class.php";
require "Validate.class.php";

      FN::session_check(); 
   // $db = new DB(DB_HOST, DB_USER, DB_PASS, DB_NAME) ;
    $users = new User();

 if(!empty( $_GET )){

             if(isset($_GET['add'])){
                  //check if user wants to add results
                 $_SESSION["page"] = 'AddUser.php' ;
                 header("Location: template.php");
              }
            //get all the post variables
           $username =  $_GET['username'] ;
           $user_name = $username."user";

            $user_name = str_replace(' ', '', $user_name) ;
           $team_name =  $username."team";
           $role_name = $username."role";
           $league_name =  $username."league";
           $user =  $_GET[$user_name] ;
           $team ="";
           $league="";
           $role =  $_GET[$role_name] ;

           if(isset($_GET[$team_name])){
                  $team =  $_GET[$team_name] ;
           }
           if(isset($_GET[$league_name])){
                  $league =  $_GET[$league_name] ;
           }
             //set all the submitted get variables  to object and sanitize them
            $users->setUserName(VS::Sanitize($username));
            $users->setTeam($team);
            $users->setRole($role);
            $users->setLeague($league);


           if(isset($_GET['delete'])){
                    $users->deleteUsers();
            }
             //validate and update
           if(isset($_GET['edit'])){
                  $users->editUsers($user);
            }

    }


    $data = $users->ViewUsers();

    echo FN::build_form_add_del_edit($data);


?>
