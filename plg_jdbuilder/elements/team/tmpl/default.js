(function () {

    var JDBuilderElementTeam = function (element) {

        element.addClass('jdb-team');

        var html = [];

        // params
        var memberAvatar = element.params.get('memberAvatar', '');
        var memberName = element.params.get('memberName', '');
        var nameHtmlTag = element.params.get('nameHtmlTag', 'h3');
        var memberDesignation = element.params.get('memberDesignation', '');
        var memberBio = element.params.get('memberBio', '');
        var slPosition = element.params.get('slPosition', 'afterbio');

        html.push('<div>');

        if (memberAvatar != '') {
            var attrs = [];
            // image title and alt
            attrs.push('title="' + memberName + '"');
            attrs.push('alt="' + memberName + '"');
            html.push('<img class="jdb-team-img" src="' + JDBRenderer.Helper.mediaValue(memberAvatar) + '" ' + ((attrs) ? '' : ' ' + implode(" ", attrs)) + ' />');
        }


        // image caption
        if (memberName != '') {
            html.push('<' + nameHtmlTag + ' class="jdb-team-name">' + memberName + '</' + nameHtmlTag + '>');
        }
        if (memberDesignation != '') {
            html.push('<p class="jdb-team-designation">' + memberDesignation + '</p>');
        }
        if (slPosition == 'beforebio') {
            html.push(getSocialLinks(element));
        }
        if (memberBio != '') {
            html.push('<p class="jdb-team-bio">' + memberBio + '</p>');
        }
        if (slPosition == 'afterbio') {
            html.push(getSocialLinks(element));
        }
        html.push('</div>');
        elementStyling(element);
        return html.join('');
    };

    function getSocialLinks(element) {
        var profiles = element.params.get('memberSocialLinks', {});
        if (!profiles.length) {
            return;
        }
        var colorStyle = element.params.get('iconStyle', 'brand');

        var animation = element.params.get('slHoverAnimation', '');
        if (animation != '') {
            animation = 'jdb-hover-' + animation;
        }

        var invertedColors = element.params.get('brandColorInverted', false);

        html = [];
        html.push('<div class="jdb-social-links jdb-social-links-icon-only' + (colorStyle === 'brand' ? ' jdb-brands-icons' : '') + '"><ul>');
        var index = 0;
        profiles.forEach(function (_profile) {
            index++;
            var linkTargetBlank = (('linkTargetBlank' in _profile) && _profile.linkTargetBlank) ? ' target="_blank"' : '';
            var linkNoFollow = (('linkNoFollow' in _profile) && _profile.linkNoFollow) ? ' rel="nofollow"' : '';

            html.push('<li class="jdb-social-link-' + index + ' ' + animation + '">');

            html.push('<a data-brand="' + _profile.icon.replace(/ /g, "-") + '" title="' + _profile.title + '" class="brand-' + (invertedColors ? 'inverted' : 'static') + '" href="' + _profile.link + '"' + linkTargetBlank + linkNoFollow + '>');
            html.push('<span class="jdb-sl-icon"><span class="' + _profile.icon + '"></span></span><span class="jdb-sl-title">' + _profile.title + '</span>');
            html.push('</a>');
            html.push('</li>');
        });
        html.push('</ul></div>');
        return html.join('');
    }

    function elementStyling(element) {

        var imageStyle = new JDBRenderer.ElementStyle(".jdb-team-img");
        var titleStyle = new JDBRenderer.ElementStyle(".jdb-team-name");
        var designationStyle = new JDBRenderer.ElementStyle(".jdb-team-designation");
        var bioStyle = new JDBRenderer.ElementStyle(".jdb-team-bio");
        var slStyle = new JDBRenderer.ElementStyle(".jdb-social-links");

        element.addChildrenStyle([imageStyle, titleStyle, designationStyle, bioStyle, slStyle]);

        var colorStyle = element.params.get('iconStyle', 'brand');

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
            Name Styling
        */

        // Name Color and Space
        titleStyle.addCss('color', element.params.get('nameColor', ''));

        let nameSpacing = element.params.get('nameSpacing', null);
        if (nameSpacing != null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if ((_deviceObj.key in nameSpacing) && JDBRenderer.Helper.checkSliderValue(nameSpacing[_deviceObj.key])) {
                    titleStyle.addCss("margin-top", nameSpacing[_deviceObj.key].value + 'px', _deviceObj.type);
                }
            });
        }

        // Name Typography
        var typography = element.params.get('nameTypography', null);
        if (typography !== null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in typography) {
                    titleStyle.addStyle(JDBRenderer.Helper.typographyValue(typography[_deviceObj.key]), _deviceObj.type);
                }
            });
        }

        /*
            Designation Styling
        */

        // Designation Color and Space
        designationStyle.addCss('color', element.params.get('designationColor', ''));

        let designationSpacing = element.params.get('designationSpacing', null);
        if (designationSpacing != null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if ((_deviceObj.key in designationSpacing) && JDBRenderer.Helper.checkSliderValue(designationSpacing[_deviceObj.key])) {
                    designationStyle.addCss("margin-top", designationSpacing[_deviceObj.key].value + 'px', _deviceObj.type);
                }
            });
        }

        // Designation Typography
        var typography = element.params.get('designationTypography', null);
        if (typography !== null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in typography) {
                    designationStyle.addStyle(JDBRenderer.Helper.typographyValue(typography[_deviceObj.key]), _deviceObj.type);
                }
            });
        }

        /*
            Bio Styling
        */

        // Bio Color and Space
        bioStyle.addCss('color', element.params.get('bioColor', ''));

        let bioSpacing = element.params.get('bioSpacing', null);
        if (bioSpacing != null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if ((_deviceObj.key in bioSpacing) && JDBRenderer.Helper.checkSliderValue(bioSpacing[_deviceObj.key])) {
                    bioStyle.addCss("margin-top", bioSpacing[_deviceObj.key].value + 'px', _deviceObj.type);
                }
            });
        }

        // Bio Typography
        var typography = element.params.get('bioTypography', null);
        if (typography !== null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in typography) {
                    bioStyle.addStyle(JDBRenderer.Helper.typographyValue(typography[_deviceObj.key]), _deviceObj.type);
                }
            });
        }


        /* Social Links Styling */

        let slSpacing = element.params.get('slSpacing', null);
        if (slSpacing != null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if ((_deviceObj.key in slSpacing) && JDBRenderer.Helper.checkSliderValue(slSpacing[_deviceObj.key])) {
                    slStyle.addCss("margin-top", slSpacing[_deviceObj.key].value + 'px', _deviceObj.type);
                }
            });
        }

        var slAlignment = element.params.get('slAlignment', null);
        if (slAlignment != null) {
            if (typeof slAlignment != 'string') {
                JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                    if (_deviceObj.key in slAlignment) {
                        slStyle.addCss("text-align", slAlignment[_deviceObj.key], _deviceObj.type);
                    }
                });
            }
        }

        var linkStyle = new JDBRenderer.ElementStyle(".jdb-social-links > ul li a");
        var linkHoverStyle = new JDBRenderer.ElementStyle(".jdb-social-links > ul li:hover a");

        element.addChildrenStyle([linkStyle, linkHoverStyle]);


        var borderRadius = element.params.get('slBorderRadius', null);
        if (borderRadius !== null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in borderRadius) {
                    linkStyle.addStyle(JDBRenderer.Helper.spacingValue(borderRadius[_deviceObj.key], "radius"), _deviceObj.type);
                }
            });
        }


        var padding = element.params.get('innerPadding', null);
        if (padding !== null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in padding) {
                    linkStyle.addCss("padding", padding[_deviceObj.key].value + 'px', _deviceObj.type);
                }
            });
        }

        let itemSpaceBetween = element.params.get('slSpaceBetween', null);
        if (itemSpaceBetween != null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if ((_deviceObj.key in itemSpaceBetween) && JDBRenderer.Helper.checkSliderValue(itemSpaceBetween[_deviceObj.key])) {
                    linkStyle.addCss("margin-right", itemSpaceBetween[_deviceObj.key].value + 'px', _deviceObj.type);
                }
            });
        }


        let itemBorderStyle = element.params.get('slBorderStyle', 'none');
        linkStyle.addCss("border-style", itemBorderStyle);
        if (itemBorderStyle != 'none') {
            let borderWidth = element.params.get('slBorderWidth', null);
            if (borderWidth !== null) {
                JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                    if (_deviceObj.key in borderWidth) {
                        linkStyle.addStyle(JDBRenderer.Helper.spacingValue(borderWidth[_deviceObj.key], "border"), _deviceObj.type);
                    }
                });
            }
        }


        var invertedColors = element.params.get('brandColorInverted', false);

        linkStyle.addCss("box-shadow", element.params.get('slBoxShadow', ''));
        if (colorStyle != "brand") {
            linkStyle.addCss("color", element.params.get('slColor', ''));
        }
        if (!(colorStyle == "brand" && invertedColors)) {
            linkHoverStyle.addCss("color", element.params.get('slHoverColor', ''));
        }
        if (colorStyle != "brand") {
            linkStyle.addCss("background-color", element.params.get('slBackgroundColor', ''));
        }
        if (!(colorStyle == "brand" && invertedColors)) {
            linkHoverStyle.addCss("background-color", element.params.get('slHoverBackgroundColor', ''));
        }
        if (colorStyle != "brand") {
            linkStyle.addCss("border-color", element.params.get('slBorderColor', ''));
        }
        if (!(colorStyle == "brand" && invertedColors)) {
            linkHoverStyle.addCss("border-color", element.params.get('slBorderHoverColor', ''));
        }
        var iconStyle = JDBRenderer.ElementStyle(".jdb-social-links > ul li a .jdb-sl-icon");
        element.addChildStyle(iconStyle);
        var iconSize = element.params.get('iconSize', null);
        if (iconSize !== null && typeof iconSize == 'object') {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if ((_deviceObj.key in iconSize) && JDBRenderer.Helper.checkSliderValue(iconSize[_deviceObj.key])) {
                    iconStyle.addCss("font-size", iconSize[_deviceObj.key].value + 'px', _deviceObj.type);
                    iconStyle.addCss("width", iconSize[_deviceObj.key].value + 'px', _deviceObj.type);
                    iconStyle.addCss("height", iconSize[_deviceObj.key].value + 'px', _deviceObj.type);
                }
            });
        }
        /* Social Links Styling End */

    }

    window.JDBuilderElementTeam = JDBuilderElementTeam;

})();