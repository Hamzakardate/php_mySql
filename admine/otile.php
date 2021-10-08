<?php 
    session_start();
if(isset($_SESSION['Username']))
{
        $pageTitle='Otile';
        include "int.php"; 
        $do=isset($_GET['do']) ? $_GET['do'] :'Manage';
        if($do=='Manage'){
            $getall=$con->prepare("select * from otile where sup_o=0 order by id_a ");
            $getall->execute(array());
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
                <h1 class="text-center"  >Page des articles /pour ajouter :</h1>
                <a class="btn btn-primary btn-lg" href="users.php?do=Add" role="button">Un utilisateur</a>
                <a class="btn btn-primary btn-lg" href="services.php?do=Add" role="button">Une service</a>
                <a class="btn btn-primary btn-lg" href="otile.php?do=Add" role="button">Un Article</a>
        
                </div>
                <div class="table-responsive table-user">
                    <table class="main-table mange-menbers text-center table table-bordered" id="emp"> 
                        <tr>
                            <td>#ID</td>
                            <td>Articles</td>
                            <td>Quantité Stoqué</td>
                            <td>Date d'utilisation</td>
                        
                            
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
                                echo '<a href="otile.php?do=Edit&userid='.$row['id_a'].'"class="btn btn-success">Modifier</a>';
                                echo '&nbsp;<a href="otile.php?do=Delete&userid='.$row['id_a'].'" class="btn btn-danger confirme">Supprimer</a>';
                                echo " </td>";
                                echo "</tr>";
                            }
                        ?>
                        
                    </table>
                </div>
             

             <a href="otile.php?do=Add" class="btn btn-primary">Ajouter un article</a>
             </div>
     
     <?php
        }elseif($do=='Add'){
            ?>
            <h1 class="text-center">Ajouter un nouveau article</h1>
            <div class="container">
            <form action="otile.php?do=Insert" method="POST">
            <div class="for-group form-group-lg" style='margin:10px;'>
                    <lable class="col-sm-2 col-md-2 col-xs-2 control-label">Nom d'article</lable>
                        <div class="col-sm-10 col-md-10 col-xs-10">
                        <input type="text" class="form-control" placeholder="Nom d'article" name="nom_a" aria-describedby="sizing-addon1" required="required" />
                        </div>
                    </div>
            <br/> <br/> <br/>
            <br/> <br/> <br/>

         
            <button  class="btn btn-primary btn-lg" >Enregistrer</button>

            </form>
            </div>
            <?php 
            
        }elseif($do=='Insert'){
            if($_SERVER['REQUEST_METHOD']=='POST')
            {
                echo '<h1 class="text-center">Ajouter un nouveau article</h1>';
                echo '<div class="container">';
                $nom_a= $_POST['nom_a'];
                $formErrors=array();
                
                
                if(empty($nom_a)){
                    $formErrors[]='<div class="alert alert-danger">Nom d\'Article Can\'t Be Empty </div>';
                }
                foreach($formErrors as $Errors)
                {
                    echo $Errors;
                }
                if(empty($formErrors))
                {
                    $stmt=$con->prepare("INSERT INTO otile( nom_a,dca)
                    VALUES (:z1,NOW())
                       ");
                       $stmt->execute(array(
                           'z1'=>$nom_a
                       ));

                       echo '<div class="alert alert-success">'.$stmt->rowCount() .' Items Insert </div>';
                }
                header("refresh:3;url=otile.php");
            }
        }elseif($do=='Edit'){
            $itmeid=isset($_GET['userid']) && is_numeric($_GET['userid'])?intval($_GET['userid']):0;
            $stmt=$con->prepare("select * from otile where id_a=? ");
            $stmt->execute(array($itmeid));
            $cat1=$stmt->fetch();
            $count=$stmt->rowCount();

            if ($count>0){
            ?>
               <h1 class="text-center">Mise à jour d'article</h1>
            <div class="container">
            <form action="otile.php?do=Update" method="POST">
                    
                 <input type="hidden" name="id_a" value="<?php echo $itmeid;?>">
                    
                   
                    <div class="for-group form-group-lg" style='margin:10px;'>
                    <lable class="col-sm-2 col-md-2 col-xs-2 control-label">Nom de article</lable>
                        <div class="col-sm-10 col-md-10 col-xs-10">
                        <input type="text" class="form-control" placeholder="Article" name="nom_a" value="<?php echo $cat1['nom_a']; ?>" aria-describedby="sizing-addon1"  />
                        </div>
                    </div>
                    <br/> <br/> <br/>
                    
                    <br/> <br/> <br/>


         
            <button  class="btn btn-primary btn-lg" >Enregistrer</button>
       
          
            </div>

        <?php 
            }
        }elseif($do=='Update'){
            echo '<h1 class="text-center">Mise à jour d\'article</h1>';
            echo '<div class="container">';
            if($_SERVER['REQUEST_METHOD']=='POST')
            {
                $nom_a      =$_POST['nom_a'];
                $id_a       =$_POST['id_a'];
                $formErrors=array();
                
                if(empty($nom_a)){
                    $formErrors[]=' <div class="alert alert-danger">Nom d\'article n\'est pas vide </div>';
                }
                foreach($formErrors as $Errors)
                {
                    echo $Errors;
                }
                if(empty($formErrors))
                {
                    $stmt=$con->prepare(" UPDATE otile SET 
                    nom_a=?
                    WHERE id_a=?");
                    $stmt->execute(array($nom_a,$id_a));
    
                    echo '<div class="alert alert-success">'.$stmt->rowCount() .' Nom de article enregistrées </div>';
                }
                echo "</div>";
                header("refresh:3;url=otile.php");
            }

            else
            {
                header('location: otile.php');
            }
        }elseif($do=='Delete'){
            echo '<h1 class="text-center">Supprimer un article</h1>';
            echo '<div class="container">';
                
            $itmeid=isset($_GET['userid']) && is_numeric($_GET['userid'])?intval($_GET['userid']):0;
            $stmt=$con->prepare("select * From otile where id_a=? LIMIT 1");
            $stmt->execute(array($itmeid));
            $count=$stmt->rowCount();

            if ($count>0){
                
                $stmt=$con->prepare(" UPDATE otile SET 
                sup_o=1
                WHERE id_a=?");
                $stmt->execute(array($itmeid));

                echo '<div class="alert alert-success">'.$stmt->rowCount() .' Article supprimer</div>';
            }
            else
            {
                echo ' <div class="alert alert-danger">This ID Is Not Exist</div>';
            }
            echo "</div>";
            header("refresh:3;url=otile.php");
        }
}

else
{
    header('location: index.php');
    exit();
    
}
?>
<?php include "includes/templates/footer.php"; ?>