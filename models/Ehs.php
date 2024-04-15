<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ehs_ass".
 *
 * @property int $id
 * @property string $label
 */
class Ehs extends \yii\db\ActiveRecord
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'ehs_ass';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      ['label', 'required'],
			['label', 'unique'],
      ['label', 'string', 'max' => 100],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'id' => 'ID',
      'label' => 'Label',
    ];
  }

  /**
   * {@inheritdoc}
   * @return EhsAssQuery the active query used by this AR class.
   */
  public static function find()
  {
    return new EhsAssQuery(get_called_class());
  }

  public static function getList()
  {
    $list = Yii::$app->cache->getOrSet('ehs', function () {
      return static::findBySql('Select id, label from ehs_ass')->asArray()->all();
    });
    return \yii\helpers\ArrayHelper::map($list, 'id', 'label');
  }

}
