<?php
namespace App\Handler;

use Phalcon\Mvc\Dispatcher;
use Phalcon\Events\Event;
use App\Component\Locale;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


class NotificationListener{
 
    public function beforeHandleRequest(Event $event , \Phalcon\Mvc\Application $application , Dispatcher $containerspatcher){
        
        
        $aclFile = APP_PATH.'/security/acl.cache';
        if(true === is_file($aclFile)){
            
            $acl = unserialize(
                file_get_contents($aclFile) 
            );
            
           $jwt = $application->request->get('bearer');
           if($jwt){
               try{
                $key = "example_key";
                $decoded = JWT::decode($jwt, new Key($key, 'HS256'));

                $role = $decoded->role;
                   
                 }
                catch(\Exception $e){
                echo $e->getMessage();
                die;
               }
           
            $controller = $containerspatcher->getControllerName();
            $action     = $containerspatcher->getActionName();
            if(!$action){
                $action="index";
            }
            if( !$role || true !== $acl->isAllowed($role,$controller,$action)){
                $locale = new Locale();
                $p = $locale->getTranslator();
                echo $p->_('access denied');
                die;
            }
        }else{
            // echo "token is not Provied";
            // die;
        }
            
        }
        else{
               echo "can't find any acl file";
              die; 
        }
        
       
    }

}