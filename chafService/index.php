<?php
    session_start();
    $nonavbar='';
    $pageTitle='Index';
    include "int.php";
    if(isset($_SESSION['Usernamec']))
    {
        echo "ok";
       header("location: dashboard.php");
        
    }
    
    
    
    
    
    if($_SERVER['REQUEST_METHOD']=='POST')
    {
      if(isset($_POST['connexion']))
      {
        $Username=$_POST['user_'];
        $Password=$_POST['pass_'];
        $hashedPass=sha1( $Password);
        
        $stmt=$con->prepare("select id_u,username,password from users where username=? and password=? and status=1 and sup=0 LIMIT 1");
        $stmt->execute(array($Username,$hashedPass));
        $row=$stmt->fetch();
        $count=$stmt->rowCount();
        
        if ($count>0)
        {
            $_SESSION['Usernamec']=$Username;
            $_SESSION['IDc']=$row['id_u'];
            header('location: dashboard.php');
            echo"ok";
            exit();
        }
        else {
          $formErrors=array();
          
              
              if(empty($Username))
              {   
                  $formErrors[]="Username n'est pas vide";
              }
              if(empty($Password))
              {   
                  $formErrors[]="Password n'est pas vide";
              }
              if(isset($Username) && isset($Password))
              {   
                  $formErrors[]="Username ou Password n'est pas vrais";
              }
              
          
         }
      }
        
    }
    ?>
      <br/>&nbsp;&nbsp;&nbsp;
    <div class="btn-group">
  <button type="button" class="btn btn-primary">Enter comme</button>
  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="caret"></span>
    <span class="sr-only">Toggle Dropdown</span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="../chafService/index.php">Chef de Service</a></li>
    <li><a href="../founseur/index.php">Magasinier</a></li>
    <li><a href="../generale/index.php">Général</a></li>
    <li role="separator" class="divider"></li>
    <li><a href="../admine/index.php">Admine</a></li>
  </ul>
</div>
<div class="container login-page">
<form class="login" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <h4 class="text-center">Chef de Service connexion</h4>
        <input class="form-control input-lg" type="text"  name="user_" placeholder="Username" autocomplete="off"/>
        <input class="form-control  input-lg" type="password"  name="pass_" placeholder="Password" autocomplete="new-password"/>
        <input class="btn btn-primary btn-block" type="submit" name="connexion" value="connexion"/>
    </form>
  <?php
              if(!empty($formErrors))
              {
                  echo'<div class="the-errors text-center" style="margin-top:-80px;">';
                  foreach($formErrors as $error)
                  {
                      echo $error.'<br/>';
                  }
                  echo'</div>';
              }
?>
</div>

<?php include "includes/templates/footer.php";?>