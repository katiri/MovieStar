<?php
    require_once('templates/header.php');
    require_once('models/User.php');
    require_once('dao/UserDAO.php');
    require_once('dao/MovieDAO.php');

    $userDao = new UserDAO($conn, $BASE_URL);

    $id = filter_input(INPUT_GET, 'id');

    if(!empty($id)){
        $user = $userDao->findById($id);

        if(!$user){
            $message->setMessage('O usuário não foi encontrado', 'danger', 'index.php');
            exit;
        }
    }
    else{
        $message->setMessage('O usuário não foi encontrado', 'danger', 'index.php');
    }

    $movieDao = new MovieDAO($conn, $BASE_URL);

    $userMovies = $movieDao->getMoviesByUserId($user->id);
?>
    <div id="main-container" class="container-fluid">
        <div class="col-md-8 offset-md-2">
            <div class="row profile-container">
                <div class="col-md-12 about-container">
                    <h1 class="page-title"><?= $user->getFullName() ?></h1>
                    <div id="profile-image-container" class="profile-image" style="background-image: url('<?= $BASE_URL ?>img/users/<?= $user->getImage() ?>');"></div>
                    <h3 class="about-title">Sobre:</h3>
                    <?php if (!empty($user->bio)): ?>
                        <p class="profile-description"><?= $user->bio ?></p>
                    <?php else: ?>
                        <p class="profile-description">O usuário ainda não escreveu nada aqui...</p>
                    <?php endif; ?>
                </div>
                <div class="col-md-12 added-movies-container">
                    <h3>Filmes que enviou:</h3>
                    <div class="movies-container">
                        <?php foreach($userMovies as $movie): ?>
                            <?php require('templates/movie_card.php'); ?>
                        <?php endforeach; ?>        
                        <?php if(count($userMovies) == 0): ?>
                            <p class="empty-list">O usuário ainda não enviou nehum filme</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
    require_once('templates/footer.php');
?>