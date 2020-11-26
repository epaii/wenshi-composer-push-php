<?php
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2019/7/16
 * Time: 9:48 AM
 */

namespace epii\http;

class http
{

    public static function postJson($api, $data, callable $curlSet = null)
    {

        if (is_array($data)) {
            $data = json_encode($data, JSON_UNESCAPED_UNICODE);
        }
        return self::post($api, $data, function ($ch) use ($data, $curlSet) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($data)));
            if ($curlSet) {
                $curlSet($ch);
            }
        });
    }

    public static function post($api, $data, callable $curlSet = null)
    {
        //初使化init方法
        $ch = curl_init();

        //指定URL
        curl_setopt($ch, CURLOPT_URL, $api);

        //设定请求后返回结果
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        //声明使用POST方式来进行发送
        curl_setopt($ch, CURLOPT_POST, 1);

        //发送什么数据呢
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);


        //忽略证书
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        //忽略header头信息
        curl_setopt($ch, CURLOPT_HEADER, 0);

        //设置超时时间
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        if ($curlSet) {
            $curlSet($ch);
        }

        //发送请求
        $output = curl_exec($ch);

        //关闭curl
        curl_close($ch);

        //返回数据
        return $output;

    }
}