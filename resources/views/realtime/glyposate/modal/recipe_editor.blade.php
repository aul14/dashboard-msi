<div class="modal fade" id="modalRecipeEditor" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="modalRecipeEditorLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalRecipeEditorLabel">Recipe Editor</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table my-tableview my-table-striped table-hover w-100">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Recipe Name</th>
                            <th>Air Baku</th>
                            <th>Awmet S1</th>
                            <th>Awmet S2</th>
                            <th>Paraquat</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td id="row_recipe_1_tag"></td>
                            <td id="row_recipe_1_step1"></td>
                            <td id="row_recipe_1_step2"></td>
                            <td id="row_recipe_1_step3"></td>
                            <td id="row_recipe_1_step4"></td>
                            <td>
                                <button class="btn btn-warning w-100" id="digital_set_recipe1">Set Recipe</button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td id="row_recipe_2_tag"></td>
                            <td id="row_recipe_2_step1"></td>
                            <td id="row_recipe_2_step2"></td>
                            <td id="row_recipe_2_step3"></td>
                            <td id="row_recipe_2_step4"></td>
                            <td>
                                <button class="btn btn-warning w-100" id="digital_set_recipe2">Set Recipe</button>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td id="row_recipe_3_tag"></td>
                            <td id="row_recipe_3_step1"></td>
                            <td id="row_recipe_3_step2"></td>
                            <td id="row_recipe_3_step3"></td>
                            <td id="row_recipe_3_step4"></td>
                            <td>
                                <button class="btn btn-warning w-100" id="digital_set_recipe3">Set Recipe</button>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td id="row_recipe_4_tag"></td>
                            <td id="row_recipe_4_step1"></td>
                            <td id="row_recipe_4_step2"></td>
                            <td id="row_recipe_4_step3"></td>
                            <td id="row_recipe_4_step4"></td>
                            <td>
                                <button class="btn btn-warning w-100" id="digital_set_recipe4">Set Recipe</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
