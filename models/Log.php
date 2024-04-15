<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log".
 *
 * @property int $id
 * @property string $date
 * @property int $userid
 * @property string $event
 */
class Log extends \yii\db\ActiveRecord
{
  public $uname;
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'log';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['date', 'userid', 'event'], 'required'],
      ['userid', 'integer'],
      ['event', 'string', 'max' => 255],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'id' => 'ID',
      'date' => 'Date Time',
      'userid' => 'Userid',
      'event' => 'Event',
      'uname' => 'Username'
    ];
  }

  /**
   * Gets query for [users].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getUser()
  {
    return $this->hasOne(User::className(), ['users.id' => 'userid']);
  }

  /**
   * {@inheritdoc}
   * @return LogQuery the active query used by this AR class.
   */
  public static function find()
  {
    return new LogQuery(get_called_class());
  }
}
