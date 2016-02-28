<?php

/**
 * AlertAsset
 *
 * @package 
 */


namespace rsol\alert\assets;


use yii\web\AssetBundle;

class AlertAsset extends AssetBundle
{
    public $sourcePath = '@bower/pnotify';

    public $css = [
        'pnotify.custom.min.css',
    ];
    public $js = [
        'pnotify.custom.min.js',
    ];
}