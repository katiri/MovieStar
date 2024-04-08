<?php
    require_once('globals.php');
    require_once('conection.php');
?>
<!DOCTYPE html>
<html lang="pt-br">
     <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MovieStar</title>

        <link rel="short icon" href="<?= $BASE_URL ?>img/moviestar.ico">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/css/bootstrap.css" integrity="sha512-nC+a1/agL6/Btk2NLY0uRsdrXxibJlYKsBhbIPKFMnVqPRtOyw1M0wd1VNPeUYjHT8YTwTNihxo/DzP++k16xQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- CSS -->
        <link rel="stylesheet" href="<?= $BASE_URL ?>css/styles.css">        
    </head>
    <body>
        <header>
            <nav id="main-navbar" class="navbar navbar-expand-lg">
                <a href="<?= $BASE_URL ?>" class="navbar-brand">
                    <img src="<?= $BASE_URL ?>img/logo.svg" alt="MovieStar" id="logo">
                    <span id="moviestar-title">MovieStar</span>
                </a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>

                <form action="" method="GET" id="search-form" class="form-inline my-2 my-lg-0">
                    <input type="search" name="q" id="search" class="form-control mr-sm-2" placeholder="Buscar filmes" aria-label="Search">
                    <button class="btn my-2 my-sm-0">
                        <i class="fas fa-search"></i>
                    </button>
                </form>

                <div class="collapse navbar-collapse" id="navbar">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a href="<?= $BASE_URL ?>auth.php" class="nav-link">Entrar/Cadastrar</a></li>
                    </ul>
                </div>
            </nav>
        </header>