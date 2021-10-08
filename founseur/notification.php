<?php 
   // session_start();

       // $pageTitle='Otile';
       // include "int.php"; 
        $getall=$con->prepare("select * from otile where sup_o=0 order by id_a ");
        $getall->execute();
        $rows=$getall->fetchAll();
        
        $formNotifictions1=array();
        $formNotifictions2=array();
        $formNotifictions3=array();
        $formNotifictions4=array();

        foreach($rows as $row)
        {
            if($row['stok_a'] < 20)
            {
                $formNotifictions1[]=$row['nom_a'];
            }
            if($row['stok_a'] > 20 && $row['stok_a'] < 50)
            {
                $formNotifictions2[]=$row['nom_a'];
            }
            if($row['stok_a'] > 50 && $row['stok_a'] < 100)
            {
                $formNotifictions3[]=$row['nom_a'];
            }
            if($row['stok_a'] > 100)
            {
                $formNotifictions4[]=$row['nom_a'];
            }
        }
        echo'<div class="row">';
        
        if(!empty($formNotifictions1))
        {
            echo '<div class ="col-sm-12">';
            echo'<div class="alert alert-danger" style="text-align: center;">';
            foreach($formNotifictions1 as $formNotifiction1)
            {
                echo $formNotifiction1.'<br/>';
            }
            echo'</div><br/>';
            echo'</div>';
        }
        
        if(!empty($formNotifictions2))
        {
            echo '<div class ="col-sm-12">';
            echo'<div class="alert alert-warning" style=" text-align: center;" >';
            foreach($formNotifictions2 as $formNotifiction2)
            {
                echo $formNotifiction2.'<br/>';
            }
            echo'</div><br/>';
            echo'</div><br/>';
        }
        echo'</div>';
        if(!empty($formNotifictions3))
        {
            echo '<div class ="col-sm-12">';
            echo'<div class="alert alert-info" style="text-align: center;">';
            foreach($formNotifictions3 as $formNotifiction3)
            {
                echo $formNotifiction3.'<br/>';
            }
            echo'</div><br/>';
            echo'</div><br/>';
        }
        if(!empty($formNotifictions4))
        {
            echo '<div class ="col-sm-12">';
            echo'<div class="alert alert-success" style=" text-align: center;">';
            foreach($formNotifictions4 as $formNotifiction4)
            {
                echo $formNotifiction4.'<br/>';
            }
            echo'</div><br/>';
            echo'</div><br/>';
        }
         echo'</div>';
        echo'</div>';

    

?>
