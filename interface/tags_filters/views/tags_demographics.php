<tr>
    <td>
        <?php
        // Tags expand collapse widget
        $widgetTitle = xl("Tags");
        $widgetLabel = "tags";
        $widgetButtonLabel = xl("Edit");
        $widgetButtonLink = $GLOBALS['webroot']."/interface/tags_filters/index.php?action=patients!edit";
        $widgetButtonClass = "tags-edit-button";
        $linkMethod = "html";
        $bodyClass = "notab";
        $widgetAuth = acl_check('patients', 'demo', '', 'write');
        $fixedWidth = true;
        expand_collapse_widget($widgetTitle, $widgetLabel, $widgetButtonLabel,
            $widgetButtonLink, $widgetButtonClass, $linkMethod, $bodyClass,
            $widgetAuth, $fixedWidth, true );
        ?>
        <div class="notab" id="TAGS" >
            <span color="red">VIP</span>
        </div>
        <script type="text/javascript">
            $(document).ready( function () {
                $(".tags-edit-button").click( function ( e ) {
                    e.stopPropagation();
                    e.preventDefault();
                    var url = $(this).attr( 'href' );
                    $("#TAGS").load( url );
                });
            });
        </script>
        </div> <!-- required for expand_collapse_widget -->
    </td>
</tr>