<?php


class VS{

        /**
        * Desc: Function to Sanitize  values
        *  Parm : value to be sanitized
        * return : sanitized Value
         */
        static function Sanitize($value){
             $value =   htmlspecialchars($value, ENT_QUOTES, 'UTF-8');;
             $value = trim($value);
             return $value;

        }

       /**
        * Desc: Function to check if  values  exists
        *  Parm : value to be select qury, value array, bind param array
        * return : 1 is not present 0 if present
        */
       static function Validate($sql,$value,$bind){

                $db = new DB(DB_HOST, DB_USER, DB_PASS, DB_NAME) ;
                 $data = $db->doQuery($sql,$value,$bind);

                 if(empty($data)){

                     return "1";
                 }
                 else{
                      return "0";
                 }


    }



}

?>