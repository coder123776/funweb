<?php
class database {
    public function connect() {
        try {
            $username = "root";
            $password = "";
            $dbhandler = new PDO('mysql:host=localhost;dbname=funweb', $username, $password);
            return $dbhandler;
        } catch (PDOException $e) {
            print('Oops, an error occurred: <br>' . $e->getMessage() . "<br>");
            return false;
        }
    }
}

