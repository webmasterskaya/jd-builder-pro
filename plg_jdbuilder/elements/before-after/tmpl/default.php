<?php

/**
 * @package    JD Builder
 * @author     Team Joomdev <info@joomdev.com>
 * @copyright  2020 www.joomdev.com
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
extract($displayData);

\JDPageBuilder\Builder::addJavascript(\JURI::root() . 'media/jdbuilder/js/jquery.event.move.js');

$beforeImage = $element->params->get('beforeImage', '');
$afterImage = $element->params->get('afterImage', '');
if (empty($beforeImage) || empty($afterImage)) {
    return;
}

$element->addClass('jdb-beforeafter-element');

$beforeDirection = ($element->params->get('orientation', 'horizontal') === 'vertical') ? 'down' : 'left';
$afterDirection = ($element->params->get('orientation', 'horizontal') === 'vertical') ? 'up' : 'right';

$html = [];

$overlayDisplay = $element->params->get('overlayDisplay', false);
$defaultOffset = $element->params->get('defaultOffset', \json_decode('{"value": 0.7, "unit": "#"}'));

$html[] = '<div class="jdb-beforeafter-wrapper jdb-beforeafter-' . $element->params->get('orientation', 'horizontal') . '">';
$html[] = '<div jdb-before-after="overlay:' . $overlayDisplay . ';moveSliderOnHover:' . ($element->params->get('moveSliderOnHover', false) ? 'true' : 'false') . ';orientation:' . $element->params->get('orientation', 'horizontal') . ';defaultOffset:' . $defaultOffset->value . '" class="jdb-beforeafter-container">';

if ($overlayDisplay != 'never') {
    $html[] = '<div class="jdb-beforeafter-overlay' . ($overlayDisplay == 'always' ? ' hovered' : '') . '"><div class="jdb-beforeafter-before-label" data-content="' . $element->params->get('beforeLabel', '') . '"></div><div class="jdb-beforeafter-after-label" data-content="' . $element->params->get('afterLabel', '') . '"></div></div>';
}

$html[] = '<img class="jdb-beforeafter-before" alt="' . $element->params->get('beforeAlt', '') . '" src="' . \JDPageBuilder\Helper::mediaValue($beforeImage) . '" />';
$html[] = '<img class="jdb-beforeafter-after" alt="' . $element->params->get('afterAlt', '') . '" src="' . \JDPageBuilder\Helper::mediaValue($afterImage) . '" />';

$html[] = '<div class="jdb-beforeafter-handle"><span class="jdb-beforeafter-' . $beforeDirection . '-arrow"></span><span class="jdb-beforeafter-' . $afterDirection . '-arrow"></span></div>';

$html[] = '</div>';
$html[] = '</div>';
echo implode('', $html);

$wrapperStyle = new JDPageBuilder\Element\ElementStyle('.jdb-beforeafter-wrapper');
$handleStyle = new JDPageBuilder\Element\ElementStyle('.jdb-beforeafter-handle');
$handleStyleBefore = new JDPageBuilder\Element\ElementStyle('.jdb-beforeafter-handle:before');
$handleStyleAfter = new JDPageBuilder\Element\ElementStyle('.jdb-beforeafter-handle:after');
$handleStyleLeft = new JDPageBuilder\Element\ElementStyle('.jdb-beforeafter-left-arrow');
$handleStyleUp = new JDPageBuilder\Element\ElementStyle('.jdb-beforeafter-up-arrow');
$handleStyleRight = new JDPageBuilder\Element\ElementStyle('.jdb-beforeafter-right-arrow');
$handleStyleDown = new JDPageBuilder\Element\ElementStyle('.jdb-beforeafter-down-arrow');

$element->addChildrenStyle([$wrapperStyle, $handleStyle, $handleStyleBefore, $handleStyleAfter, $handleStyleLeft, $handleStyleRight, $handleStyleUp, $handleStyleDown]);

$handleStyle->addCss('border-color', $element->params->get('handleColor', ''));
$handleStyleBefore->addCss('box-shadow', '0 3px 0 ' . $element->params->get('handleColor', '#fff') . ', 0px 0px 12px rgba(51, 51, 51, 0.5)');
$handleStyleBefore->addCss('background', $element->params->get('handleColor', '#fff'));
$handleStyleAfter->addCss('box-shadow', '0 -3px 0 ' . $element->params->get('handleColor', '#fff') . ', 0px 0px 12px rgba(51, 51, 51, 0.5)');
$handleStyleAfter->addCss('background', $element->params->get('handleColor', '#fff'));
$handleStyleLeft->addCss('border-right-color', $element->params->get('handleColor', ''));
$handleStyleUp->addCss('border-bottom-color', $element->params->get('handleColor', ''));
$handleStyleRight->addCss('border-left-color', $element->params->get('handleColor', ''));
$handleStyleDown->addCss('border-top-color', $element->params->get('handleColor', ''));



$width = $element->params->get('sliderWidth', null);
if (!empty($width)) {
    foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($width->{$deviceKey}) && \JDPageBuilder\Helper::checkSliderValue($width->{$deviceKey})) {
            $wrapperStyle->addCss('width', $width->{$deviceKey}->value . $width->{$deviceKey}->unit, $device);
        }
    }
}

$alignment = $element->params->get('sliderAlignment', null);
if (!empty($alignment)) {
    foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($alignment->{$deviceKey})) {
            $margin = $alignment->{$deviceKey} == 'left' ? 'margin-right' : ($alignment->{$deviceKey} == 'right' ? 'margin-left' : 'margin');
            $wrapperStyle->addCss($margin, 'auto', $device);
        }
    }
}
