<?php
use Phalcon\Mvc\Controller;


class DashboardController extends Controller
{

    public function indexAction()
    {
        $this->view->users = Users::find(
            [
                'order' => 'id DESC',

                 ]
        );
        $this->view->blogs = Blogs::find(
            [
                'order' => 'blogid DESC',
                'limit'=> 3,
                 ]
        );
    }
    public function changeAction(){
        $changeid =  $_POST['btnchange'];
        $users = Users::findFirstByid($changeid);
         if($users->status=="Restricted"){
             $users->status = "Approved";
            $success= $users->save();
             
         }
         elseif($users->status=="Approved"){
            $users->status = "Restricted";
            $success= $users->save();
         }
         if($success){
            header("location:../dashboard");
         }
    }
   public function changebstatusAction(){
       $changeid = $_POST['bstatus'];
       $blogs = Blogs::findFirstByblogid($changeid);
       if($blogs->status=="Restricted"){
           $blogs->status="Approved";
           $success=$blogs->save();
       }
       elseif($blogs->status=="Approved"){
        $blogs->status="Restricted";
        $success=$blogs->save();
    }
    if($success){
        header("location:../dashboard");
     }
   }
   public function editblogAction(){
       $editid = $_POST['btnedit'];
       $this->view->blogs = Blogs::find("blogid = $editid");
       //return $editid; 
   }

   public function updateblogAction(){
       $updateid = $_POST['updateid'];
       $title = $_POST['title'];
       $desc = $_POST['details'];
       $blogs = Blogs::findFirstByblogid($updateid);
       $blogs->title = $title;
       $blogs->details = $desc;
       $success = $blogs->save();
       if($success){
        $this->response->redirect("../dashboard");
       }
   }
   public function deleteblogAction(){
       $deleteid = $_POST['deleteblog'];
       $blogs = Blogs::findFirstByblogid($deleteid);
       $success = $blogs->delete();
       if($success){
        $this->response->redirect("../dashboard");
       }
   }
   public function deleteuserAction(){
       $deluserid = $_POST['deleteuser'];
       $users = Users::find("id = $deluserid");
       $success = $users->delete();
       $blogs = Blogs::find("userid = $deluserid");
       $success1 = $blogs->delete();
       if($success && $success1){
        $this->response->redirect("../dashboard");
       }
   }
  
    
}

