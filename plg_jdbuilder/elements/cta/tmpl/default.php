<?php

/**
 * @package    JD Builder
 * @author     Team Joomdev <info@joomdev.com>
 * @copyright  2020 www.joomdev.com
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
extract($displayData);

$element->addClass('jdb-cta');

$title = $element->params->get('title', '');
$titleHtmlTag = $element->params->get('titleHtmlTag', 'h4');
$description = $element->params->get('description', '');
$link = $element->params->get('link', '');
$buttonText = $element->params->get('buttonText', '');
$ribbonText = $element->params->get('ribbonText', '');
$verticalPosition = $element->params->get('verticalPosition', '');

if (!empty($verticalPosition)) {
    $element->addClass('jdb-' . $verticalPosition);
}

$element->addCss('text-align', $element->params->get('contentAlignment', ''));

$html = [];

if (!empty($ribbonText)) {
    $element->addClass('jdb-has-ribbon');
    $html[] = '<span class="jdb-ribbon ' . ($element->params->get('ribbonPosition', 'right')) . '">' . $ribbonText . '</span>';
}

if (!empty($title)) {
    $html[] = '<' . $titleHtmlTag . ' class="jdb-cta-title">' . $title . '</' . $titleHtmlTag . '>';
}

if (!empty($description)) {
    $html[] = '<div class="jdb-cta-desc">' . $description . '</div>';
}

if (!empty($buttonText)) {
    $html[] = JDPageBuilder\Helper::renderButtonValue('button', $element, $buttonText, [], 'link', $element->params->get('link', ''), $element->params->get('linkTargetBlank', false), $element->params->get('linkNoFollow', false));
}

echo implode('', $html);

/* Styling */
$titleStyle = new JDPageBuilder\Element\ElementStyle(".jdb-cta-title");
$titleHoverStyle = new JDPageBuilder\Element\ElementStyle("::hover .jdb-cta-title");
$descStyle = new JDPageBuilder\Element\ElementStyle(".jdb-cta-desc");
$descHoverStyle = new JDPageBuilder\Element\ElementStyle("::hover .jdb-cta-desc");
$ribbonStyle = new JDPageBuilder\Element\ElementStyle(".jdb-ribbon");
$buttonStyle = new JDPageBuilder\Element\ElementStyle(".jdb-cta-btn");
$buttonHoverStyle = new JDPageBuilder\Element\ElementStyle(".jdb-cta-btn:hover");

$element->addChildrenStyle([$titleStyle, $titleHoverStyle, $descStyle, $descHoverStyle, $buttonStyle, $buttonHoverStyle, $ribbonStyle]);


$minHeight = $element->params->get('minHeight', NULL);
if (!empty($minHeight)) {
    foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($minHeight->{$deviceKey}) && \JDPageBuilder\Helper::checkSliderValue($minHeight->{$deviceKey})) {
            $element->addCss("min-height", $minHeight->{$deviceKey}->value . $minHeight->{$deviceKey}->unit, $device);
        }
    }
}

/*
    Title Styling
*/

// Title Color and Space
$titleStyle->addCss('color', $element->params->get('titleColor', ''));
$titleHoverStyle->addCss('color', $element->params->get('titleHoverColor', ''));
$titleSpacing = $element->params->get('titleSpacing', null);

$titleSpacing = $element->params->get('titleSpacing', NULL);
if (!empty($titleSpacing)) {
    foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($titleSpacing->{$deviceKey}) && \JDPageBuilder\Helper::checkSliderValue($titleSpacing->{$deviceKey})) {
            $titleStyle->addCss("margin-bottom", (($titleSpacing->{$deviceKey}->value * 4) * .17) . 'px', $device);
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

/*
    Description Styling
*/

// Title Color and Space
$descStyle->addCss('color', $element->params->get('descriptionColor', ''));
$descHoverStyle->addCss('color', $element->params->get('descriptionHoverColor', ''));

$descSpacing = $element->params->get('descriptionSpacing', NULL);
if (!empty($descSpacing)) {
    foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($descSpacing->{$deviceKey}) && \JDPageBuilder\Helper::checkSliderValue($descSpacing->{$deviceKey})) {
            $descStyle->addCss("margin-bottom", (($descSpacing->{$deviceKey}->value * 4) * .17) . 'px', $device);
        }
    }
}

// desc Typography
$typography = $element->params->get('descriptionTypography', null);
if (!empty($typography)) {
    foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($typography->{$deviceKey}) && !empty($typography->{$deviceKey})) {
            $descStyle->addStyle(JDPageBuilder\Helper::typographyValue($typography->{$deviceKey}), $device);
        }
    }
}

/*
    Button Styling
*/

// Button Background
$buttonStyle->addCss("background-color", $element->params->get('buttonBackgroundColor', ''));
$buttonHoverStyle->addCss("background-color", $element->params->get('buttonBackgroundColorHover', ''));

// Button Text Color
$buttonStyle->addCss("color", $element->params->get('buttonTextColor', ''));
$buttonHoverStyle->addCss("color", $element->params->get('buttonTextColorHover', ''));

// Button Border Color
$buttonStyle->addCss("border-color", $element->params->get('buttonBorderColor', ''));
$buttonHoverStyle->addCss("border-color", $element->params->get('buttonBorderColorHover', ''));

// Button Gradient
$buttonStyle->addCss("background-image", $element->params->get('buttonGradient', ''));
$buttonHoverStyle->addCss("background-image", $element->params->get('buttonGradientHover', ''));
if (!empty($element->params->get('buttonGradient', '')) && empty($element->params->get('buttonGradientHover', ''))) {
    $buttonHoverStyle->addCss("background-image", 'none');
}

// Button Typography
$typography = $element->params->get('buttonTypography', null);
if (!empty($typography)) {
    foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($typography->{$deviceKey}) && !empty($typography->{$deviceKey})) {
            $buttonStyle->addStyle(JDPageBuilder\Helper::typographyValue($typography->{$deviceKey}), $device);
        }
    }
}

// Button Padding
$padding = $element->params->get('buttonPadding', null);
if (!empty($padding)) {
    foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($padding->{$deviceKey}) && !empty($padding->{$deviceKey})) {
            $buttonStyle->addStyle(JDPageBuilder\Helper::spacingValue($padding->{$deviceKey}, "padding"), $device);
        }
    }
}

// Button Border
JDPageBuilder\Helper::applyBorderValue($buttonStyle, $element->params, "buttonBorder");
JDPageBuilder\Helper::applyBorderValue($buttonHoverStyle, $element->params, "buttonHoverBorder");

// Ribbon Styling
$ribbonStyle->addCss("color", $element->params->get('ribbonColor', ''));
$ribbonStyle->addCss("background-color", $element->params->get('ribbonBackground', ''));
$typography = $element->params->get('ribbonTypography', null);
if (!empty($typography)) {
    foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($typography->{$deviceKey}) && !empty($typography->{$deviceKey})) {
            $ribbonStyle->addStyle(JDPageBuilder\Helper::typographyValue($typography->{$deviceKey}), $device);
        }
    }
}

$ribbonDistance = $element->params->get('ribbonDistance', NULL);
if (!empty($ribbonDistance)) {
    foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($ribbonDistance->{$deviceKey}) && \JDPageBuilder\Helper::checkSliderValue($ribbonDistance->{$deviceKey})) {
            $ribbonStyle->addCss("margin-" . $element->params->get('ribbonPosition', 'right'), '-' . $ribbonDistance->{$deviceKey}->value . 'px', $device);
            $ribbonStyle->addCss("width", ($ribbonDistance->{$deviceKey}->value * 4) . 'px', $device);
            $ribbonStyle->addCss("margin-top", (($ribbonDistance->{$deviceKey}->value * 4) * .17) . 'px', $device);
        }
    }
}

$elementHoverStyle = new JDPageBuilder\Element\ElementStyle("::hover");
$element->addChildrenStyle([$elementHoverStyle]);

JDPageBuilder\Helper::applyBackgroundValue($elementHoverStyle, $element->params, "ctaHoverBackground");
JDPageBuilder\Helper::applyBorderValue($elementHoverStyle, $element->params, "ctaHoverBorder");
