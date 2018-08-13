<?php
namespace backend\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use backend\models\Nodes;
use backend\models\Access;

class Roles extends ActiveRecord
{
    public static function tableName()
    {
        return "role";
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
            [["name", ], "required"],
            ["name", "string", "max" => 20],
            ["name", "unique", "targetClass" => 'backend\models\Roles', "message" => "该角色已存在"],
            ["msg", "string", "max" => 100],
        ];
    }

    public function search()
    {
        $dataProvider = new ActiveDataProvider([
            "query" => static::find()
        ]);

        return $dataProvider;
    }

    public function getNodes()
    {
        //todo 使用viatables
        $access = Access::find()->select(["node_id"])->where(["role_id" => $this->id])->all();
        $res = [];

        foreach ($access as $k => $v) {
            $res[] = Nodes::find()->where(["id" => $v->node_id])->one();
        }

        return $res;
    }

    public function add()
    {
        return $this->save(false);
    }

    public function edit()
    {
        return $this->save(false);
    }

    public function getRolesOpt()
    {
        $res = [];

        foreach (static::find()->all() as $k => $v) {
            $id = $v["id"];
            $res[$id] = $v["name"];
        }

        return $res;
    }
}