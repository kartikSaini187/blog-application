<?php


use Phalcon\Mvc\Controller;




class IndexController extends Controller
{ 
    public function indexAction()
    {
        
         $this->view->user = $this->session->get('username');
         $this->view->blogs = Blogs::find(
            [
             'order' => 'blogid DESC'
              ]);
             
              $username = $this->session->get('username');
             
          
    }
    
   
}
