<?php 
    session_start();
if(isset($_SESSION['Usernamef']))
{
        $pageTitle='Service';
        include "int.php"; 
        $do=isset($_GET['do']) ? $_GET['do'] :'Manage';
        if($do=='Manage'){
            $getall=$con->prepare("select register.* ,users.nom as u_name  ,users.prennom as u_prennom,users.id_u as u_id,otile.nom_a as o_name,otile.id_a as o_id
                                    from register 
                                    INNER JOIN users 
                                    ON users.id_u=register.iduser 
                                    INNER JOIN otile 
                                    ON otile.id_a=register.idotile 
                                    order by id_r desc");
            $getall->execute();
            $rows=$getall->fetchAll();


            ?>
            
            <div class="container select-users">
            <div class="jumbotron text-center">
                <div class="col-lg-3 col-lg-offset-9 col-xs-4 col-xs-offset-7 col-sm-4 col-sm-offset-8 
                col-md-4 col-md-offset-8 ">
                    <div class="input-group">
                    
                    <input type="text" style="border-radius:6px;"class="form-control" id="serche" placeholder="Rechercher ..">
                    </div><!-- /input-group -->
                </div>
                <h1 class="text-center"  >Page de demandes / pour  :</h1>
                <a class="btn btn-primary btn-lg" href="otile.php" role="button">Ajouter une quantité </a>
                
                
                </div>
            <div class="table-responsive table-user" >
            <table class="main-table mange-menbers text-center table table-bordered" id ="emp">
            <tr>
                <td>#ID</td>
                <td>Chef de Service</td>
                <td>Service</td>
                <td>Article</td>
                <td>Date de demande</td>
                <td>Nombre d'enregistrement</td>
                <td>contrôle</td>
                
            </tr>
            <?php

                foreach($rows as $row)
                {
                    echo "<tr>";
                    echo "<td style='background-color:#FFF;'>".$row['id_r']."</td>";
                    echo "<td style='background-color:#FFF;'>".$row['u_name']." ".$row['u_prennom']."</td>";
                    echo "<td style='background-color:#FFF;'>".affechservice($row['u_id'])."</td>";
                    echo "<td style='background-color:#FFF;'>".$row['o_name']."</td>";
                    echo "<td style='background-color:#FFF;'>".$row['date_r']."</td>";
                    echo "<td style='background-color:#FFF;'>".$row['n_r']."</td>";
                    echo '<td style="background-color:#FFF;">';
                    
                    if($row['conf']==0)
                    {
                        echo '&nbsp;<a href="?do=Modifie&userid='.$row['id_r'].'&nb='.$row['n_r'].'&otile='.$row['o_id'].'"class="btn btn-default">Modifie et accepter</a>';
                        echo '&nbsp;<a href="?do=Refuser&userid='.$row['id_r'].'"class="btn btn-danger confirme">Refuser</a>';
                    }
                    echo " </td>";
                    echo "</tr>";
                }
            ?>

            </table>
            </div>


            
            </div>

            <?php 
        }elseif($do=='Copy'){
            $a=$_GET['userid'];
            $getall=$con->prepare("select register.* ,users.nom as u_name ,otile.nom_a as o_name ,users.prennom as u_prennom
                                    from register 
                                    INNER JOIN users 
                                    ON users.id_u=register.iduser 
                                    INNER JOIN otile 
                                    ON otile.id_a=register.idotile 
                                    where id_r =?");
            $getall->execute(array($a));
            $row=$getall->fetch();
            $f=fopen('../download/php/files/myfile.html','a');
                $copy='<table><tr><td>Numero de demande</td><td>'.$row['id_r'].'</td></tr><tr><td>Demander par le chef du service</td><td>'.$row['u_name'].' '.$row['u_prennom'].'</td></tr><tr><td>Article demander</td><td>'.$row['o_name'].'</td></tr><tr><td>Date de demande</td><td>'.$row['date_r'].'</td></tr><tr><td>nombre d\'article demander</td><td>'.$row['n_r'].'</td></tr></table>';
            fwrite($f,$copy);
            fclose($f);
            
            ?>
                        <div class="container">

                                    <div class="alert alert-info" role="alert">Pour copier le fichier cliquez sur ok
                                    <a href="../download/d.php"class="btn btn-success">Ok</a></div>


                        </div>
            <?php
                
          // header('location: register.php');
            
            //echo $_GET['userid'];
        }elseif($do=='Modifie'){
            
                echo '<h1 class="text-center">Mise à jour de demandes</h1>';
                echo '<div class="container">';
                ?>
                <form action="register.php?do=Accepter" method="POST">

                    
                    <div class="for-group form-group-lg" style='margin:10px;'>
                    <lable class="col-sm-2 col-md-2 col-xs-2 control-label">Nombre d'outils</lable>
                        <div class="col-sm-10 col-md-10 col-xs-10">
                        <input type="text" class="form-control" placeholder="Nomber de Demmend" name="nb" aria-describedby="sizing-addon1" value=<?php echo $_GET['nb'];?> required="required" />
                        </div>
                    </div>
                    <br/><br/><br/>
                    <div class="for-group form-group-lg" style='margin:10px;'>
                        <div class="col-sm-10 col-md-10 col-xs-10">
                        <input type="hidden" class="form-control" placeholder="Nomber de Demmend" name="userid" aria-describedby="sizing-addon1" value=<?php echo $_GET['userid'];?> required="required" />
                        </div>
                    </div>
                    <div class="for-group form-group-lg" style='margin:10px;'>
                        <div class="col-sm-10 col-md-10 col-xs-10">
                        <input type="hidden" class="form-control" placeholder="Nomber de Demmend" name="otileid" aria-describedby="sizing-addon1" value=<?php echo $_GET['otile'];?> required="required" />
                        </div>
                    </div>
                    <br/>
                    <button  class="btn btn-primary btn-lg" >Modifie et accepter</button>

                </form>
                <?php
                echo'</div>';
            
} 
        elseif($do=='Accepter'){
            
                echo '<h1 class="text-center">Mise à jour de demandes</h1>';
                echo '<div class="container">';
                $id_r=$_POST['userid'];
                $id_o=$_POST['otileid'];
                $nb_d=$_POST['nb'];
                $formErrors=array();
                
                if(empty($nb_d)){
                    $formErrors[]='<div class="alert alert-danger">Nombre De Demandes n\'est pas vide</div>';
                }
                if($nb_d <= 0){
                    $formErrors[]='<div class="alert alert-danger">Nombre De Demandes sup strictement à 0</div>';
                }
                $recherche=0;
                $stmt3=$con->prepare("select * from otile where id_a=? order by nom_a");
                $stmt3->execute(array($id_o));
                $otile=$stmt3->fetch();
                $count=$stmt3->rowCount();

                if ($count>0){
                    $recherche=1;
                }
                if($recherche==1){
                    if($otile['stok_a'] < $nb_d)
                    {
                        $formErrors[]='<div class="alert alert-danger">La Quantité nulle ou insuffsante,il n\'existe que '.$otile['stok_a'].'</div>';
                    }
                }
               
                
                foreach($formErrors as $Errors)
                {
                    echo $Errors;
                }
                if(empty($formErrors))
                {
                    $stmt1=$con->prepare(" UPDATE register SET 
                    conf=1
                    WHERE id_r=?");
                    $stmt1->execute(array($id_r));

                    $stmt2=$con->prepare("select *  from register WHERE id_r=?");
                    $stmt2->execute(array($id_r));
                    $row1=$stmt2->fetch();


                    $id_o=$row1['idotile'];


                    $stmt3=$con->prepare("select *  from otile WHERE id_a=?");
                    $stmt3->execute(array($id_o));
                    $row2=$stmt3->fetch();

                    $nb_o=$row2['stok_a'];
                    $nb_e=$nb_o-$nb_d;
                    
                    $stmt4=$con->prepare("UPDATE otile SET 
                    stok_a=?
                    WHERE id_a=?");
                    $stmt4->execute(array($nb_e,$id_o));

                    $stmt5=$con->prepare("UPDATE register SET 
                    n_r=?
                    WHERE id_r=?");
                    $stmt5->execute(array($nb_d,$id_r));

                    echo '<div class="alert alert-success"> Demandes enregistrées </div>';
                   
                }
                
                echo'</div>';
            

        } 
        elseif($do=='Refuser'){
            echo '<h1 class="text-center">Mise à jour de demandes</h1>';
            echo '<div class="container">';
            $id_r=$_GET['userid'];
            $stmt1=$con->prepare(" delete from register 
            WHERE id_r=?");
            $stmt1->execute(array($id_r));

            

            echo '<div class="alert alert-success">'.$stmt1->rowCount() .' Demandes refuser </div>';
            echo'</div>';
        } 
}

else
{
    header('location: index.php');
    exit();
    
}
?>
<?php include "includes/templates/footer.php"; ?>