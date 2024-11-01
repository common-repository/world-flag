<?php asort($this->ar_countries); ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>Insert Country Flag</title>
    <link type="text/css" rel="stylesheet" href="<?php echo $this->pluginDir; ?>/assets/flags.css" />
    <script language="javascript" type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/jquery/jquery.js"></script>
    <script language="javascript" type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
    <script language="javascript" type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/tinymce/utils/mctabs.js"></script>
    <script language="javascript" type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
    <script language="javascript" type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
    <script language="javascript" type="text/javascript">
    jQuery(document).ready(function($) {
        var _self = tinyMCEPopup;
        $('#wpwrap .country').on('click', function(e) {
            e.preventDefault();
            var country = $(this).attr('data-cid');
            var tag = '[flag country="' + country + '"]';
            if (typeof window.tinyMCE != 'undefined') {
                var tmce_ver = window.tinyMCE.majorVersion;
                if (tmce_ver >= "4") {
                    _self.execCommand('mceInsertContent', false, tag);
                } else {
                    _self.execInstanceCommand('content', 'mceInsertContent', false, tag);
                }
                _self.execCommand('mceRepaint');
                _self.close();
            }
        });
        $('#closeMCE').click(function(e) {
            e.preventDefault();
            tinyMCEPopup.close();
        })
    });
    </script>
    <style type="text/css">
    .countries-wrap {
        background:#EEE;
    }
    .countries-wrap .country {
        width:45%;
        float:left;
        padding:3px;
        cursor:pointer;
        -moz-border-radius: 2px;
        -webkit-border-radius: 2px;
        -ms-border-radius: 2px;
        border-radius: 2px;
    }
    .countries-wrap .country:hover {
        background:#DDD;
    }
    .countries-wraps:after {
        content:"";
        clear:both;
        display:block;
        width:100%;
    }
    </style>
</head>

<body>
    <div id="wpwrap">
        <div class="countries-wrap">
            <?php foreach($this->ar_countries as $code=>$name){ ?>
            <div class="country country-<?php strtolower($code); ?>" data-cid="<?php echo strtolower($code); ?>">
                <img src="<?php echo $this->pluginDir; ?>assets/blank.gif" class="flag flag-<?php echo strtolower($code); ?>" />
                <?php echo ucwords(strtolower($name)); ?>
            </div>
            <?php } ?>
        </div>
    </div>
</body>

</html>
