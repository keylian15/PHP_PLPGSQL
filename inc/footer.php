</div>
<div style="clear:both;"></div>
<?php
if ($db) {
    $db = NULL;
}
if (is_array($_SESSION['mesgs']) && is_array($_SESSION['mesgs']['confirm'])) {
?>
    <div class="alertbox messagebox">
        <?php
        foreach ($_SESSION['mesgs']['confirm'] as $mesg) {
        ?>
            <div class="messagebox">
                <span class="closebtn">&times;</span>
                <?= $mesg; ?>
            </div>
        <?php
        }
        ?>
    </div>
<?php
    unset($_SESSION['mesgs']['confirm']);
}
if (is_array($_SESSION['mesgs']) && is_array($_SESSION['mesgs']['errors'])) {
?>
    <div class="alertbox errorbox">
        <?php
        foreach ($_SESSION['mesgs']['errors'] as $err) {
        ?>
            <div class="errorbox">
                <span class="closebtn">&times;</span>
                <?= $err; ?>
            </div>
        <?php
        }
        ?>
    </div>
<?php
    unset($_SESSION['mesgs']['errors']);
}
?>

<script>
    // Get all elements with class="closebtn"
    var close = document.getElementsByClassName("closebtn");
    var i;

    // Loop through all close buttons
    for (i = 0; i < close.length; i++) {
        // When someone clicks on a close button
        close[i].onclick = function() {

            // Get the parent of <span class="closebtn"> (<div class="alert">)
            var div = this.parentElement;

            // Set the opacity of div to 0 (transparent)
            div.style.opacity = "0";

            // Hide the div after 600ms (the same amount of milliseconds it takes to fade out)
            setTimeout(function() {
                div.style.display = "none";
            }, 600);
        }
    }
</script>
<footer class="w3-container w3-padding-64 w3-center w3-opacity w3-light-grey w3-xlarge">
    <i class="fab fa-facebook w3-hover-opacity" aria-hidden="true"></i>
    <i class="fab fa-instagram w3-hover-opacity" aria-hidden="true"></i>
    <i class="fab fa-snapchat w3-hover-opacity" aria-hidden="true"></i>
    <i class="fab fa-pinterest-p w3-hover-opacity" aria-hidden="true"></i>
    <i class="fab fa-twitter w3-hover-opacity" aria-hidden="true"></i>
    <i class="fab fa-linkedin w3-hover-opacity" aria-hidden="true"></i>
    <p class="w3-medium">Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
</footer>

</body>

</html>