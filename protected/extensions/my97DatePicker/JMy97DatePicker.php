<?php

class JMy97DatePicker extends CWidget
{
    public $model;
    public $attribute;

	public $name;
	public $value;

    public $options;
    public $htmlOptions;

	public $baseUrl;

    public function init()
    {
        $options = CJavaScript::jsonEncode($this->options);
        $this->htmlOptions['onclick'] = strtr('WdatePicker({options});', array('{options}' => $options));

        $dir = dirname(__FILE__).DIRECTORY_SEPARATOR.'source';
        $this->baseUrl = Yii::app()->getAssetManager()->publish($dir);

        $cs = Yii::app()->getClientScript();
        $cs->registerScriptFile($this->baseUrl.'/WdatePicker.js');

    }

    public function run()
    {
        echo CHtml::activeTextField($this->model,$this->attribute,$this->htmlOptions);
    }
}