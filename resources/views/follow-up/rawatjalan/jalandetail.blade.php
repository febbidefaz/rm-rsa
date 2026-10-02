@extends('adminlte::page')

@section('title', 'Detail Rawat Jalan')

@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)


@section('content_header')

    <div class="d-flex align-items-center">

        <a href="{{ route('rawatjalan.index') }}" class="btn btn-secondary btn-sm mr-3">

            <i class="fas fa-arrow-left"></i>

        </a>

        <h1 class="mb-0">
            Detail Rawat Jalan
        </h1>

    </div>

@stop


@section('content')

    @if (!$pasien)
        <div class="alert alert-warning">
            Data pasien tidak ditemukan.
        </div>
    @else
        {{-- ========================================================= --}}
        {{-- IDENTITAS PASIEN --}}
        {{-- ========================================================= --}}

        <div class="card shadow-sm mb-3 pasien-card">

            <div class="card-header pasien-header">

                <h3 class="card-title mb-0">

                    <i class="fas fa-user-injured mr-2"></i>

                    {{ $pasien->ID ?? '-' }}
                    <span class="mx-1">---</span>

                    {{ $pasien->RegNum ?? '-' }}
                    <span class="mx-1">---</span>

                    {{ $pasien->Nama ?? '-' }}
                    <span class="mx-1">---</span>

                    {{ $pasien->Addr ?? '-' }}

                </h3>

            </div>


            <div class="card-body py-3">

                <div class="row align-items-start patient-summary">

                    {{-- NO SEP --}}
                    <div class="col patient-summary-item">

                        <small class="text-muted d-block patient-summary-label">
                            No SEP
                        </small>

                        <div class="font-weight-bold patient-summary-value pasien-link"
                            onclick="showSepDetail('{{ $pasien->NoSEP ?? '' }}')">

                            {{ $pasien->NoSEP ?? '-' }}

                        </div>

                    </div>


                    {{-- PXRS --}}
                    <div class="col patient-summary-item">

                        <small class="text-muted d-block patient-summary-label">
                            PxRS
                        </small>

                        <div class="font-weight-bold patient-summary-value">

                            {{ $pasien->PxRS ?? '-' }}

                        </div>

                    </div>


                    {{-- DOKTER --}}
                    <div class="col patient-summary-item dokter-col">

                        <small class="text-muted d-block patient-summary-label">
                            Dokter
                        </small>

                        <div class="font-weight-bold patient-summary-value">

                            {{ $pasien->Dokter ?? '-' }}

                        </div>

                    </div>


                    {{-- POLI --}}
                    <div class="col patient-summary-item poli-col">

                        <small class="text-muted d-block patient-summary-label">
                            Poli
                        </small>

                        <div class="font-weight-bold patient-summary-value">

                            {{ $pasien->SubLayanan ?? '-' }}

                        </div>

                    </div>


                    {{-- TANGGAL MASUK --}}
                    <div class="col patient-summary-item tanggal-col">

                        <small class="text-muted d-block patient-summary-label">
                            Tanggal Masuk
                        </small>

                        <div class="patient-summary-value">

                            {{ !empty($pasien->Tanggal) ? date('d/m/Y', strtotime($pasien->Tanggal)) : '-' }}

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- ========================================================= --}}
        {{-- DATA SKDP --}}
        {{-- ========================================================= --}}

        <div class="card shadow-sm mb-3 skdp-card">

            {{-- HEADER --}}
            <div class="card-header skdp-header">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <h3 class="card-title mb-0">

                            <i class="fas fa-calendar-check mr-2"></i>

                            Data Surat Kontrol / SKDP

                        </h3>

                    </div>


                    <div class="d-flex align-items-center">

                        <span id="totalSKDP" class="badge badge-skdp mr-2 px-3 py-2">

                            0 Data

                        </span>


                        {{-- TAMBAH SKDP --}}
                        <button type="button" class="btn btn-sm btn-light mr-1" data-toggle="modal"
                            data-target="#modalTambahSKDP">

                            <i class="fas fa-plus-circle mr-1"></i>

                            Tambah SKDP

                        </button>


                        {{-- HISTORY --}}
                        <button type="button" class="btn btn-sm btn-warning mr-1" data-toggle="modal"
                            data-target="#modalHistorySKDP">

                            <i class="fas fa-history mr-1"></i>

                            History

                        </button>


                        {{-- CEK SKDP --}}
                        <button type="button" class="btn btn-sm btn-secondary" data-toggle="modal"
                            data-target="#modalCekSKDP">

                            <i class="fas fa-search mr-1"></i>

                            Cek SKDP

                        </button>

                    </div>

                </div>

            </div>


            {{-- BODY --}}
            <div class="card-body">

                {{-- STATUS FILTER --}}
                <div class="d-flex justify-content-between align-items-center mb-3">

                    <div>

                        <span class="text-muted small">
                            Tampilan:
                        </span>

                        <strong id="statusSKDP" style="color:#0F766E;">

                            Cek SKDP

                        </strong>

                    </div>


                    <div class="text-muted small">

                        <i class="far fa-calendar-alt mr-1"></i>

                        <span id="periodeSKDP">
                            {{ date('d-m-Y') }}
                        </span>

                    </div>

                </div>


                {{-- TABLE --}}
                <div class="table-responsive skdp-table-wrap">

                    <table id="tblSKDP" class="table table-sm table-bordered table-striped table-hover nowrap mb-0"
                        style="width:100%">

                        <thead>

                            <tr>

                                <th style="width:5px">
                                    No
                                </th>

                                <th>
                                    No Surat
                                </th>

                                <th>
                                    Tanggal
                                </th>

                                <th>
                                    Jenis Kontrol
                                </th>

                                <th>
                                    Poli Asal
                                </th>

                                <th>
                                    Poli Tujuan
                                </th>

                                <th>
                                    Dokter
                                </th>

                                <th>
                                    No SEP Asal
                                </th>

                                <th style="width:120px">
                                    Aksi
                                </th>

                            </tr>

                        </thead>

                        <tbody></tbody>

                    </table>

                </div>

            </div>

        </div>

        {{-- ========================================================= --}}
        {{-- MODAL HISTORY SKDP --}}
        {{-- ========================================================= --}}

        <div class="modal fade" id="modalHistorySKDP" tabindex="-1">

            <div class="modal-dialog modal-md">

                <div class="modal-content border-0 shadow">

                    <div class="modal-header modal-skdp-header">

                        <h5 class="modal-title">

                            <i class="fas fa-history mr-2"></i>

                            History SKDP

                        </h5>

                        <button type="button" class="close text-white" data-dismiss="modal">

                            <span>&times;</span>

                        </button>

                    </div>


                    <div class="modal-body">

                        <div class="form-group mb-0">

                            <label>
                                Bulan
                            </label>

                            <input type="month" id="history_bulan" class="form-control" value="{{ date('Y-m') }}">

                        </div>

                    </div>


                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-dismiss="modal">

                            Batal

                        </button>


                        <button type="button" id="btnHistorySKDP" class="btn btn-skdp">

                            <i class="fas fa-search mr-1"></i>

                            Tampilkan

                        </button>

                    </div>

                </div>

            </div>

        </div>

        {{-- ========================================================= --}}
        {{-- MODAL CEK SKDP --}}
        {{-- ========================================================= --}}

        <div class="modal fade" id="modalCekSKDP" tabindex="-1">

            <div class="modal-dialog modal-md">

                <div class="modal-content border-0 shadow">

                    <div class="modal-header modal-skdp-header">

                        <h5 class="modal-title">

                            <i class="fas fa-search mr-2"></i>

                            Cek SKDP

                        </h5>

                        <button type="button" class="close text-white" data-dismiss="modal">

                            <span>&times;</span>

                        </button>

                    </div>


                    <div class="modal-body">

                        <div class="form-group">

                            <label>
                                Tanggal Awal
                            </label>

                            <input type="date" id="skdp_tgl_awal" class="form-control" value="{{ date('Y-m-d') }}">

                        </div>


                        <div class="form-group mb-0">

                            <label>
                                Tanggal Akhir
                            </label>

                            <input type="date" id="skdp_tgl_akhir" class="form-control" value="{{ date('Y-m-d') }}">

                        </div>

                    </div>


                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-dismiss="modal">

                            Batal

                        </button>


                        <button type="button" id="btnCekSKDP" class="btn btn-skdp">

                            <i class="fas fa-search mr-1"></i>

                            Tampilkan

                        </button>

                    </div>

                </div>

            </div>

        </div>

        {{-- ========================================================= --}}
        {{-- MODAL TAMBAH SKDP --}}
        {{-- ========================================================= --}}

        <div class="modal fade" id="modalTambahSKDP" tabindex="-1">

            <div class="modal-dialog modal-lg">

                <div class="modal-content border-0 shadow">

                    <div class="modal-header modal-skdp-header">

                        <h5 class="modal-title">

                            <i class="fas fa-plus-circle mr-2"></i>

                            Tambah Surat Kontrol / SKDP

                        </h5>

                        <button type="button" class="close text-white" data-dismiss="modal">

                            <span>&times;</span>

                        </button>

                    </div>


                    <form action="{{ route('skdp.post') }}" method="POST">

                        @csrf


                        <input type="hidden" name="user" value="{{ Auth::user()?->name ?? 'WEB-RJ' }}">


                        <div class="modal-body">

                            <div class="row">


                                {{-- NO SEP --}}
                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label>
                                            No SEP
                                        </label>

                                        <input type="text" name="noSEP" class="form-control"
                                            value="{{ $pasien->NoSEP ?? '' }}" required>

                                    </div>

                                </div>


                                {{-- TANGGAL --}}
                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label>
                                            Tanggal Rencana Kontrol
                                        </label>

                                        <input type="date" name="tglRencanaKontrol" class="form-control"
                                            value="{{ date('Y-m-d') }}" required>

                                    </div>

                                </div>


                                {{-- DOKTER --}}
                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label>
                                            Dokter
                                        </label>

                                        <select id="kodeDokterPost" name="kodeDokter" class="form-control"
                                            style="width:100%" required>

                                            <option value="">
                                                -- Pilih Dokter --
                                            </option>

                                        </select>

                                    </div>

                                </div>


                                {{-- POLI --}}
                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label>
                                            Poli Kontrol
                                        </label>

                                        <select id="poliKontrolPost" name="poliKontrol" class="form-control"
                                            style="width:100%" required>

                                            <option value="">
                                                -- Pilih Poli --
                                            </option>

                                        </select>

                                    </div>

                                </div>


                            </div>

                        </div>


                        <div class="modal-footer">

                            <button type="button" class="btn btn-secondary" data-dismiss="modal">

                                Batal

                            </button>


                            <button type="submit" class="btn btn-skdp">

                                <i class="fas fa-save mr-1"></i>

                                Simpan SKDP

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>
    @endif

@stop


@section('css')

    <style>
        :root {
            --primary-rj: #0F766E;
            --primary-rj-dark: #0b5f59;
            --primary-rj-soft: #edf8f7;
        }


        .pasien-card,
        .skdp-card {
            border: none;
            border-radius: 10px;
            overflow: hidden;
        }


        .pasien-header,
        .skdp-header {
            background: #0F766E !important;
            color: #ffffff !important;
            border-bottom: none;
            padding: 12px 16px;
        }


        .pasien-header .card-title,
        .skdp-header .card-title {
            font-size: 17px;
            font-weight: 600;
            line-height: 1.4;
        }


        .patient-summary {
            margin-left: -10px;
            margin-right: -10px;
        }


        .patient-summary-item {
            padding-left: 16px;
            padding-right: 16px;
            min-width: 150px;
            border-right: 1px solid #e5eceb;
        }


        .patient-summary-item:last-child {
            border-right: none;
        }


        .patient-summary-label {
            margin-bottom: 3px;
            font-size: 13px;
            font-weight: 500;
            line-height: 1.2;
            color: #6c757d !important;
            white-space: nowrap;
        }


        .patient-summary-value {
            min-height: 22px;
            font-size: 16px;
            line-height: 1.35;
            color: #2f3a39;
            word-break: break-word;
        }


        .pasien-link {
            color: #0F766E !important;
            cursor: pointer;
        }


        .pasien-link:hover {
            color: #0b5f59 !important;
            text-decoration: underline;
        }


        .dokter-col {
            min-width: 220px;
        }


        .poli-col {
            min-width: 180px;
        }


        .tanggal-col {
            min-width: 150px;
        }


        .badge-skdp {
            background: #ffffff;
            color: #0F766E;
            font-size: 13px;
            font-weight: 700;
            border-radius: 8px;
        }


        .filter-label {
            display: block;
            margin-bottom: 4px;
            font-size: 13px;
            font-weight: 600;
            color: #6c757d;
        }


        .form-control {
            border-radius: 7px;
        }


        .form-control:focus {
            border-color: #0F766E !important;
            box-shadow: 0 0 0 .15rem rgba(15, 118, 110, .15) !important;
        }


        .btn-skdp {
            background: #0F766E !important;
            border-color: #0F766E !important;
            color: #ffffff !important;
            border-radius: 7px;
        }


        .btn-skdp:hover,
        .btn-skdp:focus {
            background: #0b5f59 !important;
            border-color: #0b5f59 !important;
            color: #ffffff !important;
        }


        .skdp-table-wrap {
            max-height: 500px;
            overflow: auto;
        }


        #tblSKDP {
            min-width: 1250px;
        }


        #tblSKDP thead th {
            position: sticky;
            top: 0;
            z-index: 2;
            background: #0F766E !important;
            color: #ffffff !important;
            border-color: rgba(255, 255, 255, .20);
            font-size: 13px;
            font-weight: 600;
            vertical-align: middle;
            white-space: nowrap;
        }


        #tblSKDP tbody td {
            font-size: 13px;
            vertical-align: middle;
            white-space: nowrap;
        }


        #tblSKDP tbody tr:hover td {
            background: #edf8f7 !important;
        }


        .page-item.active .page-link {
            background: #0F766E !important;
            border-color: #0F766E !important;
        }


        .page-link {
            color: #0F766E;
        }


        @media (max-width: 991.98px) {

            .patient-summary-item {
                flex: 0 0 50%;
                max-width: 50%;
                padding-top: 8px;
                padding-bottom: 8px;
                border-right: none;
                border-bottom: 1px solid #e5eceb;
            }

        }


        @media (max-width: 575.98px) {

            .patient-summary-item {
                flex: 0 0 100%;
                max-width: 100%;
            }

        }

        .skdp-card {
            border: none;
            border-radius: 10px;
            overflow: hidden;
        }

        .skdp-header,
        .modal-skdp-header {
            background: #0F766E !important;
            color: white !important;
        }

        .skdp-header {
            padding: 12px 16px;
        }

        .skdp-header .card-title {
            font-size: 17px;
            font-weight: 600;
        }

        .badge-skdp {
            background: white;
            color: #0F766E;
            font-size: 13px;
            font-weight: 700;
            border-radius: 8px;
        }

        .btn-skdp {
            background: #0F766E !important;
            border-color: #0F766E !important;
            color: white !important;
        }

        .btn-skdp:hover {
            background: #0b5f59 !important;
            border-color: #0b5f59 !important;
            color: white !important;
        }

        #tblSKDP thead th {
            background: #0F766E !important;
            color: white !important;
            vertical-align: middle;
            white-space: nowrap;
            font-size: 13px;
        }

        #tblSKDP tbody td {
            vertical-align: middle;
            white-space: nowrap;
            font-size: 13px;
        }

        #tblSKDP tbody tr:hover td {
            background: #edf8f7 !important;
        }

        .skdp-table-wrap {
            max-height: 500px;
            overflow: auto;
        }

        .skdp-table-wrap::-webkit-scrollbar {
            height: 9px;
            width: 9px;
        }

        .skdp-table-wrap::-webkit-scrollbar-thumb {
            background: #63aaa4;
            border-radius: 10px;
        }

        .skdp-table-wrap::-webkit-scrollbar-thumb:hover {
            background: #0F766E;
        }
    </style>

@stop


@section('js')

    <script>
        let tableSKDP;

        $(function() {

            tableSKDP = $('#tblSKDP').DataTable({

                processing: true,

                responsive: false,

                autoWidth: false,

                ajax: {

                    url: "{{ route('rawatjalan.skdp.data') }}",

                    type: "GET",

                    data: function(d) {

                        let periode = $('#history_bulan').val();

                        if (!periode) {
                            periode = "{{ date('Y-m') }}";
                        }

                        let pecah = periode.split('-');

                        d.tahun = pecah[0];
                        d.bulan = pecah[1];

                        d.noka = "{{ $pasien->NoJKN ?? '' }}";

                        d.filter = 1;
                    },

                    dataSrc: function(json) {

                        console.log(
                            'RESPONSE LARAVEL SKDP:',
                            json
                        );

                        if (json.debug) {
                            console.error(
                                'DEBUG SKDP:',
                                json.debug
                            );
                        }

                        return json.data || [];
                    },

                    error: function(xhr) {

                        console.error(
                            'STATUS AJAX:',
                            xhr.status
                        );

                        console.error(
                            'RESPONSE AJAX:',
                            xhr.responseText
                        );

                    }

                },
                columns: [

                    {
                        data: null,

                        orderable: false,

                        searchable: false,

                        render: function(data, type, row, meta) {

                            return meta.row +
                                meta.settings._iDisplayStart +
                                1;

                        }
                    },


                    {
                        data: 'noSuratKontrol',
                        defaultContent: '-'
                    },


                    {
                        data: 'tglRencanaKontrol',

                        render: function(data) {

                            if (!data) {
                                return '-';
                            }

                            let p = data.split('-');

                            if (p.length === 3) {
                                return p[2] +
                                    '-' +
                                    p[1] +
                                    '-' +
                                    p[0];
                            }

                            return data;

                        }
                    },


                    {
                        data: 'namaJnsKontrol',
                        defaultContent: '-'
                    },


                    {
                        data: 'namaPoliAsal',
                        defaultContent: '-'
                    },


                    {
                        data: 'namaPoliTujuan',
                        defaultContent: '-'
                    },


                    {
                        data: 'namaDokter',
                        defaultContent: '-'
                    },


                    {
                        data: 'noSepAsalKontrol',
                        defaultContent: '-'
                    },


                    {
                        data: null,

                        orderable: false,

                        searchable: false,

                        render: function(data, type, row) {

                            let json =
                                encodeURIComponent(
                                    JSON.stringify(row)
                                );

                            return `
                        <button
                            type="button"
                            class="btn btn-info btn-sm"
                            onclick="detailSKDP('${json}')">

                            <i class="fas fa-eye"></i>

                        </button>
                    `;

                        }
                    }

                ],


                pageLength: 25,


                order: [
                    [2, 'desc']
                ],


                drawCallback: function(settings) {

                    let total =
                        settings.fnRecordsTotal();

                    $('#totalSKDP')
                        .text(total + ' Data');

                },


                language: {

                    search: 'Cari:',

                    lengthMenu: 'Tampilkan _MENU_ data',

                    info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',

                    infoEmpty: 'Tidak ada data',

                    zeroRecords: 'SKDP tidak ditemukan',

                    processing: 'Mengambil data SKDP...',

                    paginate: {

                        previous: 'Sebelumnya',

                        next: 'Berikutnya'

                    }

                }

            });


            /*
            |--------------------------------------------------------------------------
            | CEK SKDP
            |--------------------------------------------------------------------------
            */

            $('#btnCekSKDP').on('click', function() {

                let awal =
                    $('#skdp_tgl_awal').val();

                let akhir =
                    $('#skdp_tgl_akhir').val();


                $('#statusSKDP')
                    .text('Cek SKDP');


                $('#periodeSKDP')
                    .text(
                        awal + ' s/d ' + akhir
                    );


                $('#modalCekSKDP')
                    .modal('hide');


                tableSKDP
                    .ajax
                    .reload();

            });

        });

        $('#btnHistorySKDP').on('click', function() {

            let periode = $('#history_bulan').val();

            if (!periode) {
                return;
            }

            $('#statusSKDP')
                .text('History SKDP');

            $('#periodeSKDP')
                .text(periode);

            $('#modalHistorySKDP')
                .modal('hide');

            tableSKDP
                .ajax
                .reload();
        });
    </script>

@stop
