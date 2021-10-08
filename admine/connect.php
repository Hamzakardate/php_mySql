<?php
    $dsm='mysql:host=localhost;dbname=pfe';
    $user='root';
    $pass='';
    $option=array(
        PDO::MYSQL_ATTR_INIT_COMMAND =>'SET NAMES utf8',
    );
    try{
        $con=new PDO($dsm,$user,$pass,$option);
        $con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        //echo"ok";
    }catch(PDOException $e)
    {
        echo "NO".$e->getMessage();
    }
    
?>