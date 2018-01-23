<?php

use yii\db\Migration;

/**
 * Class m180122_101348_create_sms_log
 */
class m180122_101348_create_sms_log extends Migration
{
    /**
     * @var string 短信日志表
     */
    public $tableName = '{{%sms_log}}';

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'phone' => $this->string(11)->notNull()->comment('手机号'),
            'usage' => $this->string(20)->defaultValue(null)->comment('用途'),
            'platform' => $this->string(20)->defaultValue(null)->comment('发送平台'),
            'code' => $this->integer(10)->defaultValue(null)->comment('验证码'),
            'content' => $this->string()->defaultValue(null)->comment('短信内容'),
            'result' => $this->string()->defaultValue(null)->comment('短信结果json'),
            'status' => $this->smallInteger()->notNull()->defaultValue(0)->comment('状态 0未使用'),

            'expired_at' => $this->integer()->defaultValue(null)->comment('过期时间戳'),
            'created_at' => $this->integer()->defaultValue(null)->comment('发送时间戳'),
            'updated_at' => $this->integer()->defaultValue(null)->comment('使用时间戳'),
        ]);
        $this->addCommentOnTable($this->tableName, '短信日志表');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable($this->tableName);
    }
}
