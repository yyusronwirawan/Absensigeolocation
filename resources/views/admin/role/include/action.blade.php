<div class="flex">
    @can('edit role & permission')
        <a class="btn btn-warning btn-sm me-2" href="{{ route('role.edit', $id) }}"><i class="bx bx-edit-alt me-1"></i>
            Edit</a>
    @endcan

    @can('delete role & permission')
        <form action="{{ route('role.destroy', $id) }}" method="POST" role="alert" alert-title="Hapus {{ $name }}"
            alert-text="Yakin ingin menghapusnya?">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm me-2 mt-2"><i class="bx bx-trash me-1"></i>
                Hapus</button>
        </form>
    @endcan

</div>
