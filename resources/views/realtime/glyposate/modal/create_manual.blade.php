<div class="modal fade" id="modalCreateManual" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="modalCreateManualLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCreateManualLabel">Create Data</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="add_manual">
                    <div class="form-group row align-items-center my-0">
                        <div class="col-sm-4">
                            <label class="col-form-label" for="add_no_po">PO Number</label>
                        </div>
                        <div class="col-sm-7">
                            <input type="text" readonly id="add_no_po" name="add_no_po" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row align-items-center my-0">
                        <div class="col-sm-4">
                            <label class="col-form-label" for="add_batch">Batch Number</label>
                        </div>
                        <div class="col-sm-7">
                            <input type="text" readonly id="add_batch" name="add_batch" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row align-items-center my-0">
                        <div class="col-sm-4">
                            <label class="col-form-label" for="add_type">Type</label>
                        </div>
                        <div class="col-sm-7">
                            <select class="choices form-select select-nopo" id="add_type" name="add_type">
                                <option value=""></option>
                                <option value="RM">RM</option>
                                <option value="Charging">Charging</option>
                                <option value="Mixing">Mixing</option>
                                <option value="Transfer">Transfer</option>
                                <option value="DownTime">DownTime</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row align-items-center my-0">
                        <div class="col-sm-4">
                            <label class="col-form-label" for="add_type_message">Type Message</label>
                        </div>
                        <div class="col-sm-7">
                            <input type="text" id="add_type_message" name="add_type_message" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row align-items-center my-0">
                        <div class="col-sm-4">
                            <label class="col-form-label" for="add_qty">Qty</label>
                        </div>
                        <div class="col-sm-7">
                            <input type="number" id="add_qty" name="add_qty" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row align-items-center my-0">
                        <div class="col-sm-4">
                            <label class="col-form-label" for="add_duration">Duration</label>
                        </div>
                        <div class="col-sm-7">
                            <input type="text" id="add_duration" name="add_duration" class="form-control">
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="btnSaveAddManual(this)">Save</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
