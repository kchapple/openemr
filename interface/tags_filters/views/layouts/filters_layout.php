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

        p.tt-suggestion {
            width: 400px;
            border-color: grey;
            border-style: solid;
            border-width: 1px 2px 1px 2px;
            background-color:rgba(255, 255, 255, 0.9);
            margin: 0px;
            padding: 4px;
        }

        .clear-date {
            cursor: pointer;
        }

    </style>
    <link href="<?php echo $GLOBALS['webroot'] ?>/interface/tags_filters/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="<?php echo $GLOBALS['webroot'] ?>/interface/tags_filters/assets/jquery/jquery.js"></script>
    <script src="<?php echo $GLOBALS['webroot'] ?>/interface/tags_filters/assets/bootstrap/js/bootstrap.min.js"></script>
    <link href="<?php echo $GLOBALS['webroot'] ?>/interface/tags_filters/assets/bootstrap-editable/css/bootstrap-editable.css" rel="stylesheet"/>
    <script src="<?php echo $GLOBALS['webroot'] ?>/interface/tags_filters/assets/bootstrap-editable/js/bootstrap-editable.js"></script>
    <script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/datatables/media/js/jquery.dataTables.js"></script>
    <script src="<?php echo $GLOBALS['webroot'] ?>/interface/tags_filters/assets/js/data_table.js"></script>
    <script src="<?php echo $GLOBALS['webroot'] ?>/interface/tags_filters/assets/js/typeahead.bundle.min.js"></script>
    <link href="<?php echo $GLOBALS['webroot'] ?>/interface/tags_filters/assets/js/jquery.datetimepicker.css" rel="stylesheet">
    <script src="<?php echo $GLOBALS['webroot'] ?>/interface/tags_filters/assets/js/jquery.datetimepicker.js"></script>

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

            });

            $('#createModal').on('hidden.bs.modal', function(){
                // When modal is cancelled or hidden, reset it
                $('#createModal textarea, #createModal input, #createModal select').val('');
            });

        });

    </script>
</head>


<body class="body_top">

<?php echo $this->content; ?>

</body>
