<?php
namespace app\models;

use Yii;

/**
 * This is the model class for table "tag".
 *
 * @property int $id
 * @property string $tagnum
 * @property string $desc
 * @property string $area_id
 */
class Tag extends \yii\db\ActiveRecord
{
  public $area_name;
  const SQLI_REGEX = '/[\'\"\;\%]|\-{2,}|\/\*/';
	
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'tag';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['tagnum', 'desct', 'area_id'], 'required'],
      //[['area_id'], 'safe'],
      ['tagnum', 'string', 'max' => 150],
      ['tagnum', 'trim'],
      ['tagnum', 'match', 'not'=>true, 'pattern' => self::SQLI_REGEX],
      ['tagnum', 'unique', 'message' => 'This tag-number already exists.'],
      ['desct', 'string', 'max' => 255],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'id' => 'ID',
      'tagnum' => 'Tag Number',
      'desct' => 'Machine/Equipment Description',
      'area_id' => 'Area / Room',
      'area_name' => 'Area / Room',
    ];
  }

  /**
   * Gets query for [[Area]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getArea()
  {
    return $this->hasOne(Area::className(), ['id' => 'area_id']);
  }

  /**
   * {@inheritdoc}
   * @return TagQuery the active query used by this AR class.
   */
  public static function find()
  {
    return new TagQuery(get_called_class());
  }
}
