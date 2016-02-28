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
        'dist/pnotify.css',
    ];
    public $js = [
        'dist/pnotify.js',
    ];
}