<?php 
    session_start();
if(isset($_SESSION['Usernameg']))
{
        $pageTitle='Service';
        include "int.php"; 
        $do=isset($_GET['do']) ? $_GET['do'] :'Manage';
        if($do=='Manage'){
            
            //$rows= affecheAll('*','users','id_u');

            
            $getall=$con->prepare("select service.*,users.nom as user_name 
                                    from  service 
                                    INNER JOIN users ON users.id_u=service.userid
                                    where sup_s=0
                                    order by id_s ");
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
                    <h1 class="text-center"  >Page des services :</h1>
                    
            
                    </div>
                <div class="table-responsive table-user">
                    <table class="main-table mange-menbers text-center table table-bordered" id="emp">
                        <tr>
                            <td>#ID</td>
                            <td>Nom de Service</td>
                            <td>Date de Création</td>
                            <td>Chef de Service</td>
                            
                        </tr>
                        <?php
                        
                            foreach($rows as $row)
                            {
                                echo "<tr>";
                                echo "<td style='background-color:#FFF;'>".$row['id_s']."</td>";
                                echo "<td style='background-color:#FFF;'>".$row['nom_s']."</td>";
                                echo "<td style='background-color:#FFF;'>".$row['date_s']."</td>";
                                echo "<td style='background-color:#FFF;'>".$row['user_name']."</td>";
                                
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