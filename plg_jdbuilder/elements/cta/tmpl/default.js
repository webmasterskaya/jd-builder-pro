(function () {

    var JDBuilderElementCta = function (element) {
        element.addClass('jdb-cta');

        var title = element.params.get('title', '');
        var titleHtmlTag = element.params.get('titleHtmlTag', 'h4');
        var description = element.params.get('description', '');
        var link = element.params.get('link', '');
        var buttonText = element.params.get('buttonText', '');
        var ribbonText = element.params.get('ribbonText', '');

        var verticalPosition = element.params.get('verticalPosition', '');

        if (verticalPosition != '') {
            element.addClass('jdb-' + verticalPosition);
        }

        element.addCss('text-align', element.params.get('contentAlignment', ''));

        var html = [];


        if (ribbonText != '') {
            element.addClass('jdb-has-ribbon');
            html.push('<span class="jdb-ribbon ' + (element.params.get('ribbonPosition', 'right')) + '">' + ribbonText + '</span>');
        }


        if (title != '') {
            html.push('<' + titleHtmlTag + ' class="jdb-cta-title">' + title + '</' + titleHtmlTag + '>');
        }

        if (description != '') {
            html.push('<div class="jdb-cta-desc">' + description + '</div>');
        }

        if (buttonText != '') {
            html.push(JDBRenderer.Helper.renderButtonValue('button', element, buttonText, [], 'link', element.params.get('link', ''), element.params.get('linkTargetBlank', false), element.params.get('linkNoFollow', false)));
        }

        elementStyling(element);
        return html.join('');
    }

    function elementStyling(element) {
        var titleStyle = new JDBRenderer.ElementStyle(".jdb-cta-title");
        var titleHoverStyle = new JDBRenderer.ElementStyle("::hover .jdb-cta-title");
        var descStyle = new JDBRenderer.ElementStyle(".jdb-cta-desc");
        var descHoverStyle = new JDBRenderer.ElementStyle("::hover .jdb-cta-desc");
        var ribbonStyle = new JDBRenderer.ElementStyle(".jdb-ribbon");
        var buttonStyle = new JDBRenderer.ElementStyle(".jdb-cta-btn");
        var buttonHoverStyle = new JDBRenderer.ElementStyle(".jdb-cta-btn:hover");

        element.addChildrenStyle([titleStyle, titleHoverStyle, descStyle, descHoverStyle, buttonStyle, buttonHoverStyle, ribbonStyle]);

        var _element = element;
        var minHeight = element.params.get('minHeight', null);
        if (minHeight != null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if ((_deviceObj.key in minHeight) && JDBRenderer.Helper.checkSliderValue(minHeight[_deviceObj.key])) {
                    _element.addCss('min-height', minHeight[_deviceObj.key].value + minHeight[_deviceObj.key].unit, _deviceObj.type);
                }
            });
        }




        /*
            Title Styling
        */

        // Title Color and Space
        titleStyle.addCss('color', element.params.get('titleColor', ''));
        titleHoverStyle.addCss('color', element.params.get('titleHoverColor', ''));

        var titleSpacing = element.params.get('titleSpacing', null);
        if (titleSpacing != null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if ((_deviceObj.key in titleSpacing) && JDBRenderer.Helper.checkSliderValue(titleSpacing[_deviceObj.key])) {
                    titleStyle.addCss('margin-bottom', ((titleSpacing[_deviceObj.key].value * 4) * .17) + 'px', _deviceObj.type);
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

        /*
            Description Styling
        */

        descStyle.addCss('color', element.params.get('descriptionColor', ''));
        descHoverStyle.addCss('color', element.params.get('descriptionHoverColor', ''));

        var descriptionSpacing = element.params.get('descriptionSpacing', null);
        if (descriptionSpacing != null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if ((_deviceObj.key in descriptionSpacing) && JDBRenderer.Helper.checkSliderValue(descriptionSpacing[_deviceObj.key])) {
                    descStyle.addCss('margin-bottom', ((descriptionSpacing[_deviceObj.key].value * 4) * .17) + 'px', _deviceObj.type);
                }
            });
        }

        // desc Typography
        typography = element.params.get('descriptionTypography', null);
        if (typography !== null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in typography) {
                    descStyle.addStyle(JDBRenderer.Helper.typographyValue(typography[_deviceObj.key]), _deviceObj.type);
                }
            });
        }

        /*
            Button Styling
        */

        // Button Background
        buttonStyle.addCss("background-color", element.params.get('buttonBackgroundColor', ''));
        buttonHoverStyle.addCss("background-color", element.params.get('buttonBackgroundColorHover', ''));

        // Button Text Color
        buttonStyle.addCss("color", element.params.get('buttonTextColor', ''));
        buttonHoverStyle.addCss("color", element.params.get('buttonTextColorHover', ''));

        // Button Border Color
        buttonStyle.addCss("border-color", element.params.get('buttonBorderColor', ''));
        buttonHoverStyle.addCss("border-color", element.params.get('buttonBorderColorHover', ''));

        // Button Gradient
        buttonStyle.addCss("background-image", element.params.get('buttonGradient', ''));
        buttonHoverStyle.addCss("background-image", element.params.get('buttonGradientHover', ''));
        if ((element.params.get('buttonGradient', '') != '') && (element.params.get('buttonGradientHover', '') == '')) {
            buttonHoverStyle.addCss("background-image", 'none');
        }

        // Button Typography
        typography = element.params.get('buttonTypography', null);
        if (typography !== null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in typography) {
                    buttonStyle.addStyle(JDBRenderer.Helper.typographyValue(typography[_deviceObj.key]), _deviceObj.type);
                }
            });
        }

        // Button Padding
        var padding = element.params.get('buttonPadding', null);
        if (padding != null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in padding) {
                    buttonStyle.addStyle(JDBRenderer.Helper.spacingValue(padding[_deviceObj.key], "padding"), _deviceObj.type);
                }
            });
        }

        // Button Border
        JDBRenderer.Helper.applyBorderValue(buttonStyle, element.params, "buttonBorder");
        JDBRenderer.Helper.applyBorderValue(buttonHoverStyle, element.params, "buttonHoverBorder");

        // Ribbon Styling
        ribbonStyle.addCss("color", element.params.get('ribbonColor', ''));
        ribbonStyle.addCss("background-color", element.params.get('ribbonBackground', ''));
        typography = element.params.get('ribbonTypography', null);
        if (typography !== null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in typography) {
                    ribbonStyle.addStyle(JDBRenderer.Helper.typographyValue(typography[_deviceObj.key]), _deviceObj.type);
                }
            });
        }

        var ribbonDistance = element.params.get('ribbonDistance', null);
        if (ribbonDistance != null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if ((_deviceObj.key in ribbonDistance) && JDBRenderer.Helper.checkSliderValue(ribbonDistance[_deviceObj.key])) {
                    ribbonStyle.addCss('margin-' + element.params.get('ribbonPosition', 'right'), '-' + ribbonDistance[_deviceObj.key].value + 'px', _deviceObj.type);
                    ribbonStyle.addCss('width', (ribbonDistance[_deviceObj.key].value * 4) + 'px', _deviceObj.type);
                    ribbonStyle.addCss('margin-top', ((ribbonDistance[_deviceObj.key].value * 4) * .17) + 'px', _deviceObj.type);
                }
            });
        }

        var elementHoverStyle = new JDBRenderer.ElementStyle("::hover");
        element.addChildrenStyle([elementHoverStyle]);

        JDBRenderer.Helper.applyBackgroundValue(elementHoverStyle, element.params, "ctaHoverBackground");
        JDBRenderer.Helper.applyBorderValue(elementHoverStyle, element.params, "ctaHoverBorder");

    }

    window.JDBuilderElementCta = JDBuilderElementCta;

})();