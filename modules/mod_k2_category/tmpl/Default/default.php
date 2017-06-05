<?php
// no direct access
defined('_JEXEC') or die;
?>
<div id="k2ModuleBox<?php echo $module->id; ?>" class="k2CategoryBlock<?php if($params->get('moduleclass_sfx')) echo ' '.$params->get('moduleclass_sfx'); ?>">
	<ul>
		<?foreach($categories as $category):?>
			<li>
				<a href="<?php echo $category->link;?>">
					<?php echo $category->name;?>
				</a>
			</li>
		<?endforeach;?>
	</ul>
	<?php if($params->get('catCustomLink')): ?>
		<a href="<?php echo $params->get('catCustomLinkURL'); ?>" title="<?php echo K2HelperUtilities::cleanHtml($catCustomLinkTitle); ?>"><?php echo $catCustomLinkTitle; ?></a>
	<?php endif; ?>
</div>