<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
      <!-- Font Awesome Icons -->
  <link rel="stylesheet" href={{asset("bower_components/admin-lte/plugins/fontawesome-free/css/all.min.css" )}}>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet"  type="text/css" href="{{ asset('css/style.css') }}">
</head>
<body>
    

    <header>
        <div class="container-fluid ">
            <nav class="navbar navbar-expand-md fixed-top bg-navbar shadow">
                <div class="container">
                    <a class="navbar-brand" href="#">Navbar</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="fas fa-bars py-2 px-3" style="color: whitesmoke ;border: 1px solid whitesmoke"></span>
                    </button>
                    <div class="collapse navbar-collapse text-center" id="navbarNav">
                            <ul class="navbar-nav ml-auto">
                                <li class="nav-item">
                                <a class="nav-link" href="#">À propos</a>
                                </li>
                                <li class="nav-item">
                                <a class="nav-link" href="#">Fonctionnalités</a>
                                </li>
                                <li class="nav-item">
                                <a class="nav-link" href="#">Services</a>
                                </li>
                                <li class="nav-item">
                                <a class="nav-link" href="#">Contact</a>
                                </li>
                                <li class="nav-item pl-0 pl-md-4 ">
                                <a class="nav-link btn btn-outline-light" href="{{ route('login') }}">Se connecter</a>
                                </li>
                            </ul>
                </div>
            </nav>

            <div class="container text-center parallax">
                <div class="row align-items-center ">
                    <div class="col-md-7 col-sm-12 py-5">
                        <div class="margin">
                        <h1>Restez Organisé</h1>
                        <h3>Nous avons sur un seul endroit tout les outils dont vous avez besoin pour réussir un projet</h3>
                        <form action="{{ route('register') }}">
                            <button class="btn btn-success btn-perso" type="submit">Commencer</button>
                        </form>
                                 
                    </div>
                    </div>
                    <div class="col-md-5 col-sm-12">
                        <img class="img d-none d-md-block" src="{{asset('assets/hero-illustration.svg')}}" alt="Teamwork">
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-md-12 col-12">
                    <div class="wave-container d-none d-md-block">
                        <div class="wave wave1"></div>
                        <div class="wave wave2"></div>
                        <div class="wave wave3"></div>
                    </div>
                </div>
            </div>
        </div>

        
    </header>
    
    

    <div class="container">
       
            <canvas id="myChart" width="100%" height="50" class="p-5"></canvas>
      
    </div>

    <footer>

    </footer>

    


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" integrity="sha256-R4pqcOYV8lt7snxMQO/HSbVCFRPMdrhAFMH+vr9giYI=" crossorigin="anonymous"></script>

    <script>


        if($(window).width() >= 576){
            $(document).ready(function() {
            //parallax scroll
            $(window).on("load scroll", function() {
                var parallaxElement = $(".parallax"),
                parallaxQuantity = parallaxElement.length;
                window.requestAnimationFrame(function() {
                for (var i = 0; i < parallaxQuantity; i++) {
                    var currentElement = parallaxElement.eq(i),
                    windowTop = $(window).scrollTop(),
                    elementTop = currentElement.offset().top,
                    elementHeight = currentElement.height(),
                    viewPortHeight = window.innerHeight * 0.5 - elementHeight * 0.5,
                    scrolled = windowTop - elementTop + viewPortHeight;
                    currentElement.css({
                    transform: "translate3d(0," + scrolled * 0.55 + "px, 0)"
                    });
                }
                });
            });
            });
        }
       

            
    </script>
</body>
</html>