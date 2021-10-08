<?php 
    session_start();
if(isset($_SESSION['Usernamec']))
{
        $pageTitle='Service';
        include "int.php"; 
        $do=isset($_GET['do']) ? $_GET['do'] :'Manage';
        if($do=='Manage'){
            /**/ 
            //$rpp=2;
             /**/ 
             /**/
                //$page_used=!isset($_GET['page']) ? 1:$_GET['page'];
                 //$page_used;
              /**/ 
              /**/ 
               // $a=($page_used-1)*2;
            /**/ 
            $getall=$con->prepare("select register.* ,users.nom as u_name ,users.prennom as u_prennom,users.id_u as u_id,otile.nom_a as o_name 
                                    from register 
                                    INNER JOIN users 
                                    ON users.id_u=register.iduser 
                                    INNER JOIN otile 
                                    ON otile.id_a=register.idotile 
                                    where register.conf=1
                                    order by id_r desc ");
            $getall->execute();
            $rows=$getall->fetchAll();
             /**/ 
            //$ndp=ceil(countItems('id_r','register')/$rpp);
             /**/ 
            ?>
            
            <div class="container select-users ">
                <div class="jumbotron text-center">
                <div class="col-lg-3 col-lg-offset-9 col-xs-4 col-xs-offset-7 col-sm-4 col-sm-offset-8 
                col-md-4 col-md-offset-8 ">
                    <div class="input-group">
                    
                    <input type="text" style="border-radius:6px;"class="form-control" id="serche" placeholder="Rechercher ..">
                    </div><!-- /input-group -->
                </div>
                <h1 class="text-center"  >Page de demandes :</h1>
                </div>
            <div class="table-responsive table-user" id="emp">
            <table class="main-table mange-menbers text-center table table-bordered">
            <tr>
                <td>#ID</td>
                <td>Chef de Service</td>
                <td>Service</td>
                <td>Article</td>
                <td>Date de demande</td>
                <td>Nombre d'enregistrement</td>
                
                
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
                    if($row['u_id']==$_SESSION['IDc'])
                    {
                    echo "<td style='background-color:#FFF;'>".$row['n_r']."</td>";
                    }
                    else{
                    echo "<td style='background-color:#FFF;'></td>";  
                    }
                    
                    
                    echo "</tr>";
                }
            ?>

            </table>
            </div>
            <a href="register.php?do=Add" class="btn btn-primary">Ajouter ume nouvelle demande</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="?do=Copy"class="btn btn-danger">copie le bon d'entrée</a>

            
            </div>

            <?php 
             /**/
                      /*  for($page=1;$page<=$ndp;$page++)
                        {
                            echo'<a href="register.php?page='.$page.'">'.$page.'</a>';
                        }*/
                         /**/ 

         }elseif($do=='Add'){
            ?>
            <h1 class="text-center">Ajouter une nouvelle Demande</h1>
            <div class="container">
            <form action="register.php?do=Insert" method="POST">
            <div class="for-group form-group-lg" style='margin:10px;'>
                    <lable class="col-sm-2 col-md-2 col-xs-2 control-label">Article</lable>
                        <div class="col-sm-10 col-md-10 col-xs-10">
                            <select class ="form-control" name="nom_a">
                                <option value="0">....</option>
                                <?php
                                    $stmt2=$con->prepare("select * from otile where sup_o=0 order by nom_a");
                                    $stmt2->execute();
                                    $cats=$stmt2->fetchAll();
                                    foreach($cats as $cat)
                                    {
                                        echo "<option value ='".$cat['id_a']."'>".$cat['nom_a']."</option>";
                                    }
                                ?>
                                
                            </select>
                        </div>
                    </div>
            <br/> <br/> <br/>
            <div class="for-group form-group-lg" style='margin:10px;'>
                    <lable class="col-sm-2 col-md-2 col-xs-2 control-label">Nombre d'articles</lable>
                        <div class="col-sm-10 col-md-10 col-xs-10">
                        <input type="text" class="form-control" placeholder="Nomber de Demmend" name="n_r" aria-describedby="sizing-addon1" required="required" />
                        </div>
                    </div>
            <br/> <br/> <br/>
            
            

         
            <button  class="btn btn-primary btn-lg" >Ajouter une demande</button>

            </form>
            </div>
            <?php 
        }elseif($do=='Insert'){
            if($_SERVER['REQUEST_METHOD']=='POST')
            {
                echo '<h1 class="text-center">Mise à jour de demandes</h1>';
                echo '<div class="container">';
                $n_r=$_POST['n_r'];
                $nom_a=$_POST['nom_a'];

                $formErrors=array();
                
                if(empty($n_r)){
                    $formErrors[]='<div class="alert alert-danger">Nombre De Demandes n\'est pas vide</div>';
                }
                if($n_r <= 0){
                    $formErrors[]='<div class="alert alert-danger">Nombre De Demandes sup strictement à 0</div>';
                }
                if($nom_a==0){
                    $formErrors[]='<div class="alert alert-danger">Outil n\'est pas vide </div>';
                }
                $recherche=0;
                $recherchecon=0;
                $stmt3=$con->prepare("select * from otile where id_a=? order by nom_a");
                $stmt3->execute(array($nom_a));
                $otile=$stmt3->fetch();
                $count=$stmt3->rowCount();

                if ($count>0){
                    $recherche=1;
                }
                if($recherche==1){
                    if($otile['stok_a'] < $n_r)
                    {
                        $formErrors[]='<div class="alert alert-danger">La Quantité nulle ou insuffsante </div>';
                    }
                }
                
                foreach($formErrors as $Errors)
                {
                    echo $Errors;
                }
                if(empty($formErrors))
                {
                    
                    $stmt=$con->prepare("INSERT INTO register( iduser ,idotile ,date_r,n_r)
                     VALUES (:z1,:z2,NOW(),:z3)
                        ");
                        $stmt->execute(array(
                            'z1'=>$_SESSION['IDc'],
                            'z2'=>$nom_a,
                            'z3'=>$n_r 
                        ));
                        /*
                        $id_a=$otile['id_a'];
                        $n_r=$otile['stok_a']-$n_r; 
                        
                        
                    $stmt4=$con->prepare(" UPDATE otile SET 
                        stok_a=?
                        WHERE id_a=?");
                    $stmt4->execute(array($n_r,$id_a));
*/
                        echo '<div class="alert alert-success">'.$stmt->rowCount() .' Demandes en cours de traitement </div>';
                }
                header("refresh:3;url=register.php");
            }
            else{
                header('location: register.php');
            }
            }elseif($do=='Copy'){
                
                $getall=$con->prepare("select register.* ,users.nom as u_name ,users.prennom as u_prennom,users.id_u as u_id,otile.nom_a as o_name 
                                        from register 
                                        INNER JOIN users 
                                        ON users.id_u=register.iduser 
                                        INNER JOIN otile 
                                        ON otile.id_a=register.idotile 
                                        where register.conf=1
                                        and users.id_u=?
                                        order by id_r desc ");
                $getall->execute(array($_SESSION['IDc']));
                $rows=$getall->fetchAll();
                
                
                $f=fopen('../download/php/files/myfile.html','w');
                
                $copy="";
                $copy="<br/><br/>";
                $copy.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $copy.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $copy.="Royaume du Maroc<br/>";
                $copy.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $copy.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $copy.="Ministere de l'Intérieur<br/>";
                $copy.="Prefecture des Arrondissements Moulay Rachid";
                $copy.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $copy.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $copy.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $copy.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $copy.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $copy.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $copy.="<strong>Bon d'Entrée</strong>";
                $copy.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $copy.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $copy.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $myfile = fopen("../download/php/files/webdictionary.txt", "r") or die("Unable to open file!");
                $x=fread($myfile,filesize("../download/php/files/webdictionary.txt"));
                $y=$x+1;
                fclose($myfile);
                $myfile = fopen("../download/php/files/webdictionary.txt", "w") or die("Unable to open file!");
                fwrite($myfile, $y);
                fclose($myfile);
                $copy.="<strong>N :".$y."</strong><br/>";
                $copy.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $copy.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $copy.="Arrondissement Moulay Rachid<br/>";
                $copy.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $copy.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $copy.="MAGASIN GENERAL<br/><br/><br/>";

                $copy.="<table border='2px' >";
                $copy.="<tr>";
                $copy.="<td style='padding:20px'>Réference</td>";
                $copy.="<td style='padding:20px'>DESIGNATION DU FOURNITURES</td>";
                $copy.="<td style='padding:20px'>Date de demande</td>";
                $copy.="<td style='padding:20px'>Nombre d'enregistrement</td>";
                $copy.="<td style='padding:20px'>Chef de Service</td>";
                $copy.="<td style='padding:20px'>AFFECTATIONS</td>";
                $copy.="<tr>";
                $x=0;
                foreach($rows as $row)
                {
                    $copy.="<tr>";
                    $copy.="<td style='padding:20px'>".$row['id_r']."</td>";
                    $copy.="<td style='padding:20px'>".$row['o_name']."</td>";
                    $copy.="<td style='padding:20px'>".$row['date_r']."</td>";
                    if($row['u_id']==$_SESSION['IDc'])
                    {
                        $copy.="<td style='padding:20px'>".$row['n_r']."</td>";
                    }
                    else{
                        $copy.="<td style='padding:20px'></td>";  
                    }
                    if($x<1){
                    $copy.="<td style='padding:20px'>".$row['u_name']." ".$row['u_prennom']."</td>";
                    }
                    else{
                        $copy.="<td style='padding:20px'>----------------------</td>";  
                    }
                    if($x<1){
                        $copy.="<td style='padding:20px'>".affechservice($row['u_id'])."</td>";
                    }
                    else{
                        $copy.="<td style='padding:20px'> --------------------------------------------</td>";  
                    }
                    $x++;
                    $copy.="</tr>";
                }
                $copy.="</table>";
                $copy.="<br/><br/>";
                $copy.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $copy.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $copy.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $copy.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $copy.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $copy.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $copy.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $copy.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $copy.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $copy.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $copy.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $copy.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $copy.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $copy.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $copy.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $copy.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $copy.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $copy.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $copy.="Casablanca,le ";
                $copy.="<br/>";
                $copy.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $copy.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $copy.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $copy.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $copy.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $copy.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $copy.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $copy.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $copy.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $copy.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $copy.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $copy.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $copy.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $copy.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $copy.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $copy.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $copy.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $copy.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $copy.="Le Magasinier";
                fwrite($f,$copy);
                fclose($f);
            
            ?>
                        <div class="container">

                                    <div class="alert alert-info" role="alert">Pour copier le fichier cliquez sur ok
                                    <a href="../download/d.php"class="btn btn-success">Ok</a></div>


                        </div>
            <?php
            
        } 
}

else
{
    header('location: index.php');
    exit();
    
}
?>
<?php include "includes/templates/footer.php"; ?>