<?php

namespace app\modules\Codnitive\Template\helpers;

use app\modules\Codnitive\Core\helpers\Html as CoreHtml;

class Html extends CoreHtml
{
    public static function getField($form, $model, $field, $icon = '', $template = '', $data = [])
    {
        if (empty($template)) {
            $template = '';
            if (!isset($data['remove_label']) || !$data['remove_label']) {
                $template .= '<p>'.$model->getAttributeLabel($field).'</p>';
            }
            $template .= '
                <div class="input-group">
                    <span class="input-group-addon"><i class="'.$icon.'" aria-hidden="true"></i></span>
                    {input}
                    <div class="field-hint">{hint}</div><div class="field-error red-text">{error}</div>
                </div>';
        }
        $data['form_group_class'] = isset($data['form_group_class'])
            ? $data['form_group_class']
            : 'col-lg-6 col-md-6 col-sm-12';
        return parent::getField($form, $model, $field, $icon, $template, $data);
    }

    public static function getDropdownList($form, $model, $field, $list, $data = [])
    {
        if (empty($template)) {
            $data['template'] = '';
            if (!isset($data['remove_label']) || !$data['remove_label']) {
                $data['template'] .= '<p>'.$model->getAttributeLabel($field).'</p>';
            }
            $data['template'] .= '
                        <div class="input-group">
                            <span class="input-group-addon"><i class="'.$data['icon'].'" aria-hidden="true"></i></span>
                            {input}
                            <div class="field-hint">{hint}</div><div class="field-error red-text">{error}</div>
                        </div>';
        }
        $data['form_group_class'] = isset($data['form_group_class'])
            ? $data['form_group_class']
            : 'col-lg-6 col-md-6 col-sm-12';
        return parent::getDropdownList($form, $model, $field, $list, $data);
    }

}
