(function () {

    var JDBuilderElementFlipBox = function (element) {

        var html = [];

        element.addClass('jdb-flipbox');
        var animation = element.params.get('flipboxAnimation', 'flip');
        var direction = element.params.get('flipboxDirection', 'left');
        var linkOn = element.params.get('linkOn', 'button');

        var wrapperClass = ['jdb-flipbox-wrapper'];
        if (linkOn == 'box') {
            wrapperClass.push('jdb-flipbox-box-linked');
        }
        wrapperClass.push('jdb-flipbox-' + animation);
        if (['flip', 'slide', 'push'].indexOf(animation) > -1) {
            wrapperClass.push('jdb-flipbox-dir-' + direction);
        }

        var frontClass = ['jdb-flipbox-front'];
        frontClass.push('jdb-flipbox-content-' + element.params.get('frontHorizontalAlignment', 'center'));
        frontClass.push('jdb-flipbox-vertical-' + element.params.get('frontVerticalAlignment', 'middle'));

        var backClass = ['jdb-flipbox-back'];
        backClass.push('jdb-flipbox-content-' + element.params.get('backHorizontalAlignment', 'center'));
        backClass.push('jdb-flipbox-vertical-' + element.params.get('backVerticalAlignment', 'middle'));

        var graphic = element.params.get('graphic', 'none');
        var backGraphic = element.params.get('backGraphic', 'none');

        html.push('<div class="' + wrapperClass.join(' ') + '">');
        html.push('<div class="jdb-flipbox-card">');
        html.push('<div class="' + frontClass.join(' ') + '">');
        html.push('<div class="jdb-flipbox-front-wrapper">');
        html.push('<div class="jdb-flipbox-media">');
        switch (graphic) {
            case 'icon':
                var icon = element.params.get('icon', '');
                if (icon != '') {
                    JDBRenderer.Document.loadFontLibraryByIcon(icon);
                    html.push('<div class="jdb-flipbox-icon jdb-icon"><div class="jdb-icon-wrapper"><span class="' + icon + '"></span></div></div>');
                }
                break;
            case 'image':
                var image = element.params.get('image', '');
                if (image != '') {
                    html.push('<div class="jdb-flipbox-image"><img src="' + JDBRenderer.Helper.mediaValue(image) + '" /></div>');
                }
                break;
        }
        html.push('</div>');
        var frontTitle = element.params.get('frontTitle', '');
        if (frontTitle != '') {
            html.push('<div class="jdb-flipbox-front-title">' + frontTitle + '</div>');
        }

        var frontDescription = element.params.get('frontDescription', '');
        if (frontDescription != '') {
            html.push('<div class="jdb-flipbox-front-description">' + frontDescription + '</div>');
        }

        html.push('</div>');
        html.push('</div>');


        html.push('<div class="' + backClass.join(' ') + '">');
        html.push('<div class="jdb-flipbox-back-wrapper">');
        html.push('<div class="jdb-flipbox-media">');
        switch (backGraphic) {
            case 'icon':
                var icon = element.params.get('backIcon', '');
                if (icon != '') {
                    JDBRenderer.Document.loadFontLibraryByIcon(icon);
                    html.push('<div class="jdb-flipbox-icon jdb-icon"><div class="jdb-icon-wrapper"><span class="' + icon + '"></span></div></div>');
                }
                break;
            case 'image':
                var image = element.params.get('backImage', '');
                if (image != '') {
                    html.push('<div class="jdb-flipbox-image"><img src="' + JDBRenderer.Helper.mediaValue(image) + '" /></div>');
                }
                break;
        }
        html.push('</div>');
        var backTitle = element.params.get('backTitle', '');
        if (backTitle != '') {
            html.push('<div class="jdb-flipbox-back-title">' + (linkOn == 'title' ? JDBRenderer.Helper.linkValue(backTitle, element.params) : backTitle) + '</div>');
        }

        var backDescription = element.params.get('backDescription', '');
        if (backDescription != '') {
            html.push('<div class="jdb-flipbox-back-description">' + backDescription + '</div>');
        }

        var buttonText = element.params.get('buttonText', '');
        var link = element.params.get('link', '');
        if (link != '' && buttonText != '' && linkOn != 'title') {
            if (linkOn != 'title') {
                html.push(JDBRenderer.Helper.renderButtonValue('button', element, buttonText, ['jdb-flipbox-back-button'], 'link', link, element.params.get('linkTargetBlank', false), element.params.get('linkNoFollow', false)));
            } else {
                html.push(JDBRenderer.Helper.renderButtonValue('button', element, buttonText, ['jdb-flipbox-back-button'], 'button'));
            }
        }

        html.push('</div>');
        html.push('</div>');

        html.push('</div>');
        html.push('</div>');

        elementStyling(element);
        return html.join('');
    };

    function elementStyling(element) {
        // Flipbox Settings
        var boxStyle = new JDBRenderer.ElementStyle(".jdb-flipbox-card");
        element.addChildStyle(boxStyle);

        const minHeight = element.params.get('height', null);
        if (minHeight != null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if ((_deviceObj.key in minHeight) && JDBRenderer.Helper.checkSliderValue(minHeight[_deviceObj.key])) {
                    boxStyle.addCss('min-height', minHeight[_deviceObj.key].value + minHeight[_deviceObj.key].unit, _deviceObj.type);
                }
            });
        }

        // Front Styling
        var frontBoxStyle = new JDBRenderer.ElementStyle(".jdb-flipbox-front");
        element.addChildStyle(frontBoxStyle);

        JDBRenderer.Helper.applyBackgroundValue(frontBoxStyle, element.params, "frontBackground");
        JDBRenderer.Helper.applyBorderValue(frontBoxStyle, element.params, "frontBorder");
        var padding = element.params.get('frontPadding', null);
        if (padding != null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in padding) {
                    frontBoxStyle.addStyle(JDBRenderer.Helper.spacingValue(padding[_deviceObj.key], "padding"), _deviceObj.type);
                }
            });
        }

        var frontTitleStyle = new JDBRenderer.ElementStyle(".jdb-flipbox-front-title");
        element.addChildStyle(frontTitleStyle);

        frontTitleStyle.addCss('color', element.params.get('frontTitleColor', ''));
        var titleSpacing = element.params.get('frontTitleSpacing', null);
        if (JDBRenderer.Helper.checkSliderValue(titleSpacing)) {
            frontTitleStyle.addCss('margin-top', titleSpacing.value + "" + 'px');
        }

        var typography = element.params.get('frontTitleTypography', null);
        if (typography !== null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in typography) {
                    frontTitleStyle.addStyle(JDBRenderer.Helper.typographyValue(typography[_deviceObj.key]), _deviceObj.type);
                }
            });
        }

        var frontDescStyle = new JDBRenderer.ElementStyle(".jdb-flipbox-front-description");
        element.addChildStyle(frontDescStyle);

        frontDescStyle.addCss('color', element.params.get('frontDescriptionColor', ''));
        var descSpacing = element.params.get('frontDescriptionSpacing', null);
        if (JDBRenderer.Helper.checkSliderValue(descSpacing)) {
            frontDescStyle.addCss('margin-top', descSpacing.value + "" + 'px');
        }
        typography = element.params.get('frontDescriptionTypography', null);
        if (typography !== null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in typography) {
                    frontDescStyle.addStyle(JDBRenderer.Helper.typographyValue(typography[_deviceObj.key]), _deviceObj.type);
                }
            });
        }

        // Back Styling
        var backBoxStyle = new JDBRenderer.ElementStyle(".jdb-flipbox-back");
        element.addChildStyle(backBoxStyle);

        JDBRenderer.Helper.applyBackgroundValue(backBoxStyle, element.params, "backBackground");
        JDBRenderer.Helper.applyBorderValue(backBoxStyle, element.params, "backBorder");
        var padding = element.params.get('backPadding', null);
        if (padding != null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in padding) {
                    backBoxStyle.addStyle(JDBRenderer.Helper.spacingValue(padding[_deviceObj.key], "padding"), _deviceObj.type);
                }
            });
        }

        var backTitleStyle = new JDBRenderer.ElementStyle(".jdb-flipbox-back-title");
        element.addChildStyle(backTitleStyle);

        backTitleStyle.addCss('color', element.params.get('backTitleColor', ''));
        var titleSpacing = element.params.get('backTitleSpacing', null);
        if (JDBRenderer.Helper.checkSliderValue(titleSpacing)) {
            backTitleStyle.addCss('margin-top', titleSpacing.value + "" + 'px');
        }
        var typography = element.params.get('backTitleTypography', null);
        if (typography !== null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in typography) {
                    backTitleStyle.addStyle(JDBRenderer.Helper.typographyValue(typography[_deviceObj.key]), _deviceObj.type);
                }
            });
        }

        var backDescStyle = new JDBRenderer.ElementStyle(".jdb-flipbox-back-description");
        element.addChildStyle(backDescStyle);

        backDescStyle.addCss('color', element.params.get('backDescriptionColor', ''));
        var descSpacing = element.params.get('backDescriptionSpacing', null);
        if (JDBRenderer.Helper.checkSliderValue(descSpacing)) {
            backDescStyle.addCss('margin-top', descSpacing.value + "" + 'px');
        }
        typography = element.params.get('backDescriptionTypography', null);
        if (typography !== null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in typography) {
                    backDescStyle.addStyle(JDBRenderer.Helper.typographyValue(typography[_deviceObj.key]), _deviceObj.type);
                }
            });
        }

        // Icon Styling

        var iconStyle = new JDBRenderer.ElementStyle('.jdb-flipbox-front .jdb-flipbox-icon > .jdb-icon-wrapper');
        element.addChildStyle(iconStyle);


        var iconInnerStyle = new JDBRenderer.ElementStyle('.jdb-flipbox-front .jdb-flipbox-icon > .jdb-icon-wrapper > span');
        element.addChildStyle(iconInnerStyle);

        JDBRenderer.Helper.applyBorderValue(iconStyle, element.params, "iconBorder");
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
        var padding = element.params.get('iconPadding', null);
        if (padding !== null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in padding) {
                    iconStyle.addStyle(JDBRenderer.Helper.spacingValue(padding[_deviceObj.key], "padding"), _deviceObj.type);
                }
            });
        }

        iconStyle.addCss("color", element.params.get('iconForeground', ''));
        iconStyle.addCss("background-color", element.params.get('iconBackground', ''));
        iconStyle.addCss("background-image", element.params.get('iconGradient', ''));

        var iconRotate = element.params.get('iconRotate', null);
        if (iconRotate != null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if ((_deviceObj.key in iconRotate) && JDBRenderer.Helper.checkSliderValue(iconRotate[_deviceObj.key])) {
                    iconInnerStyle.addCss("transform", "rotate(" + iconRotate[_deviceObj.key].value + "deg)", _deviceObj.type);
                }
            });
        }

        // Back Icon
        var backIconStyle = new JDBRenderer.ElementStyle('.jdb-flipbox-back .jdb-flipbox-icon > .jdb-icon-wrapper');
        element.addChildStyle(backIconStyle);


        var backIconInnerStyle = new JDBRenderer.ElementStyle('.jdb-flipbox-back .jdb-flipbox-icon > .jdb-icon-wrapper > span');
        element.addChildStyle(backIconInnerStyle);

        JDBRenderer.Helper.applyBorderValue(backIconStyle, element.params, "backIconBorder");
        var iconSize = element.params.get('backIconSize', null);
        if (iconSize != null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if ((_deviceObj.key in iconSize) && JDBRenderer.Helper.checkSliderValue(iconSize[_deviceObj.key])) {
                    backIconStyle.addCss("font-size", (iconSize[_deviceObj.key].value * 0.70) + 'px', _deviceObj.type);
                    backIconStyle.addCss("width", iconSize[_deviceObj.key].value + 'px', _deviceObj.type);
                    backIconStyle.addCss("height", iconSize[_deviceObj.key].value + 'px', _deviceObj.type);
                    backIconStyle.addCss("line-height", iconSize[_deviceObj.key].value + 'px', _deviceObj.type);
                }
            });
        }
        var padding = element.params.get('backIconPadding', null);
        if (padding !== null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in padding) {
                    backIconStyle.addStyle(JDBRenderer.Helper.spacingValue(padding[_deviceObj.key], "padding"), _deviceObj.type);
                }
            });
        }

        backIconStyle.addCss("color", element.params.get('backIconForeground', ''));
        backIconStyle.addCss("background-color", element.params.get('backIconBackground', ''));
        backIconStyle.addCss("background-image", element.params.get('backIconGradient', ''));

        var iconRotate = element.params.get('backIconRotate', null);
        if (iconRotate != null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if ((_deviceObj.key in iconRotate) && JDBRenderer.Helper.checkSliderValue(iconRotate[_deviceObj.key])) {
                    backIconInnerStyle.addCss("transform", "rotate(" + iconRotate[_deviceObj.key].value + "deg)", _deviceObj.type);
                }
            });
        }

        var buttonStyle = new JDBRenderer.ElementStyle(".jdb-flipbox-back-button");
        element.addChildStyle(buttonStyle);
        var buttonSpacing = element.params.get('buttonSpacing', null);
        if (JDBRenderer.Helper.checkSliderValue(buttonSpacing)) {
            buttonStyle.addCss('margin-top', buttonSpacing.value + "" + 'px');
        }


        var imageStyle = new JDBRenderer.ElementStyle(".jdb-flipbox-image");
        element.addChildStyle(imageStyle);
        var imageWidth = element.params.get('imageWidth', null);
        if (imageWidth != null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if ((_deviceObj.key in imageWidth) && JDBRenderer.Helper.checkSliderValue(imageWidth[_deviceObj.key])) {
                    imageStyle.addCss("width", imageWidth[_deviceObj.key].value + imageWidth[_deviceObj.key].unit, _deviceObj.type);
                }
            });
        }
    }

    window.JDBuilderElementFlipBox = JDBuilderElementFlipBox;

})();