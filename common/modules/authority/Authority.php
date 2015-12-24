<?php

namespace common\modules\authority;

use Yii;

class Authority extends \yii\base\Module {

    public $controllerNamespace = 'common\modules\authority\controllers';

    public function init() {
        parent::init();
        $this->registerTranslations();
    }

    public function registerTranslations() {
        Yii::$app->i18n->translations['authority*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'forceTranslation' => true,
            'basePath' => '@common/modules/authority/messages',
            'fileMap' => [
                'modules/authority' => 'authority.php'
            ],
        ];
    }
}
