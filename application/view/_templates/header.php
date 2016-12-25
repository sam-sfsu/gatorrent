<!--Copyright San Francisco State University Software Engineering CSC 648/848 F16G13-->

<!DOCTYPE html>
<?php
    if (isset($_COOKIE['session'])) {
        $session = json_decode($_COOKIE['session'], true);
    } else {
        $session = array(
            'loggedIn' => false
        );
        setcookie('session', json_encode($session), 0, '/');
    }
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>GatorRent</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- JS -->
        <!-- please note: The JavaScript files are loaded in the footer to speed up page construction -->
        <!-- See more here: http://stackoverflow.com/q/2105327/1114320 -->

        <!-- Our Custom CSS -->
        <link href="<?php echo URL; ?>css/style.css" rel="stylesheet">
        <link href="<?php echo URL; ?>css/navbarstyle.css" rel="stylesheet">
        <link href="<?php echo URL; ?>css/resultstyle.css" rel="stylesheet">

        <!-- Bootstrap -->
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <!-- search bar function -->
        <script src="<?php echo URL; ?>js/searchbar.js"></script>

        <!-- Google Analytics tracking -->
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-88746021-1', 'auto');
            ga('send', 'pageview');

        </script>
    </head>
    <body>
        <div class="container">
            <div class="row text-center">
                <h5><strong>SFSU/FAU/Fulda Software Engineering Project, Fall 2016.  For Demonstration Only</strong></h5>
            </div>
        </div>
        <nav class="navbar navbar-inverse navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo URL; ?>">GatorRent</a>
                </div>

                <div class="col-sm-5">
                    <form class="navbar-form" action="<?php echo URL; ?>home/search" method="POST">
                        <div class="input-group" style="width: 100%">
                            <div class="input-group-btn search-panel" style="width: 1%">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                    <span id="search_concept"><?php echo(isset($_POST['search_option']) ? $search_options[$_POST['search_option']] : 'Any') ?></span><span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <?php foreach ($search_options as $key => $option) { ?>
                                        <li><a href="#" data-value="<?php echo $key ?>"><?php echo $option ?></a></li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <input type="hidden" name="search_option" value="<?php echo(isset($_POST['search_option']) ? $_POST['search_option'] : 'any') ?>" id="search_option">
                            <input type="text" class="form-control" name="search_query" placeholder="Search" value="<?php echo(isset($_POST['search_query']) ? $_POST['search_query'] : '') ?>">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="submit" name="submit_search" value="Search"><span class="glyphicon glyphicon-search"></span></button>
                            </span>
                        </div>
                    </form>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="<?php echo(($location == 'home') ? 'active' : '') ?>" ><a href="<?php echo URL; ?>">Home</a></li>
                        <li class="<?php echo(($location == 'aboutus') ? 'active' : '') ?>"><a href="<?php echo URL; ?>home/aboutus">About Us</a></li>
                        <?php if ($session['loggedIn'] === false || $session['accountType'] === 'Lessor') { ?>
                            <li class="<?php echo(($location == 'createlisting') ? 'active' : '') ?>"><a href="<?php echo URL; ?>user/createlisting">Create Listing</a></li>
                        <?php } ?>
                        <li class="dropdown" id="menuLogin">
                            <?php if ($session['loggedIn'] === true) { ?>
                                <!-- Logged in state -->
                                <a class="dropdown-toggle" href="#" data-toggle="dropdown" id="navLogin"><?php echo $session['email']; ?><span class="caret"></span></a>
                                <ul class="dropdown-menu" id="dropdown-login">
                                    <li>
                                        <div class="row">
                                            <div class="form-group text-center">
                                                <a href="<?php echo URL; ?>user/logout"><span style="color: #337ab7;">Logout</span></a>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            <?php } else { ?>
                                <!-- Logged out state -->
                                <a class="dropdown-toggle" href="#" data-toggle="dropdown" id="navLogin">Login<span class="caret"></span></a>
                                <ul class="dropdown-menu" id="dropdown-login">
                                    <li>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <form class="form" role="form" method="post" action="<?php echo URL; ?>user/login" accept-charset="UTF-8" id="login-nav">
                                                    <div class="form-group">
                                                        <label class="sr-only" for="email">Email address</label>
                                                        <input type="email" class="form-control" name="email" id="email" placeholder="Email address" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="sr-only" for="password">Password</label>
                                                        <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-primary btn-block">Sign in</button>
                                                    </div>
                                                    <div class="form-group text-center">
                                                        Not a member? <a href="<?php echo URL; ?>register"><span style="color: #337ab7;">Sign Up</span></a>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            <?php } ?>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div>
        </nav>
