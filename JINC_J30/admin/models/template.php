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
jimport('joomla.application.component.modeladmin');

class JINCModelTemplate extends JModelAdmin {

    function __construct() {
        parent::__construct();
    }

    /**
     * Method to get the record form.
     *
     * @param	array	$data		Data for the form.
     * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
     *
     * @return	mixed	A JForm object on success, false on failure
     * @since	1.6
     */
    public function getForm($data = array(), $loadData = true) {
        $form = $this->loadForm('com_jinc.template', 'template', array('control' => 'jform', 'load_data' => false));

        $data = array();
        if ($loadData) {
            $data = $this->loadFormData();
        }
        $this->preprocessForm($form, $data);
        // Load the data into the form after the plugins have operated.
        $form->bind($data);

        if (empty($form)) {
            return false;
        }
        return $form;
    }

    /**
     * Method to get the data that should be injected in the form.
     *
     * @return	mixed	The data for the form.
     * @since	1.6
     */
    protected function loadFormData() {
        $data = $this->getItem();
        return $data;
    }

    /**
     * Method to get a single record.
     *
     * @param	integer	The id of the primary key.
     *
     * @return	mixed	Object on success, false on failure.
     */
    public function getItem($pk = null) {
        jincimport('utility.servicelocator');
        $servicelocator = ServiceLocator::getInstance();
        $logger = $servicelocator->getLogger();

        jimport('joomla.filesystem.folder');
        jimport('joomla.filesystem.file');

        $item = parent::getItem($pk);       
        if (strlen($item->cssfile) > 0) {
            $item->cssfile_abs = JPATH_COMPONENT_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . $item->cssfile;
            $logger->debug('JINCModelTemplate - Reading CSS file ' . $item->cssfile_abs);

            $item->cssfile_content = is_readable($item->cssfile_abs)?file_get_contents($item->cssfile_abs):false;            
            if (!$item->cssfile_content) {
                $logger->debug('JINCModelTemplate - Error reading CSS file ' . $item->cssfile_abs);
            }
        }
        return $item;
    }

}

?>
