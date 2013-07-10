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

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('dropdown.init');
JHtml::_('formbehavior.chosen', 'select');

$user = JFactory::getUser();
isset($this->items) or die('Items not defined');
jincimport('utility.jinchtmlhelper');
jincimport('frontend.jhtmljincdropdown');
jincimport('core.newsletter');
JINCHTMLHelper::hint('NEWSLETTER_LIST', 'NEWSLETTER_LIST_TITLE');
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn = $this->escape($this->state->get('list.direction'));
$userId = $user->get('id');

$sortFields = $this->getSortFields();
?>
<script type="text/javascript">
    Joomla.orderTable = function()
    {
        table = document.getElementById("sortTable");
        direction = document.getElementById("directionTable");
        order = table.options[table.selectedIndex].value;
        if (order != '<?php echo $listOrder; ?>')
        {
            dirn = 'asc';
        }
        else
        {
            dirn = direction.options[direction.selectedIndex].value;
        }
        Joomla.tableOrdering(order, dirn, '');
    }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_jinc&view=newsletters'); ?>" method="post" name="adminForm" id="adminForm">
    <div id="j-main-container">
        <div id="filter-bar" class="btn-toolbar">
            <div class="filter-search btn-group pull-left">
                <label for="filter_search" class="element-invisible"><?php echo JText::_('COM_JINC_FILTER_SEARCH_DESC'); ?></label>
                <input type="text" name="filter_search" placeholder="<?php echo JText::_('COM_JINC_FILTER_SEARCH_DESC'); ?>" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_CONTENT_FILTER_SEARCH_DESC'); ?>" />
            </div>
            <div class="btn-group pull-left hidden-phone">
                <button class="btn tip hasTooltip" type="submit" title="<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>"><i class="icon-search"></i></button>
                <button class="btn tip hasTooltip" type="button" onclick="document.id('filter_search').value='';this.form.submit();" title="<?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>"><i class="icon-remove"></i></button>
            </div>
            <div class="btn-group pull-right hidden-phone">
                <label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC'); ?></label>
                <?php echo $this->pagination->getLimitBox(); ?>
            </div>
            <div class="btn-group pull-right hidden-phone">
                <label for="directionTable" class="element-invisible"><?php echo JText::_('JFIELD_ORDERING_DESC'); ?></label>
                <select name="directionTable" id="directionTable" class="input-medium" onchange="Joomla.orderTable()">
                    <option value=""><?php echo JText::_('JFIELD_ORDERING_DESC'); ?></option>
                    <option value="asc" <?php if ($listDirn == 'asc') echo 'selected="selected"'; ?>><?php echo JText::_('JGLOBAL_ORDER_ASCENDING'); ?></option>
                    <option value="desc" <?php if ($listDirn == 'desc') echo 'selected="selected"'; ?>><?php echo JText::_('JGLOBAL_ORDER_DESCENDING'); ?></option>
                </select>
            </div>
            <div class="btn-group pull-right">
                <label for="sortTable" class="element-invisible"><?php echo JText::_('JGLOBAL_SORT_BY'); ?></label>
                <select name="sortTable" id="sortTable" class="input-medium" onchange="Joomla.orderTable()">
                    <option value=""><?php echo JText::_('JGLOBAL_SORT_BY'); ?></option>
                    <?php echo JHtml::_('select.options', $sortFields, 'value', 'text', $listOrder); ?>
                </select>
            </div>
        </div>

        <div class="clr"> </div>
    </div>
    <div class="clearfix"> </div>

    <table class="table table-striped" id="newsletterList">
        <thead>
            <tr>
                <th width="1%" class="hidden-phone">
                    <input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
                </th>
                <th width="1%" style="min-width:55px" class="nowrap center">
                    <?php echo JHtml::_('grid.sort', 'COM_JINC_STATUS', 'published', $listDirn, $listOrder); ?>
                </th>
                <th>
                    <?php echo JHtml::_('grid.sort', 'COM_JINC_LIST_NEWS_NAME', 'name', $listDirn, $listOrder); ?>
                </th>
                <th width="1%" style="min-width:55px" class="nowrap center">
                    <?php echo JHtml::_('grid.sort', 'COM_JINC_LIST_TYPE', 'type', $listDirn, $listOrder); ?>
                </th>
                <th width="10%" class="nowrap hidden-phone">
                    <?php echo JHtml::_('grid.sort', 'COM_JINC_LIST_CREATED', 'created', $listDirn, $listOrder); ?>
                </th>
                <th width="10%" class="nowrap hidden-phone">
                    <?php echo JHtml::_('grid.sort', 'COM_JINC_LIST_SENDER_ADDRESS', 'senderaddr', $listDirn, $listOrder); ?>
                </th>
                <th width="10%" class="nowrap hidden-phone">
                    <?php echo JHtml::_('grid.sort', 'COM_JINC_LIST_SENDER_NAME', 'sendername', $listDirn, $listOrder); ?>
                </th>
                <th width="1%" class="nowrap hidden-phone">
                    <?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'id', $listDirn, $listOrder); ?>
                </th>
            </tr>
        </thead>    
        <tbody>
            <?php
            $base_url = JURI::base() . 'components/com_jinc/assets/images/';
            $public_img = JHTML::image($base_url . 'send_f2.png', JText::_('COM_JINC_LEGEND_PUBLIC'), array("height" => 16, "width" => 16));
            $private_img = JHTML::image($base_url . 'security_f2.png', JText::_('COM_JINC_LEGEND_PRIVATE'), array("height" => 16, "width" => 16));
            foreach ($this->items as $i => $item) :
                $canCheckin = $user->authorise('core.manage', 'com_checkin') || $item->checked_out == $userId || $item->checked_out == 0;
                $canChange = $user->authorise('core.edit.state', 'com_jinc.newsletter.' . $item->id) && $canCheckin;
                $canEdit = $user->authorise('core.edit', 'com_jinc.newsletter.' . $item->id);
                ?>
                <tr class="row<?php echo $i % 2; ?>">
                    <td class="center hidden-phone">
                        <?php echo JHtml::_('grid.id', $i, $item->id); ?>
                    </td>
                    <td class="center">
                        <div class="hidden-phone">
                            <?php echo JHtml::_('jgrid.published', $item->published, $i, 'newsletters.', $canChange, 'cb', $item->published, 1 - $item->published); ?>
                        </div>
                    </td>
                    <td class="nowrap has-context">
                        <div class="pull-left">
                            <?php if ($canEdit) : ?>
                                <a href="<?php echo JRoute::_('index.php?option=com_jinc&task=newsletter.edit&id=' . $item->id); ?>" title="<?php echo JText::_('JACTION_EDIT'); ?>">
                                    <?php echo $this->escape($item->name); ?></a>
                            <?php else : ?>
                                <span title="<?php echo JText::sprintf('COM_JINC_TITLE', $this->escape($item->name)); ?>"><?php echo $this->escape($item->name); ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="pull-left">
                            <?php
                            JHtml::_('jincdropdown.import', $item->id, 'newsletter');
                            // JHtml::_('jincdropdown.stats', $item->id, 'newsletter.');
                            echo JHtml::_('dropdown.render');
                            ?>
                        </div>


                    </td>
                    <td class="hidden-phone">
                        <?php
                        echo ($item->type == NEWSLETTER_PUBLIC_NEWS) ? $public_img : $private_img;
                        ?>
                    </td>
                    <td class="small hidden-phone">
                        <?php echo $this->escape(JFactory::getDate($item->created)); ?>
                    </td>
                    <td class="small hidden-phone">
                        <?php echo $this->escape($item->senderaddr); ?>
                    </td>
                    <td class="small hidden-phone">
                        <?php echo $this->escape($item->sendername); ?>
                    </td>
                    <td class="center hidden-phone">
                        <?php echo (int) $item->id; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php echo $this->pagination->getListFooter(); ?>

    <?php
    $legend_array = array();
    array_push($legend_array, array('text' => 'COM_JINC_LEGEND_PUBLIC',
        'icon' => 'send_f2.png'));
    array_push($legend_array, array('text' => 'COM_JINC_LEGEND_PRIVATE',
        'icon' => 'security_f2.png'));
    JINCHTMLHelper::legend($legend_array);
    ?>
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="0" />
    <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
    <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
    <?php echo JHtml::_('form.token'); ?>
</form>