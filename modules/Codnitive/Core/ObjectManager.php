<?php 

function getObject(string $className)
{
    $container = new \yii\di\Container;
    return $container->get($className);
}
