<?php 
   session_start();
   $pageTitle='Dashboard';
   if(isset($_SESSION['Usernamef']))
   {
    include "int.php";
   
    
    ?>


<div class="container home-stats text-center">

        <!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
      <?php 
            
            foreach($cat1 as $row)
            {
                //echo "<li ><a href=''><span class='glyphicon glyphicon-bell'></span>".$row['id_n']."</a></li>";
                
                echo "
                                      <div class='row'>
                                                      <div class='col-md-3'><span class='glyphicon glyphicon-bell'></span></div>
                                                       <div class='col-md-6'>Il n'y a que <br/>".$row['n_stok']." ".$row['n_name']."</div>
                                                       <div class='col-md-3'><span class='glyphicon glyphicon-eye-open'></sapn></div>
                                      </div>
                                      ".$row['date']."
                      <hr/>";
                //echo "<li ><a href=''><div class='row'><div class='col-md-3'>1</div><div class='col-md-6'>2</div><div class='col-md-3'>2</div></a></li>";
            }
            
            ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        
      </div>
      
    </div>
  </div>
</div>
<!-- Button trigger modal -->

        <div class="jumbotron">
        <!-- Button trigger modal -->
            <div class="container">

            <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
            notification
            </button>

            </div>
        <h1>Bienvenue <?php echo $_SESSION['Usernamef']; ?> / pour  :</h1>
        <a class="btn btn-primary btn-lg" href="register.php?do=Add" role="button">Ajouter une demande </a>
        <a class="btn btn-primary btn-lg" href="register.php" role="button">Coupier un outil</a>
        
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="stat st-members">
                Nombre d'utilisateurs
                <span><a href="users.php"><?php echo affecheLeNomber('id_u','users','where sup=0'); ?></a></span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat st-pending">
                Nombre de Services
                <span><a href="services.php"><?php echo affecheLeNomber('id_s','service','where sup_s=0'); ?></a></span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat st-items">
                Nombre d'article.
                <span><a href="otile.php"><?php echo affecheLeNomber('id_a','otile','where sup_o=0'); ?></a></span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat st-comments">
                Nombre de demandes
                <span><a href="register.php"><?php echo countItems('id_r','register'); ?></a></span>
                </div>
            </div>
        </div>
    </div>

    <div class="container latest">
        <div class="row">
            <div class ="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                    Liste d'utilisateurs
                    </div>
                    <div class="panel-body">

<?php
$getall=$con->prepare("select * from users where sup=0 order by id_u ");
$getall->execute();
$rows=$getall->fetchAll();
?>
<div class="container ">
                <div class="  col-sm-4">
                    <table class="  text-center table ">
                        
                        <?php
                        
                            foreach($rows as $row)
                            {
                                echo "<tr>";
                                echo "<td >".$row['nom']."</td>";
                                echo "<td >".$row['prennom']."</td>";
                          
                                echo "</tr>";
                            }
                        ?>
                        
                    </table>
                </div>
             

             </div>

                    </div>
                </div>
            </div>
            <?php
$getall1=$con->prepare("select * from service where sup_s=0 order by id_s ");
$getall1->execute();
$rows1=$getall1->fetchAll();
?>
            <div class ="col-sm-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Liste de services
                    </div>
                    <div class="panel-body">
                    <table class="  text-center table ">
                    <?php
                        
                        foreach($rows1 as $row1)
                        {
                            echo "<tr>";
                            echo "<td >".$row1['nom_s']."</td>";
                      
                            echo "</tr>";
                        }
                    ?>
                    </table>
                    </div>
                </div>
            </div>
            <?php
$getall2=$con->prepare("select * from otile where sup_o=0 order by id_a ");
$getall2->execute();
$rows2=$getall2->fetchAll();
?>
            <div class ="col-sm-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                         Liste d'outils
                    </div>
                    <div class="panel-body">
                    <table class="  text-center table ">
                    <?php
                        
                        foreach($rows2 as $row2)
                        {
                            echo "<tr>";
                            echo "<td >".$row2['nom_a']."</td>";
                      
                            echo "</tr>";
                        }
                    ?>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    

<?php       
          
          echo"</div>";
          echo '<div class="container home-stats text-center">'; include "notification.php"; echo '</div>';
          include "includes/templates/footer.php"; 
    }
    else
    {
        header('location: index.php');
        
    }?>