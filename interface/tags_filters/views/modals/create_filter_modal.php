<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel">
    <div class="modal-dialog" role="document" style="width: 80%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="encounterModalLabel"><?php echo xl( 'Filter Builder' ); ?></h4>
            </div>
            <div class="modal-body">
                <form id="filter-builder-form"style="margin:0px">
                    <div class="row">
                        <div class="form-group col-sm-2">
                            <select name="permission" class="form-control" id="permission">
                                <option value="" selected> -- </option>
                                <option value="allow">Allow</option>
                                <option value="deny">Deny</option>
                            </select>
                        </div>

                        <div class="form-group col-sm-2">
                            <select name="source_type" class="form-control" id="source-type">
                                <option value="" selected> -- </option>
                                <option value="user">User</option>
                                <option value="group">Group</option>
                            </select>
                        </div>

                        <div id="source-user-fg" class="form-group col-sm-2">
                            <select name="source_user" class="form-control" id="source-user">
                                <option value="" selected> -- </option>
                                <?php foreach ( $this->users as $user ) { ?>
                                <option value="<?php echo $user->username; ?>"><?php echo $user->name; ?>s</option>
                                <?php } ?>
                            </select>
                        </div>

                        <div id="source-group-fg" class="form-group col-sm-2" style="display: none;">
                            <select name="source_group" class="form-control" id="source-group">
                                <option value="" selected> -- </option>
                                <?php foreach ( $this->groups as $id => $title ) { ?>
                                    <option value="<?php echo $id; ?>"><?php echo $title; ?>s</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class ="row">
                        <div class="form-group col-sm-2">
                            <select name="filter_type" class="form-control" id="filter-type">
                                <option value="patient">Patient</option>
                                <option value="tag">Tag</option>
                            </select>
                        </div>

                        <div class="form-group col-sm-2" id="filter-patient-fg">
                            <div id="patient-container">
                                <input required name="filter_patient" type="text" style="display: block; width: 100%;" class="form-control typeahead" id="filter-patient" placeholder="last, first">
                                <span id="patient-last-encounter-date"></span>
                            </div>
                        </div>

                        <div id="filter-tag-fg" class="form-group col-sm-2" style="display: none;">
                            <select name="filter_tag" class="form-control" id="filter-tag">
                                <option value=""> -- </option>
                                <?php foreach ( $this->tags as $tag ) { ?>
                                <option value="<?php echo $tag->id; ?>"><?php echo $tag->tag_name; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group col-sm-2">
                            <div class="input-group">
                                <input readonly placeholder="from ..." name="effective_datetime" type="text" data-date-format='dd/mm/yyyy' class="datetime form-control" id="effective-datetime">
                                <div class="input-group-addon"><span class="clear-date glyphicon glyphicon-ban-circle">&nbsp;</span></div>
                            </div>
                        </div>

                        <div class="form-group col-sm-2">
                            <input placeholder="to ..." name="expiration_datetime" type="text" data-date-format='dd/mm/yyyy' class="datetime form-control" id="expiration-datetime">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-2">
                            <label for="priority" class="control-label">Priority</label>
                            <select name="priority" class="form-control" id="priority">
                                <option value="3">3</option>
                                <option value="2">2</option>
                                <option value="1">1</option>
                            </select>
                        </div>

                        <div class="form-group col-md-2">
                            <label for="note" class="control-label">Note</label>
                            <input type="text" name="note" class="form-control" id="note"/>
                        </div>
                    </div>
                </form>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="save-new-encounter" class="btn btn-primary">Save</button>
            </div>

        </div>
    </div>
    <script type="text/javascript">
        $(document).ready( function() {

            $(".clear-date").click( function() {
                var input = $(this).parent().siblings('input');
                var value = input.val();
                input.datetimepicker('reset')
            });

            $(".datetime").each( function() {
                $(this).datetimepicker({
                    step: 30,
                    mask:false,
                    format: 'Y-m-d H:i',
                    formatDate:'Y-m-d',
                    formatTime:'H:i',
                    defaultDate: '<?php echo date('Y-m-d'); ?>',
                    defaultTime: '<?php echo date('H:i'); ?>',
                    onChangeDateTime: function() {

                    }
                });
            });

            var patientSearch = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.whitespace,
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                remote: {
                    url: '<?php echo $GLOBALS['webroot'] ?>/interface/tags_filters/index.php?action=filters!patient_search&query=%QUERY',
                    wildcard: '%QUERY'
                }
            });

            $('#filter-patient').typeahead({
                hint: true,
                highlight: true,
                minLength: 2
            }, {
                name: 'patient-search',
                source: patientSearch,
                display: "name",
                templates: {
                    suggestion: function ( e ) {
                        return '<p>' + e.displayKey + '</p>';
                    }
                },
                limit: 20
            });

            $("#source-type").change( function() {
                var sourceType = $(this).val()
                if ( sourceType == 'user' ) {
                    $("#source-group").val('');
                    $("#source-group-fg").hide();
                    $("#source-user-fg").show();
                } else if ( sourceType == 'group' ) {
                    $("#source-user").val('');
                    $("#source-user-fg").hide();
                    $("#source-group-fg").show();
                }
            });


            $("#filter-type").change( function() {
                var filterType = $(this).val()
                if ( filterType == 'patient' ) {
                    $("#filter-tag").val('');
                    $("#filter-tag-fg").hide();
                    $("#filter-patient-fg").show();
                } else if ( filterType == 'tag' ) {
                    $("#filter-patient").val('');
                    $("#filter-patient-fg").hide();
                    $("#filter-tag-fg").show();
                }
            });
        });

    </script>
</div>