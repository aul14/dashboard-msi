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
                        <button type="button" class="btn btn-dark mx-1">Recepy Editor</button>
                    </div>
                    <div class="card">
                        <div class="card-body p-2">
                            <h6>RM Tank Name</h6>

                            <div class="form-group row align-items-center my-0">
                                <div class="col-sm-2">
                                    <label class="col-form-label" for="setting_rm1">RM 1</label>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" id="setting_rm1" name="setting_rm1" class="form-control"
                                        autocomplete="off">
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-primary w-100">Edit</button>
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-success w-100">Save</button>
                                </div>
                            </div>
                            <div class="form-group row align-items-center my-0">
                                <div class="col-sm-2">
                                    <label class="col-form-label" for="setting_rm2">RM 2</label>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" id="setting_rm2" name="setting_rm2" class="form-control"
                                        autocomplete="off">
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-primary w-100">Edit</button>
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-success w-100">Save</button>
                                </div>
                            </div>
                            <div class="form-group row align-items-center my-0">
                                <div class="col-sm-2">
                                    <label class="col-form-label" for="setting_rm3">RM 3</label>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" id="setting_rm3" name="setting_rm3" class="form-control"
                                        autocomplete="off">
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-primary w-100">Edit</button>
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-success w-100">Save</button>
                                </div>
                            </div>
                            <div class="form-group row align-items-center my-0">
                                <div class="col-sm-2">
                                    <label class="col-form-label" for="setting_rm4">RM 4</label>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" id="setting_rm4" name="setting_rm4" class="form-control"
                                        autocomplete="off">
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-primary w-100">Edit</button>
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-success w-100">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body p-2">
                            <h6>Storage Tank Name</h6>

                            <div class="form-group row align-items-center my-0">
                                <div class="col-sm-2">
                                    <label class="col-form-label" for="setting_storage1">Storage 1</label>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" id="setting_storage1" name="setting_storage1"
                                        class="form-control" autocomplete="off">
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-primary w-100">Edit</button>
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-success w-100">Save</button>
                                </div>
                            </div>
                            <div class="form-group row align-items-center my-0">
                                <div class="col-sm-2">
                                    <label class="col-form-label" for="setting_storage2">Storage 2</label>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" id="setting_storage2" name="setting_storage2"
                                        class="form-control" autocomplete="off">
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-primary w-100">Edit</button>
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-success w-100">Save</button>
                                </div>
                            </div>
                            <div class="form-group row align-items-center my-0">
                                <div class="col-sm-2">
                                    <label class="col-form-label" for="setting_storage3">Storage 3</label>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" id="setting_storage3" name="setting_storage3"
                                        class="form-control" autocomplete="off">
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-primary w-100">Edit</button>
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-success w-100">Save</button>
                                </div>
                            </div>
                            <div class="form-group row align-items-center my-0">
                                <div class="col-sm-2">
                                    <label class="col-form-label" for="setting_storage4">Storage 4</label>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" id="setting_storage4" name="setting_storage4"
                                        class="form-control" autocomplete="off">
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-primary w-100">Edit</button>
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-success w-100">Save</button>
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
