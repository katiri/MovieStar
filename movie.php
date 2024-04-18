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

    if($userData){
        $userOwnsMovie = $userData->id === $movie->users_id ? true : false;
        $alreadyReview = false;
    }
?>
    <div id="main-container" class="container-fluid">
        <div class="row">
            <div class="offset-md-1 col-md-6 movie-container">
                <h1 class="page-title"><?= $movie->title ?></h1>
                <p class="movie-details">
                    <span>Duração: <?= $movie->length ?></span>
                    <span class="pipe"></span>
                    <span><?= $movie->category ?></span>
                    <span class="pipe"></span>
                    <span><i class="fas fa-star"></i> 9</span>
                </p>
                <?php if($movie->getTrailer()): ?>
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/<?= $movie->getTrailer() ?>" title="<?= $movie->title ?> trailer player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                <?php endif; ?>
                <p><?= $movie->description ?></p>
            </div>
            <div class="col-md-4">
                <div class="movie-image-container" style="background-image: url('<?= $BASE_URL ?>img/movies/<?= $movie->getImage() ?>');"></div>
            </div>
            <div id="reviews-container" class="offset-md-1 col-md-10">
                <h3 id="reviews-title">Avaliações:</h3>
                <?php if($userData && !$userOwnsMovie && !$alreadyReview): ?>
                    <div id="review-form-container" class="col-md-12">
                        <h4>Envie sua avaliação:</h4>
                        <p class="page-description">Preencha o formulário com a nota e o comentário sobre o filme</p>
                        <form action="<?= $BASE_URL ?>review_process.php" method="post" id="review-form">
                            <input type="hidden" name="type" value="create">
                            <input type="hidden" name="movie_id" value="<?= $movie->id ?>">
                            <div class="form-group">
                                <label for="rating">Nota do filme:</label>
                                <select name="rating" id="rating" class="form-control">
                                    <option value="">Selecione</option>
                                    <option value="10">10</option>
                                    <option value="9">9</option>
                                    <option value="8">8</option>
                                    <option value="7">7</option>
                                    <option value="6">6</option>
                                    <option value="5">5</option>
                                    <option value="4">4</option>
                                    <option value="3">3</option>
                                    <option value="2">2</option>
                                    <option value="1">1</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="review">Seu comentário:</label>
                                <textarea name="review" id="review" rows="3" class="form-control"O que você achou do filme?></textarea>
                            </div>
                            <input type="submit" value="Enviar comentário" class="btn card-btn">
                        </form>
                    </div>
                <?php endif; ?>
                <div class="col-md-12 review">
                    <div class="row">
                        <div class="col-md-1 text-center">
                            <div class="profile-image-container review-image" style="background-image: url('<?= $BASE_URL ?>img/users/user.png');"></div>
                        </div>
                        <div class="col-md-9 author-details-container">
                            <h4 class="author-name">
                                <a href="#">João</a>
                            </h4>
                            <p><i class="fas fa-star"></i> 9</p>
                        </div>
                        <div class="col-md-12">
                            <p class="comment-title">Comentário:</p>
                            <p>Este é o comentário do usuário</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
    require_once('templates/footer.php');
?>