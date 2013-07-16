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
isset($this->items) or die('Items not defined');

$user = JFactory::getUser();
jincimport('utility.jinchtmlhelper');
jincimport('utility.jincjoomlahelper');

$this->tmplListInit('TEMPLATE_LIST');
?>

<form action="<?php echo JRoute::_('index.php?option=com_jinc&view=templates'); ?>" method="post" name="adminForm" id="adminForm">
    <?php
    $this->tmplListFormInit();
    ?>

    <table class="table table-striped" id="messageList">
        <?php
        $headers = array();
        array_push($headers, array('dbcol' => 'subject', 'label' => 'COM_JINC_SUBJECT',
            'sortable' => true));
        array_push($headers, array('dbcol' => 'name', 'label' => 'COM_JINC_NAME',
            'sortable' => true, 'options' => 'width="40%" class="nowrap hidden-phone"'));
        $this->tmplListTH($headers);
        ?>
        <tbody>
            <?php
            foreach ($this->items as $i => $item) :
                ?>
                <tr class="row<?php echo $i % 2; ?>">
                    <td class="center">
                        <?php echo JHtml::_('grid.id', $i, $item->id); ?>
                    </td>
                    <td>
                        <a href="<?php echo JRoute::_('index.php?option=com_jinc&task=template.edit&id=' . $this->escape($item->id)); ?>">
                            <?php echo $this->escape($item->name); ?>
                        </a>
                    </td>
                    <td class="center">
                        <?php echo $this->escape($item->subject); ?>
                    </td>
                    <td class="center">
                        <?php echo $this->escape($item->id); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php $this->tmplListEnd(); ?>
</form>