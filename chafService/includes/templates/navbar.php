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
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['Usernamec']; ?><span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="users.php?do=EditProfile&userid=<?php echo $_SESSION['IDc'];?>">Editer le profil</a></li>
            <li><a href="logout.php">Déconnecter</a></li>

          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>