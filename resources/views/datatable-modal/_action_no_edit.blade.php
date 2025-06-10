<form action="{{ $delete_url }}" method="post" class="d-inline">
    @method('delete')
    @csrf
    <button type="submit" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure?')"><i
            class="fa fa-trash"></i>
    </button>
</form>
