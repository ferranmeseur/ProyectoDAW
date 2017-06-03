<style>
    .mySlides {display:none}

</style>

<div style="max-width:79%; margin:auto" class="center">
    <?php
    include_once 'bbdd.php';
    echo '<div class="mySlides">';

    ShowNoticiasMusico();
    echo'</div>';
    echo '<div class="mySlides">';
    ShowNoticiasLocal();
    echo'</div>';
    echo '<div class="mySlides">';
    ShowNoticiasConcierto();
    echo'</div>';
    ?>

</div>

<script>
    var slideIndex = 0;
    carousel();

    function carousel() {
        var i;
        var x = document.getElementsByClassName("mySlides");
        for (i = 0;
                i < x.length;
                i++) {
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

