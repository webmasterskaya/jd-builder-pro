<?php

/**
 * @package    JD Builder
 * @author     Team Joomdev <info@joomdev.com>
 * @copyright  2020 www.joomdev.com
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

\JDPageBuilder\Builder::addJavascript(\JURI::root() . 'media/jdbuilder/js/parsley.min.js');
\JDPageBuilder\Builder::addJavascript(\JURI::root() . 'media/jdbuilder/js/imask.min.js');
\JDPageBuilder\Builder::addJavascript(\JURI::root() . 'media/jdbuilder/js/selectr.min.js');
\JDPageBuilder\Builder::addJavascript(\JURI::root() . 'media/jdbuilder/js/parsley.custom.js');
$buiderConfig = \JComponentHelper::getParams('com_jdbuilder');
$recaptchaSiteKey = $buiderConfig->get('recaptchaSiteKey', '');

defined('_JEXEC') or die;
extract($displayData);

$element->addClass('jdb-form');

$fields = $element->params->get('fields', []);
$inline = $element->params->get('inputLabelInline', false) ? 1 : 0;
$labels = [];
?>
<div class="jdb-form-inner jdb-position-relative">
    <div jdb-loader class="jdb-d-none" id="<?php echo $element->id; ?>-form-loading"></div>
    <div class="empty-hidden" id="<?php echo $element->id; ?>-form-message"></div>
    <form id="<?php echo $element->id; ?>-form" action="<?php echo $element->ajaxUrl('submit'); ?>" data-parsley-errors-wrapper="<ul class='jdb-form-input-errors'></ul>" data-parsley-error-class="jdb-input-error" data-parsley-success-class="jdb-input-success" class="<?php echo $inline ? '' : 'jdb-row'; ?>">
        <?php
        foreach ($fields as $i => $field) {
            $_field = new FieldHelper($field, $i, $element);
            $labels[$_field->name] = $_field->label;
            $label = JDPageBuilder\Helper::renderMustacheTemplateByFile(__DIR__ . '/partials/label.html', ['field' => $_field, 'inline' => $inline]);
            if ($field->type == 'html') {
                $label = '';
            }
            $input = JDPageBuilder\Helper::renderMustacheTemplateByFile(__DIR__ . '/partials/fields/' . $_field->type . '.html', ['field' => $_field, 'inline' => $inline]);
            if ($field->type != 'hidden') {
                echo JDPageBuilder\Helper::renderMustacheTemplateByFile(__DIR__ . '/partials/group.html', ['class' => $inline ? 'jdb-form-group jdb-row' : 'jdb-form-group', 'label' => $label, 'field' => $_field, 'input' => $input, 'inline' => $inline, 'inline' => $inline]);
            } else {
                echo $input;
            }
            // styling
            if (!$inline) {
                $fieldGroupStyle = new JDPageBuilder\Element\ElementStyle('.jdb-col.' . $_field->id);

                $element->addChildStyle($fieldGroupStyle);
                $width = $field->width;
                foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
                    if (isset($width->{$deviceKey}) && JDPageBuilder\Helper::checkSliderValue($width->{$deviceKey})) {
                        $fieldGroupStyle->addCss("flex", "0 0 " . $width->{$deviceKey}->value . $width->{$deviceKey}->unit, $device);
                        $fieldGroupStyle->addCss("max-width", $width->{$deviceKey}->value . $width->{$deviceKey}->unit, $device);
                    }
                }
            }
        }
        if ($element->params->get('reCAPTCHA', false)) {
            echo JDPageBuilder\Helper::renderMustacheTemplateByFile(__DIR__ . '/partials/recaptcha.html', ['class' => $inline ? 'jdb-form-group jdb-row' : 'jdb-form-group', 'label' => $element->params->get('reCAPTCHALabel', ''), 'labelClass' => $inline ? 'jdb-col-form-label jdb-col' : 'jdb-form-label jdb-d-block', 'id' => $element->id, 'inline' => $inline, 'position' => $element->params->get('recaptchaPosition', ''), 'theme' => $element->params->get('recaptchaTheme', 'light')]);
        }
        echo $inline ? '' : '<div class="jdb-col jdb-submit-wrapper">';
        echo JDPageBuilder\Helper::renderButtonValue('submit', $element, $element->params->get('submitText', 'Submit'), [$element->params->get('submitClass', '')], 'submit');
        echo $inline ? '' : '</div>';

        if (!$inline) {
            $submitWrapperStyle = new JDPageBuilder\Element\ElementStyle('.jdb-col.jdb-submit-wrapper');

            $element->addChildStyle($submitWrapperStyle);
            $width = $element->params->get('submitWidth', null);
            foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
                if (isset($width->{$deviceKey}) && JDPageBuilder\Helper::checkSliderValue($width->{$deviceKey})) {
                    $submitWrapperStyle->addCss("flex", "0 0 " . $width->{$deviceKey}->value . $width->{$deviceKey}->unit, $device);
                    $submitWrapperStyle->addCss("max-width", $width->{$deviceKey}->value . $width->{$deviceKey}->unit, $device);
                }
            }

            $reCAPTCHAWrapperStyle = new JDPageBuilder\Element\ElementStyle('.jdb-col.jdb-reCAPTCHA-wrapper');

            $element->addChildStyle($reCAPTCHAWrapperStyle);
            $width = $element->params->get('reCAPTCHAWidth', null);
            foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
                if (isset($width->{$deviceKey}) && JDPageBuilder\Helper::checkSliderValue($width->{$deviceKey})) {
                    $reCAPTCHAWrapperStyle->addCss("flex", "0 0 " . $width->{$deviceKey}->value . $width->{$deviceKey}->unit, $device);
                    $reCAPTCHAWrapperStyle->addCss("max-width", $width->{$deviceKey}->value . $width->{$deviceKey}->unit, $device);
                }
            }
        }

        ?>
        <input type="hidden" name="<?php echo JDB_FORM_TOKEN; ?>" value="1" />
    </form>
</div>
<?php
// Inline Label Width
if ($inline) {
    $inlineLabelStyle = new JDPageBuilder\Element\ElementStyle(".jdb-col-form-label");
    $element->addChildStyle($inlineLabelStyle);
    $inputLabelInlineWidth = $element->params->get('inputLabelInlineWidth', null);
    if ($inputLabelInlineWidth != null) {
        foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
            if (isset($inputLabelInlineWidth->{$deviceKey}) && JDPageBuilder\Helper::checkSliderValue($inputLabelInlineWidth->{$deviceKey})) {
                $inlineLabelStyle->addCss("flex", "0 0 " . $inputLabelInlineWidth->{$deviceKey}->value . $inputLabelInlineWidth->{$deviceKey}->unit, $device);
                $inlineLabelStyle->addCss("max-width", $inputLabelInlineWidth->{$deviceKey}->value . $inputLabelInlineWidth->{$deviceKey}->unit, $device);
            }
        }
    }
}


$inline = $element->params->get('inputLabelInline', false) ? 1 : 0;

if ($inline) {
    $labelStyle = new JDPageBuilder\Element\ElementStyle(".jdb-col-form-label");
} else {
    $labelStyle = new JDPageBuilder\Element\ElementStyle(".jdb-form-label");
}
$element->addChildStyle($labelStyle);

if ($inline) {
    $inputLabelInlineWidth = $element->params->get('inputLabelInlineWidth', null);
    if ($inputLabelInlineWidth != null) {
        foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
            if (isset($inputLabelInlineWidth->{$deviceKey}) && JDPageBuilder\Helper::checkSliderValue($inputLabelInlineWidth->{$deviceKey})) {
                $labelStyle->addCss("flex", "0 0 " . $inputLabelInlineWidth->{$deviceKey}->value . $inputLabelInlineWidth->{$deviceKey}->unit, $device);
                $labelStyle->addCss("max-width", $inputLabelInlineWidth->{$deviceKey}->value . $inputLabelInlineWidth->{$deviceKey}->unit, $device);
            }
        }
    }
} else {
    $inputLabelSpacing = $element->params->get('labelSpacing', null);
    if ($inputLabelSpacing != null) {
        foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
            if (isset($inputLabelSpacing->{$deviceKey}) && JDPageBuilder\Helper::checkSliderValue($inputLabelSpacing->{$deviceKey})) {
                $labelStyle->addCss("margin-bottom", $inputLabelSpacing->{$deviceKey}->value . "px", $device);
            }
        }
    }
}

$labelStyle->addCss("color", $element->params->get('labelColor', ''));

$typography = $element->params->get("labelTypography", NULL);
if (!empty($typography)) {
    foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($typography->{$deviceKey}) && !empty($typography->{$deviceKey})) {
            $labelStyle->addStyle(JDPageBuilder\Helper::typographyValue($typography->{$deviceKey}), $device);
        }
    }
}

$inputStyle = new JDPageBuilder\Element\ElementStyle(".jdb-form-control");
$countryCodeStyle = new JDPageBuilder\Element\ElementStyle(".jdb-country-selected");
$optionLabelStyle = new JDPageBuilder\Element\ElementStyle(".jdb-form-check-label");
$placeholderStyle = new JDPageBuilder\Element\ElementStyle(" ::placeholder");
$element->addChildStyle($inputStyle);
$element->addChildStyle($countryCodeStyle);
$element->addChildStyle($optionLabelStyle);
$element->addChildStyle($placeholderStyle);

$inputStyle->addCss("color", $element->params->get('inputColor', ''));
$countryCodeStyle->addCss("color", $element->params->get('inputColor', ''));
$optionLabelStyle->addCss("color", $element->params->get('inputColor', ''));
$placeholderStyle->addCss("color", $element->params->get('placeholderColor', ''));
$inputStyle->addCss("background-color", $element->params->get('inputBackground', ''));
$typography = $element->params->get("inputTypography", null);
if (!empty($typography)) {
    foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($typography->{$deviceKey}) && !empty($typography->{$deviceKey})) {
            $inputStyle->addStyle(JDPageBuilder\Helper::typographyValue($typography->{$deviceKey}), $device);
            $countryCodeStyle->addStyle(JDPageBuilder\Helper::typographyValue($typography->{$deviceKey}), $device);
            $optionLabelStyle->addStyle(JDPageBuilder\Helper::typographyValue($typography->{$deviceKey}), $device);
        }
    }
}
JDPageBuilder\Helper::applyBorderValue($inputStyle, $element->params, "inputBorder");

$gutter = $element->params->get('columnsGap', null);
if (!empty($gutter)) {
    $colStyle = new JDPageBuilder\Element\ElementStyle('.jdb-col, .jdb-col-12');
    $rowStyle = new JDPageBuilder\Element\ElementStyle('.jdb-row');
    $element->addChildrenStyle([$colStyle, $rowStyle]);
    foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($gutter->{$deviceKey}) && \JDPageBuilder\Helper::checkSliderValue($gutter->{$deviceKey})) {
            $rowStyle->addCss("margin-left", "-" . $gutter->{$deviceKey}->value . "px", $device);
            $rowStyle->addCss("margin-right", "-" . $gutter->{$deviceKey}->value . "px", $device);
            $colStyle->addCss("padding-left", $gutter->{$deviceKey}->value . "px", $device);
            $colStyle->addCss("padding-right", $gutter->{$deviceKey}->value . "px", $device);
        }
    }
}

$gutter = $element->params->get('rowsGap', null);
if (!empty($gutter)) {
    $rowStyle = new JDPageBuilder\Element\ElementStyle('.jdb-form-group');
    $element->addChildrenStyle([$rowStyle]);
    foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($gutter->{$deviceKey}) && \JDPageBuilder\Helper::checkSliderValue($gutter->{$deviceKey})) {
            $rowStyle->addCss("margin-bottom", $gutter->{$deviceKey}->value . "px", $device);
        }
    }
}

$successStyle = new JDPageBuilder\Element\ElementStyle(".jdb-alert-success");
$errorStyle = new JDPageBuilder\Element\ElementStyle(".jdb-alert-danger");
$element->addChildStyle($successStyle);
$element->addChildStyle($errorStyle);

$successStyle->addCss('background-color', $element->params->get('successBackground', ''));
$successStyle->addCss('color', $element->params->get('successColor', ''));
JDPageBuilder\Helper::applyBorderValue($successStyle, $element->params, "successBorder");

$errorStyle->addCss('background-color', $element->params->get('errorBackground', ''));
$errorStyle->addCss('color', $element->params->get('errorColor', ''));
JDPageBuilder\Helper::applyBorderValue($errorStyle, $element->params, "errorBorder");
if (!empty($recaptchaSiteKey) && $element->params->get('reCAPTCHA', false)) {
    $recaptchaWidget = 'recaptchaWidget' . JDPageBuilder\Helper::classify($element->id);
    echo '<script src="https://www.google.com/recaptcha/api.js?onload=' . $recaptchaWidget . 'Call" async defer></script>';
    echo '<script>var ' . $recaptchaWidget . ' = null; function ' . $recaptchaWidget . 'Call(){' . $recaptchaWidget . " = grecaptcha.render('" . $element->id . "-reCAPTCHA', {'sitekey': '" . $recaptchaSiteKey . "'});}</script>";
}
?>
<script>
    JDBPack.form('#<?php echo $element->id; ?>-form', {
        url: '<?php echo $element->ajaxUrl('submit'); ?>',
        beforeSend: function() {
            $JDB('#<?php echo $element->id; ?>-form-loading').removeClass('jdb-d-none');
            $JDB('#<?php echo $element->id; ?>-form :input').prop('disabled', true);
            $JDB('#<?php echo $element->id; ?>-form-message').html('');
        },
        onSuccess: function(response) {
            if (response.status == 'error') {
                $JDB('#<?php echo $element->id; ?>-form-message').html('<div jdb-alert class="jdb-alert jdb-alert-danger jdb-alert-dismissible"><div class="jdb-alert-content">' + response.message + '</div><a href="#" class="jdb-close jdb-alert-close"><span aria-hidden="true">&times;</span></a></div>');
            } else {
                $JDB('#<?php echo $element->id; ?>-form-message').html('<div jdb-alert class="jdb-alert jdb-alert-success jdb-alert-dismissible"><div class="jdb-alert-content">' + response.data.message + '</div><a href="#" class="jdb-close jdb-alert-close"><span aria-hidden="true">&times;</span></a></div>');
                document.getElementById('<?php echo $element->id; ?>-form').reset();


                if (response.data.redirect !== undefined && response.data.redirect) {
                    setTimeout(function() {
                        window.location = response.data.redirectURL;
                    }, response.data.redirectDelay);
                }
            }

            <?php if (!empty($recaptchaSiteKey) && $element->params->get('reCAPTCHA', false)) { ?>
                if (<?php echo $recaptchaWidget; ?> != null) {
                    grecaptcha.reset(<?php echo $recaptchaWidget; ?>);
                }
            <?php } ?>

            $JDB('#<?php echo $element->id; ?>-form-loading').addClass('jdb-d-none');
            $JDB('#<?php echo $element->id; ?>-form :input').prop('disabled', false);
        },
        onError: function(error) {
            alert(error.responseText);
            $JDB('#<?php echo $element->id; ?>-form-loading').addClass('jdb-d-none');
            $JDB('#<?php echo $element->id; ?>-form :input').prop('disabled', false);
        }
    });

    $JDB('#<?php echo $element->id; ?>-form').parsley().on('form:submit', function() {
        <?php if (!empty($recaptchaSiteKey) && $element->params->get('reCAPTCHA', false)) { ?>
            if (<?php echo $recaptchaWidget; ?> != null) {
                var response = grecaptcha.getResponse(
                    <?php echo $recaptchaWidget; ?>
                );
                if (response == '') {
                    $JDB('#<?php echo $element->id; ?>-form-message').html('<div jdb-alert class="jdb-alert jdb-alert-danger jdb-alert-dismissible"><div class="jdb-alert-content">Please check the recaptcha</div><a href="#" class="jdb-close jdb-alert-close"><span aria-hidden="true">&times;</span></a></div>');
                    return false;
                }
            }
        <?php } ?>
        JDBPack.form('#<?php echo $element->id; ?>-form').submit();
        return false;
    });
</script>