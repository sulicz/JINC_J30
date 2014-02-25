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

jincimport('core.newsletter');
$this->preEditForm('newsletter');
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

<form action="<?php echo JRoute::_('index.php?option=com_jinc&layout=edit&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="item-form" class="form-validate">
    <div class="form-inline form-inline-header">
        <?php
        $form = $this->getForm();
        echo $form->getControlGroup('name');
        echo $form->getControlGroup('type');
        ?>
    </div>   


    <div class="row-fluid">
        <!-- Begin Content -->
        <div class="form-horizontal">
            <ul class="nav nav-tabs">
                <?php
                $this->printTabHeader('general', 'COM_JINC_DETAILS', true);
                $this->printTabHeader('frontend', 'COM_JINC_FRONTEND_SECURITY');
                $this->printTabHeader('welcome', 'COM_JINC_WELCOME_DISCLAINER');
                $this->printTabHeader('optin', 'COM_JINC_OPTIN');
                $this->printTabHeader('addictional', 'COM_JINC_ATTRIBUTES');
                $this->printTabHeader('permissions', 'COM_JINC_PERMISSION');
                ?>
            </ul>

            <div class="tab-content">
                <!-- Begin Tabs -->

                <?php
                $formArray = array('description');
                $formArrayRight = array('on_subscription', 'jcontact_enabled', 'notify', 'default_template', 'sendername', 'senderaddr', 'replyto_name', 'replyto_addr');

                $this->printTabBodyGeneralRightCol('general', $formArray, $formArrayRight);
                $this->printTabBodyFieldset('frontend');
                $this->printTabTwoColumns('welcome', array('welcome_subject', 'welcome'), 
                        array('disclaimer'));
                $this->printTabTwoColumns('optin', array('optin_subject', 'optin'),
                        array('optinremove_subject', 'optinremove'));
                $this->printTabBodyFieldset('addictional');
                $this->printTabBodyPermission();
                ?>

            </div>
            <?php $this->printEditEndForm(); ?>
        </div>

</form>

<script type="text/javascript">
    onChangeType();
</script>