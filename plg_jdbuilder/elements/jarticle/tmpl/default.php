<?php

/**
 * @package    JD Builder
 * @author     Team Joomdev <info@joomdev.com>
 * @copyright  2020 www.joomdev.com
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
extract($displayData);
if ($element->indexMode) {
    return;
}
$element->addClass('jdb-joomla-article');

$id = $element->params->get('articleId', 0);

if (empty($id)) {
    return;
}
$dateFormat = $element->params->get('metaDateFormat', 'd M, Y');
$item = \JDBuilderJarticleElementHelper::getArticle($id, $dateFormat);

if (empty($item)) {
    return;
}

$articleMetaData = $element->params->get('articleMetaData', []);
$mIcon = $element->params->get('articleMetaIcons', true);
if ($mIcon) {
    \JDPageBuilder\Builder::loadFontLibraryByIcon('far fa-user');
}
$image = '';
if ($element->params->get('showImage', true) && !empty($item->imageSrc)) {
    $image = '<img itemprop="thumbnailUrl" class="jdb-jarticle-image" src="' . $item->imageSrc . '" alt="' . $item->title . '">';
}

if (count($articleMetaData)) {
    if (in_array('author', $articleMetaData)) {
    }
}
ob_start();
?>
<?php if (count($articleMetaData)) { ?>
    <div class="jdb-jarticle-meta-info">
        <?php if (in_array('author', $articleMetaData)) { ?>
            <span class="jdb-jarticle-author">
                <?php if ($mIcon) { ?>
                    <i class="far fa-user"></i>
                <?php } ?>
                <?php echo $item->author; ?>
            </span>
        <?php } ?>
        <?php if (in_array('category', $articleMetaData)) { ?>
            <span class="jdb-jarticle-category">
                <?php if ($mIcon) { ?>
                    <i class="far fa-folder"></i>
                <?php } ?>
                <?php echo $item->category_title; ?>
            </span>
        <?php } ?>
        <?php if (in_array('publish-date', $articleMetaData)) { ?>
            <span class="jdb-jarticle-published-date">
                <?php if ($mIcon) { ?>
                    <i class="far fa-calendar-check"></i>
                <?php } ?>
                <?php echo JText::_('JDB_JARTICLE_META_PUBLISHED_ON'); ?> <?php echo $item->published_formatted; ?>
            </span>
        <?php } ?>
        <?php if (in_array('created-date', $articleMetaData)) { ?>
            <span class="jdb-jarticle-created-date">
                <?php if ($mIcon) { ?>
                    <i class="far fa-calendar-plus"></i>
                <?php } ?>
                <?php echo JText::_('JDB_JARTICLE_META_CREATED_ON'); ?> <?php echo $item->created_formatted; ?>
            </span>
        <?php } ?>
        <?php if (in_array('modified-date', $articleMetaData)) { ?>
            <span class="jdb-jarticle-modified-date">
                <?php if ($mIcon) { ?>
                    <i class="far fa-calendar-alt"></i>
                <?php } ?>
                <?php echo JText::_('JDB_JARTICLE_META_MODIFIED_ON'); ?> <?php echo $item->modified_formatted; ?>
            </span>
        <?php } ?>
        <?php if (in_array('hits', $articleMetaData)) { ?>
            <span class="jdb-jarticle-hits">
                <?php if ($mIcon) { ?>
                    <i class="far fa-eye"></i>
                <?php } ?>
                <?php echo JText::_('JDB_JARTICLE_META_HITS'); ?> <?php echo $item->hits; ?>
            </span>
        <?php } ?>
    </div>
<?php }
$meta = ob_get_contents();
ob_end_clean();
?>
<article itemprop="blogPost" class="jdb-jarticle" itemscope="" itemtype="https://schema.org/BlogPosting">
    <?php
    if ($element->params->get('imagePosition', 'above') === 'above') {
        echo $image;
    }
    if ($element->params->get('metaPosition', 'below') === 'above') {
        echo $meta;
    }
    if ($element->params->get('showTitle', true)) {
        $titleTag = $element->params->get('titleHtmlTag', 'h2');
    ?>
        <<?php echo $titleTag; ?> itemprop="name" class="jdb-jarticle-title">
            <?php echo $item->title; ?>
        </<?php echo $titleTag; ?>>
    <?php }
    if ($element->params->get('metaPosition', 'below') === 'below') {
        echo $meta;
    }
    if ($element->params->get('imagePosition', 'above') === 'below') {
        echo $image;
    } ?>
    <div class="jdb-jarticle-fulltext">
        <?php echo $item->text; ?>
    </div>
    <?php if ($element->params->get('showTags', true) && count($item->tags)) { ?>
        <div class="jdb-jarticle-tags">
            <?php foreach ($item->tags as $tag) { ?>
                <a href="<?php echo $tag['link']; ?>"><?php echo $tag['title']; ?></a>
            <?php } ?>
        </div>
    <?php } ?>
</article>

<?php
$metaStyle = new JDPageBuilder\Element\ElementStyle(".jdb-jarticle-meta-info");
$metaTitleStyle = new JDPageBuilder\Element\ElementStyle(".jdb-jarticle-meta-info span:not(:last-child)");
$metaIconStyle = new JDPageBuilder\Element\ElementStyle(".jdb-jarticle-meta-info span i");

$titleStyle = new JDPageBuilder\Element\ElementStyle(".jdb-jarticle-title");
$contentStyle = new JDPageBuilder\Element\ElementStyle(".jdb-jarticle-fulltext");
$tagStyle = new JDPageBuilder\Element\ElementStyle(".jdb-jarticle-tags > a");
$tagHoverStyle = new JDPageBuilder\Element\ElementStyle(".jdb-jarticle-tags > a:hover");

$element->addChildrenStyle([$metaStyle, $metaTitleStyle, $metaIconStyle, $titleStyle, $contentStyle, $tagStyle, $tagHoverStyle]);

// meta styling
$metaStyle->addCss('color', $element->params->get('metaColor', ''));
$metaIconStyle->addCss('color', $element->params->get('metaIconColor', ''));

$spacing = $element->params->get('metaSpacing', null);
if (!empty($spacing)) {
    foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($spacing->{$deviceKey}) && JDPageBuilder\Helper::checkSliderValue($spacing->{$deviceKey})) {
            $metaTitleStyle->addCss('margin-right', $spacing->{$deviceKey}->value . 'px', $device);
        }
    }
}

$margin = $element->params->get('metaMargin', null);
if (!empty($margin)) {
    foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($margin->{$deviceKey}) && !empty($margin->{$deviceKey})) {
            $metaStyle->addStyle(JDPageBuilder\Helper::spacingValue($margin->{$deviceKey}, "margin"), $device);
        }
    }
}

$typography = $element->params->get('metaTypography', null);
if (!empty($typography)) {
    foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($typography->{$deviceKey}) && !empty($typography->{$deviceKey})) {
            $metaStyle->addStyle(JDPageBuilder\Helper::typographyValue($typography->{$deviceKey}), $device);
            if (isset($typography->{$deviceKey}->alignment) && !empty($typography->{$deviceKey}->alignment)) {
                $justifyContent = $typography->{$deviceKey}->alignment;
                $justifyContent = $justifyContent == 'left' ? 'flex-start' : ($justifyContent == 'right' ? 'flex-end' : ($justifyContent == 'center' ? 'center' : ($justifyContent == 'justify' ? 'space-between' : '')));
                $metaStyle->addCss('justify-content', $justifyContent, $device);
            }
        }
    }
}

// title & content styling
$titleStyle->addCss('color', $element->params->get('titleColor', ''));
$contentStyle->addCss('color', $element->params->get('contentColor', ''));

$typography = $element->params->get('titleTypography', null);
if (!empty($typography)) {
    foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($typography->{$deviceKey}) && !empty($typography->{$deviceKey})) {
            $titleStyle->addStyle(JDPageBuilder\Helper::typographyValue($typography->{$deviceKey}), $device);
        }
    }
}

$typography = $element->params->get('contentTypography', null);
if (!empty($typography)) {
    foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($typography->{$deviceKey}) && !empty($typography->{$deviceKey})) {
            $contentStyle->addStyle(JDPageBuilder\Helper::typographyValue($typography->{$deviceKey}), $device);
        }
    }
}

$margin = $element->params->get('titleMargin', null);
if (!empty($margin)) {
    foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($margin->{$deviceKey}) && !empty($margin->{$deviceKey})) {
            $titleStyle->addStyle(JDPageBuilder\Helper::spacingValue($margin->{$deviceKey}, "margin"), $device);
        }
    }
}

$margin = $element->params->get('contentMargin', null);
if (!empty($margin)) {
    foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($margin->{$deviceKey}) && !empty($margin->{$deviceKey})) {
            $contentStyle->addStyle(JDPageBuilder\Helper::spacingValue($margin->{$deviceKey}, "margin"), $device);
        }
    }
}

// tag styling
$tagStyle->addCss('color', $element->params->get('tagColor', ''));
$tagStyle->addCss('background-color', $element->params->get('tagBackgroundColor', ''));

$typography = $element->params->get('tagTypography', null);
if (!empty($typography)) {
    foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($typography->{$deviceKey}) && !empty($typography->{$deviceKey})) {
            $tagStyle->addStyle(JDPageBuilder\Helper::typographyValue($typography->{$deviceKey}), $device);
        }
    }
}

$padding = $element->params->get('tagPadding', null);
if (!empty($padding)) {
    foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($padding->{$deviceKey}) && !empty($padding->{$deviceKey})) {
            $tagStyle->addStyle(JDPageBuilder\Helper::spacingValue($padding->{$deviceKey}, "padding"), $device);
        }
    }
}

$tagSpacing = $element->params->get('tagSpacing', NULL);
if (!empty($tagSpacing)) {
    foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($tagSpacing->{$deviceKey}) && \JDPageBuilder\Helper::checkSliderValue($tagSpacing->{$deviceKey})) {
            $tagStyle->addCss("margin-left", ($tagSpacing->{$deviceKey}->value) . 'px', $device);
        }
    }
}

JDPageBuilder\Helper::applyBorderValue($tagStyle, $element->params, "tagBorder");

$tagHoverStyle->addCss('color', $element->params->get('tagHoverColor', ''));
$tagHoverStyle->addCss('background-color', $element->params->get('tagHoverBackground', ''));

JDPageBuilder\Helper::applyBorderValue($tagHoverStyle, $element->params, "tagHoverBorder");
?>