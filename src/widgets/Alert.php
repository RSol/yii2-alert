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