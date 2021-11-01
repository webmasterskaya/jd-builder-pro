<?php

/**
 * @package    JD Builder
 * @author     Team Joomdev <info@joomdev.com>
 * @copyright  2020 www.joomdev.com
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '\/helpers/');
// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet(JUri::root() . 'administrator/components/com_jdbuilder/assets/css/jdbuilder.css');
$document->addStyleSheet(JUri::root() . 'media/com_jdbuilder/css/list.css');

$buiderConfig = JComponentHelper::getParams('com_jdbuilder');
$article_integration = $buiderConfig->get('article_integration',  1);
?>
<div>
   <?php if (!empty($this->sidebar)) : ?>
      <div id="j-sidebar-container" class="span2">
         <?php echo $this->sidebar; ?>
      </div>
      <div id="j-main-container" class="span10">
      <?php else : ?>
         <div id="j-main-container">
         <?php endif; ?>
         <div class="clearfix"></div>
         <table class="table">
            <tbody>
               <tr>
                  <td style="border: none">
                     <div class="jdb-integration-item">
                        <div class="item-icon">
                           <img src="<?php echo JURI::root(); ?>/media/jdbuilder/images/joomla.svg" />
                        </div>
                        <a href="<?php echo JRoute::_('index.php?option=com_jdbuilder&task=integrations.articleToggle'); ?>" class="item-title">
                           <h4>Joomla Articles <span class="item-switch"><img src="<?php echo JURI::root(); ?>/media/jdbuilder/images/switch-<?php echo $article_integration ? 'on' : 'off'; ?>.svg" /><span></h4>
                        </a>
                     </div>
                  </td>
               </tr>
            </tbody>
         </table>
         <div class="component-version-container">
            <span class="component-version"><?php echo \JText::_('COM_JDBUILDER'); ?> <span>v<?php echo JDB_VERSION; ?></span><?php echo \JText::_('JDBUILDER_VERSION_LABEL'); ?>| Developed with <span style="color: red">&hearts;</span> by <a href="https://www.joomdev.com" target="_blank">JoomDev</a></span>
            <div class="support-link">
               <a href="https://docs.joomdev.com/category/jd-builder/" target="_blank">Documentation</a> <span>|</span> <a href="https://www.joomdev.com/jd-builder/changelog" target="_blank">Changelog</a> <span>|</span> <a href="https://www.joomdev.com/forum/jd-builder" target="_blank">Forum</a> <span>|</span> <a href="https://www.youtube.com/playlist?list=PLv9TlpLcSZTAnfiT0x10HO5GGaTJhUB1K" target="_blank">Video Tutorials</a> <span>|</span> <a href="https://extensions.joomla.org/extension/jd-builder" target="_blank"><span class="icon-joomla"></span> Rate Us</a>
            </div>
         </div>
         </div>
      </div>
</div>