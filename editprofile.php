<?php
    require_once('templates/header.php');
    require_once('dao/UserDAO.php');

    $user = new User();
    $userDao = new UserDAO($conn, $BASE_URL);

    $userData = $userDao->verifyToken(true);

    $fullname = $user->getFullName($userData);
    $image = $user->getImage($userData);
?>
    <div id="main-container" class="container-fluid">
        <div class="col-md-12">
            <form action="<?= $BASE_URL ?>user_process.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="type" value="update">
                <div class="row">
                    <div class="col-md-4">
                        <h1><?= $fullname ?></h1>
                        <p class="page-description">Altere seus dados no formulário abaixo:</p>
                        <div class="form-group">
                            <label for="name">Nome:</label>
                            <input type="text" name="name" value="<?= $userData->name ?>" id="name" class="form-control" placeholder="Digite seu nome">
                        </div>
                        <div class="form-group">
                            <label for="lastname">Sobrenome:</label>
                            <input type="text" name="lastname" value="<?= $userData->lastname ?>" id="lastname" class="form-control" placeholder="Digite seu sobrenome">
                        </div>
                        <div class="form-group">
                            <label for="email">E-mail:</label>
                            <input type="text" readonly name="email" value="<?= $userData->email ?>" id="email" class="form-control disabled" placeholder="Digite seu sobrenome">
                        </div>
                        <input type="submit" value="Alterar" class="btn form-btn">
                    </div>
                    <div class="col-md-4">
                        <div id="profile-image-container" style="background-image: url('<?= $BASE_URL ?>img/users/<?= $image ?>');"></div>
                        <div class="form-group">
                            <label for="image">Foto:</label>
                            <input type="file" name="image" value="<?= $userData->image ?>" id="image" class="form-control-file">
                        </div>
                        <div class="form-group">
                            <label for="bio">Bio:</label>
                            <textarea name="bio" id="bio" rows="5" class="form-control" placeholder="Conte quem você é, o que faz e onde trabalha..."><?= $userData->bio ?></textarea>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php
    require_once('templates/footer.php');
?>