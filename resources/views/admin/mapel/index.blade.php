@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header py-4 d-flex">
            <h2 class="m-0 font-weight-bold text-dark">
                {{ __('Daftar Mata Pelajaran') }} {{ $kelas }}
            </h2>
            <div class="ml-auto">
                <a href="{{ route('admin.mapel.create') }}" class="btn bg-success-dashboard">
                    <span class="icon text-dark">
                        <i class="fa fa-plus-circle"></i>
                    </span>
                    <span class="text"> {{ __('Mapel Baru') }}</span>
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover datatable datatable-mapel" cellspacing="0"
                    width="100%">
                    <thead class="bg-primary-dashboard text-light">
                        <tr>
                            <th width="10"></th>
                            <th>No</th>
                            <th>Nama Mata Pelajaran</th>
                            <th>Tahun Ajaran</th>
                            <th>Guru Pengampu</th>
                            <th>Kelas</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mapels as $data)
                        <tr data-entry-id="{{ $data->id }}">
                            <td></td>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $data->nama_mapel }}</td>
                            <td>2023 - 2024</td>
                            <td>{{ $data->user?->name }}</td>
                            <td>{{ $data->kelas }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.mapel.edit', $data->id) }}" class="btn btn-warning">
                                        <i class="fa fa-pen-alt"></i>
                                    </a>
                                    <a href="{{ route('admin.mapel.show', $data->id) }}" class="btn btn-info btn-sm"><i
                                            class="fa fa-eye"></i></a>
                                    <form onclick="return confirm('are you sure ? ')" class="d-inline"
                                        action="{{ route('admin.mapel.destroy', $data->id) }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger"
                                            style="border-top-left-radius: 0;border-bottom-left-radius: 0;">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">{{ __('Data Empty') }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script-alt')
<script>
    $(function () {
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
        let deleteButtonTrans = 'Delete selected'
        let deleteButton = {
            text: deleteButtonTrans,
            url: "{{ route('admin.mapel.mass_destroy') }}",
            className: 'btn-danger',
            action: function (e, dt, node, config) {
                var ids = $.map(dt.rows({
                    selected: true
                }).nodes(), function (entry) {
                    return $(entry).data('entry-id')
                });
                if (ids.length === 0) {
                    alert('Zero selected')
                    return
                }
                if (confirm('Are you sure?')) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        method: 'POST',
                        url: config.url,
                        data: {
                            ids: ids,
                            _method: 'DELETE'
                        }
                    }).done(function () {
                        location.reload()
                    })
                }
            }
        }
        dtButtons.push(deleteButton)
        $.extend(true, $.fn.dataTable.defaults, {
            order: [
                [1, 'asc']
            ],
            pageLength: 50,
        });
        $('.datatable-mapel:not(.ajaxTable)').DataTable({
            buttons: dtButtons
        })
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });
    })
</script>
@endpush