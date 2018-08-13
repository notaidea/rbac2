<?php
namespace common\models;

use Yii;
use backend\models\Nodes;

class AccessMenu
{
    public static function getMenu()
    {
        if (!Yii::$app->user->identity) {
            return [];
        }

        $id = Yii::$app->user->identity->getId();

        //超级用户
        if ($id == 1) {
            $data = Nodes::find()->where(["is_show" => 1])->asArray()->orderBy("pid")->all();

            return static::formater($data);
        }

        $sql = "select node.* from node left join access on node.id = access.node_id left join user_role on user_role.role_id = access.role_id where user_role.user_id = {$id} order by node.pid";
        $data = Yii::$app->db->createCommand($sql)->queryAll();

        return static::formater($data);
    }

    /*
    public static function formater($data)
    {
        $res = [];

        foreach ($data as $k => $v) {
            $key = ['label' => $v["msg"], 'icon' => '', 'url' => [$v["url"]]];
            $res[] = $key;
        }

        return $res;
    }
    */
    public static function formater($data)
    {
        $res = [];
        $topArr = [];
        $subArr = [];

        foreach ($data as $k => $v) {
            if ($v["pid"] == 0) {
                $topArr[] = $v;
            } else {
                $subArr[] = $v;
            }
        }

        foreach ($topArr as $k => $v) {
            foreach ($subArr as $k2 => $v2) {
                if ($v["id"] == $v2["pid"]) {
                    $key = [
                        'label' => $v2["msg"],
                        'icon' => '',
                        'url' => [$v2["url"]],
                    ];
                    $topArr[$k]["items"][] = $key;
                }
            }
        }

        $return = [];
        $return = $topArr ? $topArr : $subArr;

        foreach ($return as $k => $v) {
            $key = [
                'label' => $v["msg"],
                'icon' => '',
                'url' => [$v["url"]],
                'items' => isset($v["items"]) ? $v["items"] : [],
            ];

            $res[] = $key;
        }

        return $res;
    }
}