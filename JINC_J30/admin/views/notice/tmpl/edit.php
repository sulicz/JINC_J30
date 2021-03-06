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

$this->preEditForm('notice');
?>

<form action="<?php echo JRoute::_('index.php?option=com_jinc&layout=edit&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="item-form" class="form-validate">
    <div class="form-inline form-inline-header">
        <?php
        $form = $this->getForm();
        echo $form->getControlGroup('name');
        echo $form->getControlGroup('title');
        ?>
    </div>   

    <div class="row-fluid">
        <!-- Begin Content -->
        <div class="span10 form-horizontal">
            <ul class="nav nav-tabs">
                <?php
                $this->printTabHeader('general', 'COM_JINC_EDIT_NOTICE', true);
                ?>
            </ul>

            <div class="tab-content">
                <!-- Begin Tabs -->

                <?php
                $this->printTabBodyGeneralRightCol('general', array('conditions'), array('bdesc'));
                ?>

            </div>
            <?php $this->printEditEndForm(); ?>
        </div>
</form>
