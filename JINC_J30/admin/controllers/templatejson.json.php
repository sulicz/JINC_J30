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
jimport('joomla.application.component.controllerform');

class JINCControllerTemplateJSON extends JControllerLegacy {
    function __construct() {
        parent::__construct();
    }

    function getTemplateInfo() {
        header("Content-Type: text/plain; charset=UTF-8");
        jincimport('core.messagefactory');
        jincimport('utility.jsonresponse');
        $tem_id = JRequest::getInt('id', 0);
        $minstance = MessageFactory::getInstance();
        if (! $template = $minstance->loadTemplate($tem_id))
            $template = new MessageTemplate(0);
        // Building JSON response
        $response = new JSONResponse();
        $response->set('subject', $template->get('subject'));
        $response->set('body', $template->get('body'));
        echo $response->toString();
    }
}
?>
