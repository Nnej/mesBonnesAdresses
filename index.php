<?php session_start() ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Acceuil</title>
    <!-- Styles CSS -->
    <link rel="stylesheet" href="general_style.css" />
    <link rel="stylesheet" href="home_style.css" />
    <link rel="stylesheet" href="animate_button.css" />
</head>

<body>
    <?php
    if(isset($_POST['login']) && isset($_POST['mdp'])){
        //$_SESSION['login'] = 
            $login= htmlspecialchars($_POST['login']);
        echo '<div class="login_infos">' . $login . '</div>';
    }else {
        echo 'None';
    }
    
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=bdd_adresses;charset=utf8', 'root', 'root');
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
    
    $response = $bdd->query('SELECT placeID,imagesFolderURL,shortDescription,name FROM Place');
    
    ?>
        <!-- Header -------------------- -->

        <?php include("header.php"); ?>
        <!-- Filter start --------------------- -->
        <div class="filter_bar">


            <div class="animate_button">
                <a href="#"><img src="images/filters/bar.png" />
                    <span class="animate_button_text">Restaurants</span></a>
            </div>

            <div class="animate_button">
                <a href="#"><img src="images/filters/face-mask.png" />
                    <span class="animate_button_text">Beauté</span></a>
            </div>

            <div class="animate_button">
                <a href="#"><img src="images/filters/wardrobes.png" />
                    <span class="animate_button_text">Vêtements</span></a>
            </div>

        </div>
        <!-- Filter end -------------------- -->
        <hr/>
        <!-- Page content start -------------------- -->
        <div class="page_content">
            <?php 
            while ($donnees = $response->fetch()) {
               echo  '<a href="place_detail.php?id=' . $donnees['placeID'] . '">'; 
               echo '<div class="location_item" style="background-image: url(' . $donnees['imagesFolderURL'] . 'overview.png);">';
            ?>
            <div class="location_overlay">
                <h3>
                    <?php echo $donnees['name']; ?> </h3>
                <p class="location_description">
                    <?php echo $donnees['shortDescription']; ?> </p>
            </div>
        </div>
        </a>
        <?php 
            }
            $response->closeCursor(); // End query treatment
            ?>


        </div>
        <!-- Page content end -------------------- -->

        <!-- Footer -->
        <?php include('footer.php'); ?>
        <!--
        <hr/>
         Footer -------------------- 
        <footer>
            <span class="footer_text">Fait avec &#10084; par</span> <a href="http://www.linkedin.com/in/jenniferguiard/">Jennifer G.</a>
        </footer>
-->

</body>

</html>
