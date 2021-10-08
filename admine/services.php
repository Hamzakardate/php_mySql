<?php 
    session_start();
if(isset($_SESSION['Username']))
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
                <h1 class="text-center"  >Page des services /pour ajouter :</h1>
                <a class="btn btn-primary btn-lg" href="users.php?do=Add" role="button">Un utilisateur</a>
                <a class="btn btn-primary btn-lg" href="services.php?do=Add" role="button">Une service</a>
                <a class="btn btn-primary btn-lg" href="otile.php?do=Add" role="button">Un article</a>
        
                </div>
                <div class="table-responsive table-user ">
                    <table class="main-table mange-menbers text-center table table-bordered" id="emp">
                        <tr>
                            <td>#ID</td>
                            <td>Nom de Service</td>
                            <td>Date de Création</td>
                            <td>Chef de Service</td>
                            
                            
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
                                echo '<a href="services.php?do=Edit&userid='.$row['id_s'].'"class="btn btn-success">Modifier</a>';
                                echo '&nbsp;<a href="services.php?do=Delete&userid='.$row['id_s'].'" class="btn btn-danger confirme">Supprimer</a>';
                                echo " </td>";
                                echo "</tr>";
                            }
                        ?>
                        
                    </table>
                </div>
             

             <a href="services.php?do=Add" class="btn btn-primary">Ajouter un Service</a>
             </div>
     
     <?php
        }elseif($do=='Add'){
            ?>
            <h1 class="text-center">Ajouter un nouveau Service</h1>
            <div class="container">
            <form action="services.php?do=Insert" method="POST">
            <div class="for-group form-group-lg" style='margin:10px;'>
                    <lable class="col-sm-2 col-md-2 col-xs-2 control-label">Nom de service</lable>
                        <div class="col-sm-10 col-md-10 col-xs-10">
                        <input type="text" class="form-control" placeholder="Nom de service" name="nom_s" aria-describedby="sizing-addon1" required="required" />
                        </div>
                    </div>
            <br/> <br/> <br/>
            <div class="for-group form-group-lg" style='margin:10px;'>
                    <lable class="col-sm-2 col-md-2 col-xs-2 control-label">Chef de Service</lable>
                        <div class="col-sm-10 col-md-10 col-xs-10">
                            <select class ="form-control" name="user_name">
                                <option value="0">....</option>
                                <?php
                                    $stmt2=$con->prepare("select * from users where sup=0 and status=1");
                                    $stmt2->execute();
                                    $cats=$stmt2->fetchAll();
                                    foreach($cats as $cat)
                                    {
                                        echo "<option value ='".$cat['id_u']."'>".$cat['nom']."</option>";
                                    }
                                ?>
                                
                            </select>
                        </div>
                    </div>
            <br/> <br/> <br/>

         
            <button  class="btn btn-primary btn-lg" >Enregistrer</button>

            </form>
            </div>
            <?php 
        }elseif($do=='Insert'){
            if($_SERVER['REQUEST_METHOD']=='POST')
            {
                echo '<h1 class="text-center">Ajouter un nouveau Service</h1>';
                echo '<div class="container">';
                $nom_s      =$_POST['nom_s'];
                $user_name  =$_POST['user_name'];
                
                $formErrors=array();
                
                
                if(empty($nom_s)){
                    $formErrors[]='<div class="alert alert-danger">Nom de service n\'est pas vide </div>';
                }
                if($user_name==0){
                    $formErrors[]='<div class="alert alert-danger">Chef de Service n\'est pas vide</div>';
                }
                foreach($formErrors as $Errors)
                {
                    echo $Errors;
                }
                if(empty($formErrors))
                {
                    $stmt=$con->prepare("INSERT INTO service( nom_s,date_s,userid)
                     VALUES (:z1,NOW(),:z2)
                        ");
                        $stmt->execute(array(
                            'z1'=>$nom_s,
                            'z2'=>$user_name
                           
                        ));

                        echo '<div class="alert alert-success">'.$stmt->rowCount() .' Items Insert </div>';
                }
            }

        }elseif($do=='Edit'){
            $itmeid=isset($_GET['userid']) && is_numeric($_GET['userid'])?intval($_GET['userid']):0;
            $stmt=$con->prepare("select * from service where id_s=? ");
            $stmt->execute(array($itmeid));
            $cat1=$stmt->fetch();
            $count=$stmt->rowCount();

            if ($count>0){
            ?>
               <h1 class="text-center">Mise à jour de service </h1>
            <div class="container">
            <form action="services.php?do=Update" method="POST">
                    
                 <input type="hidden" name="id_s" value="<?php echo $itmeid;?>">
                    
                   
                    <div class="for-group form-group-lg" style='margin:10px;'>
                    <lable class="col-sm-2 col-md-2 col-xs-2 control-label">Nom de Service</lable>
                        <div class="col-sm-10 col-md-10 col-xs-10">
                        <input type="text" class="form-control" placeholder="Service" name="nom_s" value="<?php echo $cat1['nom_s']; ?>" aria-describedby="sizing-addon1"  />
                        </div>
                    </div>
                    <br/> <br/> <br/>
                    
                    <div class="for-group form-group-lg" style='margin:10px;'>
                    <lable class="col-sm-2 col-md-2 col-xs-2 control-label">Chef de Service</lable>
                        <div class="col-sm-10 col-md-10 col-xs-10">
                            <select class ="form-control" name="user_name">
                                <option value="0">....</option>
                                <?php
                                    $stmt=$con->prepare("select * from users where sup=0 and status=1");
                                    $stmt->execute();
                                    $users=$stmt->fetchAll();
                                    foreach($users as $user)
                                    {
                                        echo "<option value ='".$user['id_u']."'";
                                        if($cat1['userid']==$user['id_u']){echo "selected";}
                                        echo ">".$user['nom']."</option>";
                                    }
                                ?>
                                
                                
                            </select>
                        </div>
                    </div>
                    <br/> <br/> <br/>
                    
                    <br/> <br/> <br/>


         
            <button  class="btn btn-primary btn-lg" >Enregistrer</button>
       
          
            </div>

        <?php 
            }
        }elseif($do=='Update'){
            echo '<h1 class="text-center">Mise à jour de service</h1>';
            echo '<div class="container">';
            if($_SERVER['REQUEST_METHOD']=='POST')
            {
                $id_s       =$_POST['id_s'];
                $nom_s      =$_POST['nom_s'];
                $user_name  =$_POST['user_name'];
                $formErrors=array();
                
                if(empty($nom_s)){
                    $formErrors[]=' <div class="alert alert-danger">Nom de Service n\'est pas vide </div>';
                }
                if($user_name==0){
                    $formErrors[]=' <div class="alert alert-danger">Chaf de Service n\'est pas vide</div>';
                }
                foreach($formErrors as $Errors)
                {
                    echo $Errors;
                }
                if(empty($formErrors))
                {
                    $stmt=$con->prepare(" UPDATE service SET 
                    nom_s=?,
                    userid=?
                    WHERE id_s=?");
                    $stmt->execute(array($nom_s,$user_name,$id_s));
    
                    echo '<div class="alert alert-success">'.$stmt->rowCount() .' service engistré</div>';
                }
                echo "</div>";
            }

            else
            {
                echo '<div class="alert alert-info">Sorry ,You Can\'t Browse This Page DirectlyRecord Updated</div>';
                
            }
        }elseif($do=='Delete'){
            echo '<h1 class="text-center">Supprimer une Service</h1>';
            echo '<div class="container">';
                
            $itmeid=isset($_GET['userid']) && is_numeric($_GET['userid'])?intval($_GET['userid']):0;
            $stmt=$con->prepare("select * From service where id_s=? LIMIT 1");
            $stmt->execute(array($itmeid));
            $count=$stmt->rowCount();

            if ($count>0){
                $stmt=$con->prepare(" UPDATE service SET 
                    sup_s=1
                    WHERE id_s=?");
                    $stmt->execute(array($itmeid));
                echo '<div class="alert alert-success">'.$stmt->rowCount() .' Service supprimer</div>';
            }
            else
            {
                echo ' <div class="alert alert-danger">This ID Is Not Exist</div>';
            }
            echo "</div>";
        }
}

else
{
    header('location: index.php');
    exit();
    
}
?>
<?php include "includes/templates/footer.php"; ?>