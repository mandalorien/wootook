<?php
/**
 * This file is part of Wootook
 *
 * @license http://www.gnu.org/licenses/agpl-3.0.txt
 * @see http://wootook.org/
 *
 * Copyright (c) 2011-Present, Grégory PLANCHAT <g.planchat@gmail.com>
 * All rights reserved.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 *                                --> NOTICE <--
 *  This file is part of the core development branch, changing its contents will
 * make you unable to use the automatic updates manager. Please refer to the
 * documentation for further information about customizing Wootook.
 *
 */

abstract class Wootook_Empire_Block_Planet_Builder_Queue_ItemAbstract
    extends Wootook_Empire_Block_Planet_Builder_ItemAbstract
{
    protected $_item = null;

    protected $_itemIdField = null;

    public function setItem(Wootook_Empire_Model_Builder_Item $item)
    {
        $this->_item = $item;
        $this->setItemId($item->getData($this->_itemIdField));

        return $this;
    }

    public function getItem()
    {
        return $this->_item;
    }
}