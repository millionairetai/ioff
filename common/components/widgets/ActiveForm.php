<?php

namespace common\components\widgets;

use Yii;
use yii\base\InvalidConfigException;
use common\components\helpers\BaseHtml;

/**
 * A Bootstrap 3 enhanced version of [[\yii\widgets\ActiveForm]].
 *
 * This class mainly adds the [[layout]] property to choose a Bootstrap 3 form layout.
 * So for example to render a horizontal form you would:
 *
 * ```php
 * use yii\bootstrap\ActiveForm;
 *
 * $form = ActiveForm::begin(['layout' => 'horizontal'])
 * ```
 *
 * This will set default values for the [[yii\bootstrap\ActiveField|ActiveField]]
 * to render horizontal form fields. In particular the [[yii\bootstrap\ActiveField::template|template]]
 * is set to `{label} {beginWrapper} {input} {error} {endWrapper} {hint}` and the
 * [[yii\bootstrap\ActiveField::horizontalCssClasses|horizontalCssClasses]] are set to:
 *
 * ```php
 * [
 *     'offset' => 'col-sm-offset-3',
 *     'label' => 'col-sm-3',
 *     'wrapper' => 'col-sm-6',
 *     'error' => '',
 *     'hint' => 'col-sm-3',
 * ]
 * ```
 *
 * To get a different column layout in horizontal mode you can modify those options
 * through [[fieldConfig]]:
 *
 * ```php
 * $form = ActiveForm::begin([
 *     'layout' => 'horizontal',
 *     'fieldConfig' => [
 *         'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
 *         'horizontalCssClasses' => [
 *             'label' => 'col-sm-4',
 *             'offset' => 'col-sm-offset-4',
 *             'wrapper' => 'col-sm-8',
 *             'error' => '',
 *             'hint' => '',
 *         ],
 *     ],
 * ]);
 * ```
 *
 * @see \yii\bootstrap\ActiveField for details on the [[fieldConfig]] options
 * @see http://getbootstrap.com/css/#forms
 *
 * @author Michael Härtl <haertl.mike@gmail.com>
 * @since 2.0
 */
class ActiveForm extends \yii\bootstrap\ActiveForm
{
    /**
     * @var string the function for ng-submit of angular js. When angularSubmit is set, post and 
     * action attributes will be removed. 
     */
    public $angularSubmit = null;
    
    /**
     * @var string the default field class name when calling [[field()]] to create a new field.
     * @see fieldConfig
     */
    public $fieldClass = 'common\components\widgets\ActiveField';

    public function init()
    {
        if (!in_array($this->layout, ['default', 'horizontal', 'inline'])) {
            throw new InvalidConfigException('Invalid layout type: ' . $this->layout);
        }

        if ($this->layout !== 'default') {
            Html::addCssClass($this->options, 'form-' . $this->layout);
        }
        
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }
        
        if (!empty($this->angularSubmit)) {
            $this->options['ng-submit'] = $this->angularSubmit;
        }
        
        echo BaseHtml::beginForm($this->action, $this->method, $this->options);
    }
    
    /**
     * @inheritdoc
     * @return ActiveField the created ActiveField object
     */
    public function field($model, $attribute, $options = [], $ngModel = null)
    {
        $options = array_merge($options, ['inputOptions' => [
            'ng-model' => empty($ngModel) ? BaseHtml::getInputNameAngular($model, $attribute) : $ngModel,
        ]]);
        
        return parent::field($model, $attribute, $options);
    }
}