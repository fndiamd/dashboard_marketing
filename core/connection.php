<?php 
    try{
        $db = new PDO('pgsql:host=localhost; dbname=sales', 'postgres', 'postgres');
    }catch(PDOException $exception){
        echo 'Connection failed : ' .$exception->getMessage();
    }
