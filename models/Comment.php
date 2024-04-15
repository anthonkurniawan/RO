<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property int $id
 * @property int $user_id
 * @property int $order_id
 * @property string|null $comment
 *
 * @property User $user
 * @property Orders $order
 */
class Comment extends \yii\db\ActiveRecord
{
	const CONTEXT_OPEN = 1;
	const CONTEXT_REJECTED = 2;
  const CONTEXT_ONPROGRESS = 3;
	const CONTEXT_COMPLETE = 4;
	
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'comment';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['user_id', 'order_id', 'comment'], 'required'],
			// [['user_id', 'order_id'], 'required'],
      [['user_id', 'order_id', 'time'], 'integer'],
      ['comment', 'string', 'max' => 500],
			['comment', 'trim'],
      // ['user_id', 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
      // ['order_id', 'exist', 'skipOnError' => true, 'targetClass' => Order::className(), 'targetAttribute' => ['order_id' => 'id']],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'id' => 'ID',
      'user_id' => 'User ID',
      'order_id' => 'Order ID',
      'comment' => 'Comment',
      'time' => 'Time'
    ];
  }

  public function beforeSave($insert)
  {
    if (parent::beforeSave($insert)) {
      $this->time = time();
      return true;
    } else return false;  // IS UPDATE
  }

  /**
   * Gets query for [users].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getUser()
  {
    return $this->hasOne(User::className(), ['id' => 'user_id']);
  }

  /**
   * Gets query for [[Order]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getOrder()
  {
    return $this->hasOne(Orders::className(), ['id' => 'order_id']);
  }
	
	public function getContextText()
  {
		if($this->context_id==self::CONTEXT_OPEN)
			return "Open";
		elseif($this->context_id==self::CONTEXT_REJECTED)
			return "Reject";
		elseif($this->context_id==self::CONTEXT_ONPROGRESS)
			return "In-progress";
		elseif($this->context_id==self::CONTEXT_COMPLETE)
			return "Close";
  }
}
