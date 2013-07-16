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

<form action="<?php echo JRoute::_('index.php?option=com_jinc&view=notices'); ?>" method="post" name="adminForm" id="adminForm">
    <?php
    $this->tmplListFormInit();
    ?>

    <table class="table table-striped" id="articleList">
        <?php
        $headers = array();
        array_push($headers, array('dbcol' => 'name', 'label' => 'COM_JINC_NAME',
            'sortable' => true));
        array_push($headers, array('dbcol' => 'title', 'label' => 'COM_JINC_TITLE',
            'sortable' => true, 'options' => 'width="25%" class="nowrap hidden-phone"'));
        array_push($headers, array('dbcol' => 'bdescr', 'label' => 'COM_JINC_BDESC',
            'sortable' => false, 'options' => 'width="25%" class="nowrap hidden-phone"'));
        $this->tmplListTH($headers);
        ?>
        <tbody>
            <?php
            foreach ($this->items as $i => $item) :
                ?>
                <tr>
                    <td class="center hidden-phone">
                        <?php echo JHtml::_('grid.id', $i, $item->id); ?>
                    </td>
                    <td class="nowrap has-context">
                        <div class="pull-left">
                            <a href="<?php echo JRoute::_('index.php?option=com_jinc&task=notice.edit&id=' . $item->id); ?>" title="<?php echo JText::_('JACTION_EDIT'); ?>">
                                <?php echo $this->escape($item->name); ?></a>
                        </div>
                    </td>
                    <td class="nowrap has-context">
                        <div class="pull-left">
                            <a href="<?php echo JRoute::_('index.php?option=com_jinc&task=notice.edit&id=' . $item->id); ?>" title="<?php echo JText::_('JACTION_EDIT'); ?>">
                                <?php echo $this->escape($item->title); ?></a>
                        </div>
                    </td>

                    <td class="small hidden-phone">
                        <?php echo $this->escape($item->bdesc); ?>
                    </td>
                    <td class="center hidden-phone">
                        <?php echo (int) $item->id; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php $this->tmplListEnd(); ?>
</form>
