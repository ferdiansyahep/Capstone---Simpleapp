@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Konten Utama -->
        <div class="col-md-8">
            <h1 style="font-weight: 700;">SMP AL-AZHAR SYIFA BUDI</h1>
            <img src="{{ asset('img/img-dash.jpeg') }}" class="rounded d-block mt-3 w-100"
                style="max-height: 300px; object-fit: cover;">
            <div class="row mt-3">
                <div class="col-md-6 mb-3">
                    <div
                        class="card p-4 d-flex justify-content-center align-items-center bg-primary-dashboard text-light h-100">
                        <div class="card-block">
                            <h6 class="m-b-20">Jumlah Siswa Laki-laki</h6>
                            <h2 class="text-center">{{ $studentMaleCount }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div
                        class="card p-4 d-flex justify-content-center align-items-center bg-secondary-card text-light h-100">
                        <div class="card-block">
                            <h6 class="m-b-20">Jumlah Siswa Perempuan</h6>
                            <h2 class="text-center">{{ $studentWomenCount }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div
                        class="card p-4 d-flex justify-content-center align-items-center bg-secondary-card text-light h-100">
                        <div class="card-block">
                            <h6 class="m-b-20">Jumlah Guru</h6>
                            <h2 class="text-center">{{ $teacherCount }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div
                        class="card p-4 d-flex justify-content-center align-items-center bg-primary-dashboard text-light h-100">
                        <div class="card-block">
                            <h6 class="m-b-20">Jumlah Siswa Keseluruhan</h6>
                            <h2 class="text-center">{{ $allStudentCount }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <section class="ftco-section">
                <div class="calendar calendar-first shadow-md rounded" id="calendar_first"
                    style="max-height: 300px; overflow-y: auto;">
                    <div class="calendar_header">
                        <button class="switch-month switch-left"> <i class="fa fa-chevron-left"></i></button>
                        <h2></h2>
                        <button class="switch-month switch-right"> <i class="fa fa-chevron-right"></i></button>
                    </div>
                    <div class="calendar_weekdays"></div>
                    <div class="calendar_content"></div>
                </div>
            </section>

            <div class="row mt-3">
                <div class="col-md-12">
                    <section class="identitas-sekolah">
                        <div class="header-identitas">
                            <h4 class="text-center">Form Data Sekolah</h4>
                        </div>
                        <div class="body-identitas d-flex justify-content-center align-items-center">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="identitas-item">
                                        <p>Nama Sekolah</p>
                                        <p>Email</p>
                                        <p>Website</p>
                                        <p>Alamat</p>
                                        <p>Telepon</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="identitas-item">
                                        <p>SMP Al-Azhar Syifa Budi</p>
                                        <p>info@smkn1contohkota.sch.id</p>
                                        <p><a href="http://www.smkn1contohkota.sch.id"
                                                target="_blank">www.smkn1contohkota.sch.id</a></p>
                                        <p>Jl. Pahlawan No. 123, Contoh Kota</p>
                                        <p>(021) 1234567</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection