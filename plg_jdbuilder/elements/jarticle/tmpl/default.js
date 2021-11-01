(function () {

    var JDBuilderElementJarticle = function (element) {
        var item = {};
        var _data = _JDBDATA.get(element.id);
        if (_data === undefined) {
            item = {};
        } else if (_data === null) {
            item = {};
        } else {
            item = _data;
        }
        var id = element.params.get('articleId', 0);
        var dateFormat = element.params.get('metaDateFormat', 'd M, Y');

        return '<div class="jdb-jarticles-live-preview"><div jdb-loader></div><div jdb-jarticle="eid:' + element.id + ';id:' + id + ';format:' + dateFormat + '">' + render(element, item) + '</div></div>';
    }

    function render(element, item) {
        if (!('id' in item)) {
            return '';
        }
        element.addClass('jdb-joomla-article');
        _html = [];
        _meta = [];

        /* Meta Info */
        var articleMetaData = element.params.get('articleMetaData', []);
        var mIcon = element.params.get('articleMetaIcons', true);
        if (articleMetaData.length) {
            _meta.push('<div class="jdb-jarticle-meta-info">');

            // author
            if (articleMetaData.indexOf('author') > -1) {
                _meta.push('<span class="jdb-jarticle-author">');
                if (mIcon) {
                    _meta.push('<i class="far fa-user"></i>');
                }
                _meta.push(item.author);
                _meta.push('</span>');
            }

            // category
            if (articleMetaData.indexOf('category') > -1) {
                _meta.push('<span class="jdb-jarticle-category">');
                if (mIcon) {
                    _meta.push('<i class="far fa-folder"></i>');
                }
                _meta.push(item.category_title);
                _meta.push('</span>');
            }

            // published date
            if (articleMetaData.indexOf('publish-date') > -1) {
                _meta.push('<span class="jdb-jarticle-published-date">');
                if (mIcon) {
                    _meta.push('<i class="far fa-calendar-check"></i>');
                }
                _meta.push('Published On: ' + item.published_formatted);
                _meta.push('</span>');
            }

            // created date
            if (articleMetaData.indexOf('created-date') > -1) {
                _meta.push('<span class="jdb-jarticle-created-date">');
                if (mIcon) {
                    _meta.push('<i class="far fa-calendar-plus"></i>');
                }
                _meta.push('Created On: ' + item.created_formatted);
                _meta.push('</span>');
            }

            // modified date
            if (articleMetaData.indexOf('modified-date') > -1) {
                _meta.push('<span class="jdb-jarticle-modified-date">');
                if (mIcon) {
                    _meta.push('<i class="far fa-calendar-alt"></i>');
                }
                _meta.push('Modified On: ' + item.modified_formatted);
                _meta.push('</span>');
            }

            // hits
            if (articleMetaData.indexOf('hits') > -1) {
                _meta.push('<span class="jdb-jarticle-hits">');
                if (mIcon) {
                    _meta.push('<i class="far fa-eye"></i>');
                }
                _meta.push('Hits: ' + item.hits);
                _meta.push('</span>');
            }

            _meta.push('</div>');
        }
        /* Meta Info */

        _meta = _meta.join('');

        var articleImage = '';
        if (element.params.get('showImage', true) && item.imageSrc != '') {
            articleImage = '<img class="jdb-jarticle-image" src="' + item.imageSrc + '" alt="' + item.title + '">';
        }

        if (element.params.get('imagePosition', 'above') === 'above') {
            _html.push(articleImage);
        }
        if (element.params.get('metaPosition', 'below') === 'above') {
            _html.push(_meta);
        }
        if (element.params.get('showTitle', true)) {
            var titleTag = element.params.get('titleHtmlTag', 'h2');
            _html.push('<' + titleTag + ' class="jdb-jarticle-title">' + item.title + '</' + titleTag + '>');
        }
        if (element.params.get('metaPosition', 'below') === 'below') {
            _html.push(_meta);
        }
        if (element.params.get('imagePosition', 'above') === 'below') {
            _html.push(articleImage);
        }

        _html.push('<div class="jdb-jarticle-fulltext">');
        _html.push(item.text);
        _html.push('</div>');

        if (element.params.get('showTags', true) && item.tags.length) {
            _html.push('<div class="jdb-jarticle-tags">');
            item.tags.forEach(function (_tag) {
                _html.push('<a href="' + _tag.link + '">' + _tag.title + '</a>');
            });
            _html.push('</div>');
        }
        _html = _html.join('');
        elementStyling(element);
        return _html;
    }

    function elementStyling(element) {
        var metaStyle = new JDBRenderer.ElementStyle(".jdb-jarticle-meta-info");
        var metaTitleStyle = new JDBRenderer.ElementStyle(".jdb-jarticle-meta-info span:not(:last-child)");
        var metaIconStyle = new JDBRenderer.ElementStyle(".jdb-jarticle-meta-info span i");
        var titleStyle = new JDBRenderer.ElementStyle(".jdb-jarticle-title");
        var contentStyle = new JDBRenderer.ElementStyle(".jdb-jarticle-fulltext");
        var tagStyle = new JDBRenderer.ElementStyle(".jdb-jarticle-tags > a");
        var tagHoverStyle = new JDBRenderer.ElementStyle(".jdb-jarticle-tags > a:hover");

        element.addChildrenStyle([metaStyle, metaTitleStyle, metaIconStyle, titleStyle, contentStyle, tagStyle, tagHoverStyle]);

        // meta styling
        metaStyle.addCss('color', element.params.get('metaColor', ''));
        metaIconStyle.addCss('color', element.params.get('metaIconColor', ''));

        var spacing = element.params.get('metaSpacing', null);
        if (spacing !== null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if ((_deviceObj.key in spacing) && JDBRenderer.Helper.checkSliderValue(spacing[_deviceObj.key])) {
                    metaTitleStyle.addCss('margin-right', spacing[_deviceObj.key].value + 'px', _deviceObj.type);
                }
            });
        }

        var margin = element.params.get('metaMargin', null);
        if (margin != null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in margin) {
                    metaStyle.addStyle(JDBRenderer.Helper.spacingValue(margin[_deviceObj.key], "margin"), _deviceObj.type);
                }
            });
        }

        var typography = element.params.get('metaTypography', null);
        if (typography !== null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in typography) {
                    metaStyle.addStyle(JDBRenderer.Helper.typographyValue(typography[_deviceObj.key]), _deviceObj.type);
                    if ('alignment' in typography[_deviceObj.key] && typography[_deviceObj.key].alignment != '') {
                        var justifyContent = typography[_deviceObj.key].alignment;
                        var justifyContent = justifyContent == 'left' ? 'flex-start' : (justifyContent == 'right' ? 'flex-end' : (justifyContent == 'center' ? 'center' : (justifyContent == 'justify' ? 'space-between' : '')));
                        metaStyle.addCss('justify-content', justifyContent, _deviceObj.type);
                    }
                }
            });
        }

        // title & content styling
        titleStyle.addCss('color', element.params.get('titleColor', ''));
        contentStyle.addCss('color', element.params.get('contentColor', ''));

        var typography = element.params.get('titleTypography', null);
        if (typography !== null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in typography) {
                    titleStyle.addStyle(JDBRenderer.Helper.typographyValue(typography[_deviceObj.key]), _deviceObj.type);
                }
            });
        }

        var typography = element.params.get('contentTypography', null);
        if (typography !== null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in typography) {
                    contentStyle.addStyle(JDBRenderer.Helper.typographyValue(typography[_deviceObj.key]), _deviceObj.type);
                }
            });
        }

        var margin = element.params.get('titleMargin', null);
        if (margin != null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in margin) {
                    titleStyle.addStyle(JDBRenderer.Helper.spacingValue(margin[_deviceObj.key], "margin"), _deviceObj.type);
                }
            });
        }

        var margin = element.params.get('contentMargin', null);
        if (margin != null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in margin) {
                    contentStyle.addStyle(JDBRenderer.Helper.spacingValue(margin[_deviceObj.key], "margin"), _deviceObj.type);
                }
            });
        }

        // tag styling
        tagStyle.addCss('color', element.params.get('tagColor', ''));
        tagStyle.addCss('background-color', element.params.get('tagBackgroundColor', ''));

        var typography = element.params.get('tagTypography', null);
        if (typography !== null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in typography) {
                    tagStyle.addStyle(JDBRenderer.Helper.typographyValue(typography[_deviceObj.key]), _deviceObj.type);
                }
            });
        }

        var padding = element.params.get('tagPadding', null);
        if (padding != null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in padding) {
                    tagStyle.addStyle(JDBRenderer.Helper.spacingValue(padding[_deviceObj.key], "padding"), _deviceObj.type);
                }
            });
        }

        let tagSpacing = element.params.get('tagSpacing', null);
        if (tagSpacing != null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if ((_deviceObj.key in tagSpacing) && JDBRenderer.Helper.checkSliderValue(tagSpacing[_deviceObj.key])) {
                    tagStyle.addCss("margin-left", tagSpacing[_deviceObj.key].value + 'px', _deviceObj.type);
                }
            });
        }


        JDBRenderer.Helper.applyBorderValue(tagStyle, element.params, "tagBorder");

        tagHoverStyle.addCss('color', element.params.get('tagHoverColor', ''));
        tagHoverStyle.addCss('background-color', element.params.get('tagHoverBackground', ''));
        JDBRenderer.Helper.applyBorderValue(tagHoverStyle, element.params, "tagHoverBorder");
    }

    window.JDBuilderElementJarticle = JDBuilderElementJarticle;

})();