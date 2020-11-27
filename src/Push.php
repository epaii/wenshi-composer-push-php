<?php

namespace wenshi\push;

use epii\http\http;

class Push
{

    private static $PUSH_URL = "http://pushnotice.wszx.cc/api.php?app=";

    protected static $_sign;
    private static $emsg = "";

    public static function init($sign, $url = null)
    {
        self::$_sign = $sign;
        if ($url) {
            self::$PUSH_URL = $url;
        }

    }
    /*
     * 注册CID(如果存在直接修改)
     *@param  uid 用户ID
     *@param  cid
     **/
    public static function bind($uid, $cid)
    {
        return self::doPush(['uid' => $uid, 'cid' => $cid], 'push@bind');
    }

    /*
     * 退出关闭
     *@param   uid 用户ID
     * @param  cid
     * */
    public static function unbind($uid, $cid)
    {
        return self::doPush(['uid' => $uid, 'cid' => $cid], 'push@unbind');
    }

    /*
     * 发送多条或者一条信息
     *
     * uid  用户uid(多个已逗号隔开)
     * title 发送的标题
     * content  发送的内容
     * data 参数[]
     * */

    public static function push($uids, $title, $content, $data = [])
    {
        return self::__push($uids, 0, $title, $content, $data);
    }
    public static function pushByCids($cids, $title, $content, $data = [])
    {
        return self::__push($cids, 1, $title, $content, $data);
    }

    private static function __push($ids, $is_cid, $title, $content, $data)
    {
        if (!isset($data["notice_config"])) {
            $data["notice_config"] = [];
        }
        $data["notice_config"] = array_merge(["title" => $title, "content" => $content],$data["notice_config"]);
        $data = [
            'uids' => $ids,
            'title' => $title,
            'content' => $content,
            'is_cid' => $is_cid,
            'data' => json_encode($data),
        ];
        return self::doPush($data, 'push@push');
    }

    /*
     * 发送全部
     * title 发送的标题
     * content  发送的内容
     * data 参数[]
     *
     * */
    public static function pushToApp($title, $content, $data = [])
    {
        if (!isset($data["notice_config"])) {
            $data["notice_config"] = [];
        }
        $data["notice_config"] = array_merge(["title" => $title, "content" => $content],$data["notice_config"]);

        $data = [
            'title' => $title,
            'content' => $content,
            'data' => json_encode($data),
        ];
        return self::doPush($data, 'push@pushToApp');
    }

    protected static function doPush($data, $route)
    {

        $data['sign'] = self::$_sign;
        $body = http::post(self::$PUSH_URL . $route, $data);
        // var_dump($body);
        $request = json_decode($body, true);

        if ($request['code'] == '1') {
            self::$emsg = "";
            return true;
        } else {
            self::$emsg = $request["msg"];
            // var_dump($request);
            return false;
        }
    }
    public static function getErrorMsg()
    {
        return self::$emsg;
    }

}
