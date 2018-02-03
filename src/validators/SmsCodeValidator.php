<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 2018/1/22 18:52
 * description:
 */

namespace yiier\smser\validators;

use yii\validators\Validator;
use yiier\smser\models\SmsLog;

class SmsCodeValidator extends Validator
{
    /**
     * 用途【可选参数】
     * @var string
     */
    public $usage = null;

    /**
     * 手机号字段名称【可选参数】
     * @var string
     */
    public $phoneAttribute = 'phone';

    /**
     * @param \yii\base\Model $model
     * @param string $attribute
     */
    public function validateAttribute($model, $attribute)
    {
        $phone = $model->{$this->phoneAttribute};
        $smsLog = SmsLog::find()
            ->filterWhere(['phone' => $phone, 'code' => $model->$attribute, 'usage' => $this->usage, 'status' => SmsLog::STATUS_TODO])
            ->andWhere(['>=', 'expired_at', time()])
            ->orderBy('created_at DESC')
            ->count('id');

        if (!$smsLog) {
            $this->addError($model, $attribute, '验证码有误');
        }
    }
}