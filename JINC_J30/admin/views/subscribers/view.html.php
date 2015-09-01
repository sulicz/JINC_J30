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
defined('_JEXEC') or die();
jincimport('jhelper.jincview');
require_once JPATH_COMPONENT . '/models/fields/jincnewsletter.php';
require_once JPATH_COMPONENT . '/models/fields/jincsubstate.php';
class JINCViewSubscribers extends JINCView {
    protected $items;
    protected $pagination;
    protected $state;
    protected $tmpl;
    function display($tpl = null) {
        $this->items = $this->get('Items');
        $this->pagination = $this->get('Pagination');
        $this->state = $this->get('State');
        $this->addToolbar();
        parent::display($tpl);
    }
    protected function addToolbar() {
        JHTML::stylesheet('administrator/components/com_jinc/assets/css/jinc_admin.css');
        JToolBarHelper::title(JText::_('COM_JINC_MENU_SUBSCRIBERS'), 'jinc');
        $bar = JToolBar::getInstance('toolbar');
        $bar->appendButton('Popup', 'addsubscriber', 'COM_JINC_ADDSUBSCRIBER', 'index.php?option=com_jinc&amp;view=newsletter&amp;tmpl=component&amp;layout=addsubscriber', 875, 550, 0, 0, '');        
        JToolBarHelper::custom('subscribers.approve', 'approve', 'approve', 'COM_JINC_APPROVE', true);
        JToolBarHelper::deleteList(JText::_('COM_JINC_WARNING_DELETE_ITEMS'), 'subscribers.delete');        
        jincimport('utility.jinchelper');
        JINCHelper::helpOnLine(98);
    }
    
    /**
     * Returns an array of fields the table can be sorted by
     *
     * @return  array  Array containing the field name to sort by as the key and display text as value
     *
     * @since   3.0
     */
    protected function getSortFields() {          
        return array(
            'n.name' => JText::_('COM_JINC_NEWS_NAME'),
            'subs_email' => JText::_('COM_JINC_MAIL_ADDRESS'),
            'id' => JText::_('COM_JINC_ID'),
        );
    }        
}