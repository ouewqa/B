<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Area]].
 *
 * @see Area
 */
class AreaQuery extends BaseActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Area[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Area|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}