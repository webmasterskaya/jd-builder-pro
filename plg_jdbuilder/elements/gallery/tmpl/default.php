<?php

/**
 * @package    JD Builder
 * @author     Team Joomdev <info@joomdev.com>
 * @copyright  2020 www.joomdev.com
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
extract($displayData);

$document = \JDPageBuilder\Builder::getDocument();
$layout = $element->params->get('layout', 'masonry');
$items = $element->params->get('items', []);

$settings = \JDPageBuilder\Builder::getSettings();
$lightbox = $element->params->get('lightbox', '');
$lightbox = $lightbox == '' ? filter_var($settings->get('lightbox', true), FILTER_VALIDATE_BOOLEAN) : ($lightbox == '1' ? true : false);

if ($lightbox) {
    \JDPageBuilder\Builder::loadLightBox();
}

\JDPageBuilder\Builder::addJavascript(\JURI::root() . 'media/jdbuilder/js/isotope.pkgd.min.js');
\JDPageBuilder\Builder::addJavascript(\JURI::root() . 'media/jdbuilder/js/jquery.justifiedGallery.min.js');

$galleryClass = [];
$galleryItemClass = ['jdb-gallery-item'];
$galleryItemClass[] = 'jdb-caption-' . $element->params->get('caption', 'never');
if ($layout === 'masonry' || $layout === 'grid') {
    $galleryClass[] = 'jdb-row';
    $galleryClass[] = 'jdb-no-gutters';
    $columnCount = $element->params->get('columnCount', NULL);
    if (!empty($columnCount)) {
        foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
            if (isset($columnCount->{$deviceKey})) {
                $key = ($deviceKey == 'xs' ? '' : ($deviceKey == 'sm' ? 'md-' : 'lg-'));
                $galleryItemClass[] = 'jdb-col-' . $key . (12 / $columnCount->{$deviceKey});
            }
        }
    } else {
        $galleryItemClass[] = 'jdb-col-4';
    }
}


$rowHeight = $element->params->get('rowHeight', \json_decode('{"value":200,"unit":"px"}', false));
$gridGap = $element->params->get('gridGap', \json_decode('{"value":10,"unit":"px"}', false));


$selectedFilter = $element->params->get('selectedFilter', '');
$labelAll = $element->params->get('labelAll', 'All');
$selectedFilter  = strtolower($selectedFilter) == strtolower($labelAll) ? '*' : $selectedFilter;

$html = [];
$filters = [];
$html[] = '<div class="jdb-gallery-container">';
$html[] = '<div class="' . implode(' ', $galleryClass) . '" jdb-' . $layout . '-gallery="rowHeight:' . $rowHeight->value . ';gridGap:' . $gridGap->value . ';selected:' . $selectedFilter . '">';
foreach ($items as $index => $item) {
    if (empty($item->image)) {
        continue;
    }
    $itemClass = $galleryItemClass;
    if (isset($item->tag) && !empty($item->tag)) {
        foreach (explode(',', $item->tag) as $tag) {
            $filters[strtolower($tag)] = $tag;
            $itemClass[] = 'jdb-gallery-item-' . strtolower($tag);
        }
    }
    $html[] = '<div class="' . implode(' ', $itemClass) . '">';
    if ($lightbox) {
        $html[] = '<a href="' . \JDPageBuilder\Helper::mediaValue($item->image) . '" data-jdb-lightbox="lightbox-' . $element->id . '" data-jdb-lightbox-caption="' . \JDPageBuilder\Helper::getLightboxContent('description', @$item->title, @$item->caption, @$item->alt) . '" data-jdb-lightbox-title="' . \JDPageBuilder\Helper::getLightboxContent('title', @$item->title, @$item->caption, @$item->alt) . '">';
    }
    if ($layout !== 'grid') {
        $html[] = '<img src="' . \JDPageBuilder\Helper::mediaValue($item->image) . '" />';
    } else {
        $html[] = '<div class="jdb-gallery-item-inner" style="background-image: url(\'' . \JDPageBuilder\Helper::mediaValue($item->image) . '\')"></div>';
    }
    if ($lightbox) {
        $html[] = '</a>';
    }
    if (($element->params->get('caption', 'never') != 'never') && !empty($item->caption)) {
        $html[] = '<' . $element->params->get('captionTag', 'never') . ' class="jdb-gallery-item-caption">' . $item->caption . '</' . $element->params->get('caption', 'never') . '>';
    }
    $html[] = '</div>';
}
$html[] = '</div>';
if ($element->params->get('filters', false) && $layout === 'masonry' && count($filters)) {
    $html[] = '<div class="jdb-gallery-filters jdb-d-flex jdb-justify-content-' . $element->params->get('filterAlignment', 'left') . '">';
    if ($element->params->get('showAll', false)) {
        $html[] = '<button type="button" data-filter="*">' . $labelAll . '</button>';
    }
    foreach ($filters as $key => $filter) {
        $html[] = '<button type="button" data-filter=".jdb-gallery-item-' . $key . '">' . $filter . '</button>';
    }
    $html[] = '</div>';
}
$html[] = '</div>';

echo implode('', $html);
if ($document->lightBox) {
?>
    <script>
        refreshJDLightbox();
    </script>
<?php
}
$galleryStyle = new JDPageBuilder\Element\ElementStyle(".jdb-gallery");
$itemStyle = new JDPageBuilder\Element\ElementStyle(".jdb-gallery-item");
$captionStyle = new JDPageBuilder\Element\ElementStyle(".jdb-gallery-item-caption");
$filterStyle = new JDPageBuilder\Element\ElementStyle(".jdb-gallery-filters > button");
$filterHoverStyle = new JDPageBuilder\Element\ElementStyle(".jdb-gallery-filters > button:hover");
$filterActiveStyle = new JDPageBuilder\Element\ElementStyle(".jdb-gallery-filters > button.active");
$element->addChildrenStyle([$itemStyle, $galleryStyle, $captionStyle, $filterStyle, $filterHoverStyle, $filterActiveStyle]);

if ($layout === 'masonry' || $layout === 'grid') {
    $gridMargin = $element->params->get('gridMargin', NULL);
    if (!empty($gridMargin)) {
        foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
            if (isset($gridMargin->{$deviceKey}) && \JDPageBuilder\Helper::checkSliderValue($gridMargin->{$deviceKey})) {
                $galleryStyle->addCss("margin-left", '-' . ($gridMargin->{$deviceKey}->value / 2) . 'px', $device);
                $galleryStyle->addCss("margin-right", '-' . ($gridMargin->{$deviceKey}->value / 2) . 'px', $device);
                $itemStyle->addCss("margin-bottom", $gridMargin->{$deviceKey}->value . 'px', $device);
                $itemStyle->addCss('padding-right', ($gridMargin->{$deviceKey}->value / 2) . 'px', $device);
                $itemStyle->addCss('padding-left', ($gridMargin->{$deviceKey}->value / 2) . 'px', $device);
                $captionStyle->addCss('width', 'calc(100% - ' . ($gridMargin->{$deviceKey}->value . 'px') . ')', $device);
                $captionStyle->addCss('left', ($gridMargin->{$deviceKey}->value / 2) . 'px', $device);
            }
        }
    }
}

if ($layout === 'grid') {
    $rowHeight = $element->params->get('rowHeight', \json_decode('{"value":200,"unit":"px"}', false));
    $itemStyle->addCss('height', $rowHeight->value . 'px');
}

if ($element->params->get('caption', 'never') != 'never') {
    $captionStyle->addCss('color', $element->params->get('captionColor', ''));
    $captionStyle->addCss('background-color', $element->params->get('captionBackground', ''));
    $typography = $element->params->get('captionTypography', null);
    if (!empty($typography)) {
        foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
            if (isset($typography->{$deviceKey}) && !empty($typography->{$deviceKey})) {
                $captionStyle->addStyle(JDPageBuilder\Helper::typographyValue($typography->{$deviceKey}), $device);
            }
        }
    }
    $padding = $element->params->get('captionPadding', null);
    if (!empty($padding)) {
        foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
            if (isset($padding->{$deviceKey}) && !empty($padding->{$deviceKey})) {
                $captionStyle->addStyle(JDPageBuilder\Helper::spacingValue($padding->{$deviceKey}, "padding"), $device);
            }
        }
    }
}

$filterStyle->addCss('color', $element->params->get('filterColor', ''));
$filterStyle->addCss('background-color', $element->params->get('filterBackground', ''));
JDPageBuilder\Helper::applyBorderValue($filterStyle, $element->params, "filterBorder");

$typography = $element->params->get('filterTypography', null);
if (!empty($typography)) {
    foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($typography->{$deviceKey}) && !empty($typography->{$deviceKey})) {
            $filterStyle->addStyle(JDPageBuilder\Helper::typographyValue($typography->{$deviceKey}), $device);
        }
    }
}

$padding = $element->params->get('filterPadding', null);
if (!empty($padding)) {
    foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($padding->{$deviceKey}) && !empty($padding->{$deviceKey})) {
            $filterStyle->addStyle(JDPageBuilder\Helper::spacingValue($padding->{$deviceKey}, "padding"), $device);
        }
    }
}

$filterHoverStyle->addCss('color', $element->params->get('filterHoverColor', ''));
$filterHoverStyle->addCss('background-color', $element->params->get('filterHoverBackground', ''));
JDPageBuilder\Helper::applyBorderValue($filterHoverStyle, $element->params, "filterHoverBorder");

$filterActiveStyle->addCss('color', $element->params->get('filterActiveColor', ''));
$filterActiveStyle->addCss('background-color', $element->params->get('filterActiveBackground', ''));
JDPageBuilder\Helper::applyBorderValue($filterActiveStyle, $element->params, "filterActiveBorder");
