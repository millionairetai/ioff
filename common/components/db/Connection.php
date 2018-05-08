<?php
namespace common\components\db;

use common\components\db\mysql\Schema;

class Connection extends \yii\db\Connection
{
    public function __construct($config = array()) {
        $this->schemaMap['mysql'] = 'common\components\db\mysql\Schema';
        parent::__construct($config);
    }
}
