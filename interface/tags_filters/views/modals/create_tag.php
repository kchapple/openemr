<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="encounterModalLabel"><?php echo xl( 'New Tag' ); ?></h4>
            </div>
            <div class="modal-body">
                <form id="new-tag-form">
                    <div id="filter-form">
                        <div class="form-group form-horizontal">
                            <label for="tag_name" class="control-label">Tag Name:</label>
                            <input name="tag_name" type="text" class="form-control" id="tag_name">
                        </div>
                    </div>
                </form>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="save-new-tag" class="btn btn-primary">Save</button>
            </div>

        </div>
    </div>
    <script type="text/javascript">
    $(document).ready( function() {
        $("#save-new-tag").on("click", function (e) {

            e.preventDefault();
            var data = $('#new-tag-form').serializeArray();

            $.ajax({
                type: 'POST',
                url: '<?php echo $controllerUrl ?>!create_tag',
                data: data,
                success: function (data) {
                    $('#createModal').modal('hide');
                }
            });

        });
    });
    </script>
</div>