(function () {

    var JDBuilderElementNumberCounter = function (element) {
        element.addClass('jdb-numbercounter');

        var startValue = element.params.get('startValue', 0);
        var endValue = element.params.get('endValue', 0);
        var prefix = element.params.get('prefix', '');
        var suffix = element.params.get('suffix', '');
        var separator = element.params.get('separator', '');
        var decimalPlaces = element.params.get('decimalPlaces', 0);
        var duration = element.params.get('duration', {
            value: 2000
        });

        separator = encodeURI(separator);

        var title = element.params.get('title', '');
        var titlePosition = element.params.get('titlePosition', 'bottom');

        var icon = element.params.get('icon', '');
        var iconPosition = element.params.get('iconPosition', 'top');

        var html = [];

        if (icon != '') {
            JDBRenderer.Document.loadFontLibraryByIcon(icon);
            html.push('<div class="jdb-numbercounter-icon"><span class="' + icon + '"></span></div>');
        }

        if (title != '' && titlePosition == 'top') {
            html.push('<div class="jdb-numbercounter-title">' + title + '</div>');
        }

        html.push('<div class="jdb-numbercounter-number">');
        html.push('<span class="jdb-numbercounter-prefix">' + prefix + '</span>');
        html.push('<span jdb-counter="start:' + startValue + ';end:' + endValue + ';separator:' + separator + ';decimalPlaces:' + decimalPlaces + ';duration:' + duration.value + '"></span>');
        html.push('<span class="jdb-numbercounter-suffix">' + suffix + '</span>');
        html.push('</div>');

        if (title != '' && titlePosition == 'bottom') {
            html.push('<div class="jdb-numbercounter-title">' + title + '</div>');
        }
        elementStyling(element);
        return html.join('');
    }

    function elementStyling(element) {
        var titlePosition = element.params.get('titlePosition', 'bottom');

        var iconStyle = new JDBRenderer.ElementStyle('.jdb-numbercounter-icon');
        var titleStyle = new JDBRenderer.ElementStyle('.jdb-numbercounter-title');
        var numberParentStyle = new JDBRenderer.ElementStyle('.jdb-numbercounter-number');
        var numberStyle = new JDBRenderer.ElementStyle('.jdb-numbercounter-prefix,.jdb-counter>span,.jdb-numbercounter-suffix');

        element.addChildrenStyle([iconStyle, titleStyle, numberStyle, numberParentStyle]);

        switch (element.params.get('iconShape', 'circle')) {
            case 'rounded':
                var borderRadius = element.params.get('iconBorderRadius', null);
                if (borderRadius !== null) {
                    JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                        if (_deviceObj.key in borderRadius) {
                            iconStyle.addStyle(JDBRenderer.Helper.spacingValue(borderRadius[_deviceObj.key], "radius"), _deviceObj.type);
                        }
                    });
                }
                break;
            case 'circle':
                iconStyle.addCss("border-radius", "50%");
                break;
            case 'square':
                iconStyle.addCss("border-radius", "0");
                break;
        }

        // Icon Size
        var iconSize = element.params.get('iconSize', null);
        if (iconSize != null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if ((_deviceObj.key in iconSize) && JDBRenderer.Helper.checkSliderValue(iconSize[_deviceObj.key])) {
                    iconStyle.addCss("font-size", (iconSize[_deviceObj.key].value * 0.70) + 'px', _deviceObj.type);
                    iconStyle.addCss("width", iconSize[_deviceObj.key].value + 'px', _deviceObj.type);
                    iconStyle.addCss("height", iconSize[_deviceObj.key].value + 'px', _deviceObj.type);
                    iconStyle.addCss("line-height", iconSize[_deviceObj.key].value + 'px', _deviceObj.type);
                }
            });
        }

        // Icon Padding
        var padding = element.params.get('iconPadding', null);
        if (padding !== null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in padding) {
                    iconStyle.addStyle(JDBRenderer.Helper.spacingValue(padding[_deviceObj.key], "padding"), _deviceObj.type);
                }
            });
        }



        numberParentStyle.addCss("color", element.params.get('counterColor', ''));
        iconStyle.addCss("color", element.params.get('iconTextColor', ''));
        iconStyle.addCss("background-color", element.params.get('iconBackgroundColor', ''));
        iconStyle.addCss("border-color", element.params.get('iconBorderColor', ''));
        iconStyle.addCss("background-image", element.params.get('iconGradient', ''));
        iconStyle.addCss("box-shadow", element.params.get('iconBoxShadow', ''));

        // border
        let iconBorderStyle = element.params.get('iconBorderStyle', 'none');
        iconStyle.addCss("border-style", iconBorderStyle);

        if (iconBorderStyle != 'none') {
            let borderWidth = element.params.get('iconBorderWidth', null);
            if (borderWidth !== null) {
                JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                    if (_deviceObj.key in borderWidth) {
                        iconStyle.addStyle(JDBRenderer.Helper.spacingValue(borderWidth[_deviceObj.key], "border"), _deviceObj.type);
                    }
                });
            }
        }

        // Title Color and Space
        titleStyle.addCss('color', element.params.get('titleColor', ''));
        var spacingBetween = element.params.get('spacingBetween', null);
        if (spacingBetween !== null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (JDBRenderer.Helper.checkSliderValue(spacingBetween[_deviceObj.key])) {
                    titleStyle.addCss('margin-' + (titlePosition == 'top' ? 'bottom' : 'top'), spacingBetween[_deviceObj.key].value + "" + 'px',  _deviceObj.type);
                    // iconStyle.addCss('margin-bottom', spacingBetween[_deviceObj.key].value + "" + 'px');
                }
            });
        }

        // Title Typography
        var typography = element.params.get('titleTypography', null);
        if (typography !== null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in typography) {
                    titleStyle.addStyle(JDBRenderer.Helper.typographyValue(typography[_deviceObj.key]), _deviceObj.type);
                }
            });
        }

        // Number Typography
        var typography = element.params.get('counterTypography', null);
        if (typography !== null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in typography) {
                    numberParentStyle.addStyle(JDBRenderer.Helper.typographyValue(typography[_deviceObj.key]), _deviceObj.type);
                }
            });
        }
    }

    window.JDBuilderElementNumberCounter = JDBuilderElementNumberCounter;

})();