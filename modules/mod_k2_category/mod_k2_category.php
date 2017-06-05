<?php

// no direct access
defined('_JEXEC') or die ;

if (K2_JVERSION != '15')
{
    $language = JFactory::getLanguage();
    $language->load('mod_k2.j16', JPATH_ADMINISTRATOR, null, true);
}

require_once (dirname(__FILE__).DS.'helper.php');

// Params
$moduleclass_sfx = $params->get('moduleclass_sfx', '');
$getTemplate = $params->get('getTemplate', 'Default');
$catCustomLinkTitle = $params->get('catCustomLinkTitle', '');
if ($params->get('catCustomLinkMenuItem'))
{
    $menu = JMenu::getInstance('site');
    $menuLink = $menu->getItem($params->get('catCustomLinkMenuItem'));
    if (!$catCustomLinkTitle)
    {
        $catCustomLinkTitle = (K2_JVERSION != '15') ? $menuLink->title : $menuLink->name;
    }
    $params->set('catCustomLinkURL', JRoute::_('index.php?&Itemid='.$menuLink->id));
}

// Get component params
$componentParams = JComponentHelper::getParams('com_k2');

$categories = modK2CategoryHelper::getCategories($params);

if (count($categories))
{
    require (JModuleHelper::getLayoutPath('mod_k2_category', $getTemplate.DS.'default'));
}