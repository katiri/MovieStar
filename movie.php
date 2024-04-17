<?php
    require_once('templates/header.php');
    require_once('models/Message.php');
    require_once('dao/UserDAO.php');
    require_once('dao/MovieDAO.php');

    $message = new Message($BASE_URL);

    $userDao = new UserDAO($conn, $BASE_URL);
    $movieDao = new MovieDAO($conn, $BASE_URL);

    $userData = $userDao->verifyToken(false);

    $id = filter_input(INPUT_GET, 'id');

    if(!empty($id)){
        $movie = $movieDao->findById($id);

        if(!$movie){
            $message->setMessage('O filme não foi encontrado', 'danger', 'index.php');
            exit;
        }
    }
    else{
        $message->setMessage('O filme não foi encontrado', 'danger', 'index.php');
    }

    $userOwnsMovie = true ? $userData->id === $movie->users_id : false;
?>
    <div id="main-container" class="container-fluid">
        
    </div>
<?php
    require_once('templates/footer.php');
?>