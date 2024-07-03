@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header py-3 d-flex">
            <h2 class="m-0 fw-heading text-dark">
                {{ __('Database Soal') }}
            </h2>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover datatable datatable-question" cellspacing="0" width="100%">
                    <thead class="bg-primary-dashboard text-light">
                        <tr>
                            <th width="10"></th>
                            <th>No</th>
                            <th>Judul Ujian</th>
                            <th>Question Text</th>
                            <th>Correct Answer</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($questions as $question)
                        <tr data-entry-id="{{ $question->id }}">
                            <td></td>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ optional($question->category)->name }}</td>
                            <td>{{ $question->question_text }}</td>
                            <td>
                                @foreach($question->options as $option)
                                    @if($option->is_correct)
                                        {{ $option->option_text }}
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.questions.edit', $question->id) }}" class="btn btn-info">
                                        <i class="fa fa-pencil-alt"></i>
                                    </a>
                                    <form onclick="return confirm('are you sure ? ')" class="d-inline" action="{{ route('admin.questions.destroy', $question->id) }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger" style="border-top-left-radius: 0;border-bottom-left-radius: 0;">
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
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons);
        let deleteButtonTrans = 'delete selected';
        let deleteButton = {
            text: deleteButtonTrans,
            url: "{{ route('admin.questions.mass_destroy') }}",
            className: 'btn-danger',
            action: function (e, dt, node, config) {
                var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
                    return $(entry).data('entry-id');
                });

                if (ids.length === 0) {
                    alert('zero selected');
                    return;
                }

                if (confirm('are you sure ?')) {
                    $.ajax({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        method: 'POST',
                        url: config.url,
                        data: { ids: ids, _method: 'DELETE' }
                    })
                    .done(function () { location.reload() });
                }
            }
        };
        dtButtons.push(deleteButton);
        $.extend(true, $.fn.dataTable.defaults, {
            order: [[1, 'asc']],
            pageLength: 50,
        });
        $('.datatable-question:not(.ajaxTable)').DataTable({ buttons: dtButtons });
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
        });
    });
</script>
@endpush