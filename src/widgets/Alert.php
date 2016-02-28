<?php

/**
 * Alert
 *
 * @package
 */


namespace rsol\alert\widgets;


use rsol\alert\assets\AlertAsset;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;


class Alert extends Widget
{
    /**
     * @var array the alert types configuration for the flash messages.
     * This array is setup as $key => $value, where:
     * - $key is the name of the session flash variable
     * - $value is the array:
     *       - class of alert type (i.e. danger, success, info, warning)
     *       - icon for alert AdminLTE
     */
    public $alertTypes = [
        'error' => [
            'class' => 'bg-danger',
            'icon' => '<i class="icon fa fa-ban"></i> ',
        ],
        'danger' => [
            'class' => 'bg-danger',
            'icon' => '<i class="icon fa fa-ban"></i> ',
        ],
        'success' => [
            'class' => 'bg-success',
            'icon' => '<i class="icon fa fa-check"></i> ',
        ],
        'info' => [
            'class' => 'bg-info',
            'icon' => '<i class="icon fa fa-info"></i> ',
        ],
        'warning' => [
            'class' => 'bg-warning',
            'icon' => '<i class="icon fa fa-warning"></i> ',
        ],
    ];

    /**
     * @var string
     * If you are not using any UI library, you can use the included styling, called Bright Theme. It is the default.
     * If you are using Bootstrap version 2, include this line somewhere before your first notice:
     *
     *     PNotify.prototype.options.styling = "bootstrap2";
     *
     * If you are using Bootstrap version 3, include this line somewhere before your first notice:
     *
     *     PNotify.prototype.options.styling = "bootstrap3";
     *
     * If you are using jQuery UI, include this line somewhere before your first notice:
     *
     *     PNotify.prototype.options.styling = "jqueryui";
     *
     * If you are using Bootstrap 3 with Font Awesome, include this line somewhere before your first notice:
     *
     *     PNotify.prototype.options.styling = "fontawesome";
     */
    public $style = 'bootstrap3';

    /**
     * Initializes the widget.
     * This method will register the bootstrap asset bundle. If you override this method,
     * make sure you call the parent implementation first.
     */
    public function init()
    {
        parent::init();
        $this->registerAssets();

        $session = \Yii::$app->getSession();
        $flashes = $session->getAllFlashes();

        foreach ($flashes as $type => $data) {
            if (isset($this->alertTypes[$type])) {
                $data = (array)$data;
                foreach ($data as $message) {
                    $options = [
                        'text' => $message,
                        'addclass' => 'alert-styled-left alert-arrow-left text-sky-royal',
                        'type' => $type,
                    ];

                    $options = is_array($message)
                        ? ArrayHelper::merge($options, $message)
                        : $options;

                    $name = uniqid('notify');

                    $events = [];
                    if (array_key_exists('on', $options) && is_array($options['on'])) {
                        foreach ($options['on'] as $event => $func) {
                            $events[] = "$name.get().on('{$event}', {$func});";
                        }
                        unset($options['on']);
                    }
                    $events = implode("\n", $events);

                    $this->view->registerJs("PNotify.prototype.options.styling = '{$this->style}';");
                    $this->view->registerJs("var $name = new PNotify(" . Json::encode($options) . ");\n$events");
                }

                $session->removeFlash($type);
            }

            if ($type == 'js') {
                foreach ($data as $message) {
                    $this->view->registerJs($message);
                }
            }
        }
    }

    /**
     * Register JS & CSS
     */
    private function registerAssets()
    {
        AlertAsset::register($this->view);
    }
}