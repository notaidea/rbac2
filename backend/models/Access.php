<?php
namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use backend\models\Nodes;

class Access extends ActiveRecord
{
    public static function tableName()
    {
        return "access";
    }

    public function rules()
    {
        return [
            [["role_id", "node_id"], "required"],
            [["role_id", ], "number"],
            ["node_id", "each", "rule" => ["number"]]
        ];
    }

    public function getNodes()
    {
        $res = [];
        foreach (Nodes::find()->where([">", "pid", 0])->all() as $k => $v) {
            $id = $v["id"];
            $res[$id] = $v["msg"] . "-----" . $v["url"];
        }

        return $res;
    }

    public function add()
    {
        $bool = false;
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $tableName = static::tableName();
            $sql = "delete from {$tableName} where role_id = :role_id";
            Yii::$app->db->createCommand($sql, [":role_id" => $this->role_id])->execute();

            foreach ($this->node_id as $k => $v) {
                $model = new self();
                $model->node_id = $v;
                $model->role_id = $this->role_id;
                $model->save(false);
            }

            $transaction->commit();
        } catch(\Exception $e) {
            $transaction->rollBack();
        }
    }

    public function edit()
    {
        return $this->save(false);
    }
}