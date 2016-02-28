Yii2-alert
=======================
Widget for add PNotify alerts in yii2 application

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist rsol/yii2-alert "*"
```

or add

```
"rsol/yii2-alert": "*"
```

to the require section of your `composer.json` file.


Usage
--------
in main layout:
```php
use rsol\alert\widgets\Alert;
```

```php
<?= Alert::widget() ?>
```


in any place of your code:
```php
Yii::$app->session->addFlash('success', Yii::t('users', 'Added social networks connections'));
```

advanced

```php
Yii::$app->session->addFlash('success', [
                    'title' => Yii::t('users', 'Added social networks connections'),
                    'text' => Yii::t('users', 'Are you want to use photo from {soc} as profile photo?', [
                        'soc' => $client->getTitle(),
                    ]),
                    'addclass' => 'alert-styled-left alert-arrow-left text-sky-royal',
                    'hide' => false,
                    'confirm' => [
                        'confirm' => true,
                        'buttons' => [
                            [
                                'text' => Yii::t('users', 'YES'),
                                'addClass' => 'btn-sm',
                            ],
                            [
                                'text' => Yii::t('users', 'NO'),
                                'addClass' => 'btn-sm',
                            ]
                        ]
                    ],
                    'buttons' => [
                        'closer' => false,
                        'sticker' => false,
                    ],
                    'history' => [
                        'history' => false,
                    ],
                    'on' => [
                        'pnotify.confirm' => "function() {
                            $('.cropper').attr('src', '{$attributes['User']['photo']}');
                            $('#modal_large').modal('show');
                        }",
                    ],
                ]);
```

or JS

```php
$swal = [
                    'title' => Yii::t('users', 'Added social networks connections'),
                    'text' => Yii::t('users', 'Are you want to use photo from {soc} as profile photo?', [
                        'soc' => $client->getTitle(),
                    ]),
                    'confirmButtonColor' => "#66BB6A",
                    'type' => "success",
                    'showCancelButton' => true,
                    'confirmButtonText' => Yii::t('users', 'YES'),
                    'cancelButtonText' => Yii::t('users', 'NO'),
                ];
                $ajax = [
                    'url' => Url::toRoute("/user/user/soc-image"),
                    'data' => [
                        'soc' => $filed,
                    ],
                    'success' => new JsExpression('function(data) {
                        if (data.success) {
                            $(".col-lg-3 .eg-preview img.img-circle").attr("src", data.src);
                            $("li.dropdown.dropdown-user a.dropdown-toggle img.img-circle").attr("src", data.src);
                        }
                    }'),
                    'dataType' => "json",
                ];

                Yii::$app->session->addFlash('js', 'swal(' . Json::encode($swal) . ', function(isConfirm){
                    if (isConfirm) {
                        $.ajax(' . Json::encode($ajax) . ');
                    }
                });');

```
