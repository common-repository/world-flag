/**
 * World Flag TinyMCE Plugin
 * @author Sovit Tamrakar
 */

(function() {
    // Load plugin specific language pack
    tinymce.PluginManager.requireLangPack("worldflag");
    tinymce.create('tinymce.plugins.WorldFlag', {
        init: function(ed, url) {
            var t = this;
            t.plugin_url=url;
            ed.addCommand('worldflag', function() {
                ed.windowManager.open({
                    file: ajaxurl + "?action=wppress_worldflag_dialog",
                    width: 600,
                    height: 400,
                    inline: 1
                }, {
                    plugin_url: url // Plugin absolute URL
                });
            });

            // Register example button
            ed.addButton('worldflag', {
                title: 'worldflag.desc',
                cmd: 'worldflag',
                image: url + '/icon.png'
            });
            ed.onBeforeSetContent.add(function(ed, o) {
                o.content = t._do_visual(o.content);
            });
            ed.onPostProcess.add(function(ed, o) {
                if (o.get)
                    o.content = t._get_shortcode(o.content);
            });
        },
        createControl: function(n, cm) {
            return null;
        },
        getInfo: function() {
            return {
                longname: 'World Flag',
                author: 'Sovit Tamrakar',
                authorurl: 'http://ssovit.com',
                infourl: 'http://ssovit.com',
                version: "1.0"
            };
        },
        _do_visual: function(co) {
        	var t=this;
            return co.replace(/\[flag([^\]]*)\]/g, function(a, b) {
            	var country=(tinymce.DOM.decode(b)).match(/country=(?:\")([^\"]+)(?:\")/im);
            	var the_country=false;
            	if(country!=null){
            		the_country=country[1];
            	}
            	console.log(the_country);
                return '<img src="' + t.plugin_url + '/blank.gif" class="wppress-flag flag '+(the_country!=false?'flag-'+the_country:'')+' mceItem" title="flag' + tinymce.DOM.encode(b) + '" data-mce-resize="false" data-mce-placeholder="1" />';
            });
        },
        _get_shortcode: function(co) {
            function getAttr(s, n) {
                n = new RegExp(n + '=\"([^\"]+)\"', 'g').exec(s);
                return n ? tinymce.DOM.decode(n[1]) : '';
            };

            return co.replace(/(<img[^>]+>)*/g, function(a, im) {
                var cls = getAttr(im, 'class');

                if (cls.indexOf('wppress-flag') != -1)
                    return '[' + tinymce.trim(getAttr(im, 'title')) + ']';

                return a;
            });
        },
    });

    // Register plugin
    tinymce.PluginManager.add('worldflag', tinymce.plugins.WorldFlag);
})();
