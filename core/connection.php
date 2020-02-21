<?php 
    try{
        $db = new PDO('pgsql:host=localhost; dbname=sales', 'postgres', 'password');
    }catch(PDOException $exception){
        echo 'Connection failed : ' .$exception->getMessage();
    }
