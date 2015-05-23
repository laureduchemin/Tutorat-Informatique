<?php
/**
 *------------------------------------------------------------------------------
 *  iCagenda v3 by Jooml!C - Events Management Extension for Joomla! 2.5 / 3.x
 *------------------------------------------------------------------------------
 * @package     com_icagenda
 * @copyright   Copyright (c)2012-2015 Cyril Rezé, Jooml!C - All rights reserved
 *
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * @author      Cyril Rezé (Lyr!C)
 * @link        http://www.joomlic.com
 *
 * @version     3.4.1 2015-01-09
 * @since       3.2.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();
?>
<!--
 * - - - - - - - - - - - - - -
 * iCagenda 3.5.2 by Jooml!C
 * - - - - - - - - - - - - - -
 * @copyright	Copyright (c)2012-2015 JOOMLIC - All rights reserved.
 *
-->
<?php

// Get the site name
$config = JFactory::getConfig();

if(version_compare(JVERSION, '3.0', 'ge'))
{
	$sitename = $config->get('sitename');
}
else
{
	$sitename = $config->getValue('config.sitename');
}

// Get Component Global Options
$iCparams = JComponentHelper::getParams('com_icagenda');

// Get Authorized user groups (approval managers)
$approvalGroups = $iCparams->get('approvalGroups', array("8"));

// Get User
$user = JFactory::getUser();
$u_id = $user->get('id');

// Control: if Manager
jimport( 'joomla.access.access' );
$adminUsersArray = array();

foreach ($approvalGroups AS $ag)
{
	$adminUsers = JAccess::getUsersByGroup($ag, False);
	$adminUsersArray = array_merge($adminUsersArray, $adminUsers);
}

if ( in_array($u_id, $adminUsersArray ))
{
	$not_manager			= false;
}
else
{
	$not_manager			= true;
}

//$urllink = JURI::getInstance()->toString();
//$urllink = preg_replace('/&view=[^&]*/', '', $urllink);
//$urlNewEvent = preg_replace('/&layout=[^&]*/', '', $urllink);
$urlNewEvent = str_replace('&amp;','&', JRoute::_('index.php?option=com_icagenda&view=submit'));

// clear the data so we don't process it again
$session = JFactory::getSession();
$session->clear('ic_submit');
$session->clear('custom_fields');
$session->clear('ic_submit_dates');
$session->clear('ic_submit_catid');
$session->clear('ic_submit_shortdesc');
$session->clear('ic_submit_metadesc');
$session->clear('ic_submit_city');
$session->clear('ic_submit_country');
$session->clear('ic_submit_lat');
$session->clear('ic_submit_lat');
$session->clear('ic_submit_address');
?>

<div id="icagenda" class="ic-send<?php echo $this->pageclass_sfx; ?>">
<?php if($not_manager) : ?>
	<div><?php echo JText::_( 'COM_ICAGENDA_EVENT_SUBMISSION_EDITOR_REVIEW' ); ?></div>
	<div><?php echo JText::_( 'COM_ICAGENDA_EVENT_SUBMISSION_CONFIRMATION_EMAIL' ); ?></div>
	<div><?php echo JText::sprintf( 'COM_ICAGENDA_EVENT_SUBMISSION_THANK_YOU', $sitename ); ?></div>
	<br />
	<div>
		<a href="index.php" class="btn btn-small btn-info button">
		<?php if(version_compare(JVERSION, '3.0', 'ge')) : ?>
			<i class="icon-home icon-white"></i>&nbsp;<?php echo JTEXT::_('JERROR_LAYOUT_HOME_PAGE'); ?>
		<?php else : ?>
			<span style="color:#FFF"><?php echo JTEXT::_('JERROR_LAYOUT_HOME_PAGE'); ?></span>
		<?php endif; ?>
		</a>
		&nbsp;
		<a href="<?php echo JRoute::_($urlNewEvent); ?>" class="btn btn-small btn-success button">
		<?php if(version_compare(JVERSION, '3.0', 'ge')) : ?>
			<i class="icon-plus icon-white"></i>&nbsp;<?php echo JTEXT::_('COM_ICAGENDA_EVENT_SUBMISSION_SUBMIT_NEW_EVENT'); ?>
		<?php else : ?>
			<span style="color:#FFF"><?php echo JTEXT::_('COM_ICAGENDA_EVENT_SUBMISSION_SUBMIT_NEW_EVENT'); ?></span>
		<?php endif; ?>
		</a>
	</div>
	<br />
<?php else : ?>
	<br />
	<div>
		<a href="index.php" class="btn btn-small btn-info button">
		<?php if(version_compare(JVERSION, '3.0', 'ge')) : ?>
			<i class="icon-home icon-white"></i>&nbsp;<?php echo JTEXT::_('JERROR_LAYOUT_HOME_PAGE'); ?>
		<?php else : ?>
			<span style="color:#FFF"><?php echo JTEXT::_('JERROR_LAYOUT_HOME_PAGE'); ?></span>
		<?php endif; ?>
		</a>
		&nbsp;
		<a href="<?php echo JRoute::_($urlNewEvent); ?>" class="btn btn-small btn-success button">
		<?php if(version_compare(JVERSION, '3.0', 'ge')) : ?>
			<i class="icon-plus icon-white"></i>&nbsp;<?php echo JTEXT::_('COM_ICAGENDA_EVENT_SUBMISSION_SUBMIT_NEW_EVENT'); ?>
		<?php else : ?>
			<span style="color:#FFF"><?php echo JTEXT::_('COM_ICAGENDA_EVENT_SUBMISSION_SUBMIT_NEW_EVENT'); ?></span>
		<?php endif; ?>
		</a>
	</div>
	<br />
<?php endif; ?>
</div>
<?php
if (version_compare(JVERSION, '3.0', 'lt'))
{
	JHtml::_('stylesheet', 'icagenda.css', 'administrator/components/com_icagenda/add/css/');
	JHtml::_('stylesheet', 'icagenda.j25.css', 'components/com_icagenda/add/css/');
}
