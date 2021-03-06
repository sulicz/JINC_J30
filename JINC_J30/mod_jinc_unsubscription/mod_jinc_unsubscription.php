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

jimport('joomla.plugin.plugin');
jimport('joomla.filesystem.file');

// Preload the JINCFactory
jimport('joomla.filesystem.file');
require_once JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_jinc' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'factory.php';

$lang = JFactory::getLanguage();
$lang->load('com_jinc');
$lang->load('mod_jinc_subscription');

$id = $params->get('id', 0);

jincimport('core.newsletterfactory');
$input_style = $params->get('mod_input_style', INPUT_STYLE_INHERITED);

$ninstance = NewsletterFactory::getInstance();
if ($newsletter = $ninstance->loadNewsletter($id, true)) {
    $user = JFactory::getUser();
    if (($newsletter->getType() == NEWSLETTER_PRIVATE_NEWS) && ($user->guest)) {
        echo JText::_('COM_JINC_ERR005');
    } else {
        if ($user->authorise('jinc.subscribe', 'com_jinc.newsletter.' . $id)) {
            if ($input_style == INPUT_STYLE_INHERITED) 
                $input_style = $newsletter->get('input_style');
            
            $layout = JModuleHelper::getLayoutPath('mod_jinc_unsubscription');
            require($layout);
        } else {
            echo JText::_('COM_JINC_ERR005');
        }
    }
} else {
    echo JText::_('COM_JINC_ERR005');
}
?>
