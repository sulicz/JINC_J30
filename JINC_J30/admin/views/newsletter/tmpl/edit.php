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
defined('_JEXEC') or die;

// Load the tooltip behavior.
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');
JHtml::_('formbehavior.chosen', 'select');

jincimport('core.newsletter');
$app = JFactory::getApplication();
$input = $app->input;
?>
<script type="text/javascript">
    function onChangeType() {
        var jform_jcontact_enabled = document.getElementById('jform_jcontact_enabled');
        var jform_type = document.getElementById("jform_type");
        var news_type = jform_type.options[jform_type.selectedIndex].value;
                
        jform_jcontact_enabled.disabled = (news_type != <?php echo NEWSLETTER_PRIVATE_NEWS; ?>);        
        if (news_type != <?php echo NEWSLETTER_PRIVATE_NEWS; ?>) {
            jform_jcontact_enabled.selectedIndex = 0;
        }
    }        
</script>

<script type="text/javascript">
    Joomla.submitbutton = function(task)
    {
        if (task == 'article.cancel' || document.formvalidator.isValid(document.id('item-form')))
        {
<?php //echo $this->form->getField('articletext')->save();              ?>
            Joomla.submitform(task, document.getElementById('item-form'));
        }
    }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_jinc&layout=edit&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="item-form" class="form-validate">
    <div class="row-fluid">
        <!-- Begin Content -->
        <div class="span10 form-horizontal">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#general" data-toggle="tab"><?php echo JText::_('COM_CONTENT_NEWSLETTER_DETAILS'); ?></a></li>                
                <li><a href="#addresses" data-toggle="tab"><?php echo JText::_('COM_JINC_ADDRESSES'); ?></a></li>
                <li><a href="#permissions" data-toggle="tab"><?php echo JText::_('COM_JINC_PERMISSION'); ?></a></li>                
            </ul>

            <div class="tab-content">
                <!-- Begin Tabs -->
                <div class="tab-pane active" id="general">
                    <fieldset class="adminform">
                        <div class="control-group">
                            <?php
                            $formArray = array('name', 'type', 'on_subscription', 'jcontact_enabled', 'notify', 'default_template');
                            foreach ($formArray as $value) {
                                echo $this->form->getLabel($value) . $this->form->getInput($value);
                            }
                            ?>
                        </div>
                        <?php echo $this->form->getLabel('description'); ?>
                        <?php echo $this->form->getInput('description'); ?>
                    </fieldset>
                </div>

                <div class="tab-pane" id="addresses">
                    <div class="row-fluid">
                        <div class="span6">
                            <div class="control-group">
                                <?php foreach ($this->form->getFieldset('addresses') as $name => $field) : ?>
                                    <?php echo $field->label; ?>
                                    <?php echo $field->input; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>                

                <?php // if ($this->canDo->get('core.admin')) : ?>
                <div class="tab-pane" id="permissions">
                    <fieldset>
                        <?php echo $this->form->getInput('rules'); ?>
                    </fieldset>
                </div>
                <?php // endif; ?>
                <!-- End Tabs -->
            </div>
            <input type="hidden" name="task" value="" />
            <input type="hidden" name="return" value="<?php echo $input->getCmd('return'); ?>" />
            <?php echo JHtml::_('form.token'); ?>
        </div>
</form>

<script type="text/javascript">
    onChangeType();
</script>