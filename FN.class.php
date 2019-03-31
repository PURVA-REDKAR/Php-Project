<?php

class FN {

 /**
 * Desc: Function to check session and log out if not logged in
 */

  public static function session_check(){
          if(!isset($_SESSION)){
           session_start();
       }
       if( !isset( $_SESSION["loggedIn"])){

                header("Location: login.php");
         }
   }

/**
 * Desc: Function to build table for ui
 * Param : Data array to build table
 *  Returns : data in table format
 */
  public static function build_table( $db_array ) {

    $display = self::formhead();
  	foreach ( $db_array[0] as $column => $field ) {
  		$display .= "<th class='cell100 column1'>$column</th>\n";
  	}
  	$display .= "</tr></thead></table></div>\n";
    $display .= "<div class='table100-body '><table><tbody>" ;
  	foreach ( $db_array as $record ) {
  		$display .= "<tr class='row100 body'>\n";
  		foreach ( $record as $field ) {
  			$display .= "<td class='cell100 column1'>$field</td>\n";
  		}
  		$display .= "</tr>\n";
  	}

  	$display .= "</tbody></table>\n";
    $display .= "</div></div>\n";
  	
  	return $display;
  }

/**
 * Desc: Function to create drop down
 * Param : Data array to build table
 * Param : $match to get selected value
 * Param : place holder
 * Param : data query parameter
 *  Returns : data in table format
 */
   public static function drop_down( $db_array,$match, $change,$name = "name" ){

   $value[$change]="";

       foreach ($db_array as &$row)
           {

              if($row[$name] == $match){

                   $value[$change] = $value[$change]."<option value='".$row[$name]."' selected='selected'>".$row[$name]."</option>";

               }
               else{

                   $value[$change] = $value[$change]."<option value='".$row[$name]."'>".$row[$name]."</option>";
                }
        }

        return   $value;
   }
  /**
 * Desc: Function to get values to build drop down  without add del button
 * Param : Data array to build table
 * Param : $match to get selected value
 * Param : place holder
 * Param : data query parameter
 *  Returns : data in table format
 */
   public static function build_drop_down($selectname,$tablename,$match,$name = "name"){

       $db = new DB(DB_HOST, DB_USER, DB_PASS, DB_NAME) ;

        $value[$selectname] = "<select name='$selectname' id='$selectname'>";
       // $table = $db->getInstances($tablename);
         $sql = "SELECT * FROM $tablename ";
         $table = $db->doQuery($sql,array(),array());

        $select = self::drop_down($table,$match,$selectname,$name );
        foreach($select as $row){

            $value[$selectname] = $value[$selectname].$row;

        }

        return  $value[$selectname];

   }

 /**
 * Desc: Function to include add, delete and edit button
 * Param : Data array to build table
 *  Returns : data in table format
 */

   public static function build_form_add_del_edit($data) {




             $action = $_SERVER["PHP_SELF"] ;

              $display = "<form  method='GET' action='$action'>"  ;
              $display .= self::build_table( $data );
              if($_SESSION["page"] != "Schedule.php" && $_SESSION["page"] != "Teams.php"){
              $display .=  "<button type='submit' name='delete' id='delete' class='buttons'  value='Delete'>Delete</button> ";
              $display .=  "<button type='submit' name='edit' name='edit' class='buttons'  value='Edit'>Edit</button> ";
              if($_SESSION["role"] <5){
                     $display .=  "<button type='submit' name='add' id='add' class='buttons'  value='Add'>ADD</button> ";
              }
              }
              $display .=  "</form>";

             return $display;
   }

 /**
 * Desc: Function to include add, delete and edit button
 * Param : Data array to build table
 *  Returns : data in table format
 */
   public static function arrangeDropdown($data,$data_name,$database,$placeholder,$name = "name"){

             $db = new DB(DB_HOST, DB_USER, DB_PASS, DB_NAME) ;

             $value[$placeholder] =   "<select name='$data_name' id='$data_name'>";
             $sql = "SELECT $name  FROM $database";
             $sports = $db->doQuery($sql,array(),array());
             $select = self::drop_down($sports,$data,$placeholder,$name);
              foreach($select as $row){
                    $value[$placeholder] = $value[$placeholder].$row;

               }
               $value[$placeholder] =$value[$placeholder]."</select>" ;
            return  $value[$placeholder];

      }

 /**
 * Desc: Function to include div
 */
   public static function  formhead(){

           $forms = "<div class='limiter'>";
           $forms  .= "<div class='container-table100'>"  ;
           $forms  .= "<div class='wrap-table100'>";
           $forms  .= "<div class='table100 ver1 m-b-110'> ";
           $forms .= "<div class='table100-head'> ";
           $forms .= "<table><thead>\n<tr class='row100 head'>\n";
           return $forms;

      }

/**
 * Desc: Function to include tr and td
*/
   public static function  formrow(){


           $forms = "<tr class='row100 body'>\n";
           $forms .= "<td class='cell100 column1'>";
           return $forms;
       }

             public static function  formrnd(){


           $forms = "<tr class='row100 body'>\n";
           $forms .= "<td class='cell100 column1'>";
           return $forms;
       }


}

?>