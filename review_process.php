<?php
    require_once('globals.php');
    require_once('conection.php');
    require_once('models/Movie.php');
    require_once('models/Review.php');
    require_once('models/Message.php');
    require_once('dao/MovieDAO.php');
    require_once('dao/UserDAO.php');
    require_once('dao/ReviewDAO.php');

    $message = new Message($BASE_URL);

    $userDao = new UserDAO($conn, $BASE_URL);
    $movieDao = new MovieDAO($conn, $BASE_URL);
    $reviewDao = new ReviewDAO($conn, $BASE_URL);

    $user = $userDao->verifyToken(true);

    // Resgata o tipo do formulário
    $type = filter_input(INPUT_POST, 'type');

    // Verifica o tipo de formulário
    if($type === 'create'){
        $rating = filter_input(INPUT_POST, 'rating');
        $review = filter_input(INPUT_POST, 'review');
        $movies_id = filter_input(INPUT_POST, 'movies_id');

        $reviewObject = new Review();

        $movie = $movieDao->findById($movies_id);

        if($movie){
            if($rating && $review && $movies_id){
                $reviewObject->rating = $rating;
                $reviewObject->review = $review;
                $reviewObject->movies_id = $movies_id;
                $reviewObject->users_id = $user->id;

                $reviewDao->create($reviewObject);
            }
            else{
                $message->setMessage('Você precisa inserir nota e comentário!', 'danger', 'back');
            }
        }
        else{
            $message->setMessage('O filme não foi encontrado', 'danger', 'index.php');
        }
    }
    else{
        $message->setMessage('Informações inválidas!', 'danger', 'index.php');
    }