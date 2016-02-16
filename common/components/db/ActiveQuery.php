<?php

namespace common\components\db;


class ActiveQuery extends \yii\db\ActiveQuery
{
    public function active($state = true)
    {
//        return $this->andWhere(['active' => $state]);
    }
}
