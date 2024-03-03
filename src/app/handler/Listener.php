<?php
namespace App\Handler;

use Orders;
use Phalcon\Events\Event;
use Products;
use Settings;

class Listener{

    public function productsave(){
         $settings = Settings::findFirstBysid(1);
        $products = Products::findFirst(['order' => 'id DESC']);
         if($products->price == 0){
     
            $products->price = $settings->default_price;
         }
         if ($products->stock == 0){
             $products->stock = $settings->default_stock;
         }
         if($settings->title_opt=='with'){
             
             $products->name = $products->tags." + ".$products->name;
         }
         $products->save();  
    }
    public function ordersave(){
        $settings = Settings::findFirstBysid(1);
        $order = Orders::findFirst(['order'=>'order_id']);
        if($order->zipcode == 0){
            $order->zipcode = $settings->default_zip;
        }
        $order->save();
    }

}