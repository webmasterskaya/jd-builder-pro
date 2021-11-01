<?php

/**
 * @package    JD Builder
 * @author     Team Joomdev <info@joomdev.com>
 * @copyright  2020 www.joomdev.com
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
extract($displayData);

$element->addClass('jdb-iconbox');

$html = [];

// params
$icon = $element->params->get('icon', '');
$title = $element->params->get('title', '');
$titleHtmlTag = $element->params->get('titleHtmlTag', 'h4');
$description = $element->params->get('description', '');
$link = $element->params->get('link', '');
$buttonText = $element->params->get('buttonText', '');
$linkOn = $element->params->get('linkOn', 'button');

$linkStart = '';
$linkEnd = '';
if (!empty($link)) {
    // link title
    $linkTitle = empty($title) ? '' : ' title="' . $title . '"';

    // link target
    $linkTargetBlank = $element->params->get('linkTargetBlank', FALSE);
    $linkTarget = $linkTargetBlank ? ' target="_blank"' : "";

    // link follow
    $linkNoFollow = $element->params->get('linkNoFollow', FALSE);
    $linkRel = $linkNoFollow ? ' rel="nofollow"' : "";

    $linkClass = '';
    if (!empty($link) && !empty($buttonText) && $linkOn == 'button') {
        $linkClass = ' class="jdb-iconbox-btn"';
    }
    $linkStart = '<a href="' . $link . '"' . $linkClass . $linkTitle . $linkTarget . $linkRel . '>';
    $linkEnd = '</a>';
}

if ($linkOn == 'full-box') {
    $html[] = $linkStart;
}

$html[] = '<div class="jdb-d-flex jdb-flex-' . $element->params->get('iconPosition', 'column') . '">';

if (!empty($icon)) {
    \JDPageBuilder\Builder::loadFontLibraryByIcon($icon);

    if ($linkOn == 'both-icon-and-title' || $linkOn == 'icon') {
        $html[] = $linkStart;
    }
    $html[] = '<div class="jdb-iconbox-icon jdb-icon"><div class="jdb-icon-wrapper"><span class="' . $icon . '"></span></div></div>';
    if ($linkOn == 'both-icon-and-title' || $linkOn == 'icon') {
        $html[] = $linkEnd;
    }
}

$html[] = '<div>';
// icon caption
if (!empty($title)) {
    if ($linkOn == 'both-icon-and-title' || $linkOn == 'title') {
        $html[] = $linkStart;
    }
    $html[] = '<' . $titleHtmlTag . ' class="jdb-iconbox-title">' . $title . '</' . $titleHtmlTag . '>';
    if ($linkOn == 'both-icon-and-title' || $linkOn == 'title') {
        $html[] = $linkEnd;
    }
}
if (!empty($description)) {
    $html[] = '<div class="jdb-iconbox-desc">' . $description . '</div>';
}
if (!empty($link) && !empty($buttonText)) {
    $html[] = '<div class="jdb-iconbox-btn-container">';
    if ($linkOn == 'button') {
        $html[] = $linkStart . $buttonText . $linkEnd;
    } else if ($linkOn == 'full-box') {
        $html[] = '<span class="jdb-iconbox-btn">' . $buttonText . '</span>';
    }
    $html[] = '</div>';
}
$html[] = '</div>';

$html[] = '</div>';
if ($linkOn == 'full-box') {
    $html[] = $linkEnd;
}
echo implode('', $html);

$titleStyle = new JDPageBuilder\Element\ElementStyle(".jdb-iconbox-title");
$titleHoverStyle = new JDPageBuilder\Element\ElementStyle(":hover .jdb-iconbox-title");
$descStyle = new JDPageBuilder\Element\ElementStyle(".jdb-iconbox-desc");
$descHoverStyle = new JDPageBuilder\Element\ElementStyle(":hover .jdb-iconbox-desc");
$buttonStyle = new JDPageBuilder\Element\ElementStyle(".jdb-iconbox-btn");
$buttonStyleContainer = new JDPageBuilder\Element\ElementStyle(".jdb-iconbox-btn-container");
$buttonHoverStyle = new JDPageBuilder\Element\ElementStyle(":hover .jdb-iconbox-btn");

$element->addChildrenStyle([$titleStyle, $titleHoverStyle, $descStyle, $descHoverStyle, $buttonStyle, $buttonHoverStyle, $buttonStyleContainer]);

/*
    Title Styling
*/

// Title Color and Space
$titleStyle->addCss('color', $element->params->get('titleColor', ''));
$titleHoverStyle->addCss('color', $element->params->get('titleHoverColor', ''));
$titleSpacing = $element->params->get('titleSpacing', null);
if (JDPageBuilder\Helper::checkSliderValue($titleSpacing)) {
    $titleStyle->addCss('margin-top', $titleSpacing->value . 'px');
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
    Desc Styling
*/

// Desc Color and Space
$descStyle->addCss('color', $element->params->get('descColor', ''));
$descHoverStyle->addCss('color', $element->params->get('descHoverColor', ''));
$descSpacing = $element->params->get('descSpacing', null);
if (JDPageBuilder\Helper::checkSliderValue($descSpacing)) {
    $descStyle->addCss('margin-top', $descSpacing->value . 'px');
}

// Description Typography
$typography = $element->params->get('descTypography', null);
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
// Button Spacing
$buttonSpacing = $element->params->get('buttonSpacing', null);
if (JDPageBuilder\Helper::checkSliderValue($buttonSpacing)) {
    $buttonStyleContainer->addCss('margin-top', $buttonSpacing->value . 'px');
}

// Button Alignment
$alignment = $element->params->get('buttonAlignment', null);
if (!empty($alignment)) {
    foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($alignment->{$deviceKey}) && !empty($alignment->{$deviceKey})) {
            $align = $alignment->{$deviceKey};
            if ($align != 'block') {
                $buttonStyleContainer->addCss('text-align', $align, $device);
            } else {
                $buttonStyle->addCss("width", "100%", $device);
            }
        }
    }
}

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
$borderType = $element->params->get('buttonBorderStyle', 'solid');
$buttonStyle->addCss("border-style", $borderType);
if ($borderType != 'none') {
    $borderWidth = $element->params->get('buttonBorderWidth', null);
    if ($borderWidth != null) {
        foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
            if (isset($borderWidth->{$deviceKey}) && !empty($borderWidth->{$deviceKey})) {
                $css = JDPageBuilder\Helper::spacingValue($borderWidth->{$deviceKey}, "border");
                $buttonStyle->addStyle($css, $device);
            }
        }
    }
}

// Button Radius
$borderRadius = $element->params->get('buttonBorderRadius', null);
if (!empty($borderRadius)) {
    foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($borderRadius->{$deviceKey}) && !empty($borderRadius->{$deviceKey})) {
            $css = JDPageBuilder\Helper::spacingValue($borderRadius->{$deviceKey}, "radius");
            $buttonStyle->addStyle($css, $device);
        }
    }
}

// Button Shadow
$buttonStyle->addCss("box-shadow", $element->params->get('buttonBoxShadow', ''));

$iconStyle = new JDPageBuilder\Element\ElementStyle('.jdb-iconbox-icon > .jdb-icon-wrapper');
$iconInnerStyle = new JDPageBuilder\Element\ElementStyle('.jdb-iconbox-icon > .jdb-icon-wrapper > span');
$iconInnerHoverStyle = new JDPageBuilder\Element\ElementStyle(':hover .jdb-iconbox-icon > .jdb-icon-wrapper > span');
$iconHoverStyle = new JDPageBuilder\Element\ElementStyle(':hover .jdb-iconbox-icon > .jdb-icon-wrapper:hover');

$element->addChildrenStyle([$iconStyle, $iconHoverStyle, $iconInnerStyle, $iconInnerHoverStyle]);

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

// Icon Rotate
$iconRotate = $element->params->get('iconRotate', null);
if (!empty($iconRotate)) {
    foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($iconRotate->{$deviceKey}) && JDPageBuilder\Helper::checkSliderValue($iconRotate->{$deviceKey}) && !empty($iconRotate->{$deviceKey}->value)) {
            $iconInnerStyle->addCss("transform", 'rotate(' . $iconRotate->{$deviceKey}->value . 'deg)', $device);
        }
    }
}
$iconRotateHover = $element->params->get('iconRotateHover', null);
if (!empty($iconRotateHover)) {
    foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($iconRotateHover->{$deviceKey}) && JDPageBuilder\Helper::checkSliderValue($iconRotateHover->{$deviceKey}) && !empty($iconRotateHover->{$deviceKey}->value)) {
            $iconInnerHoverStyle->addCss("transform", 'rotate(' . $iconRotateHover->{$deviceKey}->value . 'deg)', $device);
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

$iconStyle->addCss("color", $element->params->get('iconTextColor', ''));
$iconStyle->addCss("background-color", $element->params->get('iconBackgroundColor', ''));
$iconStyle->addCss("border-color", $element->params->get('iconBorderColor', ''));
$iconStyle->addCss("background-image", $element->params->get('iconGradient', ''));
$iconStyle->addCss("box-shadow", $element->params->get('iconBoxShadow', ''));


$iconHoverStyle->addCss("color", $element->params->get('iconTextColorHover', ''));
$iconHoverStyle->addCss("background-color", $element->params->get('iconBackgroundColorHover', ''));
$iconHoverStyle->addCss("border-color", $element->params->get('iconBorderColorHover', ''));
$iconHoverStyle->addCss("background-image", $element->params->get('iconGradientHover', ''));

// border
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

$elementHoverStyle = new JDPageBuilder\Element\ElementStyle("::hover");
$element->addChildrenStyle([$elementHoverStyle]);

JDPageBuilder\Helper::applyBackgroundValue($elementHoverStyle, $element->params, "boxHoverBackground");
JDPageBuilder\Helper::applyBorderValue($elementHoverStyle, $element->params, "boxHoverBorder");
