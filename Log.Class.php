<?php
class Log {
    //  log file and file pointer as private properties
    private $log_file, $fp;

    public function lfile($path) {
        $this->log_file = $path;
    }

    public function lwrite($username1,$login_status='') {
        // if file pointer doesn't exist, then open log file
        if (!is_resource($this->fp)) {
            $this->lopen();
        }
        // define script name
        $time = @date('[d/M/Y:H:i:s]');
        // write current time, script name and message to the log file
        if(!isset($login_status)){
          fwrite($this->fp, " exception $username1 " . PHP_EOL);
        }
        else{
        fwrite($this->fp, " User $username1 $login_status  at $time" . PHP_EOL);
        }
    }
     // close log file
    public function lclose() {
        fclose($this->fp);
    }


    private function lopen() {
        $log_file_default = 'logfile.txt';
        $lfile = $this->log_file ? $this->log_file : $log_file_default;
        // open log file for writing only and place file pointer at the end of the file
        // (if the file does not exist, try to create it)
        $this->fp = fopen($lfile, 'a') or exit("Can't open $lfile!");
    }



}


?>