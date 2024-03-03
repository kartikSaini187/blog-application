<?php
use Phalcon\Mvc\Controller;

class BlogController extends Controller
{

    public function indexAction()
    {
       
        
    }
    public function newblogAction(){
        
    }
    public function postblogAction(){
        $bearer=$this->request->get('bearer');
        $userid = $this->session->get('userid');
        $username = $this->session->get('username');
        $date = $this->config->get('app')->get('time');
        $blogs = new Blogs();
        $blogs->assign([
           'userid'=> $userid,
           'username'=>$username,
           'title'=>$this->request->getPost('title'),
           'details'=>$this->request->getPost('details'),
           'date'=>$date,
        
      ]);

      // Store and check for errors
      $success = $blogs->save();
      if($success){
          $this->response->redirect("../index?bearer=$bearer");
      }

    }
    public function readblogAction(){
       
        $blogid = $this->request->getPost('readblog');

        if(!$this->request->isPost()){
         $blogid=$this->session->get('bid');
        }
        $this->session->set('bid',$blogid);
        $bid = $this->session->get('bid');

        $this->view->blogs = Blogs::find("blogid = $bid");
        $this->view->comments = Comments::find("blogid = $bid");
    }
    public function commentAction(){
        $bearer=$this->request->get('bearer');
        $comment = $this->request->getPost('txtcomnt');
        $blogid = $this->request->getPost('btncomnt');
        $userid = $this->session->get('userid');
        $username = $this->session->get('username');
        $data = new Comments();
        $data->assign([
            'blogid'=>$blogid,
            'userid'=>$userid,
            'username'=>$username,
            'comment'=>$comment,
        ]);
        $success=$data->save();
        if($success){
            $this->response->redirect("blog/readblog?bearer=$bearer");
        }

    }
    public function likeAction(){
        $bearer=$this->request->get('bearer');
        $blogid = $this->request->getPost('btnlike');
        $username = $this->session->get('username');
        $data  = new Likes ();
   
        $like = Likes::findFirst(['conditions' => "blogid = '$blogid' AND username = '$username'"]);
        if($like){
            $like->delete();
            $this->response->redirect("index?bearer=$bearer");
        }
   else{
        $data->assign([
            'blogid' =>$blogid,
            'username'=>$username,
            'likes'=>1,
         ]);
        $success=  $data->save();
        if($success){
          $this->response->redirect("index?bearer=$bearer");
      }
    }
    }
}