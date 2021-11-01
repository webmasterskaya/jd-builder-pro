<?php

/**
 * @package    JD Builder
 * @author     Team Joomdev <info@joomdev.com>
 * @copyright  2020 www.joomdev.com
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
extract($displayData);

$element->addClass('jdb-slider-element');

$html = [];

$options = [];

$slides = $element->params->get('slides', []);
$sliderHeight = $element->params->get('sliderHeight', 'auto');

if ($sliderHeight == 'custom') {
   $sliderHeightValue = $element->params->get('sliderHeightValue', \json_decode("{value: 400,unit: 'px'}", false));
   $options[] = 'max-height:' . $sliderHeightValue->value;
} else {
   $options[] = 'ratio:' . $sliderHeight;
}

$options[] = 'finite:' . (($element->params->get('infinite', true) ? 'false' : 'true'));
$options[] = 'draggable:' . (($element->params->get('draggable', true) ? 'true' : 'false'));
$options[] = 'autoplay:' . (($element->params->get('autoplay', true) ? 'true' : 'false'));
$options[] = 'pause-on-hover:' . (($element->params->get('pauseOnHover', true) ? 'true' : 'false'));

$autoplayInterval = $element->params->get('autoplayInterval', \json_decode('{value:7000,unit:"#"}'));
if (!empty($autoplayInterval->value)) {
   $options[] = 'autoplay-interval:' . $autoplayInterval->value;
}

$options[] = 'animation:' . ($element->params->get('sliderAnimation', 'slide'));

$html[] = '<div class="jdb-position-relative" tabindex="-1" jdb-slideshow="' . (implode(';', $options)) . '"><ul class="jdb-slideshow-items">';

foreach ($slides as $index => $slide) {
   $background = @$slide->background;
   $backgroundOverlayColor = @$slide->backgroundOverlayColor;

   $html[] = '<li>';
   $html[] = '<div class="jdb-slideshow-item-' . $index . ' jdb-slideshow-item' . ($background == 'video' ? ' jdb-has-video-background' : '') . '"><div class="jdb-slideshow-item-inner' . (@$slide->mediaPosition == 'right' ? ' jdb-flex-row-reverse' : '') . ((($background == 'image' || $background == 'video') && !empty($backgroundOverlayColor)) ? ' jdb-has-overlay' : '') . '">';
   if (@$slide->media != 'none') {
      $html[] = '<div class="jdb-slideshow-media jdb-d-flex jdb-justify-center jdb-align-items-' . (empty($slide->mediaVPosition) ? 'center' : $slide->mediaVPosition) . '">';
      if (@$slide->media == 'image') {
         $html[] = '<img src="' . \JDPageBuilder\Helper::mediaValue(@$slide->image) . '" alt="' . @$slide->altText . '">';
      }
      if (@$slide->media == 'video' && !empty(@$slide->video)) {
         $html[] = '<div class="jdb-video jdb-embed-responsive jdb-embed-responsive-16by9">' . \JDPageBuilder\Helper::videoValue(@$slide->video) . '</div>';
      }
      $html[] = '</div>';
   }
   if (@$slide->preTitle != '' || @$slide->title != '' || @$slide->description != '' || @$slide->buttonText != '' || @$slide->secondaryButtonText != '') {
      $html[] = '<div class="jdb-slideshow-content jdb-d-flex jdb-justify-center jdb-align-items-' . @$slide->contentVPosition . '"><div class="p-3">';
      if (@$slide->preTitle != '') {
         $html[] = '<div class="jdb-slideshow-pretitle">' . @$slide->preTitle . '</div>';
      }
      if (@$slide->title != '') {
         $html[] = '<h3 class="jdb-slideshow-title">' . @$slide->title . '</h3>';
      }
      if (@$slide->description != '') {
         $html[] = '<p class="jdb-slideshow-description">' . @$slide->description . '</p>';
      }

      if (@$slide->buttonText != '' || @$slide->secondaryButtonText != '') {
         $alignment = isset($slide->sliderButtonAlignment) ? ' ' . $slide->sliderButtonAlignment : ' center';
         $html[] = '<div class="jdb-slideshow-buttons' . $alignment . '">';
         if (@$slide->buttonText != '') {
            $html[] = JDPageBuilder\Helper::renderButtonValue('primaryButton', $element, @$slide->buttonText, [], 'link', @$slide->link, @$slide->linkTargetBlank, @$slide->linkNoFollow);
         }

         if (@$slide->secondaryButtonText != '') {
            $html[] = JDPageBuilder\Helper::renderButtonValue('secondaryButton', $element, @$slide->secondaryButtonText, [], 'link', @$slide->secondaryLink, @$slide->secondaryLinkTargetBlank, @$slide->secondaryLinkNoFollow);
         }
         $html[] = '</div>';
      }
      $html[] = '</div>';
      $html[] = '</div>';
   }
   // $html[] = '</div>';


   $slideStyle = new JDPageBuilder\Element\ElementStyle(".jdb-slideshow-item-" . $index);
   $overlayCSS = new JDPageBuilder\Element\ElementStyle(".jdb-slideshow-item-" . $index . " .jdb-slideshow-item-inner::after");
   $contentCSS = new JDPageBuilder\Element\ElementStyle(".jdb-slideshow-item-" . $index . " .jdb-slideshow-content");
   $element->addChildrenStyle([$slideStyle, $overlayCSS, $contentCSS]);

   $backgroundOverlayOpacity = @$slide->backgroundOverlayOpacity;
   $backgroundOverlayOpacity = empty($backgroundOverlayOpacity) ? \json_decode('{value:50, unit:"%"}') : $backgroundOverlayOpacity;

   if (\JDPageBuilder\Helper::checkSliderValue($backgroundOverlayOpacity)) {
      $overlayCSS->addCss('opacity', ($backgroundOverlayOpacity->value / 100));
   }

   if (!empty($backgroundOverlayColor)) {
      $overlayCSS->addCss('background-color', $backgroundOverlayColor);
   }



   $width = @$slide->contentWidth;
   if ($width != null) {
      foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
         if (isset($width->{$deviceKey}) && \JDPageBuilder\Helper::checkSliderValue($width->{$deviceKey})) {
            $widthVal = '0 0 ' . $width->{$deviceKey}->value . $width->{$deviceKey}->unit;
            $contentCSS->addCss('-ms-flex', $widthVal, $device);
            $contentCSS->addCss('flex', $widthVal, $device);
            $contentCSS->addCss('max-width', $width->{$deviceKey}->value . $width->{$deviceKey}->unit, $device);
         }
      }
   }

   $contentCSS->addCss('text-align', @$slide->contentAlignment);
   if (@$slide->media == 'none') {
      $contentCSS->addCss(@$slide->contentHPosition, 'auto');
   }

   if ($slide->contentHPosition == 'margin' && @$slide->contentVPosition == 'start') {
      $contentCSS->addCss('margin-top', 0);
   }

   if (@$slide->contentHPosition == 'margin' && $slide->contentVPosition == 'end') {
      $contentCSS->addCss('margin-bottom', 0);
   }

   switch ($background) {
      case 'color':
         $backgroundColor = @$slide->backgroundColor;
         if (!empty($backgroundColor)) {
            $slideStyle->addCss('background-color', $backgroundColor);
         }
         break;
      case 'image':
         $backgroundColor = @$slide->backgroundColor;
         if (!empty($backgroundColor)) {
            $slideStyle->addCss('background-color', $backgroundColor);
         }
         $backgroundImage = @$slide->backgroundImage;
         if (!empty($backgroundImage)) {
            $slideStyle->addCss('background-image', 'url(' . \JDPageBuilder\Helper::mediaValue($backgroundImage) . ')');
            $backgroundRepeat = @$slide->backgroundRepeat;
            if (!empty($backgroundRepeat)) {
               $slideStyle->addCss('background-repeat', $backgroundRepeat);
            }
            $backgroundSize = @$slide->backgroundSize;
            if (!empty($backgroundSize)) {
               $slideStyle->addCss('background-size', $backgroundSize);
            }
            $backgroundAttachment = @$slide->backgroundAttachment;
            if (!empty($backgroundAttachment)) {
               $slideStyle->addCss('background-attachment', $backgroundAttachment);
            }
            $backgroundPosition = @$slide->backgroundPosition;
            if (!empty($backgroundPosition)) {
               $slideStyle->addCss('background-position', $backgroundPosition);
            }
         }
         break;
      case 'video':
         $html[] = '<div class="jdb-video-background" jdb-video="url:' . \JDPageBuilder\Helper::mediaValue(@$slide->backgroundVideoMedia) . ';autoplay:true;muted:true;loop:true;">';
         $html[] = '</div>';
         break;
   }
   $html[] = '</div>';
   $html[] = '</li>';
}
$html[] = '</ul>';

$arrows = $element->params->get('arrows', true);
if ($arrows) {
   $html[] = '<div class="jdb-slider-controls jdb-slider-next jdb-slider-inside"><a href="#" jdb-slidenav-next jdb-slideshow-item="next"><span class="fa fa-chevron-right"></span></a></div><div class="jdb-slider-controls jdb-slider-prev jdb-slider-inside"><a href="#" jdb-slidenav-previous jdb-slideshow-item="previous"><span class="fa fa-chevron-left"></span></a></div>';
}

$pagination = $element->params->get('pagination', true);
if ($pagination) {
   $html[] = '<ul class="jdb-slideshow-nav ' . $element->params->get('paginationPosition', 'outside') . ' jdb-dotnav"></ul>';
}

$html[] = '</div>';

echo implode('', $html);


$slideInnerStyle = new JDPageBuilder\Element\ElementStyle(".jdb-slideshow-item-inner");
$preTitleStyle = new JDPageBuilder\Element\ElementStyle(".jdb-slideshow-pretitle");
$titleStyle = new JDPageBuilder\Element\ElementStyle(".jdb-slideshow-title");
$descriptionStyle = new JDPageBuilder\Element\ElementStyle(".jdb-slideshow-description");
$arrowStyle = new JDPageBuilder\Element\ElementStyle(".jdb-slider-controls > a");
$paginationStyle = new JDPageBuilder\Element\ElementStyle(".jdb-dotnav>*>*");
$paginationActiveStyle = new JDPageBuilder\Element\ElementStyle(".jdb-dotnav>.jdb-active>*");

$element->addChildrenStyle([$preTitleStyle, $titleStyle, $descriptionStyle, $arrowStyle, $paginationStyle, $paginationActiveStyle, $slideInnerStyle]);

$sliderWidth = $element->params->get('sliderWidth', 'full');
if ($sliderWidth === 'boxed') {
   $width = $element->params->get('sliderWidthValue', null);
   if (!empty($width)) {
      foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
         if (isset($width->{$deviceKey}) && \JDPageBuilder\Helper::checkSliderValue($width->{$deviceKey})) {
            $slideInnerStyle->addCss('max-width', $width->{$deviceKey}->value . $width->{$deviceKey}->unit, $device);
         }
      }
   }
}

$spacing = $element->params->get('pretextSpacing', null);
if (!empty($spacing)) {
   foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
      if (isset($spacing->{$deviceKey}) && JDPageBuilder\Helper::checkSliderValue($spacing)) {
         $preTitleStyle->addCss('margin-bottom', $spacing->{$deviceKey}->value . 'px', $device);
      }
   }
}

$preTitleStyle->addCss('color', $element->params->get('pretextColor', ''));

$typography = $element->params->get('pretextTypography', null);
if (!empty($typography)) {
   foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
      if (isset($typography->{$deviceKey}) && !empty($typography->{$deviceKey})) {
         $preTitleStyle->addStyle(JDPageBuilder\Helper::typographyValue($typography->{$deviceKey}), $device);
      }
   }
}

$spacing = $element->params->get('titleSpacing', null);
if (!empty($spacing)) {
   foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
      if (isset($spacing->{$deviceKey}) && JDPageBuilder\Helper::checkSliderValue($spacing)) {
         $titleStyle->addCss('margin-bottom', $spacing->{$deviceKey}->value . 'px', $device);
      }
   }
}

$titleStyle->addCss('color', $element->params->get('titleColor', ''));

$typography = $element->params->get('titleTypography', null);
if (!empty($typography)) {
   foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
      if (isset($typography->{$deviceKey}) && !empty($typography->{$deviceKey})) {
         $titleStyle->addStyle(JDPageBuilder\Helper::typographyValue($typography->{$deviceKey}), $device);
      }
   }
}

$spacing = $element->params->get('descriptionSpacing', null);
if (!empty($spacing)) {
   foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
      if (isset($spacing->{$deviceKey}) && JDPageBuilder\Helper::checkSliderValue($spacing->{$deviceKey})) {
         $descriptionStyle->addCss('margin-bottom', $spacing->{$deviceKey}->value . 'px', $device);
      }
   }
}

$descriptionStyle->addCss('color', $element->params->get('descriptionColor', ''));

$typography = $element->params->get('descriptionTypography', null);
if (!empty($typography)) {
   foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
      if (isset($typography->{$deviceKey}) && !empty($typography->{$deviceKey})) {
         $descriptionStyle->addStyle(JDPageBuilder\Helper::typographyValue($typography->{$deviceKey}), $device);
      }
   }
}


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
