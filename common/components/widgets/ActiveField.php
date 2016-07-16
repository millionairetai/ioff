<?php
namespace common\components\widgets;

use Yii;
use yii\base\Component;
use common\components\helpers\BaseHtml;
use yii\bootstrap\Html;

class ActiveField extends \yii\bootstrap\ActiveField
{
     /**
     * @inheritdoc
     */
    public function checkbox($options = [], $enclosedByLabel = true)
    {
        $options['ng-model'] = $this->inputOptions['ng-model'];
        return parent::checkbox($options, false);
    }
    
    /**
     * @inheritdoc
     */
    public function radio($options = [], $enclosedByLabel = true)
    {
        $options['ng-model'] = $this->inputOptions['ng-model'];
        return parent::radio($options, false);
    }
    
    public function checkboxList($items, $options = [])
    {
        if ($this->inline) {
            if (!isset($options['template'])) {
                $this->template = $this->inlineCheckboxListTemplate;
            } else {
                $this->template = $options['template'];
                unset($options['template']);
            }
            if (!isset($options['itemOptions'])) {
                $options['itemOptions'] = [
                    'labelOptions' => ['class' => 'checkbox-inline'],
                ];
            }
        }  elseif (!isset($options['item'])) {
            $options['item'] = function ($index, $label, $name, $checked, $value) {

                return '<div class="checkbox">' . BaseHtml::checkbox($name, $checked, ['label' => $label, 'value' => $value],
                        BaseHtml::getInputNameAngular($this->model, $this->attribute) . "['{$value}']" ) . '</div>';
            };
        }
        parent::checkboxList($items, $options);
        return $this;
    }
    /**
     * @inheritdoc
     */
    public function radioList($items, $options = [])
    {
        if ($this->inline) {
            if (!isset($options['template'])) {
                $this->template = $this->inlineRadioListTemplate;
            } else {
                $this->template = $options['template'];
                unset($options['template']);
            }
            if (!isset($options['itemOptions'])) {
                $options['itemOptions'] = [
                    'labelOptions' => ['class' => 'radio-inline'],
                ];
            }
        }  elseif (!isset($options['item'])) {
            $options['item'] = function ($index, $label, $name, $checked, $value) {
                return '<div class="radio">' . BaseHtml::radio($name, $checked, ['label' => $label, 'value' => $value], BaseHtml::getInputNameAngular($this->model, $this->attribute)) . '</div>';
            };
        }
        
        parent::radioList($items, $options);
        return $this;
    }
}
