(function () {

    var JDBuilderElementImageBox = function (element) {
        element.addClass('jdb-imagebox');

        var html = [];

        // params
        var image = element.params.get('image', '');
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
                linkClass = ' class="jdb-imagebox-btn"';
            }
            linkStart = '<a href="' + link + '"' + linkClass + linkTitle + linkTarget + linkRel + '>';
            linkEnd = '</a>';
        }

        if (linkOn == 'full-box') {
            html.push(linkStart);
        }

        html.push('<figure>');

        if (image != '') {
            var attrs = [];
            // image title and alt
            var altText = element.params.get('altText', '');
            if (altText != '') {
                attrs.push('title="' + altText + '"');
                attrs.push('alt="' + altText + '"');
            } else if (title != '') {
                attrs.push('title="' + title + '"');
                attrs.push('alt="' + title + '"');
            }
            if (linkOn == 'both-image-and-title' || linkOn == 'image') {
                html.push(linkStart);
            }
            html.push('<img class="jdb-imagebox-img" src="' + JDBRenderer.Helper.mediaValue(image) + '" ' + (!attrs.length ? '' : ' ' + attrs.join(' ')) + ' />');
            if (linkOn == 'both-image-and-title' || linkOn == 'image') {
                html.push(linkEnd);
            }
        }

        // image caption
        if (title != '') {
            if (linkOn == 'both-image-and-title' || linkOn == 'title') {
                html.push(linkStart);
            }
            html.push('<' + titleHtmlTag + ' class="jdb-imagebox-title">' + title + '</' + titleHtmlTag + '>');
            if (linkOn == 'both-image-and-title' || linkOn == 'title') {
                html.push(linkEnd);
            }
        }
        if (description != '') {
            html.push('<figcaption class="jdb-imagebox-desc">' + description + '</figcaption>');
        }
        if (link != '' && buttonText != '') {
            html.push('<div class="jdb-imagebox-btn-container">');
            if (linkOn == 'button') {
                html.push(linkStart + buttonText + linkEnd);
            } else if (linkOn == 'full-box') {
                html.push('<span class="jdb-imagebox-btn">' + buttonText + '</span>');
            }
            html.push('</div>');
        }

        html.push('</figure>');
        if (linkOn == 'full-box') {
            html.push(linkEnd);
        }
        elementStyling(element);
        boxStyling(element);
        return html.join('');
    };

    function elementStyling(element) {

        var imageStyle = new JDBRenderer.ElementStyle(".jdb-imagebox-img");
        var titleStyle = new JDBRenderer.ElementStyle(".jdb-imagebox-title");
        var descStyle = new JDBRenderer.ElementStyle(".jdb-imagebox-desc");
        var buttonStyle = new JDBRenderer.ElementStyle(".jdb-imagebox-btn");
        var buttonStyleContainer = new JDBRenderer.ElementStyle(".jdb-imagebox-btn-container");
        var buttonHoverStyle = new JDBRenderer.ElementStyle(".jdb-imagebox-btn:hover");

        element.addChildrenStyle([imageStyle, titleStyle, descStyle, buttonStyle, buttonHoverStyle, buttonStyleContainer]);

        /*
            Image Styling
        */

        var imageWidth = element.params.get('imageWidth', null);
        if (imageWidth != null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if ((_deviceObj.key in imageWidth) && JDBRenderer.Helper.checkSliderValue(imageWidth[_deviceObj.key])) {
                    imageStyle.addCss("width", imageWidth[_deviceObj.key].value + imageWidth[_deviceObj.key].unit, _deviceObj.type);
                }
            });
        }

        const imageBorderStyle = element.params.get('imageBorderStyle', '');
        if (imageBorderStyle != '') {
            imageStyle.addCss('border-style', imageBorderStyle);
            const imageBorderWidth = element.params.get('imageBorderWidth', null);
            if (imageBorderWidth != null && imageBorderStyle != 'none') {
                JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                    if (_deviceObj.key in imageBorderWidth) {
                        imageStyle.addStyle(JDBRenderer.Helper.spacingValue(imageBorderWidth[_deviceObj.key], "border"), _deviceObj.type);
                    }
                });

                imageStyle.addCss("border-color", element.params.get('imageBorderColor', ''));
            }
        }

        const imageBorderRadius = element.params.get('imageBorderRadius', null);
        if (imageBorderRadius != null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in imageBorderRadius) {
                    imageStyle.addStyle(JDBRenderer.Helper.spacingValue(imageBorderRadius[_deviceObj.key], "radius"), _deviceObj.type);
                }
            });
        }

        const imageBoxShadow = element.params.get('imageBoxShadow', null);
        if (imageBoxShadow != null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in imageBoxShadow) {
                    imageStyle.addCss("box-shadow", imageBoxShadow[_deviceObj.key], _deviceObj.type);
                }
            });
        }


        /*
            Title Styling
        */

        // Title Color and Space
        titleStyle.addCss('color', element.params.get('titleColor', ''));
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
        var descSpacing = element.params.get('descSpacing', null);
        if (JDBRenderer.Helper.checkSliderValue(descSpacing)) {
            descStyle.addCss('margin-top', descSpacing.value + "" + 'px');
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
        if (!(element.params.get('buttonGradient', '')) && (element.params.get('buttonGradientHover', ''))) {
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

        // Button Shadow
        buttonStyle.addCss("box-shadow", element.params.get('buttonBoxShadow', ''));
    }

    function boxStyling(element) {
        var elementHoverStyle = new JDBRenderer.ElementStyle("::hover");
        element.addChildrenStyle([elementHoverStyle]);

        JDBRenderer.Helper.applyBackgroundValue(elementHoverStyle, element.params, "boxHoverBackground");
        JDBRenderer.Helper.applyBorderValue(elementHoverStyle, element.params, "boxHoverBorder");
    }

    window.JDBuilderElementImageBox = JDBuilderElementImageBox;

})();