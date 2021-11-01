<?php

/**
 * @package    JD Builder
 * @author     Team Joomdev <info@joomdev.com>
 * @copyright  2020 www.joomdev.com
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
extract($displayData);

$element->addClass('jdb-team');

$html = [];

// social links
$sociallinks = [];
$profiles = $element->params->get('memberSocialLinks', []);
if (!empty($profiles)) {
    $colorStyle = $element->params->get('iconStyle', 'brand');

    $animation = $element->params->get('slHoverAnimation', '');
    if (!empty($animation)) {
        $animation = 'jdb-hover-' . $animation;
    }

    $invertedColors = $element->params->get('brandColorInverted', false);

    $sociallinks = [];
    $sociallinks[] = '<div class="jdb-social-links jdb-social-links-icon-only' . ($colorStyle === 'brand' ? ' jdb-brands-icons' : '') . '"><ul>';
    $index = 0;
    foreach ($profiles as $profile) {
        if (empty($profile)) {
            continue;
        }
        \JDPageBuilder\Builder::loadFontLibraryByIcon($profile->icon);
        $index++;

        $linkTargetBlank = (isset($profile->linkTargetBlank) && $profile->linkTargetBlank) ? ' target="_blank"' : '';
        $linkNoFollow = (isset($profile->linkNoFollow) && $profile->linkNoFollow) ? ' rel="nofollow"' : '';

        $sociallinks[] = '<li class="jdb-social-link-' . $index . ' ' . $animation . '">
         <a data-brand="' . str_replace(" ", "-", $profile->icon) . '" title="' . $profile->title . '" class="brand-' . ($invertedColors ? 'inverted' : 'static') . '" href="' . $profile->link . '"' . $linkTargetBlank . $linkNoFollow . '>
            <span class="jdb-sl-icon">
               <span class="' . $profile->icon . '"></span>
            </span>
            <span class="jdb-sl-title">' . $profile->title . '</span>
         </a>
      </li>';
    }
    $sociallinks[] = '</ul></div>';
}

$sociallinks = implode('', $sociallinks);

// params
$memberAvatar = $element->params->get('memberAvatar', '');
$memberName = $element->params->get('memberName', '');
$nameHtmlTag = $element->params->get('nameHtmlTag', 'h3');
$memberDesignation = $element->params->get('memberDesignation', '');
$memberBio = $element->params->get('memberBio', '');
$slPosition = $element->params->get('slPosition', 'afterbio');

$html[] = '<div>';

if (!empty($memberAvatar)) {
    $attrs = [];
    // image title and alt
    $attrs[] = 'title="' . $memberName . '"';
    $attrs[] = 'alt="' . $memberName . '"';
    $html[] = '<img class="jdb-team-img" src="' . \JDPageBuilder\Helper::mediaValue($memberAvatar) . '" ' . (empty($attrs) ? '' : ' ' . implode(" ", $attrs)) . ' />';
}


// image caption
if (!empty($memberName)) {
    $html[] = '<' . $nameHtmlTag . ' class="jdb-team-name">' . $memberName . '</' . $nameHtmlTag . '>';
}
if (!empty($memberDesignation)) {
    $html[] = '<p class="jdb-team-designation">' . $memberDesignation . '</p>';
}
if ($slPosition == 'beforebio') {
    $html[] = $sociallinks;
}
if (!empty($memberBio)) {
    $html[] = '<p class="jdb-team-bio">' . $memberBio . '</p>';
}
if ($slPosition == 'afterbio') {
    $html[] = $sociallinks;
}
$html[] = '</div>';
echo implode('', $html);

$imageStyle = new JDPageBuilder\Element\ElementStyle(".jdb-team-img");
$titleStyle = new JDPageBuilder\Element\ElementStyle(".jdb-team-name");
$designationStyle = new JDPageBuilder\Element\ElementStyle(".jdb-team-designation");
$bioStyle = new JDPageBuilder\Element\ElementStyle(".jdb-team-bio");
$slStyle = new JDPageBuilder\Element\ElementStyle(".jdb-social-links");

$element->addChildrenStyle([$imageStyle, $titleStyle, $designationStyle, $bioStyle, $slStyle]);

$colorStyle = $element->params->get('iconStyle', 'brand');

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
    Title, Designation, Bio Styling
*/

foreach (['name' => $titleStyle, 'designation' => $designationStyle, 'bio' => $bioStyle] as $key => $elStyle) {
    // Color and Space
    $elStyle->addCss('color', $element->params->get($key . 'Color', ''));
    $spacing = $element->params->get($key . 'Spacing', null);
    if (!empty($spacing)) {
        foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
            if (isset($spacing->{$deviceKey}) && JDPageBuilder\Helper::checkSliderValue($spacing->{$deviceKey})) {
                $elStyle->addCss('margin-top', $spacing->{$deviceKey}->value . 'px', $device);
            }
        }
    }

    // Typography
    $typography = $element->params->get($key . 'Typography', null);
    if (!empty($typography)) {
        foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
            if (isset($typography->{$deviceKey}) && !empty($typography->{$deviceKey})) {
                $elStyle->addStyle(JDPageBuilder\Helper::typographyValue($typography->{$deviceKey}), $device);
            }
        }
    }
}


/* Social Links Styling */

$spacing = $element->params->get('slSpacing', null);
if (!empty($spacing)) {
    foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($spacing->{$deviceKey}) && JDPageBuilder\Helper::checkSliderValue($spacing->{$deviceKey})) {
            $slStyle->addCss('margin-top', $spacing->{$deviceKey}->value . 'px', $device);
        }
    }
}

$slAlignment = $element->params->get('slAlignment', null);
if (!empty($slAlignment)) {
    foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($slAlignment->{$deviceKey}) && !empty($slAlignment->{$deviceKey})) {
            $slStyle->addCss("text-align", $slAlignment->{$deviceKey}, $device);
        }
    }
}

$linkStyle = new JDPageBuilder\Element\ElementStyle(".jdb-social-links > ul li a");
$linkHoverStyle = new JDPageBuilder\Element\ElementStyle(".jdb-social-links > ul li:hover a");

$element->addChildrenStyle([$linkStyle, $linkHoverStyle]);


$borderRadius = $element->params->get('slBorderRadius', null);
if (!empty($borderRadius)) {
    foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($borderRadius->{$deviceKey}) && !empty($borderRadius->{$deviceKey})) {
            $linkStyle->addStyle(JDPageBuilder\Helper::spacingValue($borderRadius->{$deviceKey}, "radius"), $device);
        }
    }
}

$padding = $element->params->get('innerPadding', null);
if (!empty($padding)) {
    foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($padding->{$deviceKey}) && JDPageBuilder\Helper::checkSliderValue($padding->{$deviceKey})) {
            $linkStyle->addCss("padding", $padding->{$deviceKey}->value . 'px', $device);
        }
    }
}

$spaceBetween = $element->params->get('slSpaceBetween', null);
if (!empty($spaceBetween)) {
    foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($spaceBetween->{$deviceKey}) && JDPageBuilder\Helper::checkSliderValue($spaceBetween->{$deviceKey})) {
            $linkStyle->addCss("margin-right", $spaceBetween->{$deviceKey}->value . 'px', $device);
        }
    }
}

$borderStyle = $element->params->get('slBorderStyle', 'none');
$linkStyle->addCss("border-style", $borderStyle);
if ($borderStyle != "none") {
    $borderWidth = $element->params->get('slBorderWidth', null);
    if (!empty($borderWidth)) {
        foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
            if (isset($borderWidth->{$deviceKey}) && !empty($borderWidth->{$deviceKey})) {
                $linkStyle->addStyle(JDPageBuilder\Helper::spacingValue($borderWidth->{$deviceKey}, "border"), $device);
            }
        }
    }
}

$linkStyle->addCss("box-shadow", $element->params->get('slBoxShadow', ''));
if ($colorStyle != "brand") {
    $linkStyle->addCss("color", $element->params->get('slColor', ''));
}

$invertedColors = $element->params->get('brandColorInverted', false);

if (!($colorStyle == "brand" && $invertedColors)) {
    $linkHoverStyle->addCss("color", $element->params->get('slHoverColor', ''));
}
if ($colorStyle != "brand") {
    $linkStyle->addCss("background-color", $element->params->get('slBackgroundColor', ''));
}
if (!($colorStyle == "brand" && $invertedColors)) {
    $linkHoverStyle->addCss("background-color", $element->params->get('slHoverBackgroundColor', ''));
}
if ($colorStyle != "brand") {
    $linkStyle->addCss("border-color", $element->params->get('slBorderColor', ''));
}
if (!($colorStyle == "brand" && $invertedColors)) {
    $linkHoverStyle->addCss("border-color", $element->params->get('slBorderHoverColor', ''));
}
$iconStyle = new JDPageBuilder\Element\ElementStyle(".jdb-social-links > ul li a .jdb-sl-icon");
$element->addChildStyle($iconStyle);

$iconSize = $element->params->get('iconSize', null);
if (!empty($iconSize)) {
    foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($iconSize->{$deviceKey}) && JDPageBuilder\Helper::checkSliderValue($iconSize->{$deviceKey})) {
            $iconStyle->addCss("font-size", $iconSize->{$deviceKey}->value . 'px', $device);
            $iconStyle->addCss("width", $iconSize->{$deviceKey}->value . 'px', $device);
            $iconStyle->addCss("height", $iconSize->{$deviceKey}->value . 'px', $device);
        }
    }
}
/* Social Links Styling End */
