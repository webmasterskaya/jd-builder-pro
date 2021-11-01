<?php

/**
 * @package    JD Builder
 * @author     Team Joomdev <info@joomdev.com>
 * @copyright  2020 www.joomdev.com
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
extract($displayData);


$date = $element->params->get('date', date('m/d/Y', strtotime('tomorrow')));
$time = $element->params->get('time', \json_decode('{hours:0,minutes:0}'));

$time->hours = isset($time->hours) ? $time->hours : 0;
$time->minutes = isset($time->minutes) ? $time->minutes : 0;

$date = date('m/d/Y', strtotime($date)) . ' ' . $time->hours . ':' . $time->minutes . ':0';
$date = new DateTime($date, new DateTimeZone(\JFactory::getConfig()->get('offset')));
$date = $date->format('Y-m-d\TH:i:sO');

$onAfterExpire = $element->params->get('onAfterExpire', 'hide');
$redirect = $element->params->get('redirect', '');
$wait = $element->params->get('redirectWait', 3000);
$element->addAttribute('jdb-countdown', 'date: ' . $date . ';after:' . $onAfterExpire . ';redirect:' . urlencode($redirect) . ';wait:' . $wait);

$html = [];

$viewDays = $element->params->get('viewDays', true);
$viewHours = $element->params->get('viewHours', true);
$viewMinutes = $element->params->get('viewMinutes', true);
$viewSeconds = $element->params->get('viewSeconds', true);

$viewType = $element->params->get('viewType', 'block');
$labelType = $element->params->get('labelType', 'auto');
$labels = ['days' => 'Days', 'hours' => 'Hours', 'minutes' => 'Minutes', 'seconds' => 'Seconds'];
if ($labelType === 'custom') {
    foreach (['days', 'hours', 'minutes', 'seconds'] as $key) {
        $labelText = $element->params->get($key . 'Label', '');
        $labels[$key] = $labelText;
    }
}

$html[] = '<div class="jdb-countdown-container">';
$html[] = '<div class="jdb-countdown-inner jdb-countdown-' . $viewType . '">';
$html[] = '<div class="jdb-row jdb-no-gutters">';
if ($viewDays) {
    $html[] = '<div class="jdb-countdown-item jdb-col">';
    $html[] = '<span class="jdb-countdown-number jdb-countdown-days"></span>';
    if ($labelType !== 'none' && !empty($labels['days'])) {
        $html[] = '<span class="jdb-countdown-label" data-label="' . $labels['days'] . '">' . $labels['days'] . '</span>';
    }
    $html[] = '</div>';
}
if ($viewHours) {
    $html[] = '<div class="jdb-countdown-item jdb-col">';
    $html[] = '<span class="jdb-countdown-number jdb-countdown-hours"></span>';
    if ($labelType !== 'none' && !empty($labels['hours'])) {
        $html[] = '<span class="jdb-countdown-label" data-label="' . $labels['hours'] . '">' . $labels['hours'] . '</span>';
    }
    $html[] = '</div>';
}
if ($viewMinutes) {
    $html[] = '<div class="jdb-countdown-item jdb-col">';
    $html[] = '<span class="jdb-countdown-number jdb-countdown-minutes"></span>';
    if ($labelType !== 'none' && !empty($labels['minutes'])) {
        $html[] = '<span class="jdb-countdown-label" data-label="' . $labels['minutes'] . '"></span>';
    }
    $html[] = '</div>';
}
if ($viewSeconds) {
    $html[] = '<div class="jdb-countdown-item jdb-col">';
    $html[] = '<span class="jdb-countdown-number jdb-countdown-seconds"></span>';
    if ($labelType !== 'none' && !empty($labels['seconds'])) {
        $html[] = '<span class="jdb-countdown-label"  data-label="' . $labels['seconds'] . '"></span>';
    }
    $html[] = '</div>';
}
$html[] = '</div>';
$html[] = '</div>';

if ($onAfterExpire == 'message' || $onAfterExpire == 'hide+message') {
    $html[] = '<div class="jdb-countdown-message">' . $element->params->get('message', '') . '</div>';
}
$html[] = '</div>';

echo implode('', $html);

$containerStyle = new JDPageBuilder\Element\ElementStyle(".jdb-countdown-container");
$boxStyle = new JDPageBuilder\Element\ElementStyle(".jdb-countdown-item");
$numberStyle = new JDPageBuilder\Element\ElementStyle(".jdb-countdown-number");
$labelStyle = new JDPageBuilder\Element\ElementStyle(".jdb-countdown-label");
$messageStyle = new JDPageBuilder\Element\ElementStyle(".jdb-countdown-message");

$element->addChildrenStyle([$containerStyle, $boxStyle, $numberStyle, $labelStyle, $messageStyle]);

$width = $element->params->get('countdownWidth', null);
if (!empty($width)) {
    foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($width->{$deviceKey}) && \JDPageBuilder\Helper::checkSliderValue($width->{$deviceKey})) {
            if ($width->{$deviceKey}->value != '' && $width->{$deviceKey}->value != null) {
                $containerStyle->addCss('width', $width->{$deviceKey}->value . $width->{$deviceKey}->unit, $device);
            }
        }
    }
}

$boxStyle->addCss('background-color',  $element->params->get('countdownBackground', ''));
JDPageBuilder\Helper::applyBorderValue($boxStyle, $element->params, "countdownBorder");

$countdownSpace = $element->params->get('countdownSpace', null);
if (!empty($countdownSpace)) {
    foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($countdownSpace->{$deviceKey}) && JDPageBuilder\Helper::checkSliderValue($countdownSpace->{$deviceKey})) {
            $boxStyle->addCss("margin", '0 ' . $countdownSpace->{$deviceKey}->value . 'px', $device);
        }
    }
}

$padding = $element->params->get('countdownPadding', null);
if (!empty($padding)) {
    foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($padding->{$deviceKey}) && !empty($padding->{$deviceKey})) {
            $boxStyle->addStyle(JDPageBuilder\Helper::spacingValue($padding->{$deviceKey}, "padding"), $device);
        }
    }
}

$numberStyle->addCss('color',  $element->params->get('numberColor', ''));

$typography = $element->params->get('numberTypography', null);
if (!empty($typography)) {
    foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($typography->{$deviceKey}) && !empty($typography->{$deviceKey})) {
            $numberStyle->addStyle(JDPageBuilder\Helper::typographyValue($typography->{$deviceKey}), $device);
        }
    }
}

$labelStyle->addCss('color',  $element->params->get('labelColor', ''));

$typography = $element->params->get('labelTypography', null);
if (!empty($typography)) {
    foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($typography->{$deviceKey}) && !empty($typography->{$deviceKey})) {
            $labelStyle->addStyle(JDPageBuilder\Helper::typographyValue($typography->{$deviceKey}), $device);
        }
    }
}

$messageStyle->addCss('color', $element->params->get('messageColor', ''));

$typography = $element->params->get('messageTypography', null);
if (!empty($typography)) {
    foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($typography->{$deviceKey}) && !empty($typography->{$deviceKey})) {
            $messageStyle->addStyle(JDPageBuilder\Helper::typographyValue($typography->{$deviceKey}), $device);
        }
    }
}

$padding = $element->params->get('messagePadding', null);
if (!empty($padding)) {
    foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($padding->{$deviceKey}) && !empty($padding->{$deviceKey})) {
            $messageStyle->addStyle(JDPageBuilder\Helper::spacingValue($padding->{$deviceKey}, "padding"), $device);
        }
    }
}
