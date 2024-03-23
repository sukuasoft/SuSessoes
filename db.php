<?php 
    class Db{
        public static function connect(){
            return mysqli_connect('localhost', 'root', '', 'su_sessions');
        }
    }
?>