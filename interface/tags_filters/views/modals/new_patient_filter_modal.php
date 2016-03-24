<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="encounterModalLabel"><?php echo xl( 'New Filter' ); ?></h4>
            </div>
            <div class="modal-body">
                <form id="new-patient-encounter-form">
                    <div id="filter-form">
                        <div class="form-group form-horizontal">
                            <label for="filter-for-tag" class="control-label">Filter for Tag:</label>
                            <select name="filter-for-tag" class="form-control" id="filter-for-tag">
                                <option value=""> -- </option>
                                <?php foreach ( $this->tags as $tag ) { ?>
                                <option value="<?php echo $tag->id; ?>"><?php echo $tag->tag_name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group form-horizontal" id="patient-full-name-typeahead">
                            <label for="patient-fname" class="control-label">Full Name:</label>
                            <div id="patient-container">
                                <input required name="patient_name" type="text" style="display: block; width: 100%;" class="form-control typeahead" id="patient-full-name" placeholder="last, first">
                                <span id="patient-last-encounter-date"></span>
                            </div>
                        </div>
                        <div class="form-group form-horizontal">
                            <label for="patient-dob" class="control-label">DOB:</label>
                            <input name="DOB" type="text" data-date-format='dd/mm/yyyy' class="form-control" id="patient-dob">
                        </div>
                        <div class="form-group form-horizontal">
                            <label for="patient-sex" class="control-label">Sex:</label>
                            <select name="sex" class="form-control" id="patient-sex">
                                <option value="">--</option>
                                <option value="Female">Female</option>
                                <option value="Male">Male</option>
                                <option value="Other">Other</option>
                                <option value="Transgender">Transgender</option>
                            </select>
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
</div>