<?php
                $stmto=$con->prepare("delete from notification where n_o in(select id_a from otile where sup_o=1 and stok_a >20 )");
                  $stmto->execute(array());
                  ?>
<?php
                $stmtv=$con->prepare("select id_a from otile where stok_a <20 and id_a not in(select n_o from notification)");
                  $stmtv->execute(array());
                foreach($stmtv as $stmt0)
                {
                  $stmt0=$con->prepare("INSERT into notification(n_o,date) VALUES( ".$stmt0['id_a'].",now())");
                  $stmt0->execute(array());
                }
                  ?>
<nav class="navbar navbar-inverse">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="dashboard.php">Interfase</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="nav navbar-nav">
        <li ><a href="users.php">Utilisateurs</a></li>
      </ul>
      <ul class="nav navbar-nav">
            <li><a href="services.php">Services</a></li>
            <li><a href="otile.php">Acticles</a></li>
            <li><a href="register.php">Demandes</a></li>
            
      </ul>
      <ul class="nav navbar-nav navbar-right">
      <li class="dropdown">
      
          <?php
            
                $stmt=$con->prepare("select notification.* ,otile.nom_a as n_name ,otile.stok_a as n_stok
                from notification  
                INNER JOIN otile 
                ON otile.id_a=notification.n_o 
                where sup_o=0 and stok_a <20
                order by id_n desc");
                  $stmt->execute(array());
                  $cat1=$stmt->fetchAll();
                  $count=$stmt->rowCount();

          ?>
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-bell"></span><sup><?php echo $count;?></sup></a>
          <ul class="dropdown-menu">
            <?php 
            
            foreach($cat1 as $row)
            {
                //echo "<li ><a href=''><span class='glyphicon glyphicon-bell'></span>".$row['id_n']."</a></li>";
                
                echo "<li ><a href=''>
                                      <div class='row'>
                                                      <div class='col-md-3'><span class='glyphicon glyphicon-bell'></span></div>
                                                       <div class='col-md-6'>Il n'y a que <br/>".$row['n_stok']." ".$row['n_name']."</div>
                                                       <div class='col-md-3'><span class='glyphicon glyphicon-eye-open'></sapn></div>
                                      </div>
                                      ".$row['date']."
                      </a><hr/></li>";
                //echo "<li ><a href=''><div class='row'><div class='col-md-3'>1</div><div class='col-md-6'>2</div><div class='col-md-3'>2</div></a></li>";
            }
            
            ?>
            
            

          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['Usernamef']; ?><span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="users.php?do=EditProfile&userid=<?php echo $_SESSION['IDf'];?>">Edit Profile</a></li>
            <li><a href="logout.php">Déconnecter</a></li>

          </ul>
        </li>
      </ul>
      
    </div>
  </div>
</nav>


