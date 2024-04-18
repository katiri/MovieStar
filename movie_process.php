<?php
    require_once('globals.php');
    require_once('conection.php');
    require_once('models/Movie.php');
    require_once('models/Message.php');
    require_once('dao/MovieDAO.php');
    require_once('dao/UserDAO.php');

    $message = new Message($BASE_URL);

    $userDao = new UserDAO($conn, $BASE_URL);
    $movieDao = new MovieDAO($conn, $BASE_URL);

    $user = $userDao->verifyToken(true);

    // Resgata o tipo do formulário
    $type = filter_input(INPUT_POST, 'type');

    // Verifica o tipo de formulário
    if($type === 'create'){
        $title = filter_input(INPUT_POST, 'title');
        $length = filter_input(INPUT_POST, 'length');
        $category = filter_input(INPUT_POST, 'category');
        $trailer = filter_input(INPUT_POST, 'trailer');
        $description = filter_input(INPUT_POST, 'description');

        $movie = new Movie();

        // Validação mínima de dados
        if($title && $description && $category){
            $movie->title = $title;
            $movie->length = $length;
            $movie->category = $category;
            $movie->trailer = $trailer;
            $movie->description = $description;
            $movie->users_id = $user->id;

            // Upload da imagem
            if(isset($_FILES['image']) && !empty($_FILES['image']['tmp_name'])){
                $image = $_FILES['image'];
                
                $imageTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                
                // Checando tipo do arquivo
                if(in_array($image['type'], $imageTypes)){
                    if(in_array($image['type'], ['image/jpeg', 'image/jpg'])){
                        $imageFile = imagecreatefromjpeg($image['tmp_name']);
                    }
                    else{
                        $imageFile = imagecreatefrompng($image['tmp_name']);
                    }

                    $imageName = $movie->imageGenerateName();

                    imagejpeg($imageFile, './img/movies/' . $imageName, 100);

                    $movie->image = $imageName;
                }
                else{
                    $message->setMessage('Só é permitido o upload de imagens do tipo png, jpg e jpeg', 'danger', 'back');
                    exit;
                }
            }

            $movieDao->create($movie);
        }
        else{
            $message->setMessage('Você precisa preencher pelo menos: título, descrição e categoria', 'danger', 'back');
        }
    }
    else if($type === 'edit'){
        $id = filter_input(INPUT_POST, 'id');
        $title = filter_input(INPUT_POST, 'title');
        $length = filter_input(INPUT_POST, 'length');
        $category = filter_input(INPUT_POST, 'category');
        $trailer = filter_input(INPUT_POST, 'trailer');
        $description = filter_input(INPUT_POST, 'description');

        $movie = $movieDao->findById($id);

        if($movie){
            if($movie->users_id === $user->id){
                // Validação mínima de dados
                if($title && $description && $category){
                    $movie->title = $title;
                    $movie->length = $length;
                    $movie->category = $category;
                    $movie->trailer = $trailer;
                    $movie->description = $description;

                    // Upload da imagem
                    if(isset($_FILES['image']) && !empty($_FILES['image']['tmp_name'])){
                        $image = $_FILES['image'];
                        
                        $imageTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                        
                        // Checando tipo do arquivo
                        if(in_array($image['type'], $imageTypes)){
                            if(in_array($image['type'], ['image/jpeg', 'image/jpg'])){
                                $imageFile = imagecreatefromjpeg($image['tmp_name']);
                            }
                            else{
                                $imageFile = imagecreatefrompng($image['tmp_name']);
                            }

                            $imageName = $movie->imageGenerateName();

                            imagejpeg($imageFile, './img/movies/' . $imageName, 100);

                            if($movie->image){
                                unlink('./img/movies/' . $movie->image);
                            }

                            $movie->image = $imageName;
                        }
                        else{
                            $message->setMessage('Só é permitido o upload de imagens do tipo png, jpg e jpeg', 'danger', 'back');
                            exit;
                        }
                    }

                    $movieDao->update($movie);
                }
                else{
                    $message->setMessage('Você precisa preencher pelo menos: título, descrição e categoria', 'danger', 'back');
                }
            }
            else{
                $message->setMessage('Você não cadastrou esse filme e não pode apaga-lo', 'danger', 'dashboard.php');
            }
        }
        else{
            $message->setMessage('Filme não econtrado', 'danger', 'dashboard.php');
        }
    }
    else if($type === 'delete'){
        $id = filter_input(INPUT_POST, 'id');

        $movie = $movieDao->findById($id);

        if($movie){
            if($movie->users_id === $user->id){
                $movieDao->destroy($movie->id);

                if($movie->image){
                    unlink('./img/movies/' . $movie->image);
                }
            }
            else{
                $message->setMessage('Você não cadastrou esse filme e não pode apaga-lo', 'danger', 'dashboard.php');
            }
        }
        else{
            $message->setMessage('Filme não econtrado', 'danger', 'dashboard.php');
        }
    }
    else{
        $message->setMessage('Informações inválidas!', 'danger', 'index.php');
    }