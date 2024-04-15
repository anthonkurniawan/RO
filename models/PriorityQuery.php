<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Priority]].
 *
 * @see Priority
 */
class PriorityQuery extends \yii\db\ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return Priority[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Priority|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
