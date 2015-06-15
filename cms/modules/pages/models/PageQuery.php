<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\modules\pages\models;

use yii\db\ActiveQuery;

/**
 * PageQuery
 */
class PageQuery extends ActiveQuery
{
    /**
     * Filters pages by state.
     *
     * @param int $state a state to filter pages by.
     */
    public function byState($state)
    {
        return $this->andWhere(['state' => $state]);
    }

    /**
     * Filters pages by the provided category id.
     *
     * @param int $id a category id to filter pages by.
     */
    public function byCategory($id)
    {
        return $this->andWhere(['category_id' => $id]);
    }
}