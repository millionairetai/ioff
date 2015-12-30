<?php

namespace common\components\db;

use yii\db\ActiveQuery;

class CeActiveQuery extends ActiveQuery
{
    public function active($state = true)
    {
//        return $this->andWhere(['active' => $state]);
    }
}
