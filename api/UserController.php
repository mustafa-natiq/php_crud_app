<?php 

    // require_once '../envLoader.php';
    // require_once(__DIR__.'/envLoader.php');

    require_once('UserRepository.php');
    require_once('AlternativeUserRepository.php');

    class UserController {
        private $dbConnection;
        private $requestMethod;
        private $UserRepository;
        private $userId;

        public function __construct($id, $dbConnection, $requestMethod)
        {
            $current_env = $_SERVER['PROJECT_ENV'];

            $this->dbConnection = $dbConnection;
            $this->requestMethod = $requestMethod;
            $this->userId = $id;
            // $this->UserRepository = $current_env === 'test' ? new AlternativeUserRepository() : new UserRepository($this->dbConnection);
            $this->UserRepository =   new AlternativeUserRepository();
        }

        public function processRequest(){
            $response = null;

            switch($this->requestMethod){
                case 'GET':
                    $response = $this->getUsers();
                    break;
                case 'POST':
                    $response = $this->createUser();
                    break;
                case 'PUT':
                    $response = $this->updateUser($this->userId);
                    break;
                case 'DELETE':    
                    $response = $this->deleteUser($this->userId);
                    break;
                default:
                    $response = $this->notFoundResponse();
                    break;    
            }

            header($response['status_code_header']);
            return $response['body'];
        }

        private function getUsers() {
            $users = $this->UserRepository->findAll();
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode($users);
            return $response;
        }

        private function createUser(){
            $input = (array) json_decode(file_get_contents('php://input'), TRUE); 
            $message = $this->UserRepository->create($input);
            $response['status_code_header'] = 'HTTP/1.1 201 Created';
            $response['body'] = json_encode(array('message' => "$message"));
            return $response;
        }

        private function updateUser($id){
            $input = (array) json_decode(file_get_contents('php://input'), TRUE);
            $message = $this->UserRepository->update($id, $input);
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode(array('message' => "$message"));
            return $response;
        }

        private function deleteUser($id){
            $message = $this->UserRepository->delete($id);
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode(array('message' => "$message"));
            return $response;
        }

        private function notFoundResponse(){
            $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
            $response['body'] = null;
            return $response;
        }

    }