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

$this->preEditForm('message');

JHTML::script('administrator/components/com_jinc/assets/js/phplivex.js');
JHTML::script('administrator/components/com_jinc/assets/js/commons.js');
$ajax_loader = JHTML::image(JURI::base() . 'components/com_jinc/assets/images/icons/simple-loader.gif', JText::_('COM_JINC_LOADING'), array("height" => 16, "width" => 16));
jincimport('utility.PHPLiveX');
jincimport('utility.jinchtmlhelper');
jincimport('utility.jinceditor');
?>

<form action="<?php echo JRoute::_('index.php?option=com_jinc&layout=edit&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="item-form" class="form-validate">
    <div class="row-fluid">
        <!-- Begin Content -->
        <div class="span10 form-horizontal">
            <ul class="nav nav-tabs">
                <?php
                $this->printTabHeader('general', 'COM_JINC_DETAILS', true);
                $this->printTabHeader('basic_opts', 'COM_JINC_BASIC_OPTIONS');
                $this->printTabHeader('attachment', 'COM_JINC_ATTACHMENTS');
                ?>
            </ul>

            <div class="tab-content">
                <!-- Begin Tabs -->

                <?php
                $formArray = array('subject', 'news_id', 'tem_id');
                $jeditor = new JINCEditor('jform[body]');
                $this->printTabBodyGeneral('general', $formArray, array('body', $jeditor) );
                $this->printTabBodyFieldset('basic_opts');
                $this->printTabBodyFieldset('attachment');
                ?>

            </div>
            <?php $this->printEditEndForm(); ?>
        </div>
</form>

<script type="text/javascript">
    function selectTemplate(id) {
        SqueezeBox.close();
        getTemplate(id);
    }
    
    function getTemplate(id) {
        var plx = new PHPLiveX();
        return plx.ExternalRequest({
            'content_type': 'json',
            'url': 'index.php?option=com_jinc&task=templateJSON.getTemplateInfo&format=json',
            'onFinish': function(response){                
                var content = <?php echo $jeditor->getContent(); ?>
                var answer = true;
                if ((content != undefined) && (content.length > 0)) answer = confirm ('<?php echo addslashes(JText::_('COM_JINC_OVERWRITE_JS')); ?>');
                if (answer) {                    
                    document.getElementById("jform_subject").value = response.subject;
                    var newbody = response.body;
                    if(newbody.length > 2){<?php echo $jeditor->setContent('newbody') ?>};
                    document.getElementById('jform_tem_id').value = id;                 
                }
            },
            'params':{'id': id}
        });
    }

    function getDefaultTemplate() {
        id = document.getElementById("jform_news_id").value;
        var plx = new PHPLiveX();
        return plx.ExternalRequest({
            'content_type': 'json',
            'url': 'index.php?option=com_jinc&task=newsletterJSON.getDefaultTemplate&format=json',
            'onFinish': function(response){
                var tem_id = response.tem_id;
                if (tem_id != 0) {
                    getTemplate(tem_id);
                }
            },
            'params':{'id': id}
        });
    }
</script>

<script type="text/javascript">
    <!--
    function submitbutton(task) {
        if (task == 'message.cancel' || document.formvalidator.isValid(document.id('message-form'))) {
            submitform(task);
        }
        submitform(task);
    }
    // -->
</script>