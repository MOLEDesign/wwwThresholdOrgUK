<?php
/**
* @package   yoo_solar
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

$warp = Warp::getInstance();

if (!$warp["config"]->get("fp_grid_status", 1)) {
	include($warp['path']->path('warp:systems/joomla/layouts/com_content/featured/default.php'));
	return;
}
?>

<div id="system">

	<?php if ($this->params->get('show_page_heading', 1)) : ?>
	<h1 class="title"><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
	<?php endif; ?>

	<?php
	
	// init vars
	$articles = array();
	
	// leading articles
	foreach ($this->lead_items as $item) {
		$this->item = $item;
		$articles[] = $this->loadTemplate('item');
	}

	foreach ($this->intro_items as $item) {
		$this->item = $item;
		$articles[] = $this->loadTemplate('item');
	}

	if (count($articles)) {

		echo '<div class="items grid-block">';

		foreach ($articles as &$article) {
			
			echo '<div class="grid-box">'.$article.'</div>';
		}

		echo '</div>';
	}
	?>

	<?php if (!empty($this->link_items)) : ?>
	<div class="item-list">
		<h3><?php echo JText::_('COM_CONTENT_MORE_ARTICLES'); ?></h3>
		<ul>
			<?php foreach ($this->link_items as &$item) : ?>
			<li>
				<a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catslug)); ?>"><?php echo $item->title; ?></a>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>
	<?php endif; ?>

	<?php if (($this->params->def('show_pagination', 1) == 1  || ($this->params->get('show_pagination') == 2)) && ($this->pagination->get('pages.total') > 1)) : ?>
	<?php echo $this->pagination->getPagesLinks(); ?>
	<?php endif; ?>

</div>

<script type="text/javascript">
	
	window.GRIDALICIOUS_IN_USE = true;

	jQuery(function($){
		$('.items.grid-block').gridalicious({ 
			selector: '.grid-box', 
			width: <?php echo $warp["config"]->get("fp_grid_colwidth", 300);?>,
			gutter: <?php echo $warp["config"]->get("fp_grid_gutter", 10);?>,			
			animate: (<?php echo $warp["config"]->get("fp_grid_animation", 0);?>) ? true:false,
			animationOptions: {
				speed: <?php echo $warp["config"]->get("fp_grid_speed", 200);?>,
				duration: <?php echo $warp["config"]->get("fp_grid_duration", 300);?>
			}
		});
	});
</script>