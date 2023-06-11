<link rel="stylesheet" href="../../css/footer.css">
<footer>
    <div class="footer-parent">
        <?php
        if (!isset($_SESSION['userid'])){
            if($_SESSION['WebAllowed'] == true){
            ?>
        <div class="footer-balk">
            <h1 class="footerbalk">Now Sign Up For Free!</h1>
            <button onclick="GoToLocations('../../users/start/signup.php')" class="footerbalk">Sign Up</button>
        </div>
        <?php
        }}
        ?>
        <div class="footer-child">
            <div class="footers" id="footerone">
                <p id="p-parent">FUNWEB</p>
                <hr id="p-parent">
                <p>
                    funweb is a great website to earn money by buy and selling
                    uniqe items. have a talk with people make new friends
                    and make your career through the ranks
                    make you way up to reach legendary level!
                </p>
            </div>
            <div class="footers">
                <p id="">SOCIAL</p>
                <hr id="p-parent">
                <p>youtube</p>
                <p>twitter</p>
                <p>instagram</p>
                <p>about us</p>
            </div>
            <div class="footers">
                <p id="">LINKS</p>
                <hr id="p-parent">
                <p>your account</p>
                <p>become partner</p>
                <p>contact</p>
                <p>help</p>
            </div>
            <div class="footers">
                <p id="">CONTACT</p>
                <hr id="p-parent">
                <p>New York, NY, 10479, US</p>
                <p>atjezuid@gmail.com</p>
                <p>+ 06 855 20 868</p>
                <p>+ 06 855 20 868</p>
            </div>
        </div>
    </div>
</footer>

<script>
    //window.href
    function GoToLocations(location){
    window.location.href = location;
    }
</script>