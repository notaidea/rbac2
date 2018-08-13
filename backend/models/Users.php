<?php
namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\data\ActiveDataProvider;
use yii\behaviors\TimestampBehavior;

class Users extends ActiveRecord
{
    public static function tableName()
    {
        return "user";
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function search($params)
    {
        $dataProvider = new ActiveDataProvider([
            "query" => static::find()->where(["status" => 10]),
        ]);

        return $dataProvider;
    }

    public function rules()
    {
        return [
            [["username", "password_hash"], "required"],
            ["username", "string", "min" => 5, "max" => 20],
            ["password_hash", "string", "min" => 6, "max" => 20],
            [
                'username',
                'unique',
                'targetClass' => 'common\models\User',
                'message' => '用户名已存在.',
            ],
        ];
    }

    public function add()
    {
        //todo 使用场景
        $this->password_hash = Yii::$app->security->generatePasswordHash($this->password_hash);
        $this->auth_key = md5(Yii::$app->security->generateRandomString());
        $this->status = 10;

        return $this->save(false);
    }

    public function edit()
    {
        if ($this->password_hash && ($this->password_hash != "******")){
            $this->password_hash = Yii::$app->security->generatePasswordHash($this->password_hash);
        } else {
            $this->password_hash = $this->getOldAttribute("password_hash");
        }

        return $this->save(false);
    }
}