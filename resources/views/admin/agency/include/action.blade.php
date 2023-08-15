<div class="flex">
    @can('edit agency')
        <a class="btn btn-warning btn-sm me-2" href="{{ route('agency.edit', $id) }}"><i class="bx bx-edit-alt me-1"></i>
            Edit</a>
    @endcan

    @can('delete agency')
        <form action="{{ route('agency.destroy', $id) }}" method="POST" role="alert" alert-title="Hapus {{ $name }}"
            alert-text="Yakin ingin menghapusnya?">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm me-2 mt-2"><i class="bx bx-trash me-1"></i>
                Hapus</button>
        </form>
    @endcan
</div>
