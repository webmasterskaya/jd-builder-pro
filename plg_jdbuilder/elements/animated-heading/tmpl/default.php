<?php

/**
 * @package    JD Builder
 * @author     Team Joomdev <info@joomdev.com>
 * @copyright  2020 www.joomdev.com
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
extract($displayData);

\JDPageBuilder\Builder::loadAnimatedHeadingJS();

$texts = $element->params->get('texts', []);
$stringtexts = [];
foreach ($texts as $text) {
    if (!empty($text->text)) {
        $stringtexts[] = $text->text;
    }
}

$target = $element->params->get('linkTargetBlank', false) ? 'true' : 'false';
$follow = $element->params->get('linkNoFollow', false) ? 'true' : 'false';

$html = [];
$html[] = '<div jdb-animatedheading="' . ('before:' . $element->params->get("before", "") . ';after:' . $element->params->get("after", "") . ';texts:' . implode(',', $stringtexts) . ';tag:' . $element->params->get("headingHtmlTag", "h3") . ';link:' . $element->params->get("link", "") . ';linkTargetBlank:' . $target . ';linkNoFollow:' . $follow . ';animation:' . $element->params->get('rotatingAnimation', 'letters type')) . '"></div>';

echo implode('', $html);
$alignment = $element->params->get('headingAlignment', null);
if (!empty($alignment)) {
    foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($alignment->{$deviceKey}) && !empty($alignment->{$deviceKey})) {
            $element->addCss('text-align', $alignment->{$deviceKey}, $device);
        }
    }
}

$style = new JDPageBuilder\Element\ElementStyle(".cd-headline");
$animatedtTextstyle = new JDPageBuilder\Element\ElementStyle(".cd-words-wrapper");
$animatedtTextstyleLetter = new JDPageBuilder\Element\ElementStyle(".cd-words-wrapper b i");
$element->addChildStyle($style);
$element->addChildStyle($animatedtTextstyle);
$element->addChildStyle($animatedtTextstyleLetter);

$style->addCss("color", $element->params->get("headingFontColor", ""));
$animatedtTextstyle->addCss("color", $element->params->get("animatedTextColor", ""));
$style->addCss("text-shadow", $element->params->get("headingTextShadow", ""));

// typography
$typography = $element->params->get("headingTypography", NULL);
if (!empty($typography)) {
    foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($typography->{$deviceKey}) && !empty($typography->{$deviceKey})) {
            $style->addStyle(JDPageBuilder\Helper::typographyValue($typography->{$deviceKey}), $device);
        }
    }
}

$typography = $element->params->get("animatedTextTypography", NULL);
if (!empty($typography)) {
    foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($typography->{$deviceKey}) && !empty($typography->{$deviceKey})) {
            $animatedtTextstyle->addStyle(JDPageBuilder\Helper::typographyValue($typography->{$deviceKey}), $device);
            $animatedtTextstyleLetter->addStyle(JDPageBuilder\Helper::typographyValue($typography->{$deviceKey}), $device);
        }
    }
}
