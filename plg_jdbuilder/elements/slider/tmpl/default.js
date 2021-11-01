(function () {

    var JDBuilderElementSlider = function (element) {
        element.addClass('jdb-slider-element');

        var html = [];
        var options = [];

        var slides = element.params.get('slides', []);
        var sliderHeight = element.params.get('sliderHeight', 'auto');

        if (sliderHeight == 'custom') {
            var sliderHeightValue = element.params.get('sliderHeightValue', {
                "value": 400,
                "unit": 'px'
            });
            options.push('max-height:' + sliderHeightValue.value);
        } else {
            options.push('ratio:' + sliderHeight);
        }

        options.push('finite:' + ((element.params.get('infinite', true) ? 'false' : 'true')));
        options.push('draggable:' + ((element.params.get('draggable', true) ? 'true' : 'false')));
        options.push('autoplay:' + ((element.params.get('autoplay', true) ? 'true' : 'false')));
        options.push('pause-on-hover:' + ((element.params.get('pauseOnHover', true) ? 'true' : 'false')));

        var autoplayInterval = element.params.get('autoplayInterval', {
            "value": 7000,
            "unit": "#"
        });

        if (!JDBRenderer.Helper.empty(autoplayInterval.value)) {
            options.push('autoplay-interval:' + autoplayInterval.value);
        }

        options.push('animation:' + (element.params.get('sliderAnimation', 'slide')));

        html.push('<div class="jdb-position-relative" tabindex="-1" jdb-slideshow="' + (options.join(';')) + '"><ul class="jdb-slideshow-items">');

        slides.forEach(function (slide, index) {
            var background = slide.background;
            var backgroundOverlayColor = slide.backgroundOverlayColor;

            html.push('<li>');
            html.push('<div class="jdb-slideshow-item-' + index + ' jdb-slideshow-item' + (background == 'video' ? ' jdb-has-video-background' : '') + '"><div class="jdb-slideshow-item-inner' + (slide.mediaPosition == 'right' ? ' jdb-flex-row-reverse' : '') + (((background == 'image' || background == 'video') && !JDBRenderer.Helper.empty(backgroundOverlayColor)) ? ' jdb-has-overlay' : '') + '">');

            if (slide.media != 'none') {
                html.push('<div class="jdb-slideshow-media jdb-d-flex jdb-justify-center jdb-align-items-' + ((slide.mediaVPosition == undefined) ? 'center' : slide.mediaVPosition) + '">');
                if (slide.media == 'image') {
                    html.push('<img src="' + JDBRenderer.Helper.mediaValue(slide.image) + '" alt="' + slide.altText + '">');
                }
                if (slide.media == 'video' && !JDBRenderer.Helper.empty(slide.video)) {
                    html.push('<div class="jdb-video jdb-embed-responsive jdb-embed-responsive-16by9">' + JDBRenderer.Helper.videoValue(slide.video) + '</div>');
                }
                html.push('</div>');
            }

            if (slide.preTitle != '' || slide.title != '' || slide.description != '' || slide.buttonText != '' || slide.secondaryButtonText != '') {
                html.push('<div class="jdb-slideshow-content jdb-d-flex jdb-justify-center jdb-align-items-' + slide.contentVPosition + '"><div class="p-3">');
                if (slide.preTitle != '') {
                    html.push('<div class="jdb-slideshow-pretitle">' + slide.preTitle + '</div>');
                }
                if (slide.title != '') {
                    html.push('<h3 class="jdb-slideshow-title">' + slide.title + '</h3>');
                }
                if (slide.description != '') {
                    html.push('<p class="jdb-slideshow-description">' + slide.description + '</p>');
                }
                if (slide.buttonText != '' || slide.secondaryButtonText != '') {
                    var alignment = slide.sliderButtonAlignment != undefined ? ' ' + slide.sliderButtonAlignment : ' center';
                    html.push('<div class="jdb-slideshow-buttons' + alignment + '">');
                    if (slide.buttonText != '') {
                        html.push(JDBRenderer.Helper.renderButtonValue('primaryButton', element, slide.buttonText, [], 'link', slide.link, slide.linkTargetBlank, slide.linkNoFollow));
                    }
                    if (slide.secondaryButtonText != '') {
                        html.push(JDBRenderer.Helper.renderButtonValue('secondaryButton', element, slide.secondaryButtonText, [], 'link', slide.secondaryLink, slide.secondaryLinkTargetBlank, slide.secondaryLinkNoFollow));
                    }
                    html.push('</div>');
                }
                html.push('</div>');
                html.push('</div>');
            }
            var slideStyle = new JDBRenderer.ElementStyle(".jdb-slideshow-item-" + index);
            var overlayCSS = new JDBRenderer.ElementStyle(".jdb-slideshow-item-" + index + " .jdb-slideshow-item-inner::after");
            var contentCSS = new JDBRenderer.ElementStyle(".jdb-slideshow-item-" + index + " .jdb-slideshow-content");
            element.addChildrenStyle([slideStyle, overlayCSS, contentCSS]);

            var backgroundOverlayOpacity = slide.backgroundOverlayOpacity;
            backgroundOverlayOpacity = JDBRenderer.Helper.empty(backgroundOverlayOpacity) ? {
                value: 50,
                unit: '%'
            } : backgroundOverlayOpacity;

            if (JDBRenderer.Helper.checkSliderValue(backgroundOverlayOpacity)) {
                overlayCSS.addCss('opacity', (backgroundOverlayOpacity.value / 100));
            }

            if (!JDBRenderer.Helper.empty(backgroundOverlayColor)) {
                overlayCSS.addCss('background-color', backgroundOverlayColor);
            }

            var width = slide.contentWidth;
            if (width != null) {
                JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                    if ((_deviceObj.key in width) && JDBRenderer.Helper.checkSliderValue(width[_deviceObj.key])) {
                        const widthVal = '0 0 ' + width[_deviceObj.key].value + width[_deviceObj.key].unit;
                        contentCSS.addCss('-ms-flex', widthVal, _deviceObj.type);
                        contentCSS.addCss('flex', widthVal, _deviceObj.type);
                        contentCSS.addCss('max-width', width[_deviceObj.key].value + width[_deviceObj.key].unit, _deviceObj.type);
                    }
                });
            }

            contentCSS.addCss('text-align', slide.contentAlignment);
            if (slide.media == 'none') {
                contentCSS.addCss(slide.contentHPosition, 'auto');
            }
            if (slide.contentHPosition == 'margin' && slide.contentVPosition == 'start') {
                contentCSS.addCss('margin-top', 0);
            }

            if (slide.contentHPosition == 'margin' && slide.contentVPosition == 'end') {
                contentCSS.addCss('margin-bottom', 0);
            }

            switch (background) {
                case 'color':
                    var backgroundColor = slide.backgroundColor;
                    if (!JDBRenderer.Helper.empty(backgroundColor)) {
                        slideStyle.addCss('background-color', backgroundColor);
                    }
                    break;
                case 'image':
                    backgroundColor = slide.backgroundColor;
                    if (!JDBRenderer.Helper.empty(backgroundColor)) {
                        slideStyle.addCss('background-color', backgroundColor);
                    }
                    var backgroundImage = slide.backgroundImage;
                    if (!JDBRenderer.Helper.empty(backgroundImage)) {
                        slideStyle.addCss('background-image', 'url(' + JDBRenderer.Helper.mediaValue(backgroundImage) + ')');
                        var backgroundRepeat = slide.backgroundRepeat;
                        if (!JDBRenderer.Helper.empty(backgroundRepeat)) {
                            slideStyle.addCss('background-repeat', backgroundRepeat);
                        }
                        var backgroundSize = slide.backgroundSize;
                        if (!JDBRenderer.Helper.empty(backgroundSize)) {
                            slideStyle.addCss('background-size', backgroundSize);
                        }
                        var backgroundAttachment = slide.backgroundAttachment;
                        if (!JDBRenderer.Helper.empty(backgroundAttachment)) {
                            slideStyle.addCss('background-attachment', backgroundAttachment);
                        }
                        var backgroundPosition = slide.backgroundPosition;
                        if (!JDBRenderer.Helper.empty(backgroundPosition)) {
                            slideStyle.addCss('background-position', backgroundPosition);
                        }
                    }
                    break;
                case 'video':
                    html.push('<div class="jdb-video-background" jdb-video="url:' + JDBRenderer.Helper.mediaValue(slide.backgroundVideoMedia) + ';autoplay:true;muted:true;loop:true;">');
                    html.push('</div>');
                    break;
            }
            html.push('</div>');
            html.push('</li>');
        });
        html.push('</ul>');

        var arrows = element.params.get('arrows', true);
        if (arrows) {
            html.push('<div class="jdb-slider-controls jdb-slider-next jdb-slider-inside"><a href="#" jdb-slidenav-next jdb-slideshow-item="next"><span class="fa fa-chevron-right"></span></a></div><div class="jdb-slider-controls jdb-slider-prev jdb-slider-inside"><a href="#" jdb-slidenav-previous jdb-slideshow-item="previous"><span class="fa fa-chevron-left"></span></a></div>');
        }

        var pagination = element.params.get('pagination', true);
        if (pagination) {
            html.push('<ul class="jdb-slideshow-nav ' + element.params.get('paginationPosition', 'outside') + ' jdb-dotnav"></ul>');
        }

        html.push('</div>');

        elementStyling(element);
        return html.join('');
    }

    function elementStyling(element) {
        var slideInnerStyle = new JDBRenderer.ElementStyle(".jdb-slideshow-item-inner");
        var preTitleStyle = new JDBRenderer.ElementStyle(".jdb-slideshow-pretitle");
        var titleStyle = new JDBRenderer.ElementStyle(".jdb-slideshow-title");
        var descriptionStyle = new JDBRenderer.ElementStyle(".jdb-slideshow-description");
        var arrowStyle = new JDBRenderer.ElementStyle(".jdb-slider-controls > a");
        var paginationStyle = new JDBRenderer.ElementStyle(".jdb-dotnav>*>*");
        var paginationActiveStyle = new JDBRenderer.ElementStyle(".jdb-dotnav>.jdb-active>*");

        element.addChildrenStyle([preTitleStyle, titleStyle, descriptionStyle, arrowStyle, paginationStyle, paginationActiveStyle, slideInnerStyle]);

        var sliderWidth = element.params.get('sliderWidth', 'full');
        if (sliderWidth == 'boxed') {
            var width = element.params.get('sliderWidthValue', null);
            if (width != null) {
                JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                    if ((_deviceObj.key in width) && JDBRenderer.Helper.checkSliderValue(width[_deviceObj.key])) {
                        slideInnerStyle.addCss('max-width', width[_deviceObj.key].value + width[_deviceObj.key].unit, _deviceObj.type);
                    }
                });
            }
        }
        // Pretext
        var spacing = element.params.get('pretextSpacing', null);
        if (spacing != null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if ((_deviceObj.key in spacing) && JDBRenderer.Helper.checkSliderValue(spacing[_deviceObj.key])) {
                    preTitleStyle.addCss('margin-bottom', spacing[_deviceObj.key].value + 'px', _deviceObj.type);
                }
            });
        }

        preTitleStyle.addCss('color', element.params.get('pretextColor', ''));

        var typography = element.params.get('pretextTypography', null);
        if (typography !== null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in typography) {
                    preTitleStyle.addStyle(JDBRenderer.Helper.typographyValue(typography[_deviceObj.key]), _deviceObj.type);
                }
            });
        }

        // title
        var spacing = element.params.get('titleSpacing', null);
        if (spacing != null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if ((_deviceObj.key in spacing) && JDBRenderer.Helper.checkSliderValue(spacing[_deviceObj.key])) {
                    titleStyle.addCss('margin-bottom', spacing[_deviceObj.key].value + 'px', _deviceObj.type);
                }
            });
        }

        titleStyle.addCss('color', element.params.get('titleColor', ''));

        var typography = element.params.get('titleTypography', null);
        if (typography !== null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in typography) {
                    titleStyle.addStyle(JDBRenderer.Helper.typographyValue(typography[_deviceObj.key]), _deviceObj.type);
                }
            });
        }

        // description
        var spacing = element.params.get('descriptionSpacing', null);
        if (spacing != null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if ((_deviceObj.key in spacing) && JDBRenderer.Helper.checkSliderValue(spacing[_deviceObj.key])) {
                    descriptionStyle.addCss('margin-bottom', spacing[_deviceObj.key].value + 'px', _deviceObj.type);
                }
            });
        }

        descriptionStyle.addCss('color', element.params.get('descriptionColor', ''));

        var typography = element.params.get('descriptionTypography', null);
        if (typography !== null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in typography) {
                    descriptionStyle.addStyle(JDBRenderer.Helper.typographyValue(typography[_deviceObj.key]), _deviceObj.type);
                }
            });
        }

        var size = element.params.get('arrowSize', null);
        if (size != null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if ((_deviceObj.key in size) && JDBRenderer.Helper.checkSliderValue(size[_deviceObj.key])) {
                    arrowStyle.addCss("font-size", size[_deviceObj.key].value + 'px', _deviceObj.type);
                }
            });
        }

        arrowStyle.addCss('color', element.params.get('arrowColor', ''));

        var size = element.params.get('paginationSize', null);
        if (size != null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if ((_deviceObj.key in size) && JDBRenderer.Helper.checkSliderValue(size[_deviceObj.key])) {
                    paginationStyle.addCss("width", size[_deviceObj.key].value + 'px', _deviceObj.type);
                    paginationStyle.addCss("height", size[_deviceObj.key].value + 'px', _deviceObj.type);
                }
            });
        }

        paginationStyle.addCss('background-color', element.params.get('paginationColor', ''));
        paginationActiveStyle.addCss('background-color', element.params.get('paginationActiveColor', ''));
    }

    window.JDBuilderElementSlider = JDBuilderElementSlider;

})();