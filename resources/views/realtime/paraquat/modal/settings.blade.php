<div class="modal fade" id="modalSettings" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="modalSettingsLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalSettingsLabel">Settings</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="sett_form">
                    <div class="d-flex justify-content-start">
                        <button type="button" class="btn btn-dark mx-1">Tank Name</button>
                        <button type="button" class="btn btn-dark mx-1" onclick="openModalParameterSett()">Setting
                            Parameter</button>
                        <button type="button" class="btn btn-dark mx-1" onclick="openModalRecipe()">Recipe
                            Editor</button>
                    </div>
                    <div class="card">
                        <div class="card-body p-2">
                            <h6>RM Tank Name</h6>

                            <div class="form-group row align-items-center my-0">
                                <div class="col-sm-2">
                                    <label class="col-form-label" for="RM1">RM 1</label>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" id="RM1" name="RM1" class="form-control"
                                        autocomplete="off" readonly>
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-primary w-100"
                                        onclick="btnEditSettings(this)">Edit</button>
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-success w-100"
                                        onclick="btnSaveSettings(this)">Save</button>
                                </div>
                            </div>
                            <div class="form-group row align-items-center my-0">
                                <div class="col-sm-2">
                                    <label class="col-form-label" for="RM2">RM 2</label>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" id="RM2" name="RM2" class="form-control"
                                        autocomplete="off" readonly>
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-primary w-100"
                                        onclick="btnEditSettings(this)">Edit</button>
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-success w-100"
                                        onclick="btnSaveSettings(this)">Save</button>
                                </div>
                            </div>
                            <div class="form-group row align-items-center my-0">
                                <div class="col-sm-2">
                                    <label class="col-form-label" for="RM3">RM 3</label>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" id="RM3" name="RM3" class="form-control"
                                        autocomplete="off" readonly>
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-primary w-100"
                                        onclick="btnEditSettings(this)">Edit</button>
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-success w-100"
                                        onclick="btnSaveSettings(this)">Save</button>
                                </div>
                            </div>
                            <div class="form-group row align-items-center my-0">
                                <div class="col-sm-2">
                                    <label class="col-form-label" for="RM4">RM 4</label>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" id="RM4" name="RM4" class="form-control"
                                        autocomplete="off" readonly>
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-primary w-100"
                                        onclick="btnEditSettings(this)">Edit</button>
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-success w-100"
                                        onclick="btnSaveSettings(this)">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body p-2">
                            <h6>Storage Tank Name</h6>

                            <div class="form-group row align-items-center my-0">
                                <div class="col-sm-2">
                                    <label class="col-form-label" for="Storage1">Storage 1</label>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" id="Storage1" name="Storage1" class="form-control"
                                        autocomplete="off" readonly>
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-primary w-100"
                                        onclick="btnEditSettings(this)">Edit</button>
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-success w-100"
                                        onclick="btnSaveSettings(this)">Save</button>
                                </div>
                            </div>
                            <div class="form-group row align-items-center my-0">
                                <div class="col-sm-2">
                                    <label class="col-form-label" for="Storage2">Storage 2</label>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" id="Storage2" name="Storage2" class="form-control"
                                        autocomplete="off" readonly>
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-primary w-100"
                                        onclick="btnEditSettings(this)">Edit</button>
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-success w-100"
                                        onclick="btnSaveSettings(this)">Save</button>
                                </div>
                            </div>
                            <div class="form-group row align-items-center my-0">
                                <div class="col-sm-2">
                                    <label class="col-form-label" for="Storage3">Storage 3</label>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" id="Storage3" name="Storage3" class="form-control"
                                        autocomplete="off" readonly>
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-primary w-100"
                                        onclick="btnEditSettings(this)">Edit</button>
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-success w-100"
                                        onclick="btnSaveSettings(this)">Save</button>
                                </div>
                            </div>
                            <div class="form-group row align-items-center my-0">
                                <div class="col-sm-2">
                                    <label class="col-form-label" for="Storage4">Storage 4</label>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" id="Storage4" name="Storage4" class="form-control"
                                        autocomplete="off" readonly>
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-primary w-100"
                                        onclick="btnEditSettings(this)">Edit</button>
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-success w-100"
                                        onclick="btnSaveSettings(this)">Save</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
