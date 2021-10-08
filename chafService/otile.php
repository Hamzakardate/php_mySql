<?php 
    session_start();
if(isset($_SESSION['Usernamec']))
{
        $pageTitle='Otile';
        include "int.php"; 
        $do=isset($_GET['do']) ? $_GET['do'] :'Manage';
        if($do=='Manage'){
            $getall=$con->prepare("select * from otile where sup_o=0 order by id_a ");
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
                <h1 class="text-center"  >Page des articles / pour  :</h1>
                <a class="btn btn-primary btn-lg" href="register.php?do=Add" role="button">Ajouter une demande </a>
                <a class="btn btn-primary btn-lg" href="register.php" role="button">Coupier une demande</a>
                
                </div>
                <div class="table-responsive table-user">
                    <table class="main-table mange-menbers text-center table table-bordered" id="emp">
                        <tr>
                            <td>#ID</td>
                            <td>Article</td>
                            <td>Date d'utilisation</td>
                        
                        </tr>
                        <?php
                        
                            foreach($rows as $row)
                            {
                                echo "<tr>";
                                echo "<td style='background-color:#FFF;'>".$row['id_a']."</td>";
                                echo "<td style='background-color:#FFF;'>".$row['nom_a']."</td>";
                                echo "<td style='background-color:#FFF;'>".$row['dca']."</td>";
                                
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