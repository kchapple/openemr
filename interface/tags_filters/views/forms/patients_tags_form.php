<input id="patient-tags" type="text" data-role="tagsinput"/>
<link href="<?php echo $GLOBALS['webroot'] ?>/interface/tags_filters/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<script src="<?php echo $GLOBALS['webroot'] ?>/interface/tags_filters/assets/jquery/jquery.js"></script>
<script src="<?php echo $GLOBALS['webroot'] ?>/interface/tags_filters/assets/bootstrap/js/bootstrap.min.js"></script>
<link href="<?php echo $GLOBALS['webroot'] ?>/interface/tags_filters/assets/js/bootstrap-tagsinput.css" rel="stylesheet">
<script src="<?php echo $GLOBALS['webroot'] ?>/interface/tags_filters/assets/js/bootstrap-tagsinput.js"></script>
<script src="<?php echo $GLOBALS['webroot'] ?>/interface/tags_filters/assets/js/typeahead.bundle.min.js"></script>

<script>
    var cities = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('text'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: '<?php echo $GLOBALS['webroot'] ?>/interface/tags_filters/assets/cities.json'
    });
    cities.initialize();

    var elt = $('#patient-tags');
    elt.tagsinput({
        itemValue: 'value',
        itemText: 'text',
        typeaheadjs: {
            name: 'cities',
            displayKey: 'text',
            source: cities.ttAdapter()
        }
    });
    elt.tagsinput('add', { "value": 1 , "text": "Amsterdam"   , "continent": "Europe"    });
    elt.tagsinput('add', { "value": 4 , "text": "Washington"  , "continent": "America"   });
    elt.tagsinput('add', { "value": 7 , "text": "Sydney"      , "continent": "Australia" });
    elt.tagsinput('add', { "value": 10, "text": "Beijing"     , "continent": "Asia"      });
    elt.tagsinput('add', { "value": 13, "text": "Cairo"       , "continent": "Africa"    });
</script>


