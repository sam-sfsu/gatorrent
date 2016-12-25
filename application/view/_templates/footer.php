<!--Copyright San Francisco State University Software Engineering CSC 648/848 F16G13-->

<div class="wrapper">
    <div class="push"></div>
</div>
<div class="footer">
</div>
<div class="mainfooter site-footer panel-footer navbar-static-bottom text-center">
    <ul>
        <a href="<?php echo URL; ?>home/conditionsofuse" target="_blank"><span style="color: whitesmoke;">Conditions of Use  |</a>
        <a href="<?php echo URL; ?>home/privacynotice" target="_blank"><span style="color: whitesmoke;">Privacy Notice   |</a>
        <a href="<?php echo URL; ?>home/contactus" target="_blank"><span style="color: whitesmoke;">Contact Us   |</a>
        <a href="https://github.com/panique/mini" target="_blank"><span style="color: whitesmoke;">Find MINI on GitHub</a>.
    </ul>
</div>
<!-- backlink to repo on GitHub, and affiliate link to Rackspace if you want to support the project -->
<!-- jQuery, loaded in the recommended protocol-less way -->
<!-- more http://www.paulirish.com/2010/the-protocol-relative-url/ -->
<!-- moved to _templates/header.php -->
<!-- <script src="//code.jquery.com/jquery-1.11.1.min.js"></script> -->

<!-- define the project's URL (to make AJAX calls possible, even when using this in sub-folders etc) -->
<script>
    var url = "<?php echo URL; ?>";
</script>

<!-- our JavaScript -->
<script src="<?php echo URL; ?>js/application.js"></script>
</body>
</html>
