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

$this->tmplListInit('SUBSCRIBERS_LIST');
?>

<form action="<?php echo JRoute::_('index.php?option=com_jinc&view=subscribers'); ?>" method="post" name="adminForm" id="adminForm"> 
    <?php
    $this->tmplListFormInit();
    ?>

    <table class="table table-striped" id="articleList">
        <?php
        $headers = array();
        array_push($headers, array('dbcol' => 'subs_email', 'label' => 'COM_JINC_MAIL_ADDRESS',
            'sortable' => true));
        array_push($headers, array('dbcol' => 'n.name', 'label' => 'COM_JINC_NEWS_NAME',
            'sortable' => true, 'options' => 'width="25%" class="nowrap hidden-phone"'));
        $this->tmplListTH($headers);
        ?>

        <tbody>
            <?php
            foreach ($this->items as $i => $item) :
                ?>
                <tr class="row<?php echo $i % 2; ?>">
                    <td class="center hidden-phone">
                        <?php echo JHtml::_('grid.id', $i, $item->id); ?>
                    </td>
                    <td class="nowrap has-context">
                        <div class="pull-left">
                            <a class="modal" href="index.php?option=com_jinc&view=subscriber&tmpl=component&id=<?php echo $item->id; ?>" rel="{handler: 'iframe', size: {x: 875, y: 550}, onClose: function() {}}">
                                <?php echo $item->subs_email; ?>
                            </a>
                            <?php                        
                              if (strlen($item->random) > 0) {
                                if (is_null($item->datasub)) {
                                    echo '&nbsp;&nbsp;&nbsp;&nbsp;(' . JText::_('COM_JINC_WAITING_OPTIN') . ")</i>";
                                }
                              }
                            ?>
                        </div>
                    </td>
                    <td>
                        <a href="<?php echo JRoute::_('index.php?option=com_jinc&view=newsletter&task=newsletter.edit&id=' . $item->id); ?>"><?php echo $item->name; ?></a>
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