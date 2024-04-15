<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Area]].
 *
 * @see Area
 */
class AreaQuery extends \yii\db\ActiveQuery
{
  /**
   * {@inheritdoc}
   * @return Area[]|array
   */
  public function all($db = null)
  {
    return parent::all($db);
  }

  /**
   * {@inheritdoc}
   * @return Area|array|null
   */
  public function one($db = null)
  {
    return parent::one($db);
  }
}
