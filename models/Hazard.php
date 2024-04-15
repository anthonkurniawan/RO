<?php
namespace app\models;
use Yii;

/**
 * This is the model class for table "priority".
 *
 * @property int $id
 * @property string $label
 */
class Hazard extends \yii\db\ActiveRecord
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'hazard';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      ['label', 'required'],
			['label', 'unique'],
      ['label', 'string', 'max' => 50],
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
   * @return OrderTypeQuery the active query used by this AR class.
   */
  public static function find()
  {
    return new OrderTypeQuery(get_called_class());
  }

  public static function getList($data='label')
  {
    $arr = Yii::$app->cache->getOrSet('hazard', function () {
      return static::findBySql('Select id, label from hazard')->asArray()->all();
    });
		return \yii\helpers\ArrayHelper::map($arr, 'id', $data);
  }

  public static function getLabel($type)
  {
    $list = self::getList();
    if(isset($list[$type])) return $list[$type];
  }
}




