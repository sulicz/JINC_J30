<?php
/**
 * @version		$Id: jincview.php 10-jul-2013 14.39.48 lhacky $
 * @package		JINC
 * @subpackage          Utility
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
/**
 * JINC View class, extends JINCViewLegagy class in order to add JINC helpers 
 * features.
 *
 * @package		JINC
 * @subpackage          JHelper
 * @since		1.0
 */
defined('_JEXEC') or die();
jimport('joomla.application.component.view');

class JINCView extends JViewLegacy {

    protected function tmplListInit($hint = '') {
        $listOrder = $this->state->get('list.ordering');

        JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
        JHtml::_('bootstrap.tooltip');
        JHtml::_('behavior.multiselect');
        JHtml::_('formbehavior.chosen', 'select');
        JHtml::_('dropdown.init');

        jincimport('utility.jinchtmlhelper');
        jincimport('frontend.jhtmljincdropdown');

        if (strlen($hint) > 0)
            JINCHTMLHelper::hint($hint, $hint . '_TITLE');
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
        <?php
    }

    protected function tmplListFormInit() {
        $state = $this->state;
        $pagination = $this->pagination;
        $sortFields = $this->getSortFields();
        ?>
        <div id="j-main-container">
            <div id="filter-bar" class="btn-toolbar">
                <div class="filter-search btn-group pull-left">
                    <label for="filter_search" class="element-invisible"><?php echo JText::_('COM_JINC_FILTER_SEARCH_DESC'); ?></label>
                    <input type="text" name="filter_search" placeholder="<?php echo JText::_('COM_JINC_FILTER_SEARCH_DESC'); ?>" id="filter_search" value="<?php echo $this->escape($state->get('filter.search')); ?>" title="<?php echo JText::_('COM_CONTENT_FILTER_SEARCH_DESC'); ?>" />
                </div>
                <div class="btn-group pull-left hidden-phone">
                    <button class="btn tip hasTooltip" type="submit" title="<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>"><i class="icon-search"></i></button>
                    <button class="btn tip hasTooltip" type="button" onclick="document.id('filter_search').value = '';
                            this.form.submit();" title="<?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>"><i class="icon-remove"></i></button>
                </div>
                <div class="btn-group pull-right hidden-phone">
                    <label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC'); ?></label>
                    <?php echo $pagination->getLimitBox(); ?>
                </div>
                <div class="btn-group pull-right hidden-phone">
                    <label for="directionTable" class="element-invisible"><?php echo JText::_('JFIELD_ORDERING_DESC'); ?></label>
                    <select name="directionTable" id="directionTable" class="input-medium" onchange="Joomla.orderTable()">
                        <option value=""><?php echo JText::_('JFIELD_ORDERING_DESC'); ?></option>
                        <option value="asc" <?php if ($state->get('list.direction') == 'asc') echo 'selected="selected"'; ?>><?php echo JText::_('JGLOBAL_ORDER_ASCENDING'); ?></option>
                        <option value="desc" <?php if ($state->get('list.direction') == 'desc') echo 'selected="selected"'; ?>><?php echo JText::_('JGLOBAL_ORDER_DESCENDING'); ?></option>
                    </select>
                </div>
                <div class="btn-group pull-right">
                    <label for="sortTable" class="element-invisible"><?php echo JText::_('JGLOBAL_SORT_BY'); ?></label>
                    <select name="sortTable" id="sortTable" class="input-medium" onchange="Joomla.orderTable()">
                        <option value=""><?php echo JText::_('JGLOBAL_SORT_BY'); ?></option>
                        <?php echo JHtml::_('select.options', $sortFields, 'value', 'text', $state->get('list.ordering')); ?>
                    </select>
                </div>
            </div>

            <div class="clr"> </div>
        </div>
        <div class="clearfix"> </div>

        <?php
    }

    protected function tmplListEnd() {
        echo $this->pagination->getListFooter();
        ?>

        <input type="hidden" name="task" value="" />
        <input type="hidden" name="boxchecked" value="0" />
        <input type="hidden" name="filter_order" value="<?php echo $this->state->get('list.ordering'); ?>" />
        <input type="hidden" name="filter_order_Dir" value="<?php echo $this->state->get('list.direction'); ?>" />
        <?php
        echo JHtml::_('form.token');
    }

    protected function tmplListTH($columns, $cbcol = true, $idcol = true) {
        $listDirn = $this->state->get('list.direction');
        $listOrder = $this->state->get('list.ordering');
        echo '<thead>';
        echo '<tr>';
        if ($cbcol) {
            ?>
            <th width="1%" class="hidden-phone">
                <input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
            </th>
            <?php
        }
        foreach ($columns as $key => $value) {
            $options = array_key_exists('options', $value) ? $value['options'] : '';
            echo '<th ' . $options . '>';
            if ($value['sortable']) {
                echo JHtml::_('grid.sort', $value['label'], $value['dbcol'], $listDirn, $listOrder);
            } else {
                echo JText::_($value['label']);
            }
            echo '</th>';
        }
        if ($idcol) {
            ?>
            <th width="1%" class="nowrap hidden-phone">
                <?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'id', $listDirn, $listOrder); ?>
            </th>
            <?php
        }
        echo '</tr>';
        echo '</thead>';
    }

    protected function preEditForm($prefix) {
        // Load the tooltip behavior.
        JHtml::_('behavior.tooltip');
        JHtml::_('behavior.formvalidation');
        JHtml::_('behavior.keepalive');
        JHtml::_('formbehavior.chosen', 'select');
        ?>
        <script type = "text/javascript">
            Joomla.submitbutton = function(task)
            {
                if (task == '<?php echo $prefix; ?>.cancel' || document.formvalidator.isValid(document.id('item-form')))
                {
        <?php //echo $this->form->getField('articletext')->save();               
        ?>
                    Joomla.submitform(task, document.getElementById('item-form'));
                }
            }
        </script>
        <?php
    }

    protected function printTabHeader($name = 'general', $tag = 'COM_JINC_DETAILS', $active = false) {
        ?>
        <li <?php if ($active) { ?>class="active"<?php } ?> ><a href="<?php echo "#" . $name; ?>" data-toggle="tab"><?php echo JText::_($tag); ?></a></li>
        <?php
    }

    protected function printTabBodyFieldset($name) {
        ?>
        <div class="tab-pane" id="<?php echo $name; ?>">
            <div class="row-fluid">
                <div class="span6">
                    <div class="control-group">
                        <?php foreach ($this->form->getFieldset($name) as $name => $field) : ?>
                            <?php echo $field->label; ?>
                            <?php echo $field->input; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>                
        <?php
    }

    protected function printTabTwoColumns($id, $leftFormArray, $rightFormArray, $editor = NULL) {
        ?>
        <div class="tab-pane active" id="<?php echo $id; ?>">
            <div class="row-fluid">
                <div class="span6">
                    <fieldset class="adminform">
                        <?php
                        foreach ($leftFormArray as $value) {
                            echo $this->form->getLabel($value) . $this->form->getInput($value);
                        }
                        ?>
                    </fieldset>
                </div>

                <div class="span6">
                    <?php
                    foreach ($rightFormArray as $value) {
                        echo $this->form->getLabel($value) . $this->form->getInput($value);
                    }
                    ?>
                </div>
            </div>            
        </div>

        <?php
    }

    protected function printTabBodyGeneralRightCol($id, $formArray, $formArrayRight, $editor = NULL) {
        ?>
        <div class="tab-pane active" id="general">
            <div class="row-fluid">
                <div class="span9">
                    <fieldset class="adminform">
                        <?php
                        foreach ($formArray as $value) {
                            echo $this->form->getLabel($value) . $this->form->getInput($value);
                        }
                        if (!is_null($editor) && is_array($editor)) {
                            jincimport('utility.jinceditor');
                            $editorName = $editor[0];
                            $jEditor = $editor[1];
                            $jEditor->content = $this->item->$editorName;
                            if (!($this->item->id == 0))
                                $jEditor->setTemplate($this->item->id);

                            echo $this->form->getLabel($editorName) . $jEditor->display();
                        }
                        ?>
                    </fieldset>
                </div>

                <div class="span3">
                    <?php
                    foreach ($formArrayRight as $value) {
                        echo $this->form->getLabel($value) . $this->form->getInput($value);
                    }
                    ?>
                </div>
            </div>            
        </div>

        <?php
    }

    protected function printTabBodyPermission() {
        // if ($this->canDo->get('core.admin')) : 
        ?>
        <div class="tab-pane" id="permissions">
            <fieldset>
                <?php echo $this->form->getInput('rules'); ?>
            </fieldset>
        </div>
        <?php
        // endif;
    }

    protected function printEditEndForm() {
        $app = JFactory::getApplication();
        ?>
        <input type="hidden" name="task" value="" />
        <input type="hidden" name="return" value="<?php echo $app->input->getCmd('return'); ?>" />
        <?php
        echo JHtml::_('form.token');
    }

}
?>
