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

$this->tmplListInit('MESSAGE_LIST');
?>

<form action="<?php echo JRoute::_('index.php?option=com_jinc&view=messages'); ?>" method="post" name="adminForm" id="adminForm">
    <?php
    $this->tmplListFormInit();
    ?>

    <table class="table table-striped" id="messageList">
        <?php
        $headers = array();
        array_push($headers, array('dbcol' => 'm.subject', 'label' => 'COM_JINC_SUBJECT',
            'sortable' => true));
        array_push($headers, array('dbcol' => 'm.bulkmail', 'label' => 'COM_JINC_TYPE',
            'sortable' => true, 'options' => 'width="1%" style="min-width:55px" class="nowrap hidden-phone"'));
        array_push($headers, array('dbcol' => 'status', 'label' => 'COM_JINC_STATUS',
            'sortable' => true, 'options' => 'width="1%" style="min-width:55px" class="nowrap hidden-phone"'));
        array_push($headers, array('dbcol' => 'n.name', 'label' => 'COM_JINC_LIST_NEWS_NAME',
            'sortable' => true, 'options' => 'class="nowrap hidden-phone"'));
        array_push($headers, array('dbcol' => 'datasent', 'label' => 'COM_JINC_LASTSENT',
            'sortable' => true, 'options' => 'width="1%" style="min-width:55px" class="nowrap hidden-phone"'));
        $this->tmplListTH($headers);
        ?>
        <tbody>
            <?php
            $base = JURI::base() . 'components/com_jinc/assets/images/icons/';
            $options = array('height' => 16, 'width' => 16, 'title' => JText::_('COM_JINC_ATTACHMENT'));
            $attach_img = JHTML::image($base . 'attachment.png', JText::_('COM_JINC_ATTACHMENT'), $options);

            $options['title'] = JText::_('COM_JINC_BULKMAIL');
            $bulk_img = JHTML::image($base . 'user.png', JText::_('COM_JINC_BULKMAIL'), $options);
            $options['title'] = JText::_('COM_JINC_PERSONAL');
            $pers_img = JHTML::image($base . 'person4_f2.png', JText::_('COM_JINC_PERSONAL'), $options);

            foreach ($this->items as $i => $item) :
                $canEdit = $user->authorise('core.edit', 'com_jinc.newsletter.' . $item->news_id);
                $canSend = $user->authorise('jinc.send', 'com_jinc.newsletter.' . $item->news_id);
                ?>
                <tr class="row<?php echo $i % 2; ?>">
                    <td class="center hidden-phone">
                        <?php echo JHtml::_('grid.id', $i, $item->id); ?>
                    </td>
                    <td class="nowrap has-context">
                        <div class="pull-left">
                            <?php if ($canEdit) : ?>
                                <a href="<?php echo JRoute::_('index.php?option=com_jinc&task=message.edit&id=' . $item->id); ?>" title="<?php echo JText::_('JACTION_EDIT'); ?>">
                                    <?php echo $this->escape($item->subject); ?></a>
                            <?php else : ?>
                                <span title="<?php echo JText::sprintf('COM_JINC_SUBJECT', $this->escape($item->subject)); ?>"><?php echo $this->escape($item->subject); ?></span>
                            <?php endif; ?>
                        </div>

                        <?php if ($canSend) : ?>
                            <div class="pull-left">
                                <?php
                                JHtml::_('jincdropdown.send', $item->id);
                                JHtml::_('jincdropdown.preview', $item->id);
                                JHtml::_('dropdown.divider');
                                JHtml::_('jincdropdown.history', $item->id);
                                echo JHtml::_('dropdown.render');
                                ?>
                            </div>
                        <?php endif; ?>

                    </td>
                    <td class="nowrap has-context">
                        <div class="pull-left">
                            <?php
                            echo ($this->escape($item->bulkmail)) ? $bulk_img : $pers_img;
                            ?>
                        </div>
                    </td>

                    <td class="small hidden-phone">
                        <?php
                        $status = isset($item->status) ? $item->status : 0;
                        $max_status = isset($item->max_status) ? $item->max_status : 0;
                        switch ($status) {
                            case PROCESS_STATUS_PAUSED:
                                $options['title'] = JText::_('COM_JINC_PAUSED');
                                $status_img = JHTML::image(JURI::base() . 'components/com_jinc/assets/images/icons/pause.png', JText::_('COM_JINC_PAUSED'), $options);
                                break;
                            case PROCESS_STATUS_RUNNING:
                                $options['title'] = JText::_('COM_JINC_RUNNING');
                                $status_img = JHTML::image(JURI::base() . 'components/com_jinc/assets/images/icons/running.png', JText::_('COM_JINC_RUNNING'), $options);
                                break;
                            case PROCESS_STATUS_FINISHED:
                                $options['title'] = JText::_('COM_JINC_FINISHED');
                                $status_img = JHTML::image(JURI::base() . 'components/com_jinc/assets/images/icons/finished.png', JText::_('COM_JINC_FINISHED'), $options);
                                break;
                            default:
                                if ($item->datasent == 0) {
                                    $options['title'] = JText::_('COM_JINC_STOPPED');
                                    $status_img = JHTML::image(JURI::base() . 'components/com_jinc/assets/images/icons/stop.png', JText::_('COM_JINC_STOPPED'), $options);
                                } else {
                                    $options['title'] = JText::_('COM_JINC_FINISHED');
                                    $status_img = JHTML::image(JURI::base() . 'components/com_jinc/assets/images/icons/finished.png', JText::_('COM_JINC_FINISHED'), $options);
                                }
                                break;
                        }
                        echo $status_img;
                        ?>
                    </td>
                    <td class="small hidden-phone">
                        <?php echo $item->name; ?>
                    </td>

                    <td class="small hidden-phone">
                        <?php echo $this->escape(JFactory::getDate($item->datasent)); ?>
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