<?php

/**
 * @package    JD Builder
 * @author     Team Joomdev <info@joomdev.com>
 * @copyright  2020 www.joomdev.com
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

use JDPageBuilder\Element\ElementStyle;

defined('_JEXEC') or die;
extract($displayData);
$element->addClass('jdb-testimonials');
$testimonials = $element->params->get('testimonials', []);
$skin = $element->params->get('skin', '');
$layout = $element->params->get('layout', 'imagestacked');
$alignment = $element->params->get('alignment', 'center');
$bubblePosition = 'bottom';
if ($skin == 'bubble') {
    switch ($layout) {
        case 'imageabove':
            $bubblePosition = 'top';
            break;
        case 'imageleft':
            $bubblePosition = 'left';
            break;
        case 'imageright':
            $bubblePosition = 'right';
            break;
        default:
    }
}



$imageAlignment = $alignment;
switch ($layout) {
    case 'imagestacked':
        if ($alignment == 'center') {
            $imageAlignment = 'top';
        } else if ($alignment == 'right') {
            $imageAlignment = 'topright';
        } else if ($alignment == 'left') {
            $imageAlignment = 'topleft';
        }
        break;
    case 'imageleft':
        $imageAlignment = 'top';
        break;
    case 'imageright':
        $imageAlignment = 'top';
        break;
    default:
}

$scrollInSet = $element->params->get('scrollInSet', false);
$autoplay = $element->params->get('autoplay', true);
$infinite = $element->params->get('infinite', true);
$draggable = $element->params->get('draggable', true);
$pauseOnHover = $element->params->get('pauseOnHover', true);
$autoplayInterval = $element->params->get('autoplayInterval', \json_decode('{"value": 7000,"unit": "ms"}', false));
$html = [];

$html[] = '<div class="jdb-show-controls" tabindex="-1" jdb-slider="sets:' . ($scrollInSet ? 'true' : 'false') . ';autoplay:' . ($autoplay ? 'true' : 'false') . ';finite:' . ($infinite ? 'false' : 'true') . ';draggable:' . ($draggable ? 'true' : 'false') . ';pause-on-hover:' . ($pauseOnHover ? 'true' : 'false') . ';autoplay-interval:' . $autoplayInterval->value . '">';
$html[] = '<ul class="jdb-slider-items">';

foreach ($testimonials as $testimonial) {
    $html[] = '<li>';
    $html[] = '<div class="jdb-testimonial jdb-testimonial-' . $layout . '">';
    if ($skin != 'bubble' && $layout == 'imageabove') {
        $html[] = '<div class="jdb-testimonial-author-info">';
        $html[] = '<p class="jdb-testimonial-author-name">' . $testimonial->name . '</p>';
        if (!empty($testimonial->designation)) {
            $html[] = '<p class="jdb-testimonial-author-designation">';
            if (!empty($testimonial->url)) {
                $html[] =  '<a href="' . $testimonial->url . '" target="_blank">';
            }
            $html[] =  $testimonial->designation;
            if (!empty($testimonial->url)) {
                $html[] =  '</a>';
            }
            $html[] = '</p>';
        }
        $html[] = '</div>';
    }
    $html[] = '<div class="jdb-testimonial-content' . ($skin == 'bubble' ? ' jdb-speach-bubble' : '') . '" ' . ($skin == 'bubble' ? 'data-bubble-alignment="' . $alignment . '" data-bubble-position="' . $bubblePosition . '"' : '') . '><div class="jdb-testimonial-content-inner">' . $testimonial->content . '</div></div>';
    $html[] = '<div class="jdb-testimonial-author jdb-image-card jdb-image-' . $imageAlignment . '-card">';
    if (!empty($testimonial->avatar)) {
        $html[] = '<div class="jdb-testimonial-author-avatar jdb-image-card-img"><img src="' . \JDPageBuilder\Helper::mediaValue($testimonial->avatar) . '" /></div>';
    }
    if (!($skin != 'bubble' && $layout == 'imageabove')) {
        $html[] = '<div class="jdb-testimonial-author-info jdb-image-card-info"><p class="jdb-testimonial-author-name">' . $testimonial->name . '</p>';
        if (!empty($testimonial->designation)) {
            $html[] = '<p class="jdb-testimonial-author-designation">';
            if (!empty($testimonial->url)) {
                $html[] =  '<a href="' . $testimonial->url . '" target="_blank">';
            }
            $html[] =  $testimonial->designation;
            if (!empty($testimonial->url)) {
                $html[] =  '</a>';
            }
            $html[] = '</p>';
        }
        $html[] = '</div>';
    }
    $html[] = '</div>';
    $html[] = '</div>';
    $html[] = '</li>';
}

$html[] = '</ul>';
$arrows = $element->params->get('arrows', true);
if ($arrows) {
    $html[] = '<div class="jdb-slider-controls jdb-slider-next jdb-slider-inside"><a href="#" jdb-slidenav-next jdb-slider-item="next"><span class="fa fa-chevron-right"></span></a></div><div class="jdb-slider-controls jdb-slider-prev jdb-slider-inside"><a href="#" jdb-slidenav-previous jdb-slider-item="previous"><span class="fa fa-chevron-left"></span></a></div>';
}

$pagination = $element->params->get('pagination', true);
if ($pagination && !$scrollInSet) {
    $html[] = '<ul class="jdb-slider-nav jdb-dotnav"></ul>';
}

$html[] = '</div>';

echo implode('', $html);

$sliderItemStyle = new JDPageBuilder\Element\ElementStyle(".jdb-slider-items > li");
$testimonialStyle = new JDPageBuilder\Element\ElementStyle(".jdb-testimonial");
$testimonialContentStyle = new JDPageBuilder\Element\ElementStyle(".jdb-testimonial-content");
$testimonialNameStyle = new JDPageBuilder\Element\ElementStyle(".jdb-testimonial-author-name");
$testimonialDesgnationStyle = new JDPageBuilder\Element\ElementStyle(".jdb-testimonial-author-designation, .jdb-testimonial-author-designation a");
$testimonialInfoStyle = new JDPageBuilder\Element\ElementStyle(".jdb-testimonial-author-info");
$avatarStyle = new JDPageBuilder\Element\ElementStyle(".jdb-testimonial-author-avatar");
$avatarImgStyle = new JDPageBuilder\Element\ElementStyle(".jdb-testimonial-author-avatar > img");
$arrowStyle = new JDPageBuilder\Element\ElementStyle(".jdb-slider-controls > a");
$paginationStyle = new JDPageBuilder\Element\ElementStyle(".jdb-dotnav>*>*");
$paginationActiveStyle = new JDPageBuilder\Element\ElementStyle(".jdb-dotnav>.jdb-active>*");
$bubbleStyle = new JDPageBuilder\Element\ElementStyle(".jdb-speach-bubble");
$bubbleAfterStyle = new JDPageBuilder\Element\ElementStyle(".jdb-speach-bubble:after");
$element->addChildrenStyle([$testimonialContentStyle, $testimonialNameStyle, $testimonialDesgnationStyle, $testimonialInfoStyle, $sliderItemStyle, $testimonialStyle, $avatarStyle, $avatarImgStyle, $arrowStyle, $paginationStyle, $paginationActiveStyle, $bubbleStyle, $bubbleAfterStyle]);

$testimonialContentStyle->addCss('text-align', $alignment);

if ($layout == 'imageabove' && $skin !== 'bubble') {
    $testimonialInfoStyle->addCss('text-align', $alignment);
}

$slidesPerView = $element->params->get('slidesPerView', null);

if (!empty($slidesPerView)) {
    foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($slidesPerView->{$deviceKey}) && JDPageBuilder\Helper::checkSliderValue($slidesPerView->{$deviceKey})) {
            $sliderItemStyle->addCss("width", (100 / $slidesPerView->{$deviceKey}->value) . "%", $device);
        }
    }
}

$width = $element->params->get('slideWidth', null);
if (!empty($width)) {
    foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($width->{$deviceKey}) && \JDPageBuilder\Helper::checkSliderValue($width->{$deviceKey})) {
            $testimonialStyle->addCss('width', $width->{$deviceKey}->value . $width->{$deviceKey}->unit, $device);
        }
    }
}

$testimonialStyle->addCss('background-color', $element->params->get('slideBackground', ''));
JDPageBuilder\Helper::applyBorderValue($testimonialStyle, $element->params, "slideBorder");

$padding = $element->params->get('slidePadding', NULL);

if (!empty($padding)) {
    foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($padding->{$deviceKey}) && !empty($padding->{$deviceKey})) {
            $testimonialStyle->addStyle(\JDPageBuilder\Helper::spacingValue($padding->{$deviceKey}, "padding"), $device);
        }
    }
}

$testimonialContentStyle->addCss('color', $element->params->get('slideContentColor', ''));
$testimonialNameStyle->addCss('color', $element->params->get('slideNameColor', ''));
$testimonialDesgnationStyle->addCss('color', $element->params->get('slideDesignationColor', ''));

$padding = $element->params->get('slideContentPadding', NULL);

if (!empty($padding)) {
    foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($padding->{$deviceKey}) && !empty($padding->{$deviceKey})) {
            $testimonialContentStyle->addStyle(\JDPageBuilder\Helper::spacingValue($padding->{$deviceKey}, "padding"), $device);
        }
    }
}

$typography = $element->params->get("slideContentTypography", NULL);
if (!empty($typography)) {
    foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($typography->{$deviceKey}) && !empty($typography->{$deviceKey})) {
            $testimonialContentStyle->addStyle(JDPageBuilder\Helper::typographyValue($typography->{$deviceKey}), $device);
        }
    }
}

$typography = $element->params->get("slideNameTypography", NULL);
if (!empty($typography)) {
    foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($typography->{$deviceKey}) && !empty($typography->{$deviceKey})) {
            $testimonialNameStyle->addStyle(JDPageBuilder\Helper::typographyValue($typography->{$deviceKey}), $device);
        }
    }
}

$typography = $element->params->get("slideDesignationTypography", NULL);
if (!empty($typography)) {
    foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($typography->{$deviceKey}) && !empty($typography->{$deviceKey})) {
            $testimonialDesgnationStyle->addStyle(JDPageBuilder\Helper::typographyValue($typography->{$deviceKey}), $device);
        }
    }
}

$width = $element->params->get('avatarSize', null);
if (!empty($width)) {
    foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($width->{$deviceKey}) && \JDPageBuilder\Helper::checkSliderValue($width->{$deviceKey})) {
            $avatarStyle->addCss('max-width', $width->{$deviceKey}->value . 'px', $device);
        }
    }
}

JDPageBuilder\Helper::applyBorderValue($avatarImgStyle, $element->params, "avatarBorder");

$size = $element->params->get('arrowSize', null);
if (!empty($size)) {
    foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($size->{$deviceKey}) && \JDPageBuilder\Helper::checkSliderValue($size->{$deviceKey})) {
            $arrowStyle->addCss('font-size', $size->{$deviceKey}->value . 'px', $device);
        }
    }
}

$arrowStyle->addCss('color', $element->params->get('arrowColor', ''));

$size = $element->params->get('paginationSize', null);
if (!empty($size)) {
    foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($size->{$deviceKey}) && \JDPageBuilder\Helper::checkSliderValue($size->{$deviceKey})) {
            $paginationStyle->addCss('height', $size->{$deviceKey}->value . 'px', $device);
            $paginationStyle->addCss('width', $size->{$deviceKey}->value . 'px', $device);
        }
    }
}

$paginationStyle->addCss('background-color', $element->params->get('paginationColor', ''));
$paginationActiveStyle->addCss('background-color', $element->params->get('paginationActiveColor', ''));

$bubbleStyle->addCss('background-color', $element->params->get('bubbleBackground', ''));
$bubbleStyle->addCss('border-color', $element->params->get('bubbleBackground', ''));
$padding = $element->params->get('bubblePadding', NULL);
if (!empty($padding)) {
    foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($padding->{$deviceKey}) && !empty($padding->{$deviceKey})) {
            $bubbleStyle->addStyle(\JDPageBuilder\Helper::spacingValue($padding->{$deviceKey}, "padding"), $device);
        }
    }
}
JDPageBuilder\Helper::applyBorderValue($bubbleStyle, $element->params, "bubbleBorder");

$borderStyle = $element->params->get('bubbleBorderStyle');
if ($borderStyle != '') {
    $borderWidth = $element->params->get('bubbleBorderWidth', null);
    if ($borderWidth != null && $borderStyle != 'none') {
        foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
            if (isset($borderWidth->{$deviceKey})) {
                if (isset($borderWidth->{$deviceKey}->{$bubblePosition}) && !empty($borderWidth->{$deviceKey}->{$bubblePosition})) {
                    $bubbleAfterStyle->addCss('border-width', 'calc(10px + ' . $borderWidth->{$deviceKey}->{$bubblePosition} . $borderWidth->{$deviceKey}->unit . ')');
                    if ($bubblePosition == 'top') {
                        $bubbleAfterStyle->addCss('margin-bottom', 'calc(-10px - ' . $borderWidth->{$deviceKey}->{$bubblePosition} . $borderWidth->{$deviceKey}->unit .  ')');
                        $bubbleAfterStyle->addCss('margin-left', 'calc(-10px - ' . $borderWidth->{$deviceKey}->{$bubblePosition} . $borderWidth->{$deviceKey}->unit .  ')');
                    } else if ($bubblePosition == 'right') {
                        $bubbleAfterStyle->addCss('margin-top', 'calc(-10px - ' . $borderWidth->{$deviceKey}->{$bubblePosition} . $borderWidth->{$deviceKey}->unit .  ')');
                        $bubbleAfterStyle->addCss('margin-right', 'calc(-10px - ' . $borderWidth->{$deviceKey}->{$bubblePosition} . $borderWidth->{$deviceKey}->unit .  ')');
                    } else {
                        $bubbleAfterStyle->addCss('margin-top', 'calc(-10px - ' . $borderWidth->{$deviceKey}->{$bubblePosition} . $borderWidth->{$deviceKey}->unit .  ')');
                        $bubbleAfterStyle->addCss('margin-left', 'calc(-10px - ' . $borderWidth->{$deviceKey}->{$bubblePosition} . $borderWidth->{$deviceKey}->unit .  ')');
                    }
                }
            }
        }
    }
}
