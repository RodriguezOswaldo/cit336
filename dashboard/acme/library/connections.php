<?php
/*
Database Connections 
*/
function acmeConnect(){
    $server = "localhost";
    $database = "acme";
    $user = "iClient";
    $password = "YOGEfETechF4TiNQ";
    $dsn = 'mysql:host='.$server.';dbname='.$database;
    $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
    try{
        $acmeLink = new PDO($dsn, $user, $password, $options);
        // echo "Hello World From PHP!";
        return $acmeLink;
    }catch(PDOException $exc){
        header('location: /dashboard/acme/view/500.php');
        exit;
    }
}
acmeConnect();

?>