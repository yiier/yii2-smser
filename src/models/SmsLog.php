<?php

namespace yiier\smser\models;


/**
 * This is the model class for table "{{%sms_log}}".
 *
 * @property int $id
 * @property string $phone 手机号
 * @property string $usage 用途
 * @property string $platform 发送平台
 * @property int $code 验证码
 * @property string $content 短信内容
 * @property string $result 短信结果json
 * @property int $status 状态 0未使用
 * @property int $expired_at 过期时间戳
 * @property int $created_at 发送时间戳
 * @property int $updated_at 使用时间戳
 */
class SmsLog extends \yii\db\ActiveRecord
{
    /**
     * @var integer 未用
     */
    const STATUS_TODO = 0;

    /**
     * @var integer 用过
     */
    const STATUS_DID = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sms_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phone'], 'required'],
            [['code', 'status', 'expired_at', 'created_at', 'updated_at'], 'integer'],
            ['phone', 'filter', 'filter' => 'trim'],
            ['phone', 'match', 'pattern' => '/^1[34578][0-9]{9}$/', 'message' => '请输入正确的手机号'],
            [['usage', 'platform'], 'string', 'max' => 20],
            [['content', 'result'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'phone' => '手机号',
            'usage' => '用途',
            'platform' => '发送平台',
            'code' => '验证码',
            'content' => '短信内容',
            'result' => '短信结果json',
            'status' => '状态 0未使用',
            'expired_at' => '过期时间戳',
            'created_at' => '发送时间戳',
            'updated_at' => '使用时间戳',
        ];
    }

    /**
     * 验证码标记为已使用
     * @param $phone
     * @param $code
     */
    public static function used($phone, $code)
    {
        self::updateAll(['status' => self::STATUS_DID, 'updated_at' => time()], ['phone' => $phone, 'code' => $code]);
    }
}