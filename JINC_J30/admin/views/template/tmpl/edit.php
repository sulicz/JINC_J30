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
?>

<?php
defined('_JEXEC') or die('Restricted access');
isset($this->item) or die('Item is not defined');

$this->preEditForm('template');
jincimport('utility.jinceditor');
?>

<form action="<?php echo JRoute::_('index.php?option=com_jinc&layout=edit&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="item-form" class="form-validate">
    <div class="row-fluid">
        <!-- Begin Content -->
        <div class="span10 form-horizontal">
            <ul class="nav nav-tabs">
                <?php
                $this->printTabHeader('general', 'COM_JINC_EDIT_TEMPLATE', true);
                $this->printTabHeader('css', 'COM_JINC_EDIT_CSS');
                ?>
            </ul>

            <div class="tab-content">
                <!-- Begin Tabs -->
                <?php
                $formArray = array('name', 'subject');
                $jeditor = new JINCEditor('jform[body]');
                $this->printTabTwoColumns('general', $formArray, array('body'), $jeditor);
                $this->printTabBodyFieldset('css');                
                ?>                
            </div>
            <?php $this->printEditEndForm(); ?>
        </div>
</form>