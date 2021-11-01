(function () {

    var JDBuilderElementFacebookPage = function (element) {
        element.addClass('jdb-facebook-page');

        var html = [];

        // params
        var fbAppId = _JDBFBAPPID;
        var pageUrl = element.params.get('fbPageUrl', '');
        var layout = element.params.get('fbLayout', []);
        var header = element.params.get('smallHeader', true);
        var cover = element.params.get('coverPhoto', true);
        var facepile = element.params.get('facepile', true);
        var cta = element.params.get('cta', true);
        var width = element.params.get('fbWidth', {
            value: 340
        });
        var height = element.params.get('fbHeight', {
            value: 500
        });

        if (pageUrl == '') {
            return '';
        }

        return '<iframe src="https://www.facebook.com/plugins/page.php?href=' + encodeURI(pageUrl) + '&tabs=' + layout.join(',') + '&width=' + width.value + '&height=' + height.value + '&small_header=' + (header ? 'true' : 'false') + '&adapt_container_width=true&hide_cover=' + (cover ? 'false' : 'true') + '&show_facepile=' + (facepile ? 'true' : 'false') + '&hide_cta=' + (cta ? 'false' : 'true') + (fbAppId != '' ? ('&appId=' + fbAppId) : '') + '" width="' + width.value + '" height="' + height.value + '" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>';
    };

    window.JDBuilderElementFacebookPage = JDBuilderElementFacebookPage;

})();