@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header py-4 d-flex">
            <h2 class="m-0 font-weight-bold text-dark">
                {{ __('Data Nilai') }}
            </h2>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover datatable datatable-result" cellspacing="0"
                    width="100%">
                    <thead class="bg-primary-dashboard text-light">
                        <tr>
                            <th width="10"></th>
                            <th>No</th>
                            <th>NISN</th>
                            <th>Nama Siswa</th>
                            <th>Ujian</th>
                            <th>Kelas</th>
                            <th>Mata Pelajaran</th>
                            <th>Hasil Ujian</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($results as $result)
                        <tr data-entry-id="{{ $result->id }}">
                            <td></td>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $result->user->nomer_induk }}</td>
                            <td>{{ $result->user->name }}</td>
                            <td>{{ $result->category->name }}</td>
                            <td>{{ $result->user->kelas }}</td>
                            <td>{{ $result->category->mapel->nama_mapel }}</td>
                            <td>{{ $result->score }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.results.edit', $result->id) }}" class="btn btn-warning">
                                        <i class="fa fa-pen-alt"></i>
                                    </a>
                                    <a href="{{ route('admin.results.show', $result->id) }}" class="btn btn-info btn-sm"><i
                                            class="fa fa-eye"></i></a>
                                    <form onclick="return confirm('are you sure ? ')" class="d-inline"
                                        action="{{ route('admin.results.destroy', $result->id) }}" method="POST">
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
                            <td colspan="7" class="text-center">{{ __('result Empty') }}</td>
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
            url: "{{ route('admin.results.mass_destroy') }}",
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
        $('.datatable-result:not(.ajaxTable)').DataTable({
            buttons: dtButtons
        })
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });
    })
</script>
@endpush