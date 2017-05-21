<style>
    .mySlides {display:none}

</style>

<div style="max-width:75%; margin:auto" class="center">
    <div class="mySlides">
        <?php
        include_once 'bbdd.php';
        ShowNoticiasMusico();
        ?>
    </div>
    <div class="mySlides">
        <?php
        include_once 'bbdd.php';
        ShowNoticiasLocal();
        ?>
    </div>
    <div class="mySlides">
        <?php
        include_once 'bbdd.php';
        ShowNoticiasConcierto();
        ?>
    </div>
</div>

<script>
    var slideIndex = 0;
    carousel();

    function carousel() {
        var i;
        var x = document.getElementsByClassName("mySlides");
        for (i = 0; i < x.length; i++) {
            x[i].style.display = "none";
        }
        slideIndex++;
        if (slideIndex > x.length) {
            slideIndex = 1
        }
        x[slideIndex - 1].style.display = "block";
        setTimeout(carousel, 4000);
    }
</script>

