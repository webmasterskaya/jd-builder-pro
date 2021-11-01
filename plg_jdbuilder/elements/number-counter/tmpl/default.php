<?php

/**
 * @package    JD Builder
 * @author     Team Joomdev <info@joomdev.com>
 * @copyright  2020 www.joomdev.com
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
extract($displayData);

$element->addClass('jdb-numbercounter');

$startValue = $element->params->get('startValue', 0);
$endValue = $element->params->get('endValue', 0);
$prefix = $element->params->get('prefix', '');
$suffix = $element->params->get('suffix', '');
$separator = $element->params->get('separator', '');
$decimalPlaces = $element->params->get('decimalPlaces', 0);
$duration = $element->params->get('duration', \json_decode('{value:2000}'));

$title = $element->params->get('title', '');
$titlePosition = $element->params->get('titlePosition', 'bottom');

$icon = $element->params->get('icon', '');
$iconPosition = $element->params->get('iconPosition', 'top');

$html = [];
if (!empty($icon)) {
    \JDPageBuilder\Builder::loadFontLibraryByIcon($icon);
    $html[] = '<div class="jdb-numbercounter-icon"><span class="' . $icon . '"></span></div>';
}
if (!empty($title) && $titlePosition == 'top') {
    $html[] = '<div class="jdb-numbercounter-title">' . $title . '</div>';
}
$html[] = '<div class="jdb-numbercounter-number">';
$html[] = '<span class="jdb-numbercounter-prefix">' . $prefix . '</span>';

$html[] = '<div jdb-counter="start:' . $startValue . ';end:' . $endValue . ';separator:' . rawurlencode($separator) . ';decimalPlaces:' . $decimalPlaces . ';duration:' . $duration->value . '"></div>';

$html[] = '<span class="jdb-numbercounter-suffix">' . $suffix . '</span>';
$html[] = '</div>';

if (!empty($title) && $titlePosition == 'bottom') {
    $html[] = '<div class="jdb-numbercounter-title">' . $title . '</div>';
}
echo implode('', $html);

$iconStyle = new JDPageBuilder\Element\ElementStyle('.jdb-numbercounter-icon');
$titleStyle = new JDPageBuilder\Element\ElementStyle('.jdb-numbercounter-title');
$numberParentStyle = new JDPageBuilder\Element\ElementStyle('.jdb-numbercounter-number');
$numberStyle = new JDPageBuilder\Element\ElementStyle('.jdb-numbercounter-prefix,.jdb-counter>span,.jdb-numbercounter-suffix');

$element->addChildrenStyle([$iconStyle, $titleStyle, $numberStyle, $numberParentStyle]);

switch ($element->params->get('iconShape', 'circle')) {
    case 'rounded':
        $borderRadius = $element->params->get('iconBorderRadius', null);
        if (!empty($borderRadius)) {
            foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
                if (isset($borderRadius->{$deviceKey}) && !empty($borderRadius->{$deviceKey})) {
                    $css = JDPageBuilder\Helper::spacingValue($borderRadius->{$deviceKey}, "radius");
                    $iconStyle->addStyle($css, $device);
                }
            }
        }
        break;
    case 'circle':
        $iconStyle->addCss("border-radius", "50%");
        break;
    case 'square':
        $iconStyle->addCss("border-radius", "0");
        break;
}

// Icon Size
$iconSize = $element->params->get('iconSize', null);
if (!empty($iconSize)) {
    foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($iconSize->{$deviceKey}) && JDPageBuilder\Helper::checkSliderValue($iconSize->{$deviceKey})) {
            $iconStyle->addCss("font-size", ($iconSize->{$deviceKey}->value * 0.70) . 'px', $device);
            $iconStyle->addCss("width", $iconSize->{$deviceKey}->value . 'px', $device);
            $iconStyle->addCss("height", $iconSize->{$deviceKey}->value . 'px', $device);
            $iconStyle->addCss("line-height", $iconSize->{$deviceKey}->value . 'px', $device);
        }
    }
}

// Padding
$padding = $element->params->get('iconPadding', null);
if (!empty($padding)) {
    foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($padding->{$deviceKey}) && !empty($padding->{$deviceKey})) {
            $iconStyle->addStyle(JDPageBuilder\Helper::spacingValue($padding->{$deviceKey}, "padding"), $device);
        }
    }
}

$numberStyle->addCss("color", $element->params->get('counterColor', ''));
$iconStyle->addCss("color", $element->params->get('iconTextColor', ''));
$iconStyle->addCss("background-color", $element->params->get('iconBackgroundColor', ''));
$iconStyle->addCss("border-color", $element->params->get('iconBorderColor', ''));
$iconStyle->addCss("background-image", $element->params->get('iconGradient', ''));
$iconStyle->addCss("box-shadow", $element->params->get('iconBoxShadow', ''));

$iconBorderStyle = $element->params->get('iconBorderStyle', 'none');
$iconStyle->addCss("border-style", $iconBorderStyle);
if ($iconBorderStyle != 'none') {
    $borderWidth = $element->params->get('iconBorderWidth', null);
    if ($borderWidth != null) {
        foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
            if (isset($borderWidth->{$deviceKey}) && !empty($borderWidth->{$deviceKey})) {
                $iconStyle->addStyle(JDPageBuilder\Helper::spacingValue($borderWidth->{$deviceKey}, "border"), $device);
            }
        }
    }
}

// Title Color and Space
$titleStyle->addCss('color', $element->params->get('titleColor', ''));
$spacingBetween = $element->params->get('spacingBetween', null);
if (!empty($spacingBetween)) {
    foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (JDPageBuilder\Helper::checkSliderValue($spacingBetween->{$deviceKey})) {
            $titleStyle->addCss('margin-' . ($titlePosition == 'top' ? 'bottom' : 'top'), $spacingBetween->{$deviceKey}->value . 'px', $device);
            // $iconStyle->addCss('margin-bottom', $spacingBetween->{$deviceKey}->value . 'px');
        }
    }
}


// Title Typography
$typography = $element->params->get('titleTypography', null);
if (!empty($typography)) {
    foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($typography->{$deviceKey}) && !empty($typography->{$deviceKey})) {
            $titleStyle->addStyle(JDPageBuilder\Helper::typographyValue($typography->{$deviceKey}), $device);
        }
    }
}

// Number Typography
$typography = $element->params->get('counterTypography', null);
if (!empty($typography)) {
    foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($typography->{$deviceKey}) && !empty($typography->{$deviceKey})) {
            $numberStyle->addStyle(JDPageBuilder\Helper::typographyValue($typography->{$deviceKey}), $device);
        }
    }
}
