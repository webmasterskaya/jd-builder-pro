<?php

/**
 * @package    JD Builder
 * @author     Team Joomdev <info@joomdev.com>
 * @copyright  2020 www.joomdev.com
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
extract($displayData);
jimport('joomla.application.component.helper');

$element->addClass('jdb-facebook-page');
$buiderConfig = JComponentHelper::getParams('com_jdbuilder');
$fbAppId = $buiderConfig->get('fbAppId',  '');
$fbPageUrl = $element->params->get('fbPageUrl', '');

if (empty($fbPageUrl)) {
    return false;
}

$layout = $element->params->get('fbLayout', \json_decode('[]'));
$header = $element->params->get('smallHeader', true);
$cover = $element->params->get('coverPhoto', true);
$facepile = $element->params->get('facepile', true);
$cta = $element->params->get('cta', true);
// $cta = $element->params->get('cta', false);
$width = $element->params->get('fbWidth', \json_decode('{value:340}'));
$height = $element->params->get('fbHeight', \json_decode('{value:500}'));

?>
<iframe src="https://www.facebook.com/plugins/page.php?href=<?php echo urlencode($fbPageUrl); ?>&tabs=<?php echo implode(',', $layout); ?>&width=<?php echo $width->value; ?>&height=<?php echo $height->value; ?>&small_header=<?php echo $header ? 'true' : 'false'; ?>&adapt_container_width=true&hide_cover=<?php echo $cover ? 'false' : 'true'; ?>&show_facepile=<?php echo $facepile ? 'true' : 'false'; ?>&hide_cta=<?php echo $cta ? 'false' : 'true'; ?><?php echo !empty($fbAppId) ? '&appId=' . $fbAppId : ''; ?>" width="<?php echo $width->value; ?>" height="<?php echo $height->value; ?>" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>