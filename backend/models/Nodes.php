<?php
namespace backend\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class Nodes extends ActiveRecord
{
    public static function tableName()
    {
        return "node";
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function rules()
    {
        return [
            [["url", "msg", "pid"], "required"],
            ["url", "string", "max" => 20],
            ["url", "unique", "targetClass" => 'backend\models\Nodes', "message" => "该路由已存在", "filter" => function($model) {
                if ($this->url == "#") {
                    $model->where("0 = 1");
                }
            }],
            ["msg", "string", "max" => 100],
            ["pid", "number", ],
            ["is_show", "number", ],
            ["is_show", "default" , "value" => 1],
        ];
    }

    public function search()
    {
        $dataProvider = new ActiveDataProvider([
            "query" => static::find()
        ]);

        return $dataProvider;
    }

    public function add()
    {
        return $this->save(false);
    }

    public function edit()
    {
        return $this->save(false);
    }

    public function getPidArr()
    {
        //$ids = static::find()->select(["id", "msg"])->indexBy("id")->all();
        $ids = static::find()->select(["id", "msg"])->where(["pid" => 0])->all();
        $res = [];

        $res[null] = "请选择";
        $res[0] = "顶级分类";

        foreach ($ids as $k => $v) {
            $id = $v["id"];
            $res[$id] = $v["msg"];
        }

        return $res;
    }
}