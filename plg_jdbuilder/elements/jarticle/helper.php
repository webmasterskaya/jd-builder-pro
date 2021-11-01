<?php

/**
 * @package    JD Builder
 * @author     Team Joomdev <info@joomdev.com>
 * @copyright  2020 www.joomdev.com
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

use JDPageBuilder\ElementHelper as ElementHelper;

class JDBuilderJarticleElementHelper extends ElementHelper
{
    public static function getArticle($id = 0, $format = '')
    {
        $app = \JFactory::getApplication();

        if (empty($id)) {
            $id = $app->input->get('id', 0, 'INT');
        }

        if (empty($format)) {
            $format = $app->input->get('dateFormat', 'd M, Y', 'RAW');
        }
        if (empty($format)) {
            $format = 'd M, Y';
        }

        if (empty($id)) {
            return null;
        }

        $model = \JModelLegacy::getInstance('Article', 'ContentModel', array('ignore_request' => false));
        $item = $model->getItem($id);
        if ($item->params->get('show_intro', '1') == '1') {
            $item->text = $item->introtext . ' ' . $item->fulltext;
        } elseif ($item->fulltext) {
            $item->text = $item->fulltext;
        } else {
            $item->text = $item->introtext;
        }
        
        \JPluginHelper::importPlugin('content');
        $dispatcher = \JEventDispatcher::getInstance();
        $dispatcher->trigger('onContentPrepare', array('com_content.article', &$item, &$item->params, 0));

        $item->slug = $item->alias ? ($item->id . ':' . $item->alias) : $item->id;

        $item->catslug = $item->category_alias ? ($item->catid . ':' . $item->category_alias) : $item->catid;
        $item->catlink  = \JRoute::_(\ContentHelperRoute::getCategoryRoute($item->catid));

        $item->readmore = strlen(trim($item->fulltext));
        $item->link = \JRoute::_(\ContentHelperRoute::getArticleRoute($item->slug, $item->catid, $item->language));
        $item->linkText = \JText::_('MOD_ARTICLES_NEWS_READMORE');

        $item->created_formatted = date($format, strtotime($item->created));
        $item->modified_formatted = date($format, strtotime($item->modified));
        $item->published_formatted = date($format, strtotime($item->publish_up));



        $item->introtext = preg_replace('/<img[^>]*>/', '', $item->introtext);
        $item->introtext = strip_tags($item->introtext);

        $images = json_decode($item->images);
        $item->imageSrc = '';
        $item->imageAlt = '';
        $item->imageCaption = '';

        if (!empty($images->image_fulltext)) {
            $item->imageSrc = \JURI::root() . htmlspecialchars($images->image_fulltext, ENT_COMPAT, 'UTF-8');
            $item->imageAlt = htmlspecialchars($images->image_fulltext_alt, ENT_COMPAT, 'UTF-8');

            if ($images->image_intro_caption) {
                $item->imageCaption = htmlspecialchars($images->image_fulltext_caption, ENT_COMPAT, 'UTF-8');
            }
        }

        $tags = new \JHelperTags;
        $tags->getItemTags('com_content.article', $item->id);

        $item->tags = [];
        if ($tags->itemTags && !empty($tags->itemTags)) {
            \JLoader::register('TagsHelperRoute', JPATH_BASE . '/components/com_tags/helpers/route.php');
            foreach ($tags->itemTags as $itemTag) {
                $item->tags[] = ['title' => $itemTag->title, 'link' => \JRoute::_(\TagsHelperRoute::getTagRoute($itemTag->tag_id . ':' . $itemTag->alias))];
            }
        }

        return $item;
    }
}
