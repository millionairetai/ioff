<?php

namespace common\components\db;

use yii\db\ActiveRecord;

class CeActivieRecord extends ActiveRecord
{
    public static function find()
    {
        return new CommentQuery(get_called_class());
    }
}