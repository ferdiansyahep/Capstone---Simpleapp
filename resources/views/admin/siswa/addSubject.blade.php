@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card-header">{{ __('Add mapels for ') }} {{ $siswa->name }}</div>

            <div class="card-body">
                <form action="{{ route('admin.siswa.storeSubject', $siswa) }}" method="POST">
                    @csrf
                    <div class="form-group">
                            <label for="mapels">{{ __('Subjects') }}</label>
                            <select name="mapels[]" id="mapels" class="form-control" multiple required>
                                @foreach ($mapels as $kelas => $mapelGroup)
                                    <optgroup label="Kelas {{ $kelas }}">
                                        @foreach ($mapelGroup as $mapel)
                                            <option value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                            @error('mapels')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    <button type="submit" class="btn btn-primary">{{ __('Add mapels') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection