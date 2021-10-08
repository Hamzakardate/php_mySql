<?php 
   session_start();
   $pageTitle='Dashboard';
   if(isset($_SESSION['Username']))
   {
    include "int.php";
    
    ?>


    <div class="container home-stats text-center">
    <div class="jumbotron">
        <h1>Bienvenue <?php echo $_SESSION['Username']; ?> / ajouter  :</h1>
        <p><a class="btn btn-primary btn-lg" href="users.php?do=Add" role="button">Un utilisateur</a>
        <a class="btn btn-primary btn-lg" href="services.php?do=Add" role="button">Une service</a>
        <a class="btn btn-primary btn-lg" href="otile.php?do=Add" role="button">Un outile</a>
        </p>
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
                Nombre d'articles
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
                    Liste d'articles
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
    </div>


<?php     include "includes/templates/footer.php"; 
    }
    else
    {
        header('location: index.php');
        
    }?>