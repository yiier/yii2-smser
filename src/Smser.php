<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 2018/1/23 14:04
 * description:
 */

namespace yiier\smser;

use Overtrue\EasySms\EasySms;
use yii\base\Component;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yiier\smser\models\SmsLog;

class Smser extends Component
{
    /**
     * @var int 验证码过期时间，默认是10分钟
     */
    public $expire = 600;

    /**
     * @var
     */
    public $config = [];

    /**
     * @var EasySms
     */
    private $easySms;

    public function init()
    {
        $defaultConfig = [
            'default' => [
                'gateways' => array_keys(ArrayHelper::getValue($this->config, 'gateways'))
            ]
        ];

        $this->easySms = new EasySms(array_merge($defaultConfig, $this->config));
    }

    /**
     * @param $to
     * @param $message
     * @param array $gateways
     * @return boolean
     */
    public function send($to, $message, array $gateways = [])
    {
        try {
            $results = $this->easySms->send($to, $message, $gateways);
            foreach ($results as $key => $result) {
                if (ArrayHelper::getValue($result, 'status') == 'success') {
                    $item = ['platform' => $key, 'phone' => $to, 'result' => json_encode($result['result'])];
                    $this->saveSmsLog(array_merge($item, $message));
                }
            }
            return true;
        } catch (\Exception $e) {
            \Yii::error($e, '短信发送失败');
            return false;
        }
    }

    /**
     * @param $message
     * @return bool
     * @throws Exception
     */
    private function saveSmsLog($message)
    {
        $model = new SmsLog();
        $time = time();
        $item = ['expired_at' => $time + $this->expire, 'created_at' => $time, 'updated_at' => $time];
        $model->load(array_merge($message, ArrayHelper::getValue($message, 'data'), $item), '');
        if (!$model->save()) {
            throw new Exception(json_encode($model->errors));
        }
    }
}