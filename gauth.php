<?php
require_once('settings.php');
require_once('google-login-api.php');
require_once "User.class.php";


// Google passes a parameter 'code' in the Redirect Url
if(isset($_GET['code'])) {
	try {
		$gapi = new GoogleLoginApi();
		
		// Get the access token 
		$data = $gapi->GetAccessToken(CLIENT_ID, CLIENT_REDIRECT_URL, CLIENT_SECRET, $_GET['code']);
		
		// Get user information
		$user_info = $gapi->GetUserProfileInfo($data['access_token']);
        $name = $user_info['name'];
         $db = new DB(DB_HOST, DB_USER, DB_PASS, DB_NAME) ;

         $sql =  "SELECT *
                  FROM server_user
                   WHERE username = ?"  ;

         $data = $db->doQuery($sql,array($name),array(PDO::PARAM_STR));

         //check if user exists, if exists give him option of chosing role, team , leagues
         if(empty($data)) {

             header("Location: register.php?gauth=$name");
        }
        else{
        
                 foreach( $data as $rows){
                       $dbpass = substr( $rows['password'], 0, 60 );
                        $role = $rows['role'];
                     }
                       $_SESSION["name"] =  $name ;
                       $_SESSION["loggedIn"] = "true" ;
                       $_SESSION["role"] = $rows['role'] ;
                       $_SESSION["team"] = $rows['team'] ;
                       $_SESSION["league"] = $rows['league'] ;
                       $_SESSION["page"] = 'Admin.php' ;
                        header("Location: template.php");

        }
	}
	catch(Exception $e) {
		echo $e->getMessage();
		exit();
	}
}
?>
