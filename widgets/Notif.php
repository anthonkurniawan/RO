<?php

namespace app\widgets;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * Alert widget renders a message from session flash. All flash messages are displayed
 * in the sequence they were assigned using setFlash. You can set message as following:
 *
 * ```php
 * Yii::$app->session->setFlash('error', 'This is the message');
 * Yii::$app->session->setFlash('success', 'This is the message');
 * Yii::$app->session->setFlash('info', 'This is the message');
 * ```
 *
 * Multiple messages could be set as follows:
 *
 * ```php
 * Yii::$app->session->setFlash('error', ['Error 1', 'Error 2']);
 * ```
 *
 */
class Notif extends \yii\bootstrap\Widget
{
  /**
   * @var array the alert types configuration for the flash messages.
   * This array is setup as $key => $value, where:
   * - key: the name of the session flash variable
   * - value: the bootstrap alert type (i.e. danger, success, info, warning)
   */
  public $alertTypes = [
    'warning'   => 'warning',
    'error'  => 'danger',
    'success' => 'success',
    'info'    => 'info',
    'default' => 'default'
  ];

  /**
   * {@inheritdoc}
   */
  public function run()
  {
    $session = Yii::$app->getSession();
    $flashes = $session->getAllFlashes();
    $view = $this->getView();
    foreach ($flashes as $type => $flash) {
      if (!isset($this->alertTypes[$type])) {
        continue;
      }
      $type = $this->alertTypes[$type];
      foreach ((array) $flash as $i => $message) {
        $js = "app.setMsg('$message', '$type');";
        $view->registerJs($js, $view::POS_END);
      }

      $session->removeFlash($type);
    }
  }
}
