<?php
namespace app\models;
use Yii;

/**
 * This is the model class for table "dept".
 *
 * @property int $id
 * @property string $code
 * @property string $label
 *
 * @property Area[] $areas
 */
class Dept extends \yii\db\ActiveRecord
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'dept';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      ['label', 'required'],
      ['label', 'string', 'max' => 50],
      ['label', 'unique', 'message' => 'The name already exists.'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'id' => 'ID',
      'code' => 'Code',
      'label' => 'Departement',
    ];
  }

  /**
   * Gets query for [[Areas]].
   *
   * @return \yii\db\ActiveQuery|AreaQuery
   */
  public function getAreas()
  {
    return $this->hasMany(Area::className(), ['dept_id' => 'id'])->cache(600);
  }

  /**
   * {@inheritdoc}
   * @return DeptQuery the active query used by this AR class.
   */
  public static function find()
  {
    return new DeptQuery(get_called_class());
  }

  public static function getList()
  {
    $list = Yii::$app->cache->getOrSet('dept', function (){
      return static::findBySql('Select id, label from dept')->asArray()->all();
    });
    return \yii\helpers\ArrayHelper::map($list, 'id', 'label');
  }

}
