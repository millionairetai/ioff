<?php

namespace common\components\db;


class ActiveQuery extends \yii\db\ActiveQuery
{
    /**
     * Adds an additional of company_id WHERE condition to the existing one.
     * The new condition and the existing one will be joined using the 'AND' operator.
     * @param int $companyId the new WHERE condition. Please refer to [[where()]]
     * on how to specify this parameter.
     * @return $this the query object itself
     * @see where()
     * @see orWhere()
     */
    public function andCompanyId($companyId = false)
    {
        if (!$companyId) {
            return $this->andWhere(['company_id' => \Yii::$app->user->getCompanyId()]);
        }
        
        return $this->andWhere(['company_id' => $companyId]);
    }
}
