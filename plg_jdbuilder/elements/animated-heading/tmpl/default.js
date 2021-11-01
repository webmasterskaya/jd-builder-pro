(function () {

   var JDBuilderElementAnimatedHeading = function (element) {
      // Params
      var texts = element.params.get('texts', []);
      var stringtexts = [];
      texts.forEach(function (text) {
         if (text.text != '') {
            stringtexts.push(text.text);
         }
      });

      _html = [];
      _html.push('<div jdb-animatedheading="' + ('before:' + element.params.get("before", "") + ';after:' + element.params.get("after", "") + ';texts:' + stringtexts.join(',') + ';tag:' + element.params.get("headingHtmlTag", "h3") + ';link:' + element.params.get("link", "") + ';linkTargetBlank:' + element.params.get('linkTargetBlank', false) + ';linkNoFollow:' + element.params.get('linkNoFollow', false) + ';animation:' + element.params.get('rotatingAnimation', 'letters type')) + '"></div>');

      var alignment = element.params.get('headingAlignment', null);
      if (alignment !== null && typeof alignment == 'object') {
         JDBRenderer.DEVICES.forEach(function (_deviceObj) {
            if (_deviceObj.key in alignment) {
               element.addCss('text-align', alignment[_deviceObj.key], _deviceObj.type);
            }
         });
      }

      headingStyles(element);

      return _html.join('');
   };

   function headingStyles(element) {
      var _style = JDBRenderer.ElementStyle(".cd-headline");
      var _animatedtTextstyle = JDBRenderer.ElementStyle(".cd-words-wrapper");
      var _animatedtTextstyleLetter = JDBRenderer.ElementStyle(".cd-words-wrapper b i");
      element.addChildStyle(_style);
      element.addChildStyle(_animatedtTextstyle);
      element.addChildStyle(_animatedtTextstyleLetter);
      _style.addCss("color", element.params.get("headingFontColor", ""));
      _animatedtTextstyle.addCss("color", element.params.get("animatedTextColor", ""));
      _style.addCss("text-shadow", element.params.get("headingTextShadow", ""));

      var typography = element.params.get("headingTypography", null);
      if (typography !== null) {
         JDBRenderer.DEVICES.forEach(function (_deviceObj) {
            if (_deviceObj.key in typography) {
               _style.addStyle(JDBRenderer.Helper.typographyValue(typography[_deviceObj.key]), _deviceObj.type);
            }
         });
      }

      var typography = element.params.get("animatedTextTypography", null);
      if (typography !== null) {
         JDBRenderer.DEVICES.forEach(function (_deviceObj) {
            if (_deviceObj.key in typography) {
               _animatedtTextstyle.addStyle(JDBRenderer.Helper.typographyValue(typography[_deviceObj.key]), _deviceObj.type);
               _animatedtTextstyleLetter.addStyle(JDBRenderer.Helper.typographyValue(typography[_deviceObj.key]), _deviceObj.type);
            }
         });
      }
   }

   window.JDBuilderElementAnimatedHeading = JDBuilderElementAnimatedHeading;

})();