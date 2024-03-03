<?php

namespace App\Component;

use Phalcon\Di\Injectable;
use Phalcon\Translate\Adapter\NativeArray;
use Phalcon\Translate\InterpolatorFactory;
use Phalcon\Translate\TranslateFactory;

class Locale extends Injectable
{
    /**
     * @return NativeArray
     */
    public function getTranslator(): NativeArray
    {
        if(true === $this->cache->has('my-key')){
         $language = $this->cache->get('my-key');
        }
else{
    $language = "en";
} 
        if (isset($_POST['locale'])) {
          
            $locale = $this->request->getPost('locale');
            $this->cache->set('my-key', $locale);
            $language = $this->cache->get('my-key');
            
        }
      
        
        $messages = [];
       
        $translationFile = APP_PATH.'/messages/' . $language . '.php';

        if (true !== file_exists($translationFile)) {
            $translationFile = APP_PATH.'/messages/en.php';
        }
        
        require $translationFile;

        $interpolator = new InterpolatorFactory();
        $factory      = new TranslateFactory($interpolator);
        
        return $factory->newInstance(
            'array',
            [
                'content' => $messages,
            ]
        );
    }
}