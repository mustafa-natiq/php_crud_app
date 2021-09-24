<?php 

    namespace Api;
  

    require_once(__DIR__.'../../envLoader.php');
    use Api\UserRepository;
    use Api\AlternativeUserRepository;
    use Exception;

    class UserController {
        public $dbConnection;
        public $requestMethod;
        public $UserRepository;
        public $userId;

        public function __construct($id, $dbConnection, $requestMethod)
        {
            $current_env = $_SERVER['PROJECT_ENV'];

            $this->dbConnection = $dbConnection;
            $this->requestMethod = $requestMethod;
            $this->userId = $id;
            $this->UserRepository = $current_env === 'test' ? new AlternativeUserRepository() : new UserRepository($this->dbConnection);
        }

        public function processRequest(){
            $response = null;

            switch($this->requestMethod){
                case 'GET':
                    $response = $this->getUsers();
                    break;
                case 'POST':
                    $response = $this->createUser([]);
                    break;
                case 'PATCH':
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

        public function getUsers() {
            $users = $this->UserRepository->findAll();
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode($users);
            return $response;
        }

        public function createUser($mockInput){
            $current_env = $_SERVER['PROJECT_ENV'];

            $input = $current_env === 'test' ? $mockInput : (array) json_decode(file_get_contents('php://input'), TRUE); 
            $message = $this->UserRepository->create($input);
            $response['status_code_header'] = 'HTTP/1.1 201 Created';
            $response['body'] = json_encode(array('message' => "$message"));
            return $response;
        }

        public function updateUser($id, $mockInput = null){
            $current_env = $_SERVER['PROJECT_ENV'];

            $input = $current_env === 'test' ? $mockInput : (array) json_decode(file_get_contents('php://input'), TRUE); 
            $message = $this->UserRepository->update($id, $input);
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode(array('message' => "$message"));
            return $response;
        }

        public function deleteUser($id){
            $message = $this->UserRepository->delete($id);
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode(array('message' => "$message"));
            return $response;
        }

        public function notFoundResponse(){
            $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
            $response['body'] = null;
            return $response;
        }

    }