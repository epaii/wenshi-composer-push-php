<?php

namespace wenshi\push;

 
class PushConfig
{
    public static function new():PushConfig{
        return new PushConfig();
    }
    private $data = [];
    public function set_offlineExpireTime($value):PushConfig{
        $this->data['offlineExpireTime']=$value;
        return $this;
    }
    public function set_img($value):PushConfig{
        $this->data['img']=$value;
        return $this;
    }
    public function data():array{
        return ["notice_config"=>$this->data];
    }
}