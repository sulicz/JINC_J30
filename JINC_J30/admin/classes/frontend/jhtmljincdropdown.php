<?php

/**
 * @copyright           Copyright (C) 2010 - Lhacky
 * @license		GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
 *   This file is part of JINC.
 *
 *   JINC is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *
 *   JINC is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with JINC.  If not, see <http://www.gnu.org/licenses/>.
 */
defined('JPATH_PLATFORM') or die;

/**
 * HTML utility class for building a JINC dropdown menu
 *
 * @package     Joomla.Libraries
 * @subpackage  HTML
 * @since       3.0
 */
abstract class JHtmlJINCDropdown extends JHtmlDropdown {

    /**
     * Append a featured item to the current dropdown menu
     *
     * @param   string  $checkboxId  ID of corresponding checkbox of the record
     * @param   string  $prefix      The task prefix
     *
     * @return  void
     *
     * @since   3.0
     */
    public static function import($id, $view = '') {        
        self::start();

        $option = JFactory::getApplication()->input->getCmd('option');
        $link = 'index.php?option=' . $option;

        $link .= '&view=' . $view . '&layout=uploadcsv&id=' . $id;
        $link = JRoute::_($link);

        self::addCustomItem(JText::_('COM_JINC_ACTION_IMPORT'), $link);
        return;
    }

    public static function stats($id, $prefix = '') {
        self::start();

        $option = JFactory::getApplication()->input->getCmd('option');
        $link = 'index.php?option=' . $option;

        $link .= '&task=' . $prefix . 'stats&id=' . $id;
        $link = JRoute::_($link);

        self::addCustomItem(JText::_('COM_JINC_STATISTICS'), $link);
        return;
    }

    public static function send($id) {
        self::start();

        $option = JFactory::getApplication()->input->getCmd('option');
        $link = 'index.php?option=' . $option;

        $link .= '&view=message&layout=send&id=' . $id;
        $link = JRoute::_($link);

        self::addCustomItem(JText::_('COM_JINC_JTOOLBAR_SEND'), $link);
        return;
    }

        public static function preview($id) {
        self::start();

        $option = JFactory::getApplication()->input->getCmd('option');
        $link = 'index.php?option=' . $option;

        $link .= '&view=message&layout=preview&id=' . $id;
        $link = JRoute::_($link);

        self::addCustomItem(JText::_('COM_JINC_JTOOLBAR_PREVIEW'), $link);
        return;
    }

        public static function history($id) {
        self::start();

        $option = JFactory::getApplication()->input->getCmd('option');
        $link = 'index.php?option=' . $option;

        $link .= '&view=message&layout=history&id=' . $id;
        $link = JRoute::_($link);

        self::addCustomItem(JText::_('COM_JINC_JTOOLBAR_HISTORY'), $link);
        return;
    }

}
