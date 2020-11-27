<?php

namespace wenshi\push;

class PushData
{
    public static function alert($content, $onok = "", $title = "提示")
    {
            return ["cmd"=>"alert","content"=>$content,"title"=>$title,"onok"=>$onok];
    }
    public static function confirm($content, $onok = "", $title = "提示")
    {
        return ["cmd"=>"confirm","content"=>$content,"title"=>$title,"onok"=>$onok];
    }
    public static function fun($name, $args = [])
    {
        return ["cmd"=>"function","name"=>$name,"args"=>$args];

    }
    public static function url($url)
    {
        return ["cmd"=>"url","name"=>$url];
    }
    public static function dialog($name)
    {
        return ["cmd"=>"dialog","name"=>$name];
    }
    public static function merge(...$args){
       return  array_merge(...$args);
    }
}
