<?php
namespace backend\components\db;

use backend\components\db\mysql\Schema;

class Connection extends \yii\db\Connection
{
    public function __construct($config = array()) {
        $this->schemaMap['mysql'] = 'backend\components\db\mysql\Schema';
        parent::__construct($config);
    }
}
