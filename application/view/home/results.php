<!--Copyright San Francisco State University Software Engineering CSC 648/848 F16G13-->

<div class="container-fluid" style="background-color:#e8e8e8">
    <div class="container container-pad" id="property-listings">
        <?php if (count($results) < 1) { ?>
            <h5>No Result Found</h5>
        <?php } else if (is_a($results, 'Exception')) { ?>
            <h5>Invalid Search</h5>
            <span><?php echo $results->getMessage(); ?></span>
        <?php } else { ?>
            <div class="row">
                <div class="col-md-12">
                    <h1 style="text-align: center;">Available Apartments</h1>
                    <p style="text-align: center;"><?php echo count($results) ?> results for "<?php echo $_POST['search_query'] ?>"</p>
                    <hr style="height: 10px; border: 0; box-shadow: 0 10px 10px -10px #8c8b8b inset;"/>
                </div>
            </div>
            <div class="row">
                <?php foreach ($results as $result) {
                    ?>
                    <div class="col-sm-6">
                        <!-- Begin Listing -->
                        <div class="brdr bgc-fff pad-10 box-shad btm-mrg-20 property-listing">
                            <div class="media">
                                <a class="pull-left" href="<?php echo URL; ?>home/singleview/<?php echo $result->apartment_id; ?>" target="_blank">
                                    <img alt="image" class="img-thumbnail-listing" src="<?php if (isset($result->apartment_id) && isset($result->picture_1)) {echo 'http://sfsuswe.com/~f16g13/imgfs/' . htmlspecialchars($result->apartment_id) . "/" . htmlspecialchars($result->picture_1);} else {echo '';} ?>" width="180px" height="135px">
                                </a>
                                <div class="clearfix visible-sm"></div>
                                <div class="media-body fnt-smaller">
                                    <a href="<?php echo URL; ?>home/singleview/<?php echo $result->apartment_id; ?>" target="_blank">
                                        <h4 class="media-heading">
                                            <span class="media-title">
                                                <?php if (isset($result->title)) {echo htmlspecialchars($result->title, ENT_QUOTES, "UTF-8");} ?>
                                            </span>
                                        </h4>
                                    </a>
                                    <h4 class="media-heading" style="color:#03a1d1;">
                                        $<?php if (isset($result->price)) {echo htmlspecialchars($result->price, ENT_QUOTES, "UTF-8");}?>
                                        <small class="pull-right" style="color: black;">
                                            <?php if (isset($result->apartment_id)) {echo htmlspecialchars($result->zipcode, ENT_QUOTES, "UTF-8");}?>
                                        </small>
                                    </h4>
                                    <ul class="list-inline mrg-0 btm-mrg-10 clr-535353">
                                        <li><?php if (isset($result->rooms)) {echo htmlspecialchars($result->rooms, ENT_QUOTES, "UTF-8");}?> Rooms</li>
                                        <li style="list-style: none">|</li>
                                        <li><?php if (isset($result->baths)) {echo htmlspecialchars($result->baths, ENT_QUOTES, "UTF-8");}?> Baths</li>
                                    </ul>
                                    <a href="<?php echo URL; ?>home/singleview/<?php echo $result->apartment_id; ?>" target="_blank">
                                        <button class="btn btn-primary btn-lg">View</button>
                                    </a>
                                    <a href="<?php if ($session['loggedIn'] === true) { echo 'mailto:' . $resultContacts[$result->lessor_id]->email . '?subject=[GatorRent] ' . $result->title; } else { echo URL . 'home/login'; } ?>" <?php if ($session['loggedIn'] === true) { echo 'target="_blank"'; } ?>>
                                        <button type="button" class="btn btn-primary btn-lg">Contact</button>
                                    </a>
                                </div>
                            </div>
                        </div><!-- End Listing-->
                    </div>
                <?php } ?>
            </div><!-- End row -->
        <?php } ?>
    </div><!-- End container -->
</div>
