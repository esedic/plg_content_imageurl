<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  User.joomla
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

class PlgContentImageurl extends JPlugin
{

	function PlgContentImageurl( &$subject, $params )
	{
		parent::__construct( $subject, $params );
	}

	public function onContentPrepare($context, &$article, &$params, $limitstart) {

		$db	= JFactory::getDbo();

		// 1-INTRO IMAGE REPLACEMENT
		$needle_images_intro = 'image_intro":"images';
		$heist_images_intro = 'image_intro":"http://www.investo.si/images';
		$needle_images_full = 'image_fulltext":"images';
		$heist_images_full = 'image_fulltext":"http://www.investo.si/images';
		// 2-INTROTEXT IMAGE REPLACEMENT
		$needle_introtext = 'src="images';
		$heist_introtext = 'src="http://www.investo.si/images';

		$sql = "UPDATE `#__content` SET `images` = REPLACE(`images`, '".$needle_images_intro."', '".$heist_images_intro."'); UPDATE `#__content` SET `images` = REPLACE(`images`, '".$needle_images_full."', '".$heist_images_full."'); UPDATE `#__content` SET `introtext` = REPLACE(`introtext`, '".$needle_introtext."', '".$heist_introtext."')";

		$queries = JDatabaseDriver::splitSql($sql);
		foreach ($queries as $query)
			{
				try
			{
				$db->setQuery($query)->execute();
			}
				catch (RuntimeException $e)
			{
				JFactory::getApplication()->enqueueMessage($e->getMessage());
			}
		}

	}

}
