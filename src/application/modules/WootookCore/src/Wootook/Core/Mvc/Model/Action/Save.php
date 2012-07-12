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

namespace Wootook\Core\Mvc\Model\Action;

use Wootook\Core\Exception as CoreException;

/**
 *
 */
trait Save
{
    public function save()
    {
        try {
            $this->_beforeSave();
            $this->_save();
            $this->_afterSave();

            $this->_setOriginalData($this->_data);
        } catch (PDOException $e) {
            throw new CoreException\DataAccessException('Could not save data: ' . $e->getMessage(), 0);
        }
        return $this;
    }

    abstract protected function _save();

    protected function _beforeSave()
    {
        \Wootook::dispatchEvent('model.before-save', array('model' => $this));

        if ($this->_eventPrefix !== null && $this->_eventObject !== null) {
            \Wootook::dispatchEvent($this->_eventPrefix . '.before-save', array($this->_eventObject => $this));
        }

        return $this;
    }

    protected function _afterSave()
    {
        \Wootook::dispatchEvent('model.after-save', array('model' => $this));

        if ($this->_eventPrefix !== null && $this->_eventObject !== null) {
            \Wootook::dispatchEvent($this->_eventPrefix . '.after-save', array($this->_eventObject => $this));
        }

        return $this;
    }
}
