(function () {

    var JDBuilderElementForm = function (element) {

        var _html = [];
        var fields = element.params.get('fields', []);
        var inline = element.params.get('inputLabelInline', false) ? 1 : 0;

        element.addClass('jdb-form');

        _html.push('<div class="jdb-form-inner jdb-position-relative">');
        _html.push('<div jdb-loader id="' + element.id + '-form-loading" class="jdb-d-none"></div>');
        _html.push('<div class="empty-hidden" id="' + element.id + '-form-message"></div>');
        _html.push('<form id="' + element.id + '-form" data-parsley-errors-wrapper="<ul class=\'jdb-form-input-errors\'></ul>" data-parsley-error-class="jdb-input-error" data-parsley-success-class="jdb-input-success" class="' + (inline ? '' : 'jdb-row') + '">');

        fields.forEach(function (field, i) {
            var _field = new FieldHelper(field, i, element);
            _field = JDBRenderer.Helper.toJSON(_field);
            var _label = JDBRenderer.Helper.renderMustacheTemplate('form-label', {
                field: _field,
                inline: inline
            });

            if (_field.type == 'html') {
                _label = '';
            }

            var _input = JDBRenderer.Helper.renderMustacheTemplate('form-fields-' + _field.type, {
                field: _field,
                inline: inline
            });

            if (_field.type != 'hidden') {
                _html.push(JDBRenderer.Helper.renderMustacheTemplate('form-group', {
                    class: inline ? 'jdb-form-group jdb-row' : 'jdb-form-group',
                    label: _label,
                    field: _field,
                    inline: inline,
                    input: _input
                }));
            } else {
                _html.push(_input);
            }

            // styling
            if (!inline) {
                _fieldGroupStyle = new JDBRenderer.ElementStyle(".jdb-col." + _field.id);
                element.addChildStyle(_fieldGroupStyle);
                var width = field.width;
                JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                    if ((_deviceObj.key in width) && JDBRenderer.Helper.checkSliderValue(width[_deviceObj.key])) {
                        _fieldGroupStyle.addCss("flex", '0 0 ' + width[_deviceObj.key].value + width[_deviceObj.key].unit, _deviceObj.type);
                        _fieldGroupStyle.addCss("max-width", width[_deviceObj.key].value + width[_deviceObj.key].unit, _deviceObj.type);
                    }
                });
            }
        });

        if (element.params.get('reCAPTCHA', false)) {
            _html.push(JDBRenderer.Helper.renderMustacheTemplate('form-recaptcha', {
                class: inline ? 'jdb-form-group jdb-row' : 'jdb-form-group',
                position: element.params.get('recaptchaPosition', 'left'),
                theme: element.params.get('recaptchaTheme', 'light'),
                label: element.params.get('reCAPTCHALabel', ''),
                labelClass: inline ? 'jdb-col-form-label jdb-col' : 'jdb-form-label jdb-d-block',
                id: element.id,
                inline: inline
            }));
        } else {
            var recaptchaDiv = document.getElementById(element.id + '-reCAPTCHA');
            if (recaptchaDiv != null) {
                recaptchaDiv.innerHTML = '';
            }
        }

        _html.push(inline ? '' : '<div class="jdb-col jdb-submit-wrapper">');
        _html.push(JDBRenderer.Helper.renderButtonValue('submit', element, element.params.get('submitText', 'Submit'), [element.params.get('submitClass', '')], 'submit'));
        _html.push(inline ? '' : '</div>');

        if (!inline) {
            var _submitWrapperStyle = new JDBRenderer.ElementStyle(".jdb-col.jdb-submit-wrapper");
            element.addChildStyle(_submitWrapperStyle);
            var width = element.params.get('submitWidth', null);
            if (width !== null) {
                JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                    if ((_deviceObj.key in width) && JDBRenderer.Helper.checkSliderValue(width[_deviceObj.key])) {
                        _submitWrapperStyle.addCss("flex", '0 0 ' + width[_deviceObj.key].value + width[_deviceObj.key].unit, _deviceObj.type);
                        _submitWrapperStyle.addCss("max-width", width[_deviceObj.key].value + width[_deviceObj.key].unit, _deviceObj.type);
                    }
                });
            }

            var _reCAPTCHAWrapperStyle = new JDBRenderer.ElementStyle(".jdb-col.jdb-reCAPTCHA-wrapper");
            element.addChildStyle(_reCAPTCHAWrapperStyle);
            var width = element.params.get('reCAPTCHAWidth', null);
            if (width !== null) {
                JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                    if ((_deviceObj.key in width) && JDBRenderer.Helper.checkSliderValue(width[_deviceObj.key])) {
                        _reCAPTCHAWrapperStyle.addCss("flex", '0 0 ' + width[_deviceObj.key].value + width[_deviceObj.key].unit, _deviceObj.type);
                        _reCAPTCHAWrapperStyle.addCss("max-width", width[_deviceObj.key].value + width[_deviceObj.key].unit, _deviceObj.type);
                    }
                });
            }
        }

        _html.push('<input type="hidden" name="' + JDB_FORM_TOKEN + '" value="1" />');

        _html.push('</form>');
        _html.push('</div>');

        elementStyling(element);
        return _html.join("");
    }

    function elementStyling(element) {
        var inline = element.params.get('inputLabelInline', false) ? 1 : 0;

        if (inline) {
            var labelStyle = new JDBRenderer.ElementStyle(".jdb-col-form-label");
        } else {
            var labelStyle = new JDBRenderer.ElementStyle(".jdb-form-label");
        }
        element.addChildStyle(labelStyle);

        if (inline) {
            var inputLabelInlineWidth = element.params.get('inputLabelInlineWidth', null);
            if (inputLabelInlineWidth != null) {
                JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                    if ((_deviceObj.key in inputLabelInlineWidth) && JDBRenderer.Helper.checkSliderValue(inputLabelInlineWidth[_deviceObj.key])) {
                        labelStyle.addCss("flex", "0 0 " + inputLabelInlineWidth[_deviceObj.key].value + inputLabelInlineWidth[_deviceObj.key].unit, _deviceObj.type);
                        labelStyle.addCss("max-width", inputLabelInlineWidth[_deviceObj.key].value + inputLabelInlineWidth[_deviceObj.key].unit, _deviceObj.type);
                    }
                });
            }
        } else {
            var inputLabelSpacing = element.params.get('labelSpacing', null);
            if (inputLabelSpacing != null) {
                JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                    if ((_deviceObj.key in inputLabelSpacing) && JDBRenderer.Helper.checkSliderValue(inputLabelSpacing[_deviceObj.key])) {
                        labelStyle.addCss("margin-bottom", inputLabelSpacing[_deviceObj.key].value + "px", _deviceObj.type);
                    }
                });
            }
        }

        labelStyle.addCss("color", element.params.get('labelColor', ''));

        var typography = element.params.get("labelTypography", null);
        if (typography !== null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in typography) {
                    labelStyle.addStyle(JDBRenderer.Helper.typographyValue(typography[_deviceObj.key]), _deviceObj.type);
                }
            });
        }

        var inputStyle = new JDBRenderer.ElementStyle(".jdb-form-control");
        var countryCodeStyle = new JDBRenderer.ElementStyle(".jdb-country-selected");
        var optionLabelStyle = new JDBRenderer.ElementStyle(".jdb-form-check-label");
        var placeholderStyle = new JDBRenderer.ElementStyle(" ::placeholder");
        element.addChildStyle(inputStyle);
        element.addChildStyle(countryCodeStyle);
        element.addChildStyle(placeholderStyle);
        element.addChildStyle(optionLabelStyle);

        inputStyle.addCss("color", element.params.get('inputColor', ''));
        countryCodeStyle.addCss("color", element.params.get('inputColor', ''));
        optionLabelStyle.addCss("color", element.params.get('inputColor', ''));
        placeholderStyle.addCss("color", element.params.get('placeholderColor', ''));
        inputStyle.addCss("background-color", element.params.get('inputBackground', ''));
        var typography = element.params.get("inputTypography", null);
        if (typography !== null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in typography) {
                    inputStyle.addStyle(JDBRenderer.Helper.typographyValue(typography[_deviceObj.key]), _deviceObj.type);
                    countryCodeStyle.addStyle(JDBRenderer.Helper.typographyValue(typography[_deviceObj.key]), _deviceObj.type);
                    optionLabelStyle.addStyle(JDBRenderer.Helper.typographyValue(typography[_deviceObj.key]), _deviceObj.type);
                }
            });
        }
        JDBRenderer.Helper.applyBorderValue(inputStyle, element.params, "inputBorder");

        var gutter = element.params.get('columnsGap', null);
        if (gutter != null) {
            const colStyle = JDBRenderer.ElementStyle('.jdb-col, .jdb-col-12');
            const rowStyle = JDBRenderer.ElementStyle('.jdb-row');
            element.addChildStyle(colStyle);
            element.addChildStyle(rowStyle);
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if ((_deviceObj.key in gutter) && JDBRenderer.Helper.checkSliderValue(gutter[_deviceObj.key])) {
                    rowStyle.addCss("margin-right", '-' + gutter[_deviceObj.key].value + "px", _deviceObj.type);
                    rowStyle.addCss("margin-left", '-' + gutter[_deviceObj.key].value + "px", _deviceObj.type);
                    colStyle.addCss("padding-left", gutter[_deviceObj.key].value + "px", _deviceObj.type);
                    colStyle.addCss("padding-right", gutter[_deviceObj.key].value + "px", _deviceObj.type);
                }
            });
        }

        var gutter = element.params.get('rowsGap', null);
        if (gutter != null) {
            const rowStyle = JDBRenderer.ElementStyle('.jdb-form-group');
            element.addChildStyle(rowStyle);
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if ((_deviceObj.key in gutter) && JDBRenderer.Helper.checkSliderValue(gutter[_deviceObj.key])) {
                    rowStyle.addCss("margin-bottom", gutter[_deviceObj.key].value + "px", _deviceObj.type);
                }
            });
        }

        var successStyle = new JDBRenderer.ElementStyle(".jdb-alert-success");
        var errorStyle = new JDBRenderer.ElementStyle(".jdb-alert-danger");
        element.addChildStyle(successStyle);
        element.addChildStyle(errorStyle);

        successStyle.addCss('background-color', element.params.get('successBackground', ''));
        successStyle.addCss('color', element.params.get('successColor', ''));
        JDBRenderer.Helper.applyBorderValue(successStyle, element.params, "successBorder");

        errorStyle.addCss('background-color', element.params.get('errorBackground', ''));
        errorStyle.addCss('color', element.params.get('errorColor', ''));
        JDBRenderer.Helper.applyBorderValue(errorStyle, element.params, "errorBorder");
    }

    JDBuilderElementForm.onAfterDisplay = function (element, oldParams, newParams, newItem) {
        if (element === undefined) {
            return;
        }
        var oldFields = oldParams.get('fields', []);
        var newFields = newParams.get('fields', []);
        if (!JDBRenderer.Helper.isEqual(oldFields, newFields)) {
            if ($JDB('#' + element.id + '-form').parsley() !== undefined) {
                $JDB('#' + element.id + '-form').parsley().refresh();
            }
        }

        var inlineChanged = oldParams.get('inputLabelInline', false) != newParams.get('inputLabelInline', false);

        if (inlineChanged) {
            if ($JDB('#' + element.id + '-form').parsley() !== undefined) {
                $JDB('#' + element.id + '-form').parsley().refresh();
            }
        }

        var recaptchaChanged = oldParams.get('reCAPTCHA', false) != newParams.get('reCAPTCHA', false);
        var recaptchaEnabled = newParams.get('reCAPTCHA', false);
        var hasRecaptchaSiteKey = JDB_RECAPTCHA_SITE_KEY != '';
        var recaptchaThemeChanged = oldParams.get('recaptchaTheme', 'light') != newParams.get('recaptchaTheme', false);

        if (recaptchaChanged && recaptchaEnabled && hasRecaptchaSiteKey) {
            if (window['recaptchaWidget' + element.id] == undefined) {
                window['recaptchaWidget' + element.id] = grecaptcha.render(element.id + '-reCAPTCHA', {
                    'sitekey': JDB_RECAPTCHA_SITE_KEY
                });
            } else {
                grecaptcha.reset(window['recaptchaWidget' + element.id]);
            }
        }

        if (!newItem && recaptchaThemeChanged && recaptchaEnabled) {
            JDBRenderer.Helper.refresh();
        }

        if (!newItem && inlineChanged && recaptchaEnabled) {
            JDBRenderer.Helper.refresh();
        }
    }

    JDBuilderElementForm.onAfterInit = function (element, params) {
        if (element === undefined) {
            return;
        }
        JDBPack.form('#' + element.id + '-form', {
            url: element.ajaxUrl('submit'),
            beforeSend: function () {
                $JDB('#' + element.id + '-form-loading').removeClass('jdb-d-none');
                $JDB('#' + element.id + '-form :input').prop('disabled', true);
                $JDB('#' + element.id + '-form-message').html('');
            },
            onSuccess: function (response) {
                if (response.status == 'error') {
                    $JDB('#' + element.id + '-form-message').html('<div jdb-alert class="jdb-alert jdb-alert-danger jdb-alert-dismissible"><div class="jdb-alert-content">' + response.message + '</div><a href="#" class="jdb-close jdb-alert-close"><span aria-hidden="true">&times;</span></a></div>');
                } else {
                    $JDB('#' + element.id + '-form-message').html('<div jdb-alert class="jdb-alert jdb-alert-success jdb-alert-dismissible"><div class="jdb-alert-content">' + response.data.message + '</div><a href="#" class="jdb-close jdb-alert-close"><span aria-hidden="true">&times;</span></a></div>');
                    document.getElementById(element.id + '-form').reset();

                    if (response.data.redirect !== undefined && response.data.redirect) {
                        setTimeout(function () {
                            window.location = response.data.redirectURL;
                        }, response.data.redirectDelay);
                    }
                }

                if (element.params.get('reCAPTCHA', false) && window['recaptchaWidget' + element.id] != undefined) {
                    grecaptcha.reset(window['recaptchaWidget' + element.id]);
                }

                $JDB('#' + element.id + '-form-loading').addClass('jdb-d-none');
                $JDB('#' + element.id + '-form :input').prop('disabled', false);
            },
            onError: function (error) {
                alert(error.responseText);
                $JDB('#' + element.id + '-form-loading').addClass('jdb-d-none');
                $JDB('#' + element.id + '-form :input').prop('disabled', false);
            }
        });

        if ($JDB('#' + element.id + '-form') != null) {
            $JDB('#' + element.id + '-form').parsley().on('form:submit', function () {
                if (window['recaptchaWidget' + element.id] != undefined) {
                    var response = grecaptcha.getResponse(
                        window['recaptchaWidget' + element.id]
                    );
                    if (response == '') {
                        $JDB('#' + element.id + '-form-message').html('<div jdb-alert class="jdb-alert jdb-alert-danger jdb-alert-dismissible"><div class="jdb-alert-content">Please check the recaptcha</div><a href="#" class="jdb-close jdb-alert-close"><span aria-hidden="true">&times;</span></a></div>');
                        return false;
                    }
                }
                JDBPack.form('#' + element.id + '-form').submit();
                return false;
            });
        }
    }

    window.JDBuilderElementForm = JDBuilderElementForm;

})();