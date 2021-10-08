<?php 
    session_start();
if(isset($_SESSION['Username']))
{
        $pageTitle='User';
        include "int.php"; 
        $do=isset($_GET['do']) ? $_GET['do'] :'Manage';
        if($do=='Manage'){
            
            //$rows= affecheAll('*','users','id_u');

            
            $getall=$con->prepare("select * from users where id_u != ? and sup=0 order by id_u ");
            $getall->execute(array($_SESSION['ID']));
            $rows=$getall->fetchAll();
           

        ?>
             
             <div class="container select-users ">
             <div class="jumbotron text-center">
                <div class="col-lg-3 col-lg-offset-9 col-xs-4 col-xs-offset-7 col-sm-4 col-sm-offset-8 
                col-md-4 col-md-offset-8 ">
                    <div class="input-group">
                    
                    <input type="text" style="border-radius:6px;"class="form-control" id="serche" placeholder="Rechercher ..">
                    </div><!-- /input-group -->
                </div>
                <h1 class="text-center"  >Page des utilisateurs /pour ajouter :</h1>
                <a class="btn btn-primary btn-lg" href="users.php?do=Add" role="button">Un utilisateur</a>
                <a class="btn btn-primary btn-lg" href="services.php?do=Add" role="button">Une service</a>
                <a class="btn btn-primary btn-lg" href="otile.php?do=Add" role="button">Un article</a>
        
                </div>
                <div class="table-responsive table-user " >
                    <table class="main-table mange-menbers text-center table table-bordered" id="emp">
                        <tr>
                            <td> PPR</td>
                            <td>Images</td>
                            <td>Nom</td>
                            <td>Prénom</td>
                            <td>Statut</td>
                            <td>Date d'enregistrement</td>
                            <td>Email</td>
                            <td>Tél</td>
                            
                            <td>Control</td>
                        </tr>
                        <?php
                        
                            foreach($rows as $row)
                            {
                                echo "<tr>";
                                echo "<td style=' background-color:#FFF;'>".$row['poo']."</td>";
                                echo "<td style='background-color:#FFF;'>";
                                
                                if(empty($row['img']))
                                {
                                    echo "<img src='images.png' alt=''class='img-circle img-class'/>";
                                }else{
                                    echo "<img src='../uploads/avatar/".$row['img']."' alt=''class='img-circle img-class'/>";
                                }
                                echo"</td>";
                                echo "<td style='background-color:#FFF;'>".$row['nom']."</td>";
                                echo "<td style='background-color:#FFF;'>".$row['prennom']."</td>";
                                if($row['status']==0){echo "<td style='background-color:#FFF;'>Admine</td>";}
                                if($row['status']==1){echo "<td style='background-color:#FFF;'>Chef de Service</td>";}
                                if($row['status']==2){echo "<td style='background-color:#FFF;'>Magasinier</td>";}
                                if($row['status']==3){echo "<td style='background-color:#FFF;'>Général</td>";}
                                echo "<td style='background-color:#FFF;'>".$row['date']."</td>";
                                echo "<td style='background-color:#FFF;'>".$row['email']."</td>";
                                echo "<td style='background-color:#FFF;'>".$row['tel']."</td>";
                                echo '<td style="background-color:#FFF;">';
                                echo '<a href="users.php?do=Edit&userid='.$row['id_u'].'"class="btn btn-success">Modifier</a>';
                                echo '&nbsp;<a href="users.php?do=Delete&userid='.$row['id_u'].'" class="btn btn-danger confirme">Supprimer</a>';
                                echo " </td>";
                                echo "</tr>";
                            }
                        ?>
                        
                    </table>
                </div>
             

             <a href="users.php?do=Add" class="btn btn-primary">Ajouter un utilisateur</a>
             </div>
     
     <?php
        }elseif($do=='Add'){
            ?>
            <h1 class="text-center">Ajouter un utilisateur</h1>
            <div class="container">
            <form action="users.php?do=Insert" method="POST">
                    

                    <div class="for-group form-group-lg" style='margin:10px;'>
                    <lable class="col-sm-2 col-md-2 col-xs-2 control-label">PPR</lable>
                        <div class="col-sm-10 col-md-10 col-xs-10">
                        <input type="text" class="form-control" placeholder="PPR" name="poo"aria-describedby="sizing-addon1"  autocomplete="off" required="required" />
                        </div>
                    </div>
                    <br/> <br/> <br/>
                    <div class="for-group form-group-lg" style='margin:10px;'>
                    <lable class="col-sm-2 col-md-2 col-xs-2 control-label">Nom</lable>
                        <div class="col-sm-10 col-md-10 col-xs-10">
                        <input type="text" class="form-control" placeholder="Nom" name="nom" aria-describedby="sizing-addon1" required="required"  />
                        </div>
                    </div>
                    <br/> <br/> <br/>
                    <div class="for-group form-group-lg" style='margin:10px;'>
                    <lable class="col-sm-2 col-md-2 col-xs-2 control-label">Prénom</lable>
                        <div class="col-sm-10 col-md-10 col-xs-10">
                        <input type="text" class="form-control" placeholder="Prénom" name="prenom" aria-describedby="sizing-addon1" required="required" />
                        </div>
                    </div>
                    <br/> <br/> <br/>
                    <div class="for-group form-group-lg" style='margin:10px;'>
                    <lable class="col-sm-2 col-md-2 col-xs-2 control-label">Statut</lable>
                        <div class="col-sm-10 col-md-10 col-xs-10">
                            <select class ="form-control" name="status">
                                <option value="4">....</option>
                                <option value="0">Admine</option>
                                <option value="1">Chef de Service</option>
                                <option value="2">Magasinier</option>
                                <option value='3'>Général</option>
                            </select>
                        </div>
                    </div>
                    <br/> <br/> <br/>
                    <div class="for-group form-group-lg" style='margin:10px;'>
                    <lable class="col-sm-2 col-md-2 col-xs-2 control-label">Username</lable>
                        <div class="col-sm-10 col-md-10 col-xs-10">
                        <input type="text" class="form-control" placeholder="Username" name="username" aria-describedby="sizing-addon1"  autocomplete="off"/>
                        </div>
                    </div>
                    <br/> <br/> <br/>
                    <div class="for-group form-group-lg" style='margin:10px;'>
                    <lable class="col-sm-2 col-md-2 col-xs-2 control-label">Password</lable>
                        <div class="col-sm-10 col-md-10 col-xs-10">
                        <input type="password" class="form-control" placeholder="Password" name="password" aria-describedby="sizing-addon1" autocomplete="new-password" />
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
            echo '<h1 class="text-center">Ajouter un utilisateur</h1>';
                echo '<div class="container">';
                    $poo        =$_POST['poo'];
                    $nom        =$_POST['nom'];
                    $prennom    =$_POST['prenom'];
                    $status     =$_POST['status'];
                    $username   =$_POST['username'];
                    $password   =$_POST['password'];
                    
                    $formErrors=array();

                    if(empty($poo)){
                        $formErrors[]='<div class="alert alert-danger">PPR n\'est pas vide </div>';
                    }
                    if(empty($nom)){
                        $formErrors[]='<div class="alert alert-danger">Nom n\'est pas vide </div>';
                    }
                    if(empty($prennom)){
                        $formErrors[]='<div class="alert alert-danger">Prénom n\'est pas vide </div>';
                    }
                    if($status==4){
                        $formErrors[]='<div class="alert alert-danger">Statut Made n\'est pas vide </div>';
                    }
                    if(empty($username)){
                        $formErrors[]=' <div class="alert alert-danger">Username n\'est pas vide </div>';
                    }
                    if(isset($username)){
                        
                            $stmtx=$con->prepare("select * from users where username=? ");
                            $stmtx->execute(array($username));
                            $rowx=$stmtx->fetch();
                            $countx=$stmtx->rowCount();
                            if ($countx>0)
                            {
                                $formErrors[]=' <div class="alert alert-danger">Username existe déjà</div>';
                            }
                    }
                    foreach($formErrors as $Errors)
                    {
                        echo $Errors;
                    }
                    if(empty($formErrors))
                    {  
                            $stmt=$con->prepare("INSERT INTO users( poo, nom , prennom, status, date ,username, password) 
                            VALUES (:zname,:zdescription,:zprice,:zcountrymade,NOW(),:zcat,:zmenber)
                            ");
                            $stmt->execute(array(
                                'zname'=>$poo,
                                'zdescription'=>$nom,
                                'zprice'=>$prennom,
                                'zcountrymade'=>$status,
                                'zcat'=>$username,
                                'zmenber'=>sha1($password)
                               
                            ));
    
                            echo '<div class="alert alert-success">'.$stmt->rowCount() .' utilisateur enregistrées </div>';
                        
                    }
                echo "</div>";
                header("refresh:3;url=users.php");
                }
                else
                {
                    header('location: users.php');
                }
                

        }elseif($do=='Edit'){
            $itmeid=isset($_GET['userid']) && is_numeric($_GET['userid'])?intval($_GET['userid']):0;
            $stmt=$con->prepare("select * from users where id_u=? ");
            $stmt->execute(array($itmeid));
            $cat1=$stmt->fetch();
            $count=$stmt->rowCount();

            if ($count>0){
            ?>
               <h1 class="text-center">Mise à jour des utilisateurs</h1>
            <div class="container">
            <form action="users.php?do=Update" method="POST">
                    
                    <input type="hidden" name="userid" value="<?php echo $itmeid;?>">
                    
                    <div class="for-group form-group-lg" style='margin:10px;'>
                    <lable class="col-sm-2 col-md-2 col-xs-2 control-label">PPR</lable>
                        <div class="col-sm-10 col-md-10 col-xs-10">
                        <input type="text" class="form-control" placeholder="PPR" name="poo"aria-describedby="sizing-addon1" value="<?php echo $cat1['poo'];?>" autocomplete="off" required="required" />
                        </div>
                    </div>
                    <br/> <br/> <br/>

                    <div class="for-group form-group-lg" style='margin:10px;'>
                    <lable class="col-sm-2 col-md-2 col-xs-2 control-label">Statut</lable>
                        <div class="col-sm-10 col-md-10 col-xs-10">
                            <select class ="form-control" name="status">
                                <option value="4">....</option>
                                <option value="0" <?php if($cat1['status']==0) {echo'selected';} ?>>Admine</option>
                                <option value="1" <?php if($cat1['status']==1) {echo'selected';} ?>>Chef de Service</option>
                                <option value="2" <?php if($cat1['status']==2) {echo'selected';} ?>>Magasinier</option>
                                <option value='3' <?php if($cat1['status']==3) {echo'selected';} ?>>Général</option>
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
            echo '<h1 class="text-center">Mise à jour des utilisateurs</h1>';
            echo '<div class="container">';
            if($_SERVER['REQUEST_METHOD']=='POST')
            {
                $id_u       =$_POST['userid'];
                $poo        =$_POST['poo'];
                $status     =$_POST['status'];
                
                $formErrors=array();

                if(empty($poo)){
                    $formErrors[]='<div class="alert alert-danger">PPR n\'est pas vide </div>';
                }
                if($status==4){
                    $formErrors[]='<div class="alert alert-danger">Statut n\'est pas vide </div>';
                } 
                foreach($formErrors as $Errors)
                {
                    echo $Errors;
                }
                if(empty($formErrors))
                {  
                    $stmt=$con->prepare(" UPDATE users SET 
                    poo=?,
                    status=?
                    where
                    id_u =?
                    ");
                    $stmt->execute(array($poo,$status,$id_u));
    
                    echo '<div class="alert alert-success">'.$stmt->rowCount() .' Modification enregistrées</div>';
                        
                }
                echo'</div>';
                header("refresh:3;url=users.php");
            }
            else
            {
                header('location: users.php');
                
            }
           
        
        }elseif($do=='Delete'){
            echo '<h1 class="text-center">Supprimer un utilisateur</h1>';
            echo '<div class="container">';
                
            $itmeid=isset($_GET['userid']) && is_numeric($_GET['userid'])?intval($_GET['userid']):0;
            $stmt=$con->prepare("select * From users where id_u=? LIMIT 1");
            $stmt->execute(array($itmeid));
            $count=$stmt->rowCount();

            if ($count>0){
                $stmt=$con->prepare(" UPDATE users SET 
                    sup=1
                    where
                    id_u =?
                    ");
                    $stmt->execute(array($itmeid));
                echo '<div class="alert alert-success">'.$stmt->rowCount() .' utilisateur supprimer</div>';
                echo'</div>';
                header("refresh:3;url=users.php");
            }
            else
            {
                header('location: users.php');
            }
            echo "</div>";
        }elseif($do=='EditProfile'){
            $itmeid=isset($_GET['userid']) && is_numeric($_GET['userid'])?intval($_GET['userid']):0;
            $stmt=$con->prepare("select * from users where id_u=? ");
            $stmt->execute(array($itmeid));
            $cat1=$stmt->fetch();
            $count=$stmt->rowCount();

            if ($count>0){
            ?>
               <h1 class="text-center">Mise à jour de Profile</h1>
            <div class="container">
            <form action="users.php?do=UpdateProfile" method="POST" enctype="multipart/form-data">
                    
                    <input type="hidden" name="userid" value="<?php echo $itmeid;?>">
                    
                    <div class="for-group form-group-lg" style='margin:10px;'>
                    <lable class="col-sm-2 col-md-2 col-xs-2 control-label">Nom</lable>
                        <div class="col-sm-10 col-md-10 col-xs-10">
                        <input type="text" class="form-control" placeholder="Nom" name="nom"aria-describedby="sizing-addon1" value="<?php echo $cat1['nom'];?>" autocomplete="off" required="required" />
                        </div>
                    </div>
                    <br/> <br/> <br/>

                    <div class="for-group form-group-lg" style='margin:10px;'>
                    <lable class="col-sm-2 col-md-2 col-xs-2 control-label">Prénom</lable>
                        <div class="col-sm-10 col-md-10 col-xs-10">
                        <input type="text" class="form-control" placeholder="Prénom" name="prennom"aria-describedby="sizing-addon1" value="<?php echo $cat1['prennom'];?>" autocomplete="off" required="required" />
                        </div>
                    </div>
                    <br/> <br/> <br/>

                    <div class="for-group form-group-lg" style='margin:10px;'>
                    <lable class="col-sm-2 col-md-2 col-xs-2 control-label">Password</lable>
                        <div class="col-sm-10 col-md-10 col-xs-10">
                        <input type="hidden" class="form-control" placeholder="Password" name="oldPassword"aria-describedby="sizing-addon1" value="<?php echo $cat1['password'];?>">
                        <input type="text" class="form-control" placeholder="Password" name="newPassword"aria-describedby="sizing-addon1"  autocomplete="new-password"  />
                        </div>
                    </div>
                    <br/> <br/> <br/>

                    <div class="for-group form-group-lg" style='margin:10px;'>
                    <lable class="col-sm-2 col-md-2 col-xs-2 control-label">Email</lable>
                        <div class="col-sm-10 col-md-10 col-xs-10">
                        <input type="text" class="form-control" placeholder="Email" name="email"aria-describedby="sizing-addon1" value="<?php echo $cat1['email'];?>" autocomplete="off" required="required" />
                        </div>
                    </div>
                    <br/> <br/> <br/>

                    <div class="for-group form-group-lg" style='margin:10px;'>
                    <lable class="col-sm-2 col-md-2 col-xs-2 control-label">Tél</lable>
                        <div class="col-sm-10 col-md-10 col-xs-10">
                        <input type="text" class="form-control" placeholder="Tél" name="tel"aria-describedby="sizing-addon1" value="<?php echo $cat1['tel'];?>" autocomplete="off" required="required" />
                        </div>
                    </div>
                    <br/> <br/> <br/>

                    <div class="for-group form-group-lg" style='margin:10px;'>
                    <lable class="col-sm-2 col-md-2 col-xs-2 control-label">Image</lable>
                        <div class="col-sm-10 col-md-10 col-xs-10">
                        <input type="file" class="form-control" placeholder="Country" name="full" aria-describedby="sizing-addon1"  />
                        </div>
                    <br/> <br/> <br/>

                    <br/> <br/> <br/>


         
            <button  class="btn btn-primary btn-lg" >Enregistrer</button>
       
          
            </div>

        <?php 
            }
        }elseif($do=='UpdateProfile'){

            echo '<h1 class="text-center">Mise à jour des Profiles</h1>';
                echo '<div class="container">';
            
            $avatarname  =$_FILES['full']['name'];
            $avatartype  =$_FILES['full']['type'];
            $avatartmp   =$_FILES['full']['tmp_name'];
            $avatarsize  =$_FILES['full']['size'];
                
            $avatarAllowedExtension=array("jpeg","jpg","png","gif");
            //echo $avatarname.$avatartype.$avatartmp.$avatarsize;
            $avatarExtension1=explode('.', $avatarname);
            $avatarExtension2=end($avatarExtension1);
            $avatarExtension=strtolower($avatarExtension2);

            $userid     =$_POST['userid'];
            $nom        =$_POST['nom'];
            $prennom    =$_POST['prennom'];
            $password   =empty($_POST['newPassword']) ? $_POST['oldPassword'] : sha1($_POST['newPassword']);
            $email      =$_POST['email'];
            $tel        =$_POST['tel'];

            $formErrors=array();

            if(empty($nom)){
                $formErrors[]='<div class="alert alert-danger">Nom n\'est pas vide </div>';
            }
            if(empty($prennom)){
                $formErrors[]='<div class="alert alert-danger">Prénom n\'est pas vide </div>';
            }
            if(empty($email)){
                $formErrors[]='<div class="alert alert-danger">Email n\'est pas vide </div>';
            }
            if(empty($tel)){
                $formErrors[]='<div class="alert alert-danger">Tél  vide </div>';
            }
            if(!empty($avatarExtension) && !in_array($avatarExtension,$avatarAllowedExtension))
            {
                $formErrors[]=' <div class="alert alert-danger">Extantion n\'est pas acceptable</div>';
            }
            if($avatarsize > 4194304){
                $formErrors[]=' <div class="alert alert-danger">Image n\'est pas plus de 4 MO</div>';
            }
            foreach($formErrors as $Errors)
            {
                echo $Errors;
            }
            if(empty($formErrors))
                {  
                    if(!empty($avatarname)){
                        $avatar=rand(0,1000000).'_'.$avatarname;
                        move_uploaded_file($avatartmp,"..\uploads\avatar\\".$avatar);
                        $stmt=$con->prepare(" UPDATE users SET 
                        nom=?,
                        prennom=?,
                        password=?,
                        email=?,
                        tel=?,
                        img=?
                        where
                        id_u =?
                        ");
                        $stmt->execute(array($nom,$prennom,$password,$email,$tel,$avatar,$userid));
        
                        echo '<div class="alert alert-success">'.$stmt->rowCount() .' Modification enregistrées</div>';
                    }
                    else{
                        $avatar=rand(0,1000000).'_'.$avatarname;
                        move_uploaded_file($avatartmp,"..\uploads\avatar\\".$avatar);
                        $stmt=$con->prepare(" UPDATE users SET 
                        nom=?,
                        prennom=?,
                        password=?,
                        email=?,
                        tel=?
                        where
                        id_u =?
                        ");
                        $stmt->execute(array($nom,$prennom,$password,$email,$tel,$userid));
        
                        echo '<div class="alert alert-success">'.$stmt->rowCount() .' Modification enregistrées</div>';
                        
                    }
                      
                }
                echo '</div>';
            header("refresh:3;url=users.php");
        }
}

else
{
    header('location: index.php');
    exit();
    
}
?>
<?php include "includes/templates/footer.php"; ?>