@extends('adminlte::page')

@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)

@section('title', 'Rawat Jalan')

@section('content_header')

    <div class="d-flex align-items-center">

        <h1 class="mb-0 mr-2">
            Data Rawat Jalan
        </h1>

        <span class="badge badge-info shadow-sm px-3 py-2" id="totalPasienHeader"
            style="
                    font-size:14px;
                    font-weight:700;
                    border-radius:10px;
                    letter-spacing:0.5px;
              ">

            0 Pasien

        </span>

    </div>

@stop


@section('content')

    <div class="card shadow-sm">

        {{-- FILTER --}}
        <div class="card-header bg-light">

            <div class="row align-items-end">

                {{-- TANGGAL AWAL --}}
                <div class="col-md-2">

                    <div class="form-group mb-0">

                        <label>
                            Tanggal Awal
                        </label>

                        <input type="text" id="tgl1" class="form-control datepicker" value="{{ date('d-m-Y') }}"
                            autocomplete="off">

                    </div>

                </div>


                {{-- TANGGAL AKHIR --}}
                <div class="col-md-2">

                    <div class="form-group mb-0">

                        <label>
                            Tanggal Akhir
                        </label>

                        <input type="text" id="tgl2" class="form-control datepicker" value="{{ date('d-m-Y') }}"
                            autocomplete="off">

                    </div>

                </div>


                {{-- DOKTER --}}
                <div class="col-md-3">

                    <div class="form-group mb-0">

                        <label>
                            Dokter
                        </label>

                        <select id="dokter_id" class="form-control">

                            <option value="">
                                Semua Dokter
                            </option>

                            @foreach ($dokter as $d)
                                <option value="{{ $d->ID }}">
                                    {{ $d->DokterAlias }}
                                </option>
                            @endforeach

                        </select>

                    </div>

                </div>


                {{-- JENIS PASIEN --}}
                <div class="col-md-2">

                    <div class="form-group mb-0">

                        <label>
                            Jenis Pasien
                        </label>

                        <select id="upx_id" class="form-control">

                            <option value="">
                                Semua
                            </option>

                            @foreach ($upx as $u)
                                <option value="{{ $u->ID }}">
                                    {{ $u->PxRS }}
                                </option>
                            @endforeach

                        </select>

                    </div>

                </div>


                {{-- JAM PRAKTEK --}}
                <div class="col-md-2">

                    <div class="form-group mb-0">

                        <label>
                            Jam Praktek
                        </label>

                        <select id="jam_praktek" class="form-control">

                            <option value="">
                                Semua
                            </option>

                            <option value="1">
                                Pagi
                            </option>

                            <option value="2">
                                Sore
                            </option>

                        </select>

                    </div>

                </div>


                {{-- BUTTON --}}
                <div class="col-md-1">

                    <button type="button" id="btnFilter" class="btn btn-info btn-block">

                        <i class="fas fa-search"></i>

                    </button>

                </div>

            </div>

        </div>


        {{-- TABLE --}}
        <div class="card-body p-0">

            <div class="table-wrap">

                <table id="tblRawatJalan" class="table table-hover table-striped table-bordered nowrap">

                    <thead class="bg-info">

                        <tr>

                            <th>No</th>

                            <th>PxRS</th>

                            <th>ID</th>

                            <th>No RM</th>

                            <th>Nama Pasien</th>

                            <th>Tanggal</th>

                            <th>Dokter</th>

                            <th>JP</th>

                            <th>No SEP</th>

                            <th>Layanan</th>

                            <th>Sub Layanan</th>

                        </tr>

                    </thead>

                    <tbody></tbody>

                </table>

            </div>

        </div>

    </div>

@stop


@section('css')

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css">

    <style>
        .table-wrap {
            width: 100%;
            overflow-x: auto;
            overflow-y: auto;
            max-height: 70vh;
            position: relative;
        }


        #tblRawatJalan {
            min-width: 1300px !important;
            width: 100% !important;
        }


        #tblRawatJalan th,
        #tblRawatJalan td {

            white-space: nowrap;
            vertical-align: middle;

        }


        #tblRawatJalan thead th {

            position: sticky;

            top: 0;

            z-index: 2;

            background: #0F766E !important;

            color: white;

        }


        #tblRawatJalan tbody tr {

            cursor: pointer;

        }


        #tblRawatJalan tbody tr:hover {

            background-color: #e8f6f8 !important;

        }


        .table-wrap::-webkit-scrollbar {

            height: 12px;
            width: 10px;

        }


        .table-wrap::-webkit-scrollbar-thumb {

            background: #999;

            border-radius: 10px;

        }


        .form-control {

            border-radius: 7px;

        }


        .card {

            border-radius: 10px;

        }


        #totalPasienHeader {

            min-width: 90px;

            text-align: center;

        }

        :root {
            --warna-utama: #0F766E;
        }


        /* HEADER TABEL */
        #tblRawatJalan thead th {
            background: #0F766E !important;
            color: #ffffff !important;
        }


        /* BADGE JUMLAH PASIEN */
        #totalPasienHeader {
            background-color: #0F766E !important;
            color: #ffffff !important;
            border-color: #0F766E !important;
        }


        /* BUTTON TAMPILKAN */
        #btnFilter {
            background-color: #0F766E !important;
            border-color: #0F766E !important;
            color: white !important;
        }


        /* BUTTON HOVER */
        #btnFilter:hover,
        #btnFilter:focus,
        #btnFilter:active {
            background-color: #0b5f59 !important;
            border-color: #0b5f59 !important;
            color: white !important;
        }


        /* INPUT / SELECT FOCUS */
        .form-control:focus {
            border-color: #0F766E !important;
            box-shadow: 0 0 0 0.2rem rgba(15, 118, 110, 0.20) !important;
        }


        /* ROW HOVER */
        #tblRawatJalan tbody tr:hover {
            background-color: rgba(15, 118, 110, 0.08) !important;
        }


        /* DATATABLE PAGINATION ACTIVE */
        .page-item.active .page-link {
            background-color: #0F766E !important;
            border-color: #0F766E !important;
            color: white !important;
        }


        /* DATATABLE PAGINATION LINK */
        .page-link {
            color: #0F766E;
        }

        .page-link:hover {
            color: #ffffff;
            background-color: #0F766E;
            border-color: #0F766E;
        }


        /* DATATABLE LENGTH SELECT */
        .dataTables_length select:focus {
            border-color: #0F766E !important;
        }


        /* DATATABLE SEARCH */
        .dataTables_filter input:focus {
            border-color: #0F766E !important;
            box-shadow: 0 0 0 0.15rem rgba(15, 118, 110, .15) !important;
        }


        /* DATEPICKER */
        .datepicker table tr td.active,
        .datepicker table tr td.active:hover,
        .datepicker table tr td.active.active {
            background: #0F766E !important;
            background-image: none !important;
            color: white !important;
        }


        /* TODAY DATEPICKER */
        .datepicker table tr td.today {
            background: rgba(15, 118, 110, .15) !important;
            color: #0F766E !important;
        }


        /* SCROLLBAR */
        .table-wrap::-webkit-scrollbar-thumb {
            background: #0F766E !important;
            border-radius: 10px;
        }
    </style>

@stop


@section('js')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js">
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/locales/bootstrap-datepicker.id.min.js">
    </script>


    <script>
        let tableRawatJalan;


        /*
        |--------------------------------------------------------------------------
        | LOCAL STORAGE
        |--------------------------------------------------------------------------
        */

        const userId = "{{ auth()->id() ?? 'guest' }}";

        const keyPrefix =
            "followup_rawat_jalan_" + userId + "_";


        /*
        |--------------------------------------------------------------------------
        | SIMPAN FILTER
        |--------------------------------------------------------------------------
        */

        function simpanFilterRawatJalan() {

            localStorage.setItem(
                keyPrefix + "tgl_awal",
                $('#tgl1').val()
            );


            localStorage.setItem(
                keyPrefix + "tgl_akhir",
                $('#tgl2').val()
            );


            localStorage.setItem(
                keyPrefix + "dokter_id",
                $('#dokter_id').val()
            );


            localStorage.setItem(
                keyPrefix + "upx_id",
                $('#upx_id').val()
            );


            localStorage.setItem(
                keyPrefix + "jam_praktek",
                $('#jam_praktek').val()
            );

        }


        /*
        |--------------------------------------------------------------------------
        | LOAD FILTER
        |--------------------------------------------------------------------------
        */

        function loadFilterRawatJalan() {

            let tglAwal =
                localStorage.getItem(
                    keyPrefix + "tgl_awal"
                );


            let tglAkhir =
                localStorage.getItem(
                    keyPrefix + "tgl_akhir"
                );


            let dokter =
                localStorage.getItem(
                    keyPrefix + "dokter_id"
                );


            let upx =
                localStorage.getItem(
                    keyPrefix + "upx_id"
                );


            let jam =
                localStorage.getItem(
                    keyPrefix + "jam_praktek"
                );


            if (tglAwal)
                $('#tgl1').val(tglAwal);


            if (tglAkhir)
                $('#tgl2').val(tglAkhir);


            if (dokter !== null)
                $('#dokter_id').val(dokter);


            if (upx !== null)
                $('#upx_id').val(upx);


            if (jam !== null)
                $('#jam_praktek').val(jam);

        }


        /*
        |--------------------------------------------------------------------------
        | DD-MM-YYYY → YYYY-MM-DD
        |--------------------------------------------------------------------------
        */

        function toDbDate(tgl) {

            if (!tgl)
                return '';


            let p = tgl.split('-');


            if (p.length !== 3)
                return tgl;


            return p[2] +
                '-' +
                p[1] +
                '-' +
                p[0];

        }


        /*
        |--------------------------------------------------------------------------
        | FORMAT TANGGAL
        |--------------------------------------------------------------------------
        */

        function formatTanggal(data) {

            if (!data)
                return '-';


            let datePart =
                data.toString()
                .substring(0, 10);


            let bagian =
                datePart.split('-');


            if (bagian.length !== 3)
                return data;


            return bagian[2] +
                '-' +
                bagian[1] +
                '-' +
                bagian[0];

        }


        $(function() {


            /*
            |--------------------------------------------------------------------------
            | DATE PICKER
            |--------------------------------------------------------------------------
            */

            $('.datepicker').datepicker({

                format: 'dd-mm-yyyy',

                autoclose: true,

                todayHighlight: true,

                language: 'id'

            });


            /*
            |--------------------------------------------------------------------------
            | LOAD SAVED FILTER
            |--------------------------------------------------------------------------
            */

            loadFilterRawatJalan();


            /*
            |--------------------------------------------------------------------------
            | DATATABLE
            |--------------------------------------------------------------------------
            */

            tableRawatJalan =
                $('#tblRawatJalan').DataTable({

                    processing: true,

                    stateSave: true,

                    responsive: false,

                    autoWidth: false,


                    /*
                    |--------------------------------------------------------------------------
                    | STATE SAVE
                    |--------------------------------------------------------------------------
                    */

                    stateSaveCallback: function(settings, data) {

                        localStorage.setItem(

                            keyPrefix +
                            "datatable_state",

                            JSON.stringify(data)

                        );

                    },


                    stateLoadCallback: function(settings) {

                        let state =
                            localStorage.getItem(

                                keyPrefix +
                                "datatable_state"

                            );


                        return state ?
                            JSON.parse(state) :
                            null;

                    },


                    /*
                    |--------------------------------------------------------------------------
                    | AJAX
                    |--------------------------------------------------------------------------
                    */

                    ajax: {

                        url: "{{ route('rawatjalan.data') }}",

                        data: function(d) {

                            d.tgl_awal =
                                toDbDate(
                                    $('#tgl1').val()
                                );


                            d.tgl_akhir =
                                toDbDate(
                                    $('#tgl2').val()
                                );


                            d.dokter_id =
                                $('#dokter_id').val();


                            d.upx_id =
                                $('#upx_id').val();


                            d.jam_praktek =
                                $('#jam_praktek').val();

                        }

                    },


                    /*
                    |--------------------------------------------------------------------------
                    | COLUMN
                    |--------------------------------------------------------------------------
                    */

                    columns: [

                        {

                            data: null,

                            orderable: false,

                            searchable: false,

                            render: function(
                                data,
                                type,
                                row,
                                meta
                            ) {

                                return meta.row +
                                    meta.settings
                                    ._iDisplayStart +
                                    1;

                            }

                        },

                        {

                            data: 'JenisPasien',

                            defaultContent: '-'

                        },



                        {

                            data: 'ID',

                            defaultContent: '-'

                        },


                        {

                            data: 'NoRM',

                            defaultContent: '-'

                        },


                        {

                            data: 'Nama',

                            defaultContent: '-'

                        },


                        {

                            data: 'Tanggal',

                            render: function(data) {

                                return formatTanggal(
                                    data
                                );

                            }

                        },


                        {

                            data: 'Dokter',

                            defaultContent: '-'

                        },


                        {

                            data: 'JamPraktek',

                            defaultContent: '-'

                        },


                        {

                            data: 'NoSEP',

                            defaultContent: '-'

                        },


                        {

                            data: 'Layanan',

                            defaultContent: '-'

                        },


                        {

                            data: 'SubLayanan',

                            defaultContent: '-'

                        }

                    ],


                    /*
                    |--------------------------------------------------------------------------
                    | ROW CLICK
                    |--------------------------------------------------------------------------
                    */

                    createdRow: function(row, data) {

                        $(row).css('cursor', 'pointer');

                        $(row).on('click', function() {

                            simpanFilterRawatJalan();

                            window.location.href =
                                "{{ route('rawatjalan.detail', ':id') }}"
                                .replace(':id', data.ID);

                        });

                    },


                    /*
                    |--------------------------------------------------------------------------
                    | PAGING
                    |--------------------------------------------------------------------------
                    */

                    paging: true,

                    pageLength: 100,


                    lengthMenu: [

                        [25, 50, 100, 200, -1],

                        [
                            25,
                            50,
                            100,
                            200,
                            "Semua"
                        ]

                    ],


                    ordering: true,


                    order: [

                        [1, 'desc']

                    ],


                    /*
                    |--------------------------------------------------------------------------
                    | TOTAL
                    |--------------------------------------------------------------------------
                    */

                    drawCallback: function(settings) {

                        let total =
                            settings
                            .fnRecordsTotal();


                        $('#totalPasienHeader')
                            .html(
                                total +
                                ' Pasien'
                            );

                    },


                    /*
                    |--------------------------------------------------------------------------
                    | BAHASA
                    |--------------------------------------------------------------------------
                    */

                    language: {

                        search: "Cari:",

                        lengthMenu: "Tampilkan _MENU_ data",

                        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",

                        infoEmpty: "Tidak ada data",

                        zeroRecords: "Data pasien tidak ditemukan",

                        processing: "Memuat data...",

                        paginate: {

                            previous: "Sebelumnya",

                            next: "Berikutnya"

                        }

                    }

                });


            /*
            |--------------------------------------------------------------------------
            | SIMPAN SAAT FILTER BERUBAH
            |--------------------------------------------------------------------------
            */

            $('#tgl1, #tgl2, #dokter_id, #upx_id, #jam_praktek')
                .on(
                    'change',
                    function() {

                        simpanFilterRawatJalan();

                    }
                );


            /*
            |--------------------------------------------------------------------------
            | TOMBOL FILTER
            |--------------------------------------------------------------------------
            */

            $('#btnFilter')
                .on(
                    'click',
                    function() {

                        simpanFilterRawatJalan();

                        tableRawatJalan
                            .ajax
                            .reload();

                    }
                );

        });
    </script>

@stop
