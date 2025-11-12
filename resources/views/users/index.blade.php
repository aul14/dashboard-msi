@extends('app')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header mb-3">
                <h3 class="page-title">{{ $title }}</h3>
            </div>
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if (session('level_user') !== 'operator')
                <a href="javascript:void(0)" onclick="openModalUser()" class="btn-sm btn-primary">
                    <i class="fa fa-plus"> Create User</i>
                </a>
            @endif
        </div>
    </div>
    <div class="row ">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table class="my-table table my-tableview my-table-striped table-hover w-100">
                    <thead>
                        <tr>
                            <th width="2px">Action</th>
                            <th>No</th>
                            <th class="select-filter">Fullname</th>
                            <th class="select-filter">Username</th>
                            <th class="select-filter">Email</th>
                            <th class="select-filter">User Level</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal --}}
    <div class="modal fade" id="modalUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="title-modal-user" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="title-modal-user">Create User</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formUser">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <label for="fullname" class="col-sm-3 col-form-label">Fullname</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="fullname" id="fullname">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="username" class="col-sm-3 col-form-label">Username</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="username" id="username">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="email" class="col-sm-3 col-form-label">Email</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="email" id="email">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <label for="level_user" class="col-sm-3 col-form-label">Level User</label>
                                    <div class="col-sm-9">
                                        <select name="level_user" id="level_user" class="form-select">
                                            <option value="operator">Operator</option>
                                            <option value="supervisor">Supervisor</option>
                                            <option value="admin">Admin</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="password" class="col-sm-3 col-form-label">Password</label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control" name="password" id="password">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="password_confirmation" class="col-sm-3 col-form-label">Password
                                        Konfirmation</label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control" name="password_confirmation"
                                            id="password_confirmation">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="btnSaveUser" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('assets/plugins/bootstrap-datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datatable/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datatable/js/dataTables.buttons.min.js') }}"></script>
    <script>
        function openModalUser() {
            $("#title-modal-user").html(`Create User`);
            $('#modalUser').modal('show');
        }

        $(document).on("click", ".btn-edit-user", function(e) {
            e.preventDefault();
            let editId = $(this).data('id');
            $('#modalUser').modal('show');
            $("#title-modal-user").html(`Edit User`);
            $('#formUser')[0].reset();
            $('#formUser').data('id', editId);

            $.ajax({
                type: "get",
                url: `/settings/users/${editId}`,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                dataType: "json",
                success: function(res) {
                    $('#fullname').val(res.data.fullname);
                    $('#username').val(res.data.username);
                    $('#email').val(res.data.email);
                    $('#level_user').val(res.data.level_user).change();
                }
            });
        });

        $('#btnSaveUser').on('click', function() {
            let userId = $('#formUser').data('id'); // ada ID = edit
            let url = userId ? `/settings/users/${userId}` : '/settings/users';
            let method = userId ? 'PUT' : 'POST';

            let formData = $('#formUser').serialize();
            if (userId) formData += '&_method=PUT';

            $.ajax({
                url: url,
                type: method,
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(res) {
                    alert(res.message);
                    $('#formUser')[0].reset();
                    $('#formUser').removeAttr('data-id');
                    $('.my-table').DataTable().ajax.reload();
                    $('#modalUser').modal('hide');
                    // refresh table or data
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let msg = '';
                        $.each(errors, function(key, val) {
                            msg += `${val[0]}\n`;
                        });
                        alert(msg);
                    } else {
                        alert('Terjadi kesalahan');
                    }
                }
            });
        });

        $(function() {
            $.fn.DataTable.ext.pager.numbers_length = 5;
            $('.my-table').DataTable({
                processing: true,
                serverSide: true,
                pagingType: 'full_numbers',
                scrollY: "50vh",
                scrollCollapse: true,
                scrollX: true,
                ajax: '{{ route('users.index') }}',
                oLanguage: {
                    oPaginate: {
                        sNext: '<span class="fa fa-angle-right pgn-1" style="color: #0033C4"></span>',
                        sPrevious: '<span class="fa fa-angle-left pgn-2" style="color: #0033C4"></span>',
                        sFirst: '<span class="fa fa-angle-double-left pgn-3" style="color: #0033C4"></span>',
                        sLast: '<span class="fa fa-angle-double-right pgn-4" style="color: #0033C4"></span>',
                    }
                },
                columns: [{
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'fullname',
                        name: 'fullname'
                    },
                    {
                        data: 'username',
                        name: 'username'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'level_user',
                        name: 'level_user'
                    },
                ],
                columnDefs: [{
                    defaultContent: "-",
                    targets: "_all"
                }],
            });
        });
    </script>
@endsection
