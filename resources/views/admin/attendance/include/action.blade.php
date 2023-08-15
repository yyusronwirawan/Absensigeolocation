<div class="flex">
    @can('edit attendance')
        <a class="btn btn-primary me-2 mt-2" href="{{ route('attendance.edit', $id) }}">
            Edit
        </a>
    @endcan

    <a class="btn btn-secondary me-2 mt-2" href="{{ route('attendance.show', $id) }}">
        Detail
    </a>
</div>
