<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Ehs]].
 *
 * @see Ehs
 */
class EhsAssQuery extends \yii\db\ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return Ehs[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Ehs|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
