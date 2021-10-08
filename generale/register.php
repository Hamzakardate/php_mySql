<?php 
    session_start();
if(isset($_SESSION['Usernameg']))
{
        $pageTitle='Service';
        include "int.php"; 
        $do=isset($_GET['do']) ? $_GET['do'] :'Manage';
        if($do=='Manage'){
            $getall=$con->prepare("select register.* ,users.nom as u_name ,users.prennom as u_prennom,users.id_u as u_id,otile.nom_a as o_name 
                                    from register 
                                    INNER JOIN users 
                                    ON users.id_u=register.iduser 
                                    INNER JOIN otile 
                                    ON otile.id_a=register.idotile 
                                    where register.conf=1
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
                        <h1 class="text-center"  >Page de demandes :</h1>
                        
                        </div>
            <div class="table-responsive table-user">
            <table class="main-table mange-menbers text-center table table-bordered" id="emp">
            <tr>
                <td>#ID</td>
                <td>Chef de Service</td>
                <td>Service</td>
                <td>Articles</td>
                <td>Date de demande</td>
                
                
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
                    echo "</tr>";
                }
            ?>

            </table>
            </div>


            
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