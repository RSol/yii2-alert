<?php
/**
 * AlertAsset class file.
 *
 * @author Virtual Frameworks LLC <post@virtualhealth.com>
 * @link http://www.virtualhealth.com/
 * @copyright Copyright &copy; 2011-2013 Virtual Frameworks LLC
 */

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