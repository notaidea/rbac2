<?php
namespace backend\models;

use Yii;
use yii\db\ActiveRecord;

class Userrole extends ActiveRecord
{
    public static function tableName()
    {
        return "user_role";
    }

    public function rules()
    {
        return [
            [["user_id", "role_id", ], "required"],
            ["user_id", "number"],
            ["role_id", "each", "rule" => ["number"]],
        ];
    }

    public function add()
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $tableName = static::tableName();
            $sql = "delete from {$tableName} where user_id = :user_id";
            Yii::$app->db->createCommand($sql, [":user_id" => $this->user_id])->execute();

            foreach ($this->role_id as $k => $v) {
                $model = new self();
                $model->role_id = $v;
                $model->user_id = $this->user_id;
                $model->save(false);
            }

            $transaction->commit();
        } catch (\ErrorException $e) {
            $transaction->rollBack();
        }
    }

    public function getRoles($id)
    {
        return static::find()->where(["user_id" => $id])->asArray()->all();
    }
}