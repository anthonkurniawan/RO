<?php
namespace app\models;

/**
 * This is the ActiveQuery class for [[OrderType]].
 *
 * @see Priority
 */
class OrderTypeQuery extends \yii\db\ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return OrderType[]|array
     */
    public function all($db = null)
    {
      return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return OrderType|array|null
     */
    public function one($db = null)
    {
      return parent::one($db);
    }
}
