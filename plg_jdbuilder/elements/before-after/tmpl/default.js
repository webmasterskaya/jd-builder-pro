(function () {

    var JDBuilderElementBeforeAfter = function (element) {

        var beforeImage = element.params.get('beforeImage', '');
        var afterImage = element.params.get('afterImage', '');
        if (beforeImage == '' || afterImage == '') {
            return;
        }
        var uKey = elementStyles(element);

        element.addClass('jdb-beforeafter-element');

        var html = [];

        var overlayDisplay = element.params.get('overlayDisplay', 'hover');
        var defaultOffset = element.params.get('defaultOffset', {
            "value": 0.7,
            "unit": "#"
        });
        var beforeDirection = (element.params.get('orientation', 'horizontal') === 'vertical') ? 'down' : 'left';
        var afterDirection = (element.params.get('orientation', 'horizontal') === 'vertical') ? 'up' : 'right';
        html.push('<div class="jdb-beforeafter-wrapper jdb-beforeafter-' + element.params.get('orientation', 'horizontal') + '">');
        html.push('<div jdb-before-after="ukey:' + JDBRenderer.Helper.hashCode(uKey.join('')) + ';overlay:' + overlayDisplay + ';moveSliderOnHover:' + (element.params.get('moveSliderOnHover', false) ? 'true' : 'false') + ';orientation:' + element.params.get('orientation', 'horizontal') + ';defaultOffset:' + defaultOffset.value + '" class="jdb-beforeafter-container">');

        if (overlayDisplay != 'never') {
            html.push('<div class="jdb-beforeafter-overlay' + (overlayDisplay == 'always' ? ' hovered' : '') + '"><div class="jdb-beforeafter-before-label" data-content="' + element.params.get('beforeLabel', '') + '"></div><div class="jdb-beforeafter-after-label" data-content="' + element.params.get('afterLabel', '') + '"></div></div>');
        }

        html.push('<img class="jdb-beforeafter-before" alt="' + element.params.get('beforeAlt', '') + '" src="' + JDBRenderer.Helper.mediaValue(beforeImage) + '" />');
        html.push('<img class="jdb-beforeafter-after" alt="' + element.params.get('afterAlt', '') + '" src="' + JDBRenderer.Helper.mediaValue(afterImage) + '" />');

        html.push('<div class="jdb-beforeafter-handle"><span class="jdb-beforeafter-' + beforeDirection + '-arrow"></span><span class="jdb-beforeafter-' + afterDirection + '-arrow"></span></div>');

        html.push('</div>');
        html.push('</div>');



        return html.join('');
    };

    function elementStyles(element) {
        var ukey = [];
        var wrapperStyle = new JDBRenderer.ElementStyle('.jdb-beforeafter-wrapper');
        var handleStyle = new JDBRenderer.ElementStyle('.jdb-beforeafter-handle');
        var handleStyleBefore = new JDBRenderer.ElementStyle('.jdb-beforeafter-handle:before');
        var handleStyleAfter = new JDBRenderer.ElementStyle('.jdb-beforeafter-handle:after');
        var handleStyleLeft = new JDBRenderer.ElementStyle('.jdb-beforeafter-left-arrow');
        var handleStyleUp = new JDBRenderer.ElementStyle('.jdb-beforeafter-up-arrow');
        var handleStyleRight = new JDBRenderer.ElementStyle('.jdb-beforeafter-right-arrow');
        var handleStyleDown = new JDBRenderer.ElementStyle('.jdb-beforeafter-down-arrow');

        element.addChildrenStyle([wrapperStyle, handleStyle, handleStyleBefore, handleStyleAfter, handleStyleLeft, handleStyleRight, handleStyleUp, handleStyleDown]);

        handleStyle.addCss('border-color', element.params.get('handleColor', ''));
        handleStyleBefore.addCss('box-shadow', '0 3px 0 ' + element.params.get('handleColor', '#fff') + ', 0px 0px 12px rgba(51, 51, 51, 0.5)');
        handleStyleBefore.addCss('background', element.params.get('handleColor', '#fff'));
        handleStyleAfter.addCss('box-shadow', '0 -3px 0 ' + element.params.get('handleColor', '#fff') + ', 0px 0px 12px rgba(51, 51, 51, 0.5)');
        handleStyleAfter.addCss('background', element.params.get('handleColor', '#fff'));
        handleStyleLeft.addCss('border-right-color', element.params.get('handleColor', ''));
        handleStyleUp.addCss('border-bottom-color', element.params.get('handleColor', ''));
        handleStyleRight.addCss('border-left-color', element.params.get('handleColor', ''));
        handleStyleDown.addCss('border-top-color', element.params.get('handleColor', ''));

        var width = element.params.get('sliderWidth', null);
        if (width != null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if ((_deviceObj.key in width)) {
                    wrapperStyle.addCss('width', width[_deviceObj.key].value + width[_deviceObj.key].unit, _deviceObj.type);
                    ukey.push(width[_deviceObj.key].value + width[_deviceObj.key].unit);
                }
            });
        }

        var alignment = element.params.get('sliderAlignment', null);
        if (alignment != null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if ((_deviceObj.key in alignment)) {
                    var margin = alignment[_deviceObj.key] == 'left' ? 'margin-right' : (alignment[_deviceObj.key] == 'right' ? 'margin-left' : 'margin');
                    wrapperStyle.addCss(margin, 'auto', _deviceObj.type);
                    ukey.push(margin);
                }
            });
        }
        return ukey;
    }

    window.JDBuilderElementBeforeAfter = JDBuilderElementBeforeAfter;

})();