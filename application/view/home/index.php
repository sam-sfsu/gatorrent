<!--Copyright San Francisco State University Software Engineering CSC 648/848 F16G13-->

<div class="jumbotron text-center" style="padding-bottom:10px;">
    <h1>Welcome to GatorRent</h1>
    <h4 style="color:#337ab7;">Apartments searching and renting site for SFSU's student only</h4>
</div>

<div class="container">
    <div class="row text-center">
        <h3>Most recent apartments</h3>
        <hr class="hr-style"/>
    </div>
    <?php foreach ($recentListings as $recentListing){?>
    <div class="col-sm-4">
        <div class="apartment-post">
            <div class="image" style="background-image: url(<?php if (isset($recentListing->apartment_id) && isset($recentListing->picture_1)) {echo 'http://sfsuswe.com/~f16g13/imgfs/' . htmlspecialchars($recentListing->apartment_id) . "/" . htmlspecialchars($recentListing->picture_1);} else {echo '';}?>);">
                <div class="price ng-binding">
                    $<?php if (isset($recentListing->price)) {echo htmlspecialchars($recentListing->price, ENT_QUOTES, "UTF-8");}?>
                </div>
            </div>
            <div class="content text-center">
                <a href="<?php echo URL; ?>home/singleview/<?php echo $recentListing->apartment_id; ?>" target="_blank">
                    <h4 class="media-heading">
                        <span class="media-title">
                            <?php if (isset($recentListing->title)) {echo htmlspecialchars($recentListing->title, ENT_QUOTES, "UTF-8");}?>
                        </span>
                    </h4>
                </a>
                <ul class="list-inline mrg-0 btm-mrg-10 clr-535353 text-center">
                    <li><?php if (isset($recentListing->rooms)) {echo htmlspecialchars($recentListing->rooms, ENT_QUOTES, "UTF-8");}?> Rooms</li>
                    <li style="list-style: none">|</li>
                    <li><?php if (isset($recentListing->baths)) {echo htmlspecialchars($recentListing->baths, ENT_QUOTES, "UTF-8");}?> Baths</li>
                    <li style="list-style: none">|</li>
                    <li><?php if (isset($recentListing->zipcode)) {echo htmlspecialchars($recentListing->zipcode, ENT_QUOTES, "UTF-8");}?></li>
                </ul>
                <div>
                    <a href="<?php echo URL; ?>home/singleview/<?php echo $recentListing->apartment_id; ?>" target="_blank">
                        <button class="btn btn-primary btn-lg">View</button>
                    </a>
                    <a href="<?php if ($session['loggedIn'] === true) { echo 'mailto:' . $listingContacts[$recentListing->lessor_id]->email . '?subject=[GatorRent] ' . $recentListing->title; } else { echo URL . 'home/login'; } ?>" <?php if ($session['loggedIn'] === true) { echo 'target="_blank"'; } ?>>
                        <button type="button" class="btn btn-primary btn-lg">Contact</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>
