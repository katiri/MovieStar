<?php
    class Movie{
        public $id;
        public $title;
        public $description;
        public $image;
        public $trailer;
        public $category;
        public $length;
        public $users_id;

        public function getTrailer(){
            if($this->trailer){
                if(strpos($this->trailer, '?v=') && strpos($this->trailer, 'youtube')){
                    return explode('?v=', $this->trailer)[1];
                }
                else{
                    return false;
                }
            }
            else{
                return false;
            }
        }

        public function getImage(){
            return $this->image ? $this->image : 'movie_cover.jpg';
        }

        public function imageGenerateName(){
            return bin2hex(random_bytes(60)) . '.jpg';
        }
    }

    interface MovieDAOInterface {
        public function buildMovie($data);
        public function findAll();
        public function getLatestMovies();
        public function getMoviesByCategory($category);
        public function getMoviesByUserId($id);
        public function findById($id);
        public function findByTitle($title);
        public function create(Movie $movie);
        public function update(Movie $movie);
        public function destroy($id);
    }