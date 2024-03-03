<?php


use Phalcon\Mvc\Controller;



class ComponentController extends Controller
{
    public function indexAction( )
    {
        $this->view->components = Components::find();
       
    }
    public function newroleAction(){
      $role = $this->request->getPost('user');
      $component = new Components();
      $component->assign([
        'role'=>$role,
        'controller'=>'index',
        'action'=>'index'
      ]);
      $success= $component->save();
      if($success){
         $this->response->redirect('../component');
      }
      
    }
    public function changecomponentAction(){
      $action = $this->request->getPost('action');
      $controller = $this->request->getPost('controller');
      $cid= $this->request->getPost('btnedit');
      
       $component = Components::findFirstBycid($cid);
       
       $component->controller = $controller;
       $component->action=$action;
       $success= $component->save();
      if($success){
        $this->response->redirect('./component');
     }
    }
}

?>