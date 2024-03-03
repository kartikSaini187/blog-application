<?php

use Phalcon\Mvc\Model;

class Comments extends Model
{
    public $id;
    public $blogid;
    public $userid;
    public $username;
    public $comment;
  
}