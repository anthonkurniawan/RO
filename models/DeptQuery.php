<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Dept]].
 *
 * @see Dept
 */
class DeptQuery extends \yii\db\ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return Dept[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Dept|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
