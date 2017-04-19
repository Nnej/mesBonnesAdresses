<?php 
// Set last visited page into cookie with httpOnly option
setcookie('lastpage', 'home.php', time() + 15*24*3600, null, null, false, true); 
session_start() 
?>
<!DOCTYPE html>
<html>

<head>
    <!-- MapBox links -->
    <script src='https://api.mapbox.com/mapbox-gl-js/v0.33.1/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v0.33.1/mapbox-gl.css' rel='stylesheet' />
    <!-- Standard links -->
    <meta charset='utf-8' />
    <link rel="stylesheet" href="general_style.css" />
    <link rel='stylesheet' href="detail_style.css" />

    <!-- BDD access -->
    <?php
    
    // Check id
    if( isset($_GET['id']) ) {
        
        $id = (int) $_GET['id'];
        
        if($id > 0) {
            try { 
                $bdd = new PDO('mysql:host=localhost;dbname=bdd_adresses;charset=utf8', 'root', 'root'); 
            } catch (Exception $e) { 
                die('Erreur : ' . $e->getMessage()); 
            } 
        
            $query = $bdd->prepare('SELECT * FROM Place WHERE placeID=?');
            $query->execute(array($id));
            $data = $query->fetch(PDO::FETCH_OBJ);
        }else {
            // End BDD connection and load 404 page
            echo 'Page introuvable';
        }
        
    }else {
        // End BDD connection and load 404 page
        echo 'Page introuvable';
    }
    
    ?>
        <title>
            <?php echo $data->name; ?>
        </title>
</head>

<body>
    <?php include("header.php"); ?>

    <div>
        <h2 class="page_title">
            <?php echo $data->name; ?>
        </h2>
    </div>

    <div class="detail_content">

        <div class="carrousel_images">
            <?php
            // Iterate on a specific folder
           $imagesIterator = new FileSystemIterator('images/1/carousel');
            foreach ($imagesIterator as $fileinfo) {
                $size = getimagesize($imagesIterator->key());
                //echo 'Width :' .$size[0] . ' Height: ' .$size[1];
                echo  '<img alt="' . $imagesIterator->key() .'" src="' . $imagesIterator->getPathname() . '" width="' . $size[0] . '" height="' . $size[1] . '" />';
            }

            ?>
        </div>

        <p id="describe_text">
            <?php echo $data->longDescription; ?>
        </p>

        <div id="map"></div>
        <script>
            mapboxgl.accessToken = 'pk.eyJ1Ijoibm5laiIsImEiOiJjaXcxenZlNjMwMDM5MnlsNXdlbzFram5yIn0.rEKnzfAb_dIU4emn3p-HOg';
            var map = new mapboxgl.Map({
                container: 'map',
                center: [2.3551467, 48.8582653],
                zoom: 15,
                style: 'mapbox://styles/mapbox/streets-v9'
            });

            map.on('load', function() {

                map.addLayer({
                    "id": "points",
                    "type": "symbol",
                    "source": {
                        "type": "geojson",
                        "data": {
                            "type": "FeatureCollection",
                            "features": [{
                                "type": "Feature",
                                "geometry": {
                                    "type": "Point",
                                    "coordinates": [2.3551467, 48.8582653]
                                },
                                "properties": {
                                    "title": "Mon lieu",
                                    "icon": "shop" /* Change icon représentation */
                                }
                            }]
                        }
                    },
                    "layout": {
                        "icon-image": "{icon}-15",
                        "text-field": "{title}",
                        "text-font": ["Open Sans Semibold", "Arial Unicode MS Bold"],
                        "text-offset": [0, 0.6],
                        "text-anchor": "top"
                    }
                });
            });

        </script>

        <aside>
            <div class="aside_element" id="open_hours_days">
                <span>Horaires</span>
                <ul id="open_hours_days">
                    <li>Lundi&nbsp;10h-13h&nbsp;15h-20h</li>
                    <li>Mardi 13h-14h</li>
                    <li>Mercredi etc..</li>
                    <li>Jeudi etc..</li>
                    <li>Vendredi etc..</li>
                    <li>Samedi etc..</li>
                    <li>Dimanche &nbsp;10h-13h&nbsp;15h-20h</li>
                </ul>

            </div>

            <div class="aside_element" id="localisation">
                <span>Adresse</span>
                <ul>
                    <li>
                        <?php echo $data->streetNumber . ' ' . $data->streetName; ?>
                    </li>
                    <li>
                        <?php echo $data->postcode . ' ' . $data->city; ?>
                    </li>
                </ul>
                <hr>
                <span>Métro à proximité</span>
                <ul>
                    <li id="metro_station">
                        <?php echo $data->metroStationsNear; ?>
                    </li>

                </ul>
            </div>

            <div class="aside_element" id="transport">
                <span>Liens</span>
                <ul>
                    <li><a href="#"> Facebook </a></li>
                    <li><a href="#"> Twitter </a></li>
                    <li><a href="#"> www.nomDuLieu.com </a></li>
                </ul>
            </div>

        </aside>

    </div>

    </div>
    <?php $query->closeCursor(); // End query treatment ?>

    <!-- Scroll to top button -->
    <a href="#" class="scrollTopButton">Haut</a>

    <!-- Footer -->
    <?php include('footer.php'); ?>

    <!-- jQuery link -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="customScripts.js"></script>

</body>

</html>
