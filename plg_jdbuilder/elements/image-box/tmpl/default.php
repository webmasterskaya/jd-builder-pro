<?php

/**
 * @package    JD Builder
 * @author     Team Joomdev <info@joomdev.com>
 * @copyright  2020 www.joomdev.com
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
extract($displayData);

$element->addClass('jdb-imagebox');

$html = [];

// params
$image = $element->params->get('image', '');
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
        $linkClass = ' class="jdb-imagebox-btn"';
    }
    $linkStart = '<a href="' . $link . '"' . $linkClass . $linkTitle . $linkTarget . $linkRel . '>';
    $linkEnd = '</a>';
}

if ($linkOn == 'full-box') {
    $html[] = $linkStart;
}

$html[] = '<figure>';

if (!empty($image)) {
    $attrs = [];
    // image title and alt
    $altText = $element->params->get('altText', '');
    if (!empty($altText)) {
        $attrs[] = 'title="' . $altText . '"';
        $attrs[] = 'alt="' . $altText . '"';
    } else if (!empty($title)) {
        $attrs[] = 'title="' . $title . '"';
        $attrs[] = 'alt="' . $title . '"';
    }
    if ($linkOn == 'both-image-and-title' || $linkOn == 'image') {
        $html[] = $linkStart;
    }
    $html[] = '<img class="jdb-imagebox-img" src="' . \JDPageBuilder\Helper::mediaValue($image) . '" ' . (empty($attrs) ? '' : ' ' . implode(" ", $attrs)) . ' />';
    if ($linkOn == 'both-image-and-title' || $linkOn == 'image') {
        $html[] = $linkEnd;
    }
}

// image caption
if (!empty($title)) {
    if ($linkOn == 'both-image-and-title' || $linkOn == 'title') {
        $html[] = $linkStart;
    }
    $html[] = '<' . $titleHtmlTag . ' class="jdb-imagebox-title">' . $title . '</' . $titleHtmlTag . '>';
    if ($linkOn == 'both-image-and-title' || $linkOn == 'title') {
        $html[] = $linkEnd;
    }
}
if (!empty($description)) {
    $html[] = '<figcaption class="jdb-imagebox-desc">' . $description . '</figcaption>';
}
if (!empty($link) && !empty($buttonText)) {
    $html[] = '<div class="jdb-imagebox-btn-container">';
    if ($linkOn == 'button') {
        $html[] = $linkStart . $buttonText . $linkEnd;
    } else if ($linkOn == 'full-box') {
        $html[] = '<span class="jdb-imagebox-btn">' . $buttonText . '</span>';
    }
    $html[] = '</div>';
}

$html[] = '</figure>';
if ($linkOn == 'full-box') {
    $html[] = $linkEnd;
}
echo implode('', $html);

$imageStyle = new JDPageBuilder\Element\ElementStyle(".jdb-imagebox-img");
$titleStyle = new JDPageBuilder\Element\ElementStyle(".jdb-imagebox-title");
$descStyle = new JDPageBuilder\Element\ElementStyle(".jdb-imagebox-desc");
$buttonStyle = new JDPageBuilder\Element\ElementStyle(".jdb-imagebox-btn");
$buttonStyleContainer = new JDPageBuilder\Element\ElementStyle(".jdb-imagebox-btn-container");
$buttonHoverStyle = new JDPageBuilder\Element\ElementStyle(".jdb-imagebox-btn:hover");

$element->addChildrenStyle([$imageStyle, $titleStyle, $descStyle, $buttonStyle, $buttonHoverStyle, $buttonStyleContainer]);

/*
    Image Styling
*/

$imageWidth = $element->params->get('imageWidth', null);
if (!empty($imageWidth)) {
    foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($imageWidth->{$deviceKey}) && JDPageBuilder\Helper::checkSliderValue($imageWidth->{$deviceKey})) {
            $imageStyle->addCss("width", $imageWidth->{$deviceKey}->value . $imageWidth->{$deviceKey}->unit, $device);
        }
    }
}

$imageBorderStyle = $element->params->get('imageBorderStyle', '');
if (!empty($imageBorderStyle)) {
    $imageStyle->addCss('border-style', $imageBorderStyle);
    $imageBorderWidth = $element->params->get('imageBorderWidth', null);
    if (!empty($imageBorderWidth) && $imageBorderStyle != 'none') {

        foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
            if (isset($imageBorderWidth->{$deviceKey}) && !empty($imageBorderWidth->{$deviceKey})) {

                $css = \JDPageBuilder\Helper::spacingValue($imageBorderWidth->{$deviceKey}, "border");
                if (!empty($css)) {
                    $imageStyle->addStyle($css, $device);
                }
            }
        }

        $imageStyle->addCss('border-color', $element->params->get('imageBorderColor', ''));
    }
}
$imageBorderRadius = $element->params->get('imageBorderRadius', null);
if (!empty($imageBorderRadius)) {
    foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($imageBorderRadius->{$deviceKey}) && !empty($imageBorderRadius->{$deviceKey})) {

            $css = \JDPageBuilder\Helper::spacingValue($imageBorderRadius->{$deviceKey}, "radius");
            if (!empty($css)) {
                $imageStyle->addStyle($css, $device);
            }
        }
    }
}
$imageBoxShadow = $element->params->get('imageBoxShadow', '');
if (!empty($imageBoxShadow)) {
    foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($imageBoxShadow->{$deviceKey}) && !empty($imageBoxShadow->{$deviceKey})) {
            $imageStyle->addCss('box-shadow', $imageBoxShadow->{$deviceKey}, $device);
        }
    }
}

/*
    Title Styling
*/

// Title Color and Space
$titleStyle->addCss('color', $element->params->get('titleColor', ''));
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

$elementHoverStyle = new JDPageBuilder\Element\ElementStyle("::hover");
$element->addChildrenStyle([$elementHoverStyle]);

JDPageBuilder\Helper::applyBackgroundValue($elementHoverStyle, $element->params, "boxHoverBackground");
JDPageBuilder\Helper::applyBorderValue($elementHoverStyle, $element->params, "boxHoverBorder");