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
defined('_JEXEC') or die('Restricted access');

// Preload the JINCFactory
jimport('joomla.filesystem.file');
jimport('joomla.application.component.controller');

require_once JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_jinc' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'factory.php';
require_once( JPATH_COMPONENT . DIRECTORY_SEPARATOR . 'controller.php' );

$controller = JControllerLegacy::getInstance('Newsletters');
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();
?>