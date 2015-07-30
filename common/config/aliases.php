<?php

/**
 * Set all application aliases.
 */

Yii::setAlias('common', dirname(__DIR__));
Yii::setAlias('backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('statics', dirname(dirname(__DIR__)) . '/statics');
Yii::setAlias('root', dirname(dirname(__DIR__)));