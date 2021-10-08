<?php 
    session_start();
if(isset($_SESSION['Usernamef']))
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
                            
                                <a class="btn btn-primary btn-lg" href="register.php" role="button">Coupier une demande</a>
                            </div>
                <div class="table-responsive table-user">
                    <table class="main-table mange-menbers text-center table table-bordered" id ="emp">
                        <tr>
                            <td>#ID</td>
                            <td>Article</td>
                            <td>Contité Ctoqué</td>
                            <td>Date </td>
                            <td>Control</td>
                        
                        </tr>
                        <?php
                        
                            foreach($rows as $row)
                            {
                                echo "<tr>";
                                echo "<td style='background-color:#FFF;'>".$row['id_a']."</td>";
                                echo "<td style='background-color:#FFF;'>".$row['nom_a']."</td>";
                                echo "<td style='background-color:#FFF;'>".$row['stok_a']."</td>";
                                echo "<td style='background-color:#FFF;'>".$row['dca']."</td>";
                                echo '<td style="background-color:#FFF;">';
                                echo '<a href="otile.php?do=AjouterContenu&userid='.$row['id_a'].'"class="btn btn-primary">Ajoter un contenu </a>';
                                echo " </td>";
                                
                                echo "</tr>";
                            }
                        ?>
                        
                    </table>
                </div>
             </div>
     
     <?php
        }if($do=='AjouterContenu'){
            $itmeid=isset($_GET['userid']) && is_numeric($_GET['userid'])?intval($_GET['userid']):0;
            $stmt=$con->prepare("select * from otile where id_a=? ");
            $stmt->execute(array($itmeid));
            $cat1=$stmt->fetch();
            $count=$stmt->rowCount();

            if ($count>0){
                
             ?>
                <h1 class="text-center">Mise à jour des articles</h1>
            <div class="container">
            <form action="otile.php?do=confermatioAjouterContenu" method="POST">
                    
                 <input type="hidden" name="id_a" value="<?php echo $itmeid;?>">
                    
                 <input type="hidden" name="stok_a" value="<?php echo $cat1['stok_a'];?>">

                    <div class="for-group form-group-lg" style='margin:10px;'>
                    <lable class="col-sm-2 col-md-2 col-xs-2 control-label">Nombre d'articles</lable>
                        <div class="col-sm-10 col-md-10 col-xs-10">
                        <input type="text" class="form-control" placeholder="Nombre d'articles" name="a"  aria-describedby="sizing-addon1"  />
                        </div>
                    </div>
                    <br/> <br/> <br/>
                    
                    <br/> <br/> <br/>


         
            <button  class="btn btn-primary btn-lg" >Enregistrer</button>
       
          
            </div>

             <?php
                
        }
        }if($do=='confermatioAjouterContenu'){
            echo '<h1 class="text-center">modification d\'article</h1>';
            echo '<div class="container">';
            if($_SERVER['REQUEST_METHOD']=='POST')
            {
                $id_a       =$_POST['id_a'];
                $a          =$_POST['a'];
                $b          =$_POST['stok_a'];

                

                $formErrors=array();
                if(empty($a)){
                    $formErrors[]=' <div class="alert alert-danger">Nom d\'article ajouté n\'est pas vide </div>';
                }
                if($a <= 0){
                    $formErrors[]=' <div class="alert alert-danger">ajoute est absolument positive</div>';
                }
                foreach($formErrors as $Errors)
                {
                    echo $Errors;
                }
                if(empty($formErrors))
                {
                    $stok_a     =$b+$a;
                    $stmt=$con->prepare(" UPDATE otile SET 
                    stok_a=?
                    WHERE id_a=?");
                    $stmt->execute(array($stok_a,$id_a));
    
                    echo '<div class="alert alert-success">'.$stmt->rowCount() .' article a modifié</div>';
                }
                echo "</div>";
                //header("refresh:3;url=otile.php");
            }

            else
            {
                header('location: otile.php');
                
            }
            
            
        }
}

else
{
    header('location: index.php');
    exit();
    
}
?>
<?php include "includes/templates/footer.php"; ?>