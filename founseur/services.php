<?php 
    session_start();
if(isset($_SESSION['Usernamef']))
{
        $pageTitle='Service';
        include "int.php"; 
        $do=isset($_GET['do']) ? $_GET['do'] :'Manage';
        if($do=='Manage'){
            
            //$rows= affecheAll('*','users','id_u');

            
            $getall=$con->prepare("select service.*,users.nom as user_name ,users.id_u as user_id
                                    from  service 
                                    INNER JOIN users ON users.id_u=service.userid
                                    where sup_s=0
                                    order by id_s ");
            $getall->execute();
            $rows=$getall->fetchAll();
           

        ?>
             
             <div class="container select-users text-center">
                <div class="jumbotron">
                <div class="col-lg-3 col-lg-offset-9 col-xs-4 col-xs-offset-7 col-sm-4 col-sm-offset-8 
                col-md-4 col-md-offset-8 ">
                    <div class="input-group">
                    
                    <input type="text" style="border-radius:6px;"class="form-control" id="serche" placeholder="Rechercher ..">
                    </div><!-- /input-group -->
                </div>
                <h1 class="text-center"  >Page des services / pour  :</h1>
                <a class="btn btn-primary btn-lg" href="otile.php" role="button">Ajouter une quantité </a>
                <a class="btn btn-primary btn-lg" href="register.php" role="button">Coupier une demande</a>
                
                </div>
                <div class="table-responsive table-user" id ="emp">
                    <table class="main-table mange-menbers text-center table table-bordered">
                        <tr>
                            <td>#ID</td>
                            <td>Nom de Service</td>
                            <td>Date de Craition</td>
                            <td>Chaf de Service</td>
                            <td>Control</td>
                            
                        </tr>
                        <?php
                        
                            foreach($rows as $row)
                            {
                                echo "<tr>";
                                echo "<td style='background-color:#FFF;'>".$row['id_s']."</td>";
                                echo "<td style='background-color:#FFF;'>".$row['nom_s']."</td>";
                                echo "<td style='background-color:#FFF;'>".$row['date_s']."</td>";
                                echo "<td style='background-color:#FFF;'>".$row['user_name']."</td>";
                                echo '<td style="background-color:#FFF;">';
                                echo '<a href="?do=Copy&userid='.$row['user_id'].'"class="btn btn-primary">Copie le bon de sortie</a>';
                                echo " </td>";
                                
                                echo "</tr>";
                            }
                        ?>
                        
                    </table>
                </div>
             

             </div>
     
     <?php
        }elseif($do=='Copy'){
            $id=$_GET['userid'];
            $getall=$con->prepare("select register.* ,users.nom as u_name ,users.prennom as u_prennom,users.id_u as u_id,otile.nom_a as o_name 
                                    from register 
                                    INNER JOIN users 
                                    ON users.id_u=register.iduser 
                                    INNER JOIN otile 
                                    ON otile.id_a=register.idotile 
                                    where  users.id_u=?
                                    order by id_r desc ");
            $getall->execute(array($id));
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
            $copy.="<strong>BON DE SORTIE</strong>";
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
                $copy.="<td style='padding:20px'>".$row['n_r']."</td>";
                
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
            $copy.="Le Chef de Service";
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