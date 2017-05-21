<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        /* slideshow styles */
        .slideshow {   
            overflow: hidden;
            border: 3px solid #f2f2f2;
            height: 250px;
        }  
        .slideshow ul {  
            list-style:none;
        }  

        .slideshow1{
            text-align:center;
            width:75%;
            margin: auto auto auto auto;
        }


    </style>

</head>

<h2>NOTICIAS</h2>

<div class="slideshow slideshow1">
    <ul>
        <li>
            <?php
            include_once 'bbdd.php';
            ShowNoticiasMusico();
            ?> 
        </li>
        <li>
            <?php
            include_once 'bbdd.php';
            ShowNoticiasLocal();
            ?> 
        </li>
        <li>
            <?php
            include_once 'bbdd.php';
            ShowNoticiasConcierto();
            ?>  
        </li>
       
    </ul>

</div>
<script>
    $(function () {
        setInterval(function () {
            $(".slideshow1 ul").animate({marginLeft: -350}, 800, function () {
                $(this).css({marginLeft: 0}).find("li:last").after($(this).find("li:first"));
            })
        }, 3500);
    });


// controls the animation with mouse over
    $(function () {
        var timeSlide;
        function goSlide() {
            $(".slideshow ul").animate({marginLeft: -350}, 800, function () {
                $(this).css({marginLeft: 0}).find("li:last").after($(this).find("li:first"));
            })
        }
        timeSlide = setInterval(goSlide, 3500);

        $('.slideshow').on('mouseenter', function () {
            // stop animation
            clearInterval(timeSlide);
        }).on('mouseleave', function () {
            // play animation
            timeSlide = setInterval(goSlide, 3500);
        });
    });
</script>


</body>






