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

class JINCViewTemplates extends JINCView {

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
        $state = $this->get('State');
        JHTML::stylesheet('administrator/components/com_jinc/assets/css/jinc_admin.css');
        JToolBarHelper::title(JText::_('COM_JINC_MENU_TEMPLATES'), 'jinc');
        JToolBarHelper::addNew('template.add', 'JTOOLBAR_NEW');
        JToolBarHelper::editList('template.edit', 'JTOOLBAR_EDIT');
        JToolBarHelper::deleteList(JText::_('COM_JINC_WARNING_DELETE_ITEMS'), 'templates.delete');
        jincimport('utility.jinchelper');
        JINCHelper::helpOnLine(95);
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
            'id' => JText::_('COM_JINC_ID'),
            'subject' => JText::_('COM_JINC_SUBJECT'),
            'name' => JText::_('COM_JINC_NAME'),
        );
    }

}