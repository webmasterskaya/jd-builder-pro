<?php

/**
 * @package    JD Builder
 * @author     Team Joomdev <info@joomdev.com>
 * @copyright  2020 www.joomdev.com
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
extract($displayData);

$element->addClass('jdb-business-hours');

$html = [];

$days = $element->params->get('days', []);
foreach ($days as $index => $day) {
    $html[] = '<div class="jdb-bh-row">';
    $html[] = '<div class="jdb-bh-day">';
    $html[] = $day->day;
    $html[] = '</div>';
    $html[] = '<div class="jdb-bh-time">';
    $html[] = $day->time;
    $html[] = '</div>';
    $html[] = '</div>';
    if ($day->style) {
        $rowStyle = new JDPageBuilder\Element\ElementStyle(".jdb-bh-row:nth-child(" . ($index + 1) . ")");
        $rowDayStyle = new JDPageBuilder\Element\ElementStyle(".jdb-bh-row:nth-child(" . ($index + 1) . ") .jdb-bh-day");
        $rowTimeStyle = new JDPageBuilder\Element\ElementStyle(".jdb-bh-row:nth-child(" . ($index + 1) . ") .jdb-bh-time");
        $element->addChildrenStyle([$rowStyle, $rowDayStyle, $rowTimeStyle]);
        $rowStyle->addCss('background', $day->background);
        $rowDayStyle->addCss('color', $day->dayColor);
        $rowTimeStyle->addCss('color', $day->timeColor);
    }
}

$rowStyle = new JDPageBuilder\Element\ElementStyle(".jdb-bh-row:not(:last-child)");
$dayStyle = new JDPageBuilder\Element\ElementStyle(".jdb-bh-row .jdb-bh-day");
$timeStyle = new JDPageBuilder\Element\ElementStyle(".jdb-bh-row .jdb-bh-time");
$element->addChildrenStyle([$rowStyle, $dayStyle, $timeStyle]);

$padding = $element->params->get('rowPadding', NULL);
if (!empty($padding)) {
    foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($padding->{$deviceKey}) && !empty($padding->{$deviceKey})) {

            $css = \JDPageBuilder\Helper::spacingValue($padding->{$deviceKey}, "padding");
            if (!empty($css)) {
                $rowStyle->addStyle($css, $device);
            }
        }
    }
}

$divider = $element->params->get('divider', false);
if ($divider) {
    $rowStyle->addCss('border-bottom-style', $element->params->get('dividerStyle', 'solid'));
    $rowStyle->addCss('border-bottom-color', $element->params->get('dividerColor', ''));
    $dividerWeight = $element->params->get('dividerWeight', null);
    if ($dividerWeight != null) {
        if (JDPageBuilder\Helper::checkSliderValue($dividerWeight)) {
            $rowStyle->addCss('border-bottom-width', $dividerWeight->value . 'px');
        }
    }
}

$dayStyle->addCss('color', $element->params->get('dayColor', ''));

$typography = $element->params->get("dayTypography", NULL);
if (!empty($typography)) {
    foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($typography->{$deviceKey}) && !empty($typography->{$deviceKey})) {
            $dayStyle->addStyle(JDPageBuilder\Helper::typographyValue($typography->{$deviceKey}), $device);
        }
    }
}

$timeStyle->addCss('color', $element->params->get('timeColor', ''));

$typography = $element->params->get("timeTypography", NULL);
if (!empty($typography)) {
    foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($typography->{$deviceKey}) && !empty($typography->{$deviceKey})) {
            $timeStyle->addStyle(JDPageBuilder\Helper::typographyValue($typography->{$deviceKey}), $device);
        }
    }
}

if ($element->params->get("striped", true)) {
    $oddStyle = new JDPageBuilder\Element\ElementStyle(".jdb-bh-row:nth-child(odd)");
    $evenStyle = new JDPageBuilder\Element\ElementStyle(".jdb-bh-row:nth-child(even)");
    $element->addChildrenStyle([$oddStyle, $evenStyle]);

    $oddStyle->addCss('background-color', $element->params->get('oddBackground', ''));
    $evenStyle->addCss('background-color', $element->params->get('evenBackground', ''));
}

echo implode('', $html);
