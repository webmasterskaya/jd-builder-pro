<?php

/**
 * @package    JD Builder
 * @author     Team Joomdev <info@joomdev.com>
 * @copyright  2020 www.joomdev.com
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
extract($displayData);

$element->addClass('jdb-flipbox');

$animation = $element->params->get('flipboxAnimation', 'flip');
$direction = $element->params->get('flipboxDirection', 'left');
$linkOn = $element->params->get('linkOn', 'button');

$wrapperClass = ['jdb-flipbox-wrapper'];
if ($linkOn == 'box') {
    $wrapperClass[] = 'jdb-flipbox-box-linked';
}
$wrapperClass[] = 'jdb-flipbox-' . $animation;
if (in_array($animation, ['flip', 'slide', 'push'])) {
    $wrapperClass[] = 'jdb-flipbox-dir-' . $direction;
}

$frontClass = ['jdb-flipbox-front'];
$frontClass[] = 'jdb-flipbox-content-' . $element->params->get('frontHorizontalAlignment', 'center');
$frontClass[] = 'jdb-flipbox-vertical-' . $element->params->get('frontVerticalAlignment', 'middle');

$backClass = ['jdb-flipbox-back'];
$backClass[] = 'jdb-flipbox-content-' . $element->params->get('backHorizontalAlignment', 'center');
$backClass[] = 'jdb-flipbox-vertical-' . $element->params->get('backVerticalAlignment', 'middle');

$graphic = $element->params->get('graphic', 'none');
$backGaphic = $element->params->get('backGraphic', 'none');
?>
<div class="<?php echo implode(' ', $wrapperClass); ?>">
    <div class="jdb-flipbox-card">
        <div class="<?php echo implode(' ', $frontClass); ?>">
            <div class="jdb-flipbox-front-wrapper">
                <div class="jdb-flipbox-media">
                    <?php
                    switch ($graphic) {
                        case 'icon':
                            $icon = $element->params->get('icon', '');
                            if (!empty($icon)) {
                                \JDPageBuilder\Builder::loadFontLibraryByIcon($icon);
                                echo '<div class="jdb-flipbox-icon jdb-icon"><div class="jdb-icon-wrapper"><span class="' . $icon . '"></span></div></div>';
                            }
                            break;
                        case 'image':
                            $image = $element->params->get('image', '');
                            if (!empty($image)) {
                                echo '<div class="jdb-flipbox-image"><img src="' . \JDPageBuilder\Helper::mediaValue($image) . '" /></div>';
                            }
                            break;
                    }
                    ?>
                </div>
                <?php
                // front title
                $frontTitle = $element->params->get('frontTitle', '');
                if (!empty($frontTitle)) {
                    echo '<div class="jdb-flipbox-front-title">' . $frontTitle . '</div>';
                }

                // front description
                $frontDescription = $element->params->get('frontDescription', '');
                if (!empty($frontDescription)) {
                    echo '<div class="jdb-flipbox-front-description">' . $frontDescription . '</div>';
                }
                ?>
            </div>
        </div>
        <div class="<?php echo implode(' ', $backClass); ?>">
            <div class="jdb-flipbox-back-wrapper">
                <div class="jdb-flipbox-media">
                    <?php
                    switch ($backGaphic) {
                        case 'icon':
                            $icon = $element->params->get('backIcon', '');
                            if (!empty($icon)) {
                                \JDPageBuilder\Builder::loadFontLibraryByIcon($icon);
                                echo '<div class="jdb-flipbox-icon jdb-icon"><div class="jdb-icon-wrapper"><span class="' . $icon . '"></span></div></div>';
                            }
                            break;
                        case 'image':
                            $image = $element->params->get('backImage', '');
                            if (!empty($image)) {
                                echo '<div class="jdb-flipbox-image"><img src="' . \JDPageBuilder\Helper::mediaValue($image) . '" /></div>';
                            }
                            break;
                    }
                    ?>
                </div>
                <?php
                // back title
                $backTitle = $element->params->get('backTitle', '');
                if (!empty($backTitle)) {
                    echo '<div class="jdb-flipbox-back-title">' . ($linkOn == 'title' ? \JDPageBuilder\Helper::linkValue($backTitle, $element->params) : $backTitle) . '</div>';
                }
                // back description
                $backDescription = $element->params->get('backDescription', '');
                if (!empty($backDescription)) {
                    echo '<div class="jdb-flipbox-back-description">' . $backDescription . '</div>';
                }
                $buttonText = $element->params->get('buttonText', '');
                $link = $element->params->get('link', '');
                if (!empty($link) && !empty($buttonText) && $linkOn != 'title') {
                    if ($linkOn != 'title') {
                        echo JDPageBuilder\Helper::renderButtonValue('button', $element, $buttonText, [], 'link', $link, $element->params->get('linkTargetBlank', false), $element->params->get('linkNoFollow', false));
                    } else {
                        echo JDPageBuilder\Helper::renderButtonValue('button', $element, $buttonText, [], 'button');
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php
// Flipbox Settings
$boxStyle = new JDPageBuilder\Element\ElementStyle(".jdb-flipbox-card");
$element->addChildStyle($boxStyle);

$height = $element->params->get('height', NULL);
if (!empty($height)) {
    foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($height->{$deviceKey}) && \JDPageBuilder\Helper::checkSliderValue($height->{$deviceKey})) {
            $boxStyle->addCss("min-height", $height->{$deviceKey}->value . $height->{$deviceKey}->unit, $device);
        }
    }
}

// Front Styling
$frontBoxStyle = new JDPageBuilder\Element\ElementStyle(".jdb-flipbox-front");
$element->addChildStyle($frontBoxStyle);

JDPageBuilder\Helper::applyBackgroundValue($frontBoxStyle, $element->params, "frontBackground");
JDPageBuilder\Helper::applyBorderValue($frontBoxStyle, $element->params, "frontBorder");
$padding = $element->params->get('frontPadding', NULL);
if (!empty($padding)) {
    foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($padding->{$deviceKey}) && !empty($padding->{$deviceKey})) {

            $css = \JDPageBuilder\Helper::spacingValue($padding->{$deviceKey}, "padding");
            if (!empty($css)) {
                $frontBoxStyle->addStyle($css, $device);
            }
        }
    }
}

$frontTitleStyle = new JDPageBuilder\Element\ElementStyle(".jdb-flipbox-front-title");
$element->addChildStyle($frontTitleStyle);

$frontTitleStyle->addCss('color', $element->params->get('frontTitleColor', ''));
$titleSpacing = $element->params->get('frontTitleSpacing', null);
if (JDPageBuilder\Helper::checkSliderValue($titleSpacing)) {
    $frontTitleStyle->addCss('margin-top', $titleSpacing->value . 'px');
}
$typography = $element->params->get('frontTitleTypography', null);
if (!empty($typography)) {
    foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($typography->{$deviceKey}) && !empty($typography->{$deviceKey})) {
            $frontTitleStyle->addStyle(JDPageBuilder\Helper::typographyValue($typography->{$deviceKey}), $device);
        }
    }
}

$frontDescStyle = new JDPageBuilder\Element\ElementStyle(".jdb-flipbox-front-description");
$element->addChildStyle($frontDescStyle);

$frontDescStyle->addCss('color', $element->params->get('frontDescriptionColor', ''));
$descSpacing = $element->params->get('frontDescriptionSpacing', null);
if (JDPageBuilder\Helper::checkSliderValue($descSpacing)) {
    $frontDescStyle->addCss('margin-top', $descSpacing->value . 'px');
}
$typography = $element->params->get('frontDescriptionTypography', null);
if (!empty($typography)) {
    foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($typography->{$deviceKey}) && !empty($typography->{$deviceKey})) {
            $frontDescStyle->addStyle(JDPageBuilder\Helper::typographyValue($typography->{$deviceKey}), $device);
        }
    }
}

// Back Styling
$backBoxStyle = new JDPageBuilder\Element\ElementStyle(".jdb-flipbox-back");
$element->addChildStyle($backBoxStyle);

JDPageBuilder\Helper::applyBackgroundValue($backBoxStyle, $element->params, "backBackground");
JDPageBuilder\Helper::applyBorderValue($backBoxStyle, $element->params, "backBorder");
$padding = $element->params->get('backPadding', NULL);
if (!empty($padding)) {
    foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($padding->{$deviceKey}) && !empty($padding->{$deviceKey})) {
            $css = \JDPageBuilder\Helper::spacingValue($padding->{$deviceKey}, "padding");
            if (!empty($css)) {
                $backBoxStyle->addStyle($css, $device);
            }
        }
    }
}

$backTitleStyle = new JDPageBuilder\Element\ElementStyle(".jdb-flipbox-back-title");
$element->addChildStyle($backTitleStyle);

$backTitleStyle->addCss('color', $element->params->get('backTitleColor', ''));
$titleSpacing = $element->params->get('backTitleSpacing', null);
if (JDPageBuilder\Helper::checkSliderValue($titleSpacing)) {
    $backTitleStyle->addCss('margin-top', $titleSpacing->value . 'px');
}
$typography = $element->params->get('backTitleTypography', null);
if (!empty($typography)) {
    foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($typography->{$deviceKey}) && !empty($typography->{$deviceKey})) {
            $backTitleStyle->addStyle(JDPageBuilder\Helper::typographyValue($typography->{$deviceKey}), $device);
        }
    }
}

$backDescStyle = new JDPageBuilder\Element\ElementStyle(".jdb-flipbox-back-description");
$element->addChildStyle($backDescStyle);

$backDescStyle->addCss('color', $element->params->get('backDescriptionColor', ''));
$descSpacing = $element->params->get('backDescriptionSpacing', null);
if (JDPageBuilder\Helper::checkSliderValue($descSpacing)) {
    $backDescStyle->addCss('margin-top', $descSpacing->value . 'px');
}
$typography = $element->params->get('backDescriptionTypography', null);
if (!empty($typography)) {
    foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($typography->{$deviceKey}) && !empty($typography->{$deviceKey})) {
            $backDescStyle->addStyle(JDPageBuilder\Helper::typographyValue($typography->{$deviceKey}), $device);
        }
    }
}

// Icon Styling

$iconStyle = new JDPageBuilder\Element\ElementStyle('.jdb-flipbox-front .jdb-flipbox-icon > .jdb-icon-wrapper');
$element->addChildStyle($iconStyle);
$iconInnerStyle = new JDPageBuilder\Element\ElementStyle('.jdb-flipbox-front .jdb-flipbox-icon > .jdb-icon-wrapper > span');
$element->addChildStyle($iconInnerStyle);

JDPageBuilder\Helper::applyBorderValue($iconStyle, $element->params, "iconBorder");
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
$padding = $element->params->get('iconPadding', null);
if (!empty($padding)) {
    foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($padding->{$deviceKey}) && !empty($padding->{$deviceKey})) {
            $iconStyle->addStyle(JDPageBuilder\Helper::spacingValue($padding->{$deviceKey}, "padding"), $device);
        }
    }
}

$iconStyle->addCss("color", $element->params->get('iconForeground', ''));
$iconStyle->addCss("background-color", $element->params->get('iconBackground', ''));
$iconStyle->addCss("background-image", $element->params->get('iconGradient', ''));

$iconRotate = $element->params->get('iconRotate', null);
if (!empty($iconRotate)) {
    foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($iconRotate->{$deviceKey}) && JDPageBuilder\Helper::checkSliderValue($iconRotate->{$deviceKey}) && !empty($iconRotate->{$deviceKey}->value)) {
            $iconInnerStyle->addCss("transform", 'rotate(' . $iconRotate->{$deviceKey}->value . 'deg)', $device);
        }
    }
}


// Back Icon Styling

$backIconStyle = new JDPageBuilder\Element\ElementStyle('.jdb-flipbox-back .jdb-flipbox-icon > .jdb-icon-wrapper');
$element->addChildStyle($backIconStyle);
$backIconInnerStyle = new JDPageBuilder\Element\ElementStyle('.jdb-flipbox-back .jdb-flipbox-icon > .jdb-icon-wrapper > span');
$element->addChildStyle($backIconInnerStyle);

JDPageBuilder\Helper::applyBorderValue($backIconStyle, $element->params, "backIconBorder");
$iconSize = $element->params->get('backIconSize', null);
if (!empty($iconSize)) {
    foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($iconSize->{$deviceKey}) && JDPageBuilder\Helper::checkSliderValue($iconSize->{$deviceKey})) {
            $backIconStyle->addCss("font-size", ($iconSize->{$deviceKey}->value * 0.70) . 'px', $device);
            $backIconStyle->addCss("width", $iconSize->{$deviceKey}->value . 'px', $device);
            $backIconStyle->addCss("height", $iconSize->{$deviceKey}->value . 'px', $device);
            $backIconStyle->addCss("line-height", $iconSize->{$deviceKey}->value . 'px', $device);
        }
    }
}
$padding = $element->params->get('backIconPadding', null);
if (!empty($padding)) {
    foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($padding->{$deviceKey}) && !empty($padding->{$deviceKey})) {
            $backIconStyle->addStyle(JDPageBuilder\Helper::spacingValue($padding->{$deviceKey}, "padding"), $device);
        }
    }
}

$backIconStyle->addCss("color", $element->params->get('backIconForeground', ''));
$backIconStyle->addCss("background-color", $element->params->get('backIconBackground', ''));
$backIconStyle->addCss("background-image", $element->params->get('backIconGradient', ''));

$iconRotate = $element->params->get('backIconRotate', null);
if (!empty($iconRotate)) {
    foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($iconRotate->{$deviceKey}) && JDPageBuilder\Helper::checkSliderValue($iconRotate->{$deviceKey}) && !empty($iconRotate->{$deviceKey}->value)) {
            $backIconInnerStyle->addCss("transform", 'rotate(' . $iconRotate->{$deviceKey}->value . 'deg)', $device);
        }
    }
}


$buttonStyle = new JDPageBuilder\Element\ElementStyle(".jdb-flipbox-back-button");
$element->addChildStyle($buttonStyle);
$buttonSpacing = $element->params->get('buttonSpacing', null);
if (JDPageBuilder\Helper::checkSliderValue($buttonSpacing)) {
    $buttonStyle->addCss('margin-top', $buttonSpacing->value . 'px');
}


$imageStyle = new JDPageBuilder\Element\ElementStyle(".jdb-flipbox-image");
$element->addChildStyle($imageStyle);
$imageWidth = $element->params->get('imageWidth', null);
if (!empty($imageWidth)) {
    foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($imageWidth->{$deviceKey}) && JDPageBuilder\Helper::checkSliderValue($imageWidth->{$deviceKey})) {
            $imageStyle->addCss("width", $imageWidth->{$deviceKey}->value . $imageWidth->{$deviceKey}->unit, $device);
        }
    }
}
?>