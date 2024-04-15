<?php
namespace app\models;
use Yii;

/**
 * This is the model class for table "region".
 *
 * @property int $id
 * @property int $dept_id
 * @property string $nama
 *
 * @property Dept $dept
 */
class Region extends \yii\db\ActiveRecord
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'region';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      ['nama', 'required'],
			['nama', 'unique'],
      ['nama', 'string', 'max' => 100],
      ['dept_id', 'exist', 'skipOnError' => true, 'targetClass' => Dept::className(), 'targetAttribute' => ['dept_id' => 'id']],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'id' => 'ID',
      'dept_id' => 'Dept ID',
      'nama' => 'Region Name',
    ];
  }

  /**
   * Gets query for [[Dept]].
   *
   * @return \yii\db\ActiveQuery|DeptQuery
   */
  public function getDept()
  {
    return $this->hasOne(Dept::className(), ['id' => 'dept_id']);
  }

  /**
   * {@inheritdoc}
   * @return RegionQuery the active query used by this AR class.
   */
  public static function find()
  {
    return new RegionQuery(get_called_class());
  }

  public static function getList()
  {
    $list = Yii::$app->cache->getOrSet('region', function (){
      return static::findBySql('select id, nama from region')->asArray()->all();
    });
    return \yii\helpers\ArrayHelper::map($list, 'id', 'nama');
  }

  public static function getLabel($id)
  {
    $list = self::getList();
    if (isset($list[$id]))
      return $list[$id];
    throw new \yii\web\NotFoundHttpException('The Region does not exist.');
  }
}
