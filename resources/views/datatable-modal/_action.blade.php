<a href="javascript:void(0)" data-href="{{ $edit_url }}" data-id="{{ $row_id }}"
    class="btn btn-sm btn-success btn-edit-user" title="Edit"> <i class="fa fa-pencil"></i>
</a>
@if ($row_id != auth()->user()->id)
    <form action="{{ $delete_url }}" method="post" class="d-inline">
        @method('delete')
        @csrf
        <button type="submit" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure?')"><i
                class="fa fa-trash"></i>
        </button>
    </form>
@endif
