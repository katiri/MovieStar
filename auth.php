<?php
    require_once('templates/header.php');
?>
    <div id="main-container" class="container-fluid">
        <div class="col-md-12">
            <div class="row" id="auth-row">
                <div class="col-md-4" id="login-container">
                    <h2>Entrar</h2>
                    <form action="" method="POST">
                        <input type="hidden" name="type" value="login">
                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="email" id="email" class="form-control" name="email" placeholder="Digite seu e-mail">
                        </div>
                        <div class="form-group">
                            <label for="password">Senha</label>
                            <input type="password" id="password" class="form-control" name="password" placeholder="Digite sua senha">
                        </div>
                        <input type="submit" class="btn card-btn" value="Entrar">
                    </form>
                </div>

                <div class="col-md-4" id="register-container">
                    <h2>Criar conta</h2>
                    <form action="" method="POST">
                        <input type="hidden" name="type" value="register">
                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="email" id="email" class="form-control" name="email" placeholder="Digite seu e-mail">
                        </div>
                        <div class="form-group">
                            <label for="name">Nome</label>
                            <input type="text" id="name" class="form-control" name="name" placeholder="Digite seu nome">
                        </div>
                        <div class="form-group">
                            <label for="lastname">Sobrenome</label>
                            <input type="text" id="lastname" class="form-control" name="lastname" placeholder="Digite seu sobrenome">
                        </div>
                        <div class="form-group">
                            <label for="password">Senha</label>
                            <input type="password" id="password" class="form-control" name="password" placeholder="Digite sua senha">
                        </div>
                        <div class="form-group">
                            <label for="confirmpassword">Confirmação de senha</label>
                            <input type="password" id="confirmpassword" class="form-control" name="confirmpassword" placeholder="Confirme sua senha">
                        </div>
                        <input type="submit" class="btn card-btn" value="Registrar">
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php
    require_once('templates/footer.php');
?>