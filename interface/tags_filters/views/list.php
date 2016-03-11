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
    <script src="./assets/js/data_table.js"></script>

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
    </script>
</head>


<body class="body_top">

<div id="log-container">

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
