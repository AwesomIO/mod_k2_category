<?php

// no direct access
defined('_JEXEC') or die ;

require_once (JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'helpers'.DS.'route.php');
require_once (JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'helpers'.DS.'utilities.php');

class modK2CategoryHelper
{

	public static function getCategories(&$params)
	{

		jimport('joomla.filesystem.file');
		$mainframe = JFactory::getApplication();

		$user = JFactory::getUser();
		$aid = $user->get('aid');
		$db = JFactory::getDBO();

		$value = $params->get('categories');
		$current = array();
		if (is_string($value) && !empty($value))
			$current[] = $value;
		if (is_array($value))
			$current = $value;

		$categories = array();
		
		foreach ($current as $id)
		{

			$query = "SELECT c.*
			FROM #__k2_categories as c";
			$query .= " WHERE c.id = {$id}";
			if (K2_JVERSION != '15')
			{
				$query .= " AND c.access IN(".implode(',', $user->getAuthorisedViewLevels()).") ";
			}
			else
			{
				$query .= " AND c.access<={$aid} ";
			}
			$query .= " AND c.trash = 0 AND c.published = 1";
			if (K2_JVERSION != '15')
			{
				if ($mainframe->getLanguageFilter())
				{
					$languageTag = JFactory::getLanguage()->getTag();
					$query .= " AND c.language IN (".$db->Quote($languageTag).", ".$db->Quote('*').")";
				}
			}
			$db->setQuery($query);
			$category = $db->loadObject();
			if ($category)
				$categories[] = $category;

		}
		
		if (count($categories))
		{

			foreach ($categories as $category)
			{

				//Clean title
				$category->name = JFilterOutput::ampReplace($category->name);
				
				//Category link
				$category->link = urldecode(JRoute::_(K2HelperRoute::getCategoryRoute($category->id.':'.urlencode($category->alias))));

				//Description
				$category->text = $category->description;
				// Word limit
				if ($params->get('catDescriptionLimit'))
				{
					$category->description = K2HelperUtilities::wordLimit($category->text, $params->get('catDescriptionLimit'));
				}
				else
				{
					$category->description = $category->text;
				}
				
				//Image
				$category->image = K2HelperUtilities::getCategoryImage($category->image, $params);
				
				$rows[] = $category;
			}

			return $rows;

		}
	}

}
