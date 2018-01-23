sms for Yii2
============
sms for Yii2

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist yiier/yii2-smser "*"
```

or add

```
"yiier/yii2-smser": "*"
```

to the require section of your `composer.json` file.


Migrations
-----------

Run the following command

```shell
$ php yii migrate --migrationPath=@yiier/smser/migrations/
```

Usage
-----

Once the extension is installed, simply modify your application configuration as follows:

```php
<?php
return [
    // something code
    'components' => [
        'smser' => [
            'class' => 'yiier\smser\Smser',
            'config' => [
                'gateways' => [
                    // 云片网
                    'yunpian' => [
                        'api_key' => 'xxxxxxxxxxxxxxxxxxxxxxxxx',
                    ],
                ],
            ]
        ]
    ]
];
```

More detail [overtrue/easy-sms 使用](https://github.com/overtrue/easy-sms#%E4%BD%BF%E7%94%A8)


Validator

```php
<?php
class SignupForm extends yii\base\Model
{
    // something code
    public $verifyCode;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // something code
            // usage is Optional
            ['verifyCode', '\yiier\smser\validators\SmsCodeValidator', 'usage' => 'Signup'],
        ];
    }
}
```

send code && update code status 

```php
<?php
// send code
Yii::$app->smser->send(18688888888, [
    'content'  => '您的验证码为: 1234',
    'template' => 'SMS_001',
    'data' => ['code' => 1234],
]);

// update used status 
\yiier\smser\models\SmsLog::used(18688888888, 1234);
```