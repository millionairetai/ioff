<?php

namespace common\components\helpers;

use Yii;
use yii\base\InvalidParamException;

class BaseHtml extends \yii\helpers\BaseHtml
{

    /**
     * Generates an appropriate input name angular for the specified attribute name or expression.
     *
     * This method generates a name that can be used as the input name to collect user input
     * for the specified attribute. The name is generated according to the [[Model::formName|form name]]
     * of the model and the given attribute name. For example, if the form name of the `Post` model
     * is `Post`, then the input name generated for the `content` attribute would be `Post.content`.
     *
     * See [[getAttributeName()]] for explanation of attribute expression.
     *
     * @param Model $model the model object
     * @param string $attribute the attribute name or expression
     * @return string the generated input name
     * @throws InvalidParamException if the attribute name contains non-word characters.
     */
    public static function getInputNameAngular($model, $attribute) {
        $formName = $model->formName();
        
        if (!preg_match('/(^|.*\])([\w\.]+)(\[.*|$)/', $attribute, $matches)) {
            throw new InvalidParamException('Attribute name must contain word characters only.');
        }
        
        $prefix = $matches[1];
        $attribute = $matches[2];
        $suffix = $matches[3];
        
        if ($formName === '' && $prefix === '') {
            return $attribute . $suffix;
        } elseif ($formName !== '') {
            return $formName . $prefix . ".$attribute" . $suffix;
        } else {
            throw new InvalidParamException(get_class($model) . '::formName() cannot be empty for tabular inputs.');
        }
    }
    
    public static function radio($name, $checked = false, $options = [], $nameAngular = null)
    {
        if (empty($options['ng-model'])) {
            $options['ng-model'] = $nameAngular;
        }
        
       return parent::radio($name, $checked, $options);
    }
    
    public static function checkbox($name, $checked = false, $options = [], $nameAngular = null)
    {
        if (empty($options['ng-model'])) {
            $options['ng-model'] = $nameAngular;
        }
        
        return parent::checkbox($name, $checked, $options);
    }
}