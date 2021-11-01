<?php

/**
 * @package    JD Builder
 * @author     Team Joomdev <info@joomdev.com>
 * @copyright  2020 www.joomdev.com
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
extract($displayData);

$element->addClass('jdb-progressbars');

$html = [];
$bars = $element->params->get('bars', []);
if (empty($bars)) {
    return '';
}

// params
$barType = $element->params->get('barType', 'default');
$barHeight = $element->params->get('barHeight', \json_decode('{"value":20}'));
$barHeight = JDPageBuilder\Helper::checkSliderValue($barHeight) ? $barHeight->value : 20;

$labelPosition = $element->params->get('labelPosition', 'inside');
$displayLabels = $element->params->get('displayLabels', true);
$displayPercentageLabels = $element->params->get('displayPercentageLabels', true);
$barStriped = $element->params->get('barStriped', false);
$barStripedAnimation = $element->params->get('barStripedAnimation', false);

$html[] = '<div>';
$index = 0;
foreach ($bars as $bar) {
    $index++;
    $html[] = '<div class="jdb-progressbar-' . $index . '" jdb-progressbar="type:' . $barType . ';height:' . $barHeight . ';displayLabels:' . ($displayLabels ? 'true' : 'false') . ';displayPercentageLabels:' . ($displayPercentageLabels ? 'true' : 'false') . ';striped:' . ($barStriped ? 'true' : 'false') . ';animation:' . ($barStripedAnimation ? 'true' : 'false') . ';label:' . $bar->title . ';position: ' . $labelPosition . ';value:' . $bar->value->value . '"><div class="jdb-progressbar-progress"></div></div>';
}
$html[] = '</div>';
echo implode('', $html);

$barStyle = new JDPageBuilder\Element\ElementStyle(".jdb-progressbar");
$progress = new JDPageBuilder\Element\ElementStyle(".jdb-progressbar-progress");
$labels = new JDPageBuilder\Element\ElementStyle(".jdb-progressbar-labels > span");
$element->addChildrenStyle([$progress, $labels, $barStyle]);

/* Progress Styling */
$barStyle->addCss('background-color', $element->params->get('barColor', ''));

$barSpacing = $element->params->get('barSpacing', null);
if (!empty($barSpacing)) {
    foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($barSpacing->{$deviceKey}) && JDPageBuilder\Helper::checkSliderValue($barSpacing->{$deviceKey})) {
            $barStyle->addCss('margin-bottom', $barSpacing->{$deviceKey}->value . 'px', $device);
        }
    }
}

$progress->addCss('background-color', $element->params->get('barProgressColor', ''));
$labels->addCss('color', $element->params->get('labelColor', ''));

$typography = $element->params->get('labelTypography', null);
if (!empty($typography)) {
    foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($typography->{$deviceKey}) && !empty($typography->{$deviceKey})) {
            $labels->addStyle(JDPageBuilder\Helper::typographyValue($typography->{$deviceKey}), $device);
        }
    }
}

$barBorderStyle = $element->params->get('barBorderStyle', '');
if (!empty($barBorderStyle)) {
    $barStyle->addCss('border-style', $barBorderStyle);
    $barBorderWidth = $element->params->get('barBorderWidth', null);
    if (!empty($barBorderWidth) && $barBorderStyle != 'none') {

        foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
            if (isset($barBorderWidth->{$deviceKey}) && !empty($barBorderWidth->{$deviceKey})) {

                $css = \JDPageBuilder\Helper::spacingValue($barBorderWidth->{$deviceKey}, "border");
                if (!empty($css)) {
                    $barStyle->addStyle($css, $device);
                }
            }
        }

        $barStyle->addCss('border-color', $element->params->get('barBorderColor', ''));
    }
}
$barBorderRadius = $element->params->get('barBorderRadius', null);
if (!empty($barBorderRadius)) {
    foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($barBorderRadius->{$deviceKey}) && !empty($barBorderRadius->{$deviceKey})) {

            $css = \JDPageBuilder\Helper::spacingValue($barBorderRadius->{$deviceKey}, "radius");
            if (!empty($css)) {
                $barStyle->addStyle($css, $device);
                $progress->addStyle($css, $device);
            }
        }
    }
}

$barStyle->addCss('box-shadow', $element->params->get('barBoxShadow', ''));
