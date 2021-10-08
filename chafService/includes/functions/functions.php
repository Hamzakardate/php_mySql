<?php
/* all affeche*/
function affecheAll($field,$tablename,$orderby,$where=NULL)
{
    global $con;
    $sql=$where==NULL ? '' : $where;
    $getall=$con->prepare("select $field from $tablename $sql order by $orderby ");
    $getall->execute();
    $all=$getall->fetchAll();
    return $all;
}

/* one affeche  */
function affecheOne($field,$tablename,$orderby,$where=NULL)
{
    global $con;
    $sql=$where==NULL ? '' : $where;
    $getall=$con->prepare("select $field from $tablename $sql order by $orderby  LIMIT 1");
    $getall->execute();
    $all=$getall->fetch();
    return $all;
}
/* one affeche le nomber */
function affecheLeNomber($field,$tablename,$orderby,$where=NULL)
{
    global $con;
    $sql=$where==NULL ? '' : $where;
    $getall=$con->prepare("select $field from $tablename $sql order by $orderby  LIMIT 1");
    $getall->execute();
    $count=$getall->rowCount();
    return $count;
}




/* pour le titre*/ 
function getTitel()
    {
        global $pageTitle;
        if(isset($pageTitle))
        {
            echo $pageTitle;
        }
        else
        {
            echo'Defult';
        }
    }
    /*calcu*/
function countItems($item,$table)
{
    global $con;
    $stat2=$con->prepare("select COUNT($item) from $table");
    $stat2->execute();
    return $stat2->fetchColumn();
}

    
?>