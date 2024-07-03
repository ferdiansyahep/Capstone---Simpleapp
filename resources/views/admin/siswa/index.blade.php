@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <!-- Content Row -->
    <div class="card">
        <div class="card-header py-3 d-flex">
            <h2 class="m-0 font-weight-bold text-dark">
                {{ __('Daftar Siswa Kelas') }} {{ $kelas }}
            </h2>
            <div class="ml-auto">
                @can('user_create')
                <a href="{{ route('admin.siswa.create') }}" class="btn bg-success-dashboard">
                    <span class="icon text-dark">
                        <i class="fa fa-plus-circle"></i>
                    </span>
                    <span class="text">{{ __('Siswa Baru') }}</span>
                </a>
                @endcan
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover datatable datatable-User" cellspacing="0"
                    width="100%">
                    <thead class="bg-primary-dashboard text-light">
                        <tr>
                            <th width="10">

                            </th>
                            <th>No</th>
                            <th>{{ __('NISN') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Tanggal Lahir') }}</th>
                            <th>{{ __('Jenis Kelamin') }}</th>
                            <th>{{ __('Kelas') }} </th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr data-entry-id="{{ $user->id }}">
                            <td></td>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->nomer_induk }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->tanggal_lahir }}</td>
                            <td>{{ $user->jenis_kelamin }}</td>
                            <td>{{ $user->kelas }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.siswa.edit', $user->id) }}" class="btn btn-info">
                                        <i class="fa fa-pencil-alt"></i>
                                    </a>
                                    <a href="{{ route('admin.siswa.addSubject', $user) }}" class="btn btn-warning"><i
                                            class="fa fa-plus"></i></a>
                                    <form onclick="return confirm('are you sure ? ')" class="d-inline"
                                        action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
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
                            <td colspan="8" class="text-center">{{ __('Data Empty') }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Content Row -->

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