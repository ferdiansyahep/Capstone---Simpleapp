@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Content Row -->
    @if($categories->isNotEmpty())
    <div class="container">
        <div class="card-header py-3 bg-transparent">
            <h1 class="fw-heading">Daftar Nilai</h1>
            <h4>{{ $categories->first()->mapel->nama_mapel }} - Kelas {{$categories->first()->mapel->kelas}}</h4>
        </div>
    </div>
    @endif

    <div class="container">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover datatable datatable-User" cellspacing="0" width="100%">
                    <thead class="bg-primary-dashboard text-light">
                        <tr>
                            <th>No</th>
                            <th>NISN</th>
                            <th>Nama Siswa</th>
                            @foreach($categories as $category)
                                <th>{{ singkatJudul($category->name) }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $resultsByUser = [];
                            foreach ($categories as $category) {
                                foreach ($category->results as $result) {
                                    $resultsByUser[$result->user->id]['user'] = $result->user;
                                    $resultsByUser[$result->user->id]['scores'][$category->id] = $result->score;
                                }
                            }
                        @endphp
                        @foreach($resultsByUser as $userId => $userData)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $userData['user']->nomer_induk }}</td>
                            <td>{{ $userData['user']->name }}</td>
                            @foreach($categories as $category)
                                <td>{{ $userData['scores'][$category->id] ?? '-' }}</td>
                            @endforeach
                        </tr>
                        @endforeach
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
        let deleteButtonTrans = 'delete selected'
        let deleteButton = {
            text: deleteButtonTrans,
            url: "{{ route('admin.users.mass_destroy') }}",
            className: 'btn-danger',
            action: function (e, dt, node, config) {
                var ids = $.map(dt.rows({
                    selected: true
                }).nodes(), function (entry) {
                    return $(entry).data('entry-id')
                });
                if (ids.length === 0) {
                    alert('zero selected')
                    return
                }
                if (confirm('are you sure ?')) {
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
                        })
                        .done(function () {
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
        $('.datatable-User:not(.ajaxTable)').DataTable({
            buttons: dtButtons
        })
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });
    })
</script>
@endpush