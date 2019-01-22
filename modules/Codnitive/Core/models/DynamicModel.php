<?php
namespace app\modules\Codnitive\Core\models;

abstract class DynamicModel extends \yii\base\DynamicModel 
{
    protected $_module = 'template';
    protected $_attributes = [];
    protected $_rules = [];
    protected $_fieldRules = [];
    protected $_labels = [];

    /**
     * {@inheritdoc}
     */
    public function __construct(array $attributes = [], $config = [])
    {
        $attributes = $this->_attributes + $attributes;
        $this->setRules();
        parent::__construct($attributes, $config);
    }

    public function setAttributeLabels(array $labels): self
    {
        $this->_labels = $labels;
        return $this;
    }

    public function attributeLabels(): array
    {
        $labels = [];
        foreach ($this->_labels as $field => $label) {
            $labels[$field] = __($this->_module, $label);
        }
        return $labels;
    }

    public function setRules(array $rules = []): self
    {
        $rules = $this->_rules + $rules;
        // $fieldRules = $rules['field_rules'] ?? [];
        // unset($rules['field_rules']);
        foreach ($rules as $rule => $fields) {
            $options = [];
            if (isset($fields['options'])) {
                $options = $fields['options'];
                unset($fields['options']);
            }
            // var_dump($options);
            $this->addRule($fields, $rule, $options);
        }
        foreach ($this->_fieldRules as $field => $rule) {
            if (isset($rule['rule'])) {
                $this->addRule($field, $rule['rule'], $rule['options'] ?? []);
            }
        }
        // exit;
        return $this;
    }

    public function getErrorsFlash(array $errors): string
    {
        $message = '';
        foreach ($errors as $error) {
            $message .= implode('<br>', $error) . '<br>';
        }
        return $message;
    }
}
