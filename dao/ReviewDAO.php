<?php
    require_once('models/Message.php');
    require_once('models/Review.php');
    
    require_once('dao/UserDAO.php');

    class ReviewDAO implements ReviewDAOInterface{
        private $conn;
        private $url;
        private $message;

        public function __construct(PDO $conn, $url){
            $this->conn = $conn;
            $this->url = $url;
            $this->message = new Message($url);
        }

        public function buildReview($data){
            $reviewObject = new Review();

            $reviewObject->id = $data['id'];
            $reviewObject->rating = $data['rating'];
            $reviewObject->review = $data['review'];
            $reviewObject->users_id = $data['users_id'];
            $reviewObject->movies_id = $data['movies_id'];

            return $reviewObject;
        }

        public function create(Review $review){
            $stmt = $this->conn->prepare('INSERT INTO reviews 
                (rating, review, movies_id, users_id)
                VALUES
                (:rating, :review, :movies_id, :users_id)
            ');

            $stmt->bindParam(':rating', $review->rating);
            $stmt->bindParam(':review', $review->review);
            $stmt->bindParam(':movies_id', $review->movies_id);
            $stmt->bindParam(':users_id', $review->users_id);

            $stmt->execute();

            $this->message->setMessage('Comentário adicionado com sucesso!', 'success', 'back');
        }

        public function getMoviesReview($id){
            $reviews = [];

            $stmt = $this->conn->prepare('SELECT * FROM reviews WHERE movies_id = :movies_id');

            $stmt->bindParam(':movies_id', $id);

            $stmt->execute();

            if($stmt->rowCount() > 0){
                $reviewsArray = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $userDao = new UserDAO($this->conn, $this->url);

                foreach($reviewsArray as $review){
                    $reviewObject = $this->buildReview($review);

                    $user = $userDao->findById($reviewObject->users_id);

                    $reviewObject->user = $user;

                    $reviews[] = $reviewObject;
                }
            }

            return $reviews;
        }

        public function hasAlreadyReviewed($id, $users_id){
            $stmt = $this->conn->prepare('SELECT * FROM reviews WHERE movies_id = :movies_id AND users_id = :users_id');

            $stmt->bindParam(':movies_id', $id);
            $stmt->bindParam(':users_id', $users_id);

            $stmt->execute();

            if($stmt->rowCount() > 0){
                return true;
            }
            else{
                return false;
            }
        }

        public function getRatings($id){
            $stmt = $this->conn->prepare('SELECT * FROM reviews WHERE movies_id = :movies_id');

            $stmt->bindParam(':movies_id', $id);

            $stmt->execute();

            if($stmt->rowCount() > 0){
                $media = 0;

                $reviewsArray = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach($reviewsArray as $review){
                    $media += $review['rating'];
                }
                
                $media /= count($reviewsArray);
            }
            else{
                $media = 'Sem nota';
            }

            return $media;
        }
    }