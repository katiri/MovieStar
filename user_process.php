<?php
    require_once('globals.php');
    require_once('conection.php');
    require_once('models/User.php');
    require_once('models/Message.php');
    require_once('dao/UserDAO.php');

    $message = new Message($BASE_URL);

    $userDao = new UserDAO($conn, $BASE_URL);

    // Resgata o tipo do formulário
    $type = filter_input(INPUT_POST, 'type');

    // Verifica o tipo de formulário
    if($type === 'update'){
        $name = filter_input(INPUT_POST, 'name');
        $lastname = filter_input(INPUT_POST, 'lastname');
        $email = filter_input(INPUT_POST, 'email');
        $bio = filter_input(INPUT_POST, 'bio');
        
        $user = $userDao->verifyToken();

        $user->name = $name;
        $user->lastname = $lastname;
        $user->email = $email;
        $user->bio = $bio;

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

                $imageName = $user->imageGenerateName();

                imagejpeg($imageFile, './img/users/' . $imageName, 100);

                if($user->image){
                    unlink('./img/users/' . $user->image);
                }

                $user->image = $imageName;
            }
            else{
                $message->setMessage('Só é permitido o upload de imagens do tipo png, jpg e jpeg', 'danger', 'back');
            }
        }

        $userDao->update($user, true);
    }
    else if($type === 'changepassword'){
        
    }
    else{
        $message->setMessage('Informações inválidas!', 'danger', 'index.php');
    }