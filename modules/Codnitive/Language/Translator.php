<?php

function __($category, $message, $params = [], $language = null)
{
    return \Yii::t($category, $message, $params, $language);
}
