<?php
$sanitize_all_escapes = true;
$fake_register_globals = false;
$controllerUrl = $GLOBALS['webroot']."/interface/tags_filters/index.php?action=".strtolower( $this->title );
?>
<head>
    <link rel="stylesheet" href="<?php echo $css_header; ?>" type="text/css">
    <style type="text/css">
        @import "<?php echo $GLOBALS['webroot'] ?>/library/js/datatables/media/css/demo_page.css";
        @import "<?php echo $GLOBALS['webroot'] ?>/library/js/datatables/media/css/demo_table.css";
    </style>

    <link href="./assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="./assets/jquery/jquery.js"></script>
    <script src="./assets/bootstrap/js/bootstrap.min.js"></script>

    <script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/datatables/media/js/jquery.dataTables.js"></script>
    <script src="<?php echo $GLOBALS['webroot'] ?>/interface/tags_filters/assets/js/data_table.js"></script>

    <script type="text/javascript">

        var data_table = new data_table( <?php echo $this->dataTable->toJson() ?>,
            function onShowDetails() {
            },
            function onHideDetails() {
            },
            function onAfterDraw() {
                // This is to reset width of columns after drawing because with fixed header, the widths don't line up
                $('table#<?php echo $this->dataTable->getTableId() ?> thead tr td.column-search-filter').each( function( index ) {
                    var thisWidth = $(this).width();
                    $('table#<?php echo $this->dataTable->getTableId() ?> tbody tr td').eq(index).css('width', thisWidth);
                    $('table#<?php echo $this->dataTable->getTableId() ?> tbody tr td').eq(index).css('column-width', thisWidth);
                    $('table#<?php echo $this->dataTable->getTableId() ?> tbody tr td').eq(index).css('-moz-column-width', thisWidth);
                    $('table#<?php echo $this->dataTable->getTableId() ?> tbody tr td').eq(index).css('column-width', thisWidth);
                });
            }
        );

        data_table.init();

        $(document).ready( function() {
            $(".search_init").change(function () {
                // Filter on the column (the index) of this element
                var oTable = data_table.getDatatable();
                var index = $(this).closest('td').index();
                oTable.fnFilter(this.value, index);
            });

            $('#createModal').on('shown.bs.modal', function () {
                // Set the hidden values
                var currtime = moment();
                $("#encounter-crt").val(currtime.utcOffset(-7).format("YYYY-MM-DD HH:mm"));
                $("#encounter-status").val('incomplete');
            });

            $('#createModal').on('hidden.bs.modal', function(){
                $('#createModal textarea, #createModal input, #createModal select').val('');
                $("#patient-last-encounter-date").text("");
                $("#patient-last-encounter-date").css("color","black");
            });

            var userSearch = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.whitespace,
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                remote: {
                    url: '<?php echo $controllerUrl ?>!user_search&query=%QUERY',
                    wildcard: '%QUERY'
                }
            });

            $('#username').typeahead({
                hint: true,
                highlight: true,
                minLength: 2
            }, {
                name: 'user-search',
                source: userSearch,
                display: "name",
                templates: {
                    suggestion: function ( e ) {
                        return '<p>' + e.displayKey + '</p>';
                    }
                },
                limit: 20
            });

            $('#username').bind('typeahead:selected', function(obj, datum, name) {
                //alert(JSON.stringify(obj)); // object
                // outputs, e.g., {"type":"typeahead:selected","timeStamp":1371822938628,"jQuery19105037956037711017":true,"isTrigger":true,"namespace":"","namespace_re":null,"target":{"jQuery19105037956037711017":46},"delegateTarget":{"jQuery19105037956037711017":46},"currentTarget":
                //alert(JSON.stringify(datum)); // contains datum value, tokens and custom fields
                // outputs, e.g., {"redirect_url":"http://localhost/test/topic/test_topic","image_url":"http://localhost/test/upload/images/t_FWnYhhqd.jpg","description":"A test description","value":"A test value","tokens":["A","test","value"]}
                // in this case I created custom fields called 'redirect_url', 'image_url', 'description'
//        alert(datum.DOB);
//        alert(datum.sex);
                $("#patient-dob").val( datum.DOB );
                $("#patient-sex").val( datum.sex );
                $("#patient-pid").val( datum.pid );
                var lastEncHTML = 'No encounters';
                if ( datum.lastEncounter ) {
                    lastEncHTML = "Last Encounter: "+datum.lastEncounter;
                }
                $("#patient-last-encounter-date").text( lastEncHTML );
                var isEncToday = moment( datum.lastEncounter).isSame( moment(), 'day' );
                if ( isEncToday ) {
                    $("#patient-last-encounter-date").css( "color", "red" );
                } else {
                    $("#patient-last-encounter-date").css( "color", "black" );
                }
                //alert(JSON.stringify(name)); // contains dataset name
                // outputs, e.g., "my_dataset"

            });

        });

    </script>
</head>


<body class="body_top">

<?php echo $this->modal; ?>

<div id="log-container">

    <?php echo $this->navbar; ?>

    <table class="display" cellspacing="0" width="100%" id="<?php echo $this->dataTable->getTableId() ?>">
        <thead>
        <tr>
            <?php foreach ( $this->dataTable->getColumns() as $column ) { ?>
                <td class="column-search-filter" align="center" rowspan="1" colspan="1">
                    <?php if ( $column->isSearchable() ) { ?>
                        <?php if ( is_a( $column->getBehavior(), 'ActiveElement' ) &&
                            is_array( $column->getBehavior()->getMap() ) ) { ?>
                            <select class="search_init">
                                <option value=""> -- </option>
                                <?php foreach( $column->getBehavior()->getMap() as $value => $label ) { ?>
                                    <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
                                <?php } ?>
                            </select>
                        <?php } else { ?>
                            <input class="search_init" type="text" value="">
                        <?php } ?>
                    <?php } else { ?>
                        &nbsp;
                    <?php } ?>
                </td>
            <?php } ?>
        </tr>
        <tr>
            <?php foreach ( $this->dataTable->getColumns() as $column ) { ?>
                <th style="width: <?php $column->getWidth(); ?>"><?php echo $column->getTitle(); ?></th>
            <?php } ?>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
</body>
