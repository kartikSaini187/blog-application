<?php


use Phalcon\Mvc\Controller;

use Firebase\JWT\JWT;




class LoginController extends Controller
{ 
    public function indexAction()
    {
        
        
    }
    public function signupAction()
    {
    }
    public function authAction()
    {
       
        $email = $this->request->getPost('email');
        $pass = $this->request->getPost('pass');
        
        $user =  Users::findFirst(['conditions' => "email = '$email' AND password = '$pass'"]);

        if ($user) {
            
            $key = "example_key";

            $payload = array(
                "iss" => "http://localhost:8080",
                "aud" => "http://localhost:8080",
                "iat" => 1356999524,
                "nbf" => 1357000000,
                "name"=>$user->name,
                "role"=>$user->role, 
            );
            $jwt = JWT::encode($payload, $key, 'HS256');
            

            $this->session->set('username',$user->name);
            $this->session->set("role",$user->role);
            $this->session->set('userid',$user->id);
            $this->logger->excludeAdapters(['signup'])->notice('Login By :-'.$user->name);
            $this->response->redirect("index?bearer=$jwt");

        }
        else{
            
            $this->view->user = $email;
            $this->logger->excludeAdapters(['signup'])->error('Login Attempt by :-'.$email);
        }
    }
    public function registerAction()
    { 
         $name = $this->request->getPost('name');
         $role = $this->request->getPost('role');
         $user = new Users();
         $user->assign([
            'name' => $name,
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'role' => $role,
            

        ]);

        $success = $user->save();
        if ($success) {
            $key = "example_key";

            $payload = array(
                "iss" => "http://localhost:8080",
                "aud" => "http://localhost:8080",
                "iat" => 1356999524,
                "nbf" => 1357000000,
                "name"=>$user->name,
                "role"=>$user->userrole, 
            );
            $jwt = JWT::encode($payload, $key, 'HS256');
            $this->session->set('username',$name);
            $this->response->redirect("index?bearer=$jwt");
            
        }else{
            $this->view->message = "Sorry, the following problems were generated:<br>"
                . implode('<br>', $user->getMessages());
            return $this->logger->excludeAdapters(['login'])->error(implode('<br>', $user->getMessages()));
        }
    }
    public function logoutAction(){
        $this->session->destroy();
        $this->response->redirect('../login');
    }
}