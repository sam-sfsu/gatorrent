<!--Copyright San Francisco State University Software Engineering CSC 648/848 F16G13-->

<style>
    #gmap_canvas {
        width: 100%;
        height: 30em;
    }

</style>

<div class="jumbotron">
    <div class="container" style="text-align: center;">
        <h2 style="text-decoration: underline;"><?php echo $apartment[0]->title ?></h2>
    </div>
    <!-- Created date -->
    <div class="container" style="text-align: center;">
        <span><h4>created <?php echo $apartment[0]->created_date; ?></h4></span>
    </div>
</div>

<div class="container">
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-6 text-center">
                <h4><strong>Price:</strong> $<?php echo $apartment[0]->price ?></h4>
            </div>
            <div class="col-md-6 text-center">
                <h4><strong>Zipcode:</strong> <?php echo $apartment[0]->zipcode ?></h4>
            </div>
        </div>
        <div class="row">
            <hr>
            <div class="col-md-6 text-center">
                <img src="<?php echo URL; ?>public/img/bed.png">
                <figcaption><strong><?php echo $apartment[0]->rooms ?> Rooms</strong></figcaption>
            </div>
            <div class="col-md-6 text-center">
                <img src="<?php echo URL; ?>public/img/bath.png">
                <figcaption><strong><?php echo $apartment[0]->baths ?> Baths</strong></figcaption>
            </div>
        </div>
        <div class="row">
            <hr>
            <h4><strong>Description:</strong> <?php echo $apartment[0]->description ?></h4>
        </div>
        <div class="row" style="padding-top:10px;">
            <hr>
            <div style="text-align: center;">
                <a href="<?php if ($session['loggedIn'] === true) { echo 'mailto:' . $contact->email . '?subject=[GatorRent] ' . $apartment[0]->title; } else { echo URL . 'home/login'; } ?>" <?php if ($session['loggedIn'] === true) { echo 'target="_blank"'; } ?>>
                    <button type="button" class="btn btn-primary btn-lg">Contact</button>
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <?php if (isset($apartment[0]->picture_1)) { ?>
                    <li data-target="#myCarousel" data-slide-to="1" class="active"></li>
                <?php } ?>
                <?php if (isset($apartment[0]->picture_2)) { ?>
                    <li data-target="#myCarousel" data-slide-to="2" class="active"></li>
                <?php } ?>
                <?php if (isset($apartment[0]->picture_3)) { ?>
                    <li data-target="#myCarousel" data-slide-to="3" class="active"></li>
                <?php } ?>
                <?php if (isset($apartment[0]->picture_4)) { ?>
                    <li data-target="#myCarousel" data-slide-to="4" class="active"></li>
                <?php } ?>

            </ol>
            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox" style="height: 385px;">
                <?php if (isset($apartment[0]->picture_1)) { ?>
                    <div class="item active">
                        <img src="<?php echo 'http://sfsuswe.com/~f16g13/imgfs/' . htmlspecialchars($apartment[0]->apartment_id) . "/" . htmlspecialchars($apartment[0]->picture_1); ?>">
                    </div>
                <?php } ?>

                <?php if (isset($apartment[0]->picture_2)) { ?>
                    <div class="item">
                        <img src="<?php echo 'http://sfsuswe.com/~f16g13/imgfs/' . htmlspecialchars($apartment[0]->apartment_id) . "/" . htmlspecialchars($apartment[0]->picture_2); ?>">
                    </div>
                <?php } ?>
                <?php if (isset($apartment[0]->picture_3)) { ?>
                    <div class="item">
                        <img src="<?php echo 'http://sfsuswe.com/~f16g13/imgfs/' . htmlspecialchars($apartment[0]->apartment_id) . "/" . htmlspecialchars($apartment[0]->picture_3); ?>">
                    </div>
                <?php } ?>
                <?php if (isset($apartment[0]->picture_4)) { ?>
                    <div class="item">
                        <img src="<?php echo 'http://sfsuswe.com/~f16g13/imgfs/' . htmlspecialchars($apartment[0]->apartment_id) . "/" . htmlspecialchars($apartment[0]->picture_4); ?>">
                    </div>
                <?php } ?>
            </div>

            <!-- Left and right controls -->
            <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
</div>
<div class="containter" style="padding-top: 20px;">

    <?php
    if ($apartment[0]->street_address) {

        // get latitude, longitude and formatted address
        $data_arr = geocode($apartment[0]->street_address);

        // if able to geocode the address
        if ($data_arr) {

            $latitude = $data_arr[0];
            $longitude = $data_arr[1];
            $formatted_address = $data_arr[2];
            ?>

            <!-- google map will be shown here -->
            <div id="gmap_canvas">Loading map...</div>

            <!-- JavaScript to show google map -->
            <script type="text/javascript" src="http://maps.google.com/maps/api/js"></script>
            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAjhXh1duCGon8_kQxnx7rwg9_NRZ8VhpI&callback=initMap"></script>
            <script type="text/javascript">
                function init_map() {
                    var myOptions = {
                        scrollwheel: false,
                        zoom: 14,
                        center: new google.maps.LatLng(<?php echo $latitude; ?>, <?php echo $longitude; ?>),
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    };
                    map = new google.maps.Map(document.getElementById("gmap_canvas"), myOptions);
                      cityCircle = new google.maps.Circle({
                        strokeColor: '#337ab7',
                        strokeOpacity: 0.8,
                        strokeWeight: 2,
                        fillColor: '#337ab7',
                        fillOpacity: 0.35,
                        map: map,
                        center: {lat: <?php echo $latitude; ?>, lng: <?php echo $longitude; ?>},
                        radius: 500
                    });
                    infowindow = new google.maps.InfoWindow({
                        content: "<?php echo $formatted_address; ?>"
                    });
                    google.maps.event.addListener(marker, "click", function () {
                        infowindow.open(map, marker);
                    });
                    infowindow.open(map, marker);
                }
                google.maps.event.addDomListener(window, 'load', init_map);
            </script>
        <?php
        // if unable to geocode the address
    } else {
        echo "No map found.";
    }
}
?>
</div>

<?php
// function to geocode address, it will return false if unable to geocode address
function geocode($address) {

    // url encode the address
    $address = urlencode($address);

    // google map geocode api url
    $url = "http://maps.google.com/maps/api/geocode/json?address={$address}";

    // get the json response
    $resp_json = file_get_contents($url);

    // decode the json
    $resp = json_decode($resp_json, true);

    // response status will be 'OK', if able to geocode given address
    if ($resp['status'] == 'OK') {

        // get the important data
        $lati = $resp['results'][0]['geometry']['location']['lat'];
        $longi = $resp['results'][0]['geometry']['location']['lng'];
        $formatted_address = $resp['results'][0]['formatted_address'];

        // verify if data is complete
        if ($lati && $longi && $formatted_address) {

            // put the data in the array
            $data_arr = array();

            array_push(
                    $data_arr, $lati, $longi, $formatted_address
            );

            return $data_arr;
        } else {
            return false;
        }
    } else {
        return false;
    }
}
?>
