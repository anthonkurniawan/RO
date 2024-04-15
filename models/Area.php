<?php
namespace app\models;

use Yii;

/**
 * This is the model class for table "area".
 *
 * @property int $id
 * @property string $code
 * @property string $label_a
 */
class Area extends \yii\db\ActiveRecord
{
	public $pagesize;
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'area';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      ['label_a', 'required'],
      ['label_a', 'filter', 'filter'=>function($value){ return preg_replace('/\s+/', ' ', $value); } ],
      ['label_a', 'unique'],
      ['label_a', 'string', 'max' => 255],
      ['label_a', 'trim'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'id' => 'ID',
      'label_a' => 'Area / Room',
    ];
  }

  /**
   * {@inheritdoc}
   * @return AreaQuery the active query used by this AR class.
   */
  public static function find()
  {
    return new AreaQuery(get_called_class());
  }

  public static function getList()
  {
    $list = Yii::$app->cache->getOrSet('area', function (){
      return static::findBySql('select id, label_a as area from area')->asArray()->all();
    });
    return \yii\helpers\ArrayHelper::map($list, 'id', 'area');
  }

}
