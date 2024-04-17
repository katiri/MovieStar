<?php
    require_once('templates/header.php');
    require_once('dao/UserDAO.php');

    $userDao = new UserDAO($conn, $BASE_URL);

    $userData = $userDao->verifyToken(true);
?>
    <div id="main-container" class="container-fluid">
        <h2 class="section-title">Dashboard</h2>
        <p class="section-description">Adicione ou atualize as informações dos filmes que você enviou</p>
        <div id="add-movie-container" class="col-md-12">
            <a href="<?= $BASE_URL ?>newmovie.php" class="btn card-btn">
                <i class="fas fa-plus"></i> Adicionar filme
            </a>
        </div>
        <div id="movies-dashboard" class="col-md-12">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Título</th>
                        <th scope="col">Nota</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td scope="row">1</td>
                        <td><a href="#" class="table-movie-title">Título</a></td>
                        <td><i class="fas fa-star"></i> 9</td>
                        <td class="actions-column">
                            <a href="#" class="edit-btn"><i class="far fa-edit"></i> Editar</a>
                            <form action="">
                                <button type="submit" class="delete-btn">
                                    <i class="fas fa-times"></i> Deletar
                                </button>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
<?php
    require_once('templates/footer.php');
?>