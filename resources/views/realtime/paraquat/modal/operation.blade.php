<div class="modal fade" id="modalOperation" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="modalOperationLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalOperationLabel">Operation</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="op_form">
                    <div class="form-group row align-items-center">
                        <div class="col-sm-4">
                            <label class="col-form-label" for="prod_ord_no">PO Number</label>
                        </div>
                        <div class="col-sm-8">
                            <select class="choices form-select" id="prod_ord_no" name="prod_ord_no">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <div class="col-sm-4">
                            <label class="col-form-label" for="material_desc">Material Desc</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" readonly id="material_desc" name="material_desc" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <div class="col-sm-4">
                            <label class="col-form-label" for="uom_material_code">Uom Material Code</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" readonly id="uom_material_code" name="uom_material_code"
                                class="form-control">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <div class="col-sm-4">
                            <label class="col-form-label" for="qty_production">Qty Production</label>
                        </div>
                        <div class="col-sm-4">
                            <input type="text" readonly id="qty_production" name="qty_production"
                                class="form-control">
                        </div>
                        <div class="col-sm-4">
                            <input type="text" readonly id="batch" name="batch" placeholder="Total Batch"
                                class="form-control">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <div class="col-sm-4">
                            <label class="col-form-label" for="batch_code">Batch Number</label>
                        </div>
                        <div class="col-sm-4">
                            <select class="choices form-select" id="batch_code" name="batch_code">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <button type="button" class="btn btn-primary">Detail</button>
                        </div>
                    </div>


                </form>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-primary">Start</button>
                <button type="button" class="btn btn-success">Finish</button>
                <div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
</div>
