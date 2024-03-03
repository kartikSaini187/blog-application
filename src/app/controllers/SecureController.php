<?php

use Phalcon\Mvc\Controller;
use Phalcon\Acl\Adapter\Memory;




class SecureController extends Controller
{
    public function BuildACLAction( )
    {   
        $component = Components::find();

       $aclFile = APP_PATH.'/security/acl.cache';
       if(true !== is_file($aclFile)){

           $acl = new Memory();

           $acl->addRole('admin');
           $acl->addRole('user');
          foreach($component as $value){
         $acl->addComponent(
            $value->controller,
            [
                $value->action
            ]
            );
            if($value->role ="admin"){
             $acl->allow($value->role,'*','*');
            }
        
   }
   
   foreach ($component as $v){
       if($v->role != "admin"){
     
            $acl->allow($v->role,$v->controller,$v->action);
       }
   }
   

   file_put_contents(
       $aclFile,
       serialize($acl)
   );
}
     else{
      $acl= unserialize(
          file_get_contents($aclFile)
      );
      }
    }
}

?>