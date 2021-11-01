(function () {

    var JDBuilderElementIconBox = function (element) {
        element.addClass('jdb-iconbox');

        var html = [];

        // params
        var icon = element.params.get('icon', '');
        var title = element.params.get('title', '');
        var titleHtmlTag = element.params.get('titleHtmlTag', 'h4');
        var description = element.params.get('description', '');
        var link = element.params.get('link', '');
        var buttonText = element.params.get('buttonText', '');
        var linkOn = element.params.get('linkOn', 'button');

        var linkStart = '';
        var linkEnd = '';
        if (link != '') {
            // link title
            var linkTitle = (title == '' ? '' : ' title="' + title + '"');

            // link target
            var linkTargetBlank = element.params.get('linkTargetBlank', false);
            var linkTarget = linkTargetBlank ? ' target="_blank"' : "";

            // link follow
            var linkNoFollow = element.params.get('linkNoFollow', false);
            var linkRel = linkNoFollow ? ' rel="nofollow"' : "";

            var linkClass = '';
            if (link != '' && buttonText != '' && linkOn == 'button') {
                linkClass = ' class="jdb-iconbox-btn"';
            }
            linkStart = '<a href="' + link + '"' + linkClass + linkTitle + linkTarget + linkRel + '>';
            linkEnd = '</a>';
        }

        if (linkOn == 'full-box') {
            html.push(linkStart);
        }

        html.push('<div class="jdb-d-flex jdb-flex-' + element.params.get('iconPosition', 'column') + '">');

        if (icon != '') {
            JDBRenderer.Document.loadFontLibraryByIcon(icon);

            if (linkOn == 'both-icon-and-title' || linkOn == 'icon') {
                html.push(linkStart);
            }
            html.push('<div class="jdb-iconbox-icon jdb-icon"><div class="jdb-icon-wrapper"><span class="' + icon + '"></span></div></div>');
            if (linkOn == 'both-icon-and-title' || linkOn == 'icon') {
                html.push(linkEnd);
            }
        }
        html.push('<div>');
        // icon caption
        if (title != '') {
            if (linkOn == 'both-icon-and-title' || linkOn == 'title') {
                html.push(linkStart);
            }
            html.push('<' + titleHtmlTag + ' class="jdb-iconbox-title">' + title + '</' + titleHtmlTag + '>');
            if (linkOn == 'both-icon-and-title' || linkOn == 'title') {
                html.push(linkEnd);
            }
        }
        if (description != '') {
            html.push('<div class="jdb-iconbox-desc">' + description + '</div>');
        }
        if (link != '' && buttonText != '') {
            html.push('<div class="jdb-iconbox-btn-container">');
            if (linkOn == 'button') {
                html.push(linkStart + buttonText + linkEnd);
            } else if (linkOn == 'full-box') {
                html.push('<span class="jdb-iconbox-btn">' + buttonText + '</span>');
            }
            html.push('</div>');
        }

        html.push('</div>');
        html.push('</div>');
        if (linkOn == 'full-box') {
            html.push(linkEnd);
        }

        iconStyling(element);
        elementStyling(element);
        boxStyling(element);
        return html.join('');
    };

    function iconStyling(element) {

        var iconStyle = JDBRenderer.ElementStyle('.jdb-iconbox-icon > .jdb-icon-wrapper');
        var iconInnerStyle = JDBRenderer.ElementStyle('.jdb-iconbox-icon > .jdb-icon-wrapper > span');
        var iconInnerHoverStyle = JDBRenderer.ElementStyle(':hover .jdb-iconbox-icon > .jdb-icon-wrapper > span');
        var iconHoverStyle = JDBRenderer.ElementStyle(':hover .jdb-iconbox-icon > .jdb-icon-wrapper');

        element.addChildrenStyle([iconStyle, iconHoverStyle, iconInnerStyle, iconInnerHoverStyle]);

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

        // Icon Rotate
        var iconRotate = element.params.get('iconRotate', null);
        var iconRotateHover = element.params.get('iconRotateHover', null);
        if (iconRotate != null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if ((_deviceObj.key in iconRotate) && JDBRenderer.Helper.checkSliderValue(iconRotate[_deviceObj.key])) {
                    iconInnerStyle.addCss("transform", "rotate(" + iconRotate[_deviceObj.key].value + "deg)", _deviceObj.type);
                }
            });
        }
        if (iconRotateHover != null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if ((_deviceObj.key in iconRotateHover) && JDBRenderer.Helper.checkSliderValue(iconRotateHover[_deviceObj.key])) {
                    iconInnerHoverStyle.addCss("transform", "rotate(" + iconRotateHover[_deviceObj.key].value + "deg)", _deviceObj.type);
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



        iconStyle.addCss("color", element.params.get('iconTextColor', ''));
        iconStyle.addCss("background-color", element.params.get('iconBackgroundColor', ''));
        iconStyle.addCss("border-color", element.params.get('iconBorderColor', ''));
        iconStyle.addCss("background-image", element.params.get('iconGradient', ''));
        iconStyle.addCss("box-shadow", element.params.get('iconBoxShadow', ''));


        iconHoverStyle.addCss("color", element.params.get('iconTextColorHover', ''));
        iconHoverStyle.addCss("background-color", element.params.get('iconBackgroundColorHover', ''));
        iconHoverStyle.addCss("border-color", element.params.get('iconBorderColorHover', ''));
        iconHoverStyle.addCss("background-image", element.params.get('iconGradientHover', ''));

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
    }

    function elementStyling(element) {

        var titleStyle = new JDBRenderer.ElementStyle(".jdb-iconbox-title");
        var titleHoverStyle = new JDBRenderer.ElementStyle(":hover .jdb-iconbox-title");
        var descStyle = new JDBRenderer.ElementStyle(".jdb-iconbox-desc");
        var descHoverStyle = new JDBRenderer.ElementStyle(":hover .jdb-iconbox-desc");
        var buttonStyle = new JDBRenderer.ElementStyle(".jdb-iconbox-btn");
        var buttonStyleContainer = new JDBRenderer.ElementStyle(".jdb-iconbox-btn-container");
        var buttonHoverStyle = new JDBRenderer.ElementStyle(":hover .jdb-iconbox-btn");

        element.addChildrenStyle([titleStyle, titleHoverStyle, descStyle, descHoverStyle, buttonStyle, buttonHoverStyle, buttonStyleContainer]);

        /*
            Title Styling
        */

        // Title Color and Space
        titleStyle.addCss('color', element.params.get('titleColor', ''));
        titleHoverStyle.addCss('color', element.params.get('titleHoverColor', ''));
        var titleSpacing = element.params.get('titleSpacing', null);
        if (JDBRenderer.Helper.checkSliderValue(titleSpacing)) {
            titleStyle.addCss('margin-top', titleSpacing.value + "" + 'px');
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
            Desc Styling
        */

        // Desc Color and Space
        descStyle.addCss('color', element.params.get('descColor', ''));
        descHoverStyle.addCss('color', element.params.get('descHoverColor', ''));
        var descSpacing = element.params.get('descSpacing', null);
        if (JDBRenderer.Helper.checkSliderValue(descSpacing)) {
            descStyle.addCss('margin-top', descSpacing.value + 'px');
        }

        // Description Typography
        typography = element.params.get('descTypography', null);
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

        // Button Spacing
        var buttonSpacing = element.params.get('buttonSpacing', null);
        if (JDBRenderer.Helper.checkSliderValue(buttonSpacing)) {
            buttonStyleContainer.addCss('margin-top', buttonSpacing.value + "" + 'px');
        }

        // Button Alignment
        var alignment = element.params.get('buttonAlignment', null);
        if (alignment != null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_.isObject(alignment) && (_deviceObj.key in alignment) && alignment[_deviceObj.key] != '') {
                    if (alignment[_deviceObj.key] == 'block') {
                        buttonStyle.addCss("width", "100%", _deviceObj.type);
                    } else {
                        buttonStyleContainer.addCss("text-align", alignment[_deviceObj.key], _deviceObj.type);
                    }
                }
            });
        }

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
        let iconBorderStyle = element.params.get('buttonBorderStyle', 'solid');
        buttonStyle.addCss("border-style", iconBorderStyle);

        if (iconBorderStyle != 'none') {
            let borderWidth = element.params.get('buttonBorderWidth', null);
            if (borderWidth !== null) {
                JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                    if (_deviceObj.key in borderWidth) {
                        buttonStyle.addStyle(JDBRenderer.Helper.spacingValue(borderWidth[_deviceObj.key], "border"), _deviceObj.type);
                    }
                });
            }
        }

        // Button Radius
        var borderRadius = element.params.get('buttonBorderRadius', null);
        if (borderRadius !== null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in borderRadius) {
                    buttonStyle.addStyle(JDBRenderer.Helper.spacingValue(borderRadius[_deviceObj.key], "radius"), _deviceObj.type);
                }
            });
        }

        // buttonStyle.addStyle(JDBRenderer.Helper.spacingValue(borderRadius[_deviceObj.key], "radius"), _deviceObj.type);

        // Button Shadow
        buttonStyle.addCss("box-shadow", element.params.get('buttonBoxShadow', ''));
    }

    function boxStyling(element) {
        var elementHoverStyle = new JDBRenderer.ElementStyle("::hover");
        element.addChildrenStyle([elementHoverStyle]);

        JDBRenderer.Helper.applyBackgroundValue(elementHoverStyle, element.params, "boxHoverBackground");
        JDBRenderer.Helper.applyBorderValue(elementHoverStyle, element.params, "boxHoverBorder");
    }

    window.JDBuilderElementIconBox = JDBuilderElementIconBox;

})();