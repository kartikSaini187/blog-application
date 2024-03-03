<?php


use Phalcon\Mvc\Controller;

class SettingsController extends Controller
{
    public function indexAction()
    {
      $this->view->settings = Settings::find();
    }
    public function changetagAction(){
        $tag = $this->request->getPost('title');
         $settings = Settings::findFirstBysid(1);
         $settings->title_opt = $tag;
        $succes= $settings->save();
        if($succes){
            $this->response->redirect('settings');
        }

    }
   

}