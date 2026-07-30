@extends('adminlte::page')

@section('title', 'Report Antrol')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>
            Report Antrol
        </h1>
    </div>
@stop

@section('content')

    <div class="card card-primary card-outline">

        <div class="card-header">
            <h3 class="card-title">Filter Data</h3>
        </div>

        <div class="card-body">

            <form id="formFilter">

                <div class="row align-items-end">

                    <div class="col-md-2">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ $tanggal }}">
                    </div>

                    <div class="col-md-4">
                        <label for="dokter_id">Dokter</label>
                        <select name="dokter_id" id="dokter_id" class="form-control select2">
                            <option value="">Semua Dokter</option>

                            @foreach ($dokter as $d)
                                <option value="{{ $d->ID }}">
                                    {{ $d->DokterAlias }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label for="status_t4">Status T4</label>
                        <select id="status_t4" class="form-control">
                            <option value="">Semua</option>
                            <option value="merah">Merah</option>
                            <option value="hijau">Hijau</option>
                            <option value="kuning">Jadwal tidak ditemukan</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-search"></i>
                            Tampilkan
                        </button>
                    </div>

                    <div class="col-md-2">
                        <button type="button" id="reload" class="btn btn-success btn-block">
                            <i class="fas fa-sync-alt"></i>
                            Refresh
                        </button>
                    </div>

                </div>

            </form>

        </div>

    </div>


    <div class="card">

        <div class="card-body">

            <div class="table-responsive">

                <table id="tableAntrol" class="table table-bordered table-striped table-hover">

                    <thead>

                        <tr>

                            <th>No</th>
                            <th>Tanggal</th>
                            <th>PxRS</th>
                            <th>No RM</th>
                            <th>Nama Pasien</th>
                            <th>Dokter</th>
                            <th>Poli</th>

                            <th>T1</th>
                            <th>T2</th>
                            <th>T3</th>
                            <th>T4</th>
                            <th>J BPJS</th>
                            <th>T5</th>
                            <th>T6</th>
                            <th>T7</th>

                        </tr>

                    </thead>

                </table>

            </div>

        </div>

    </div>

@stop

@section('plugins.Select2', true)
@section('plugins.Datatables', true)

@section('css')
    <style>
        .select2-container {
            width: 100% !important;
        }

        .select2-container .select2-selection--single {
            height: 38px !important;
            border: 1px solid #ced4da !important;
            border-radius: 8px !important;
            display: flex !important;
            align-items: center !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: normal !important;
            padding-left: 12px !important;
            display: flex !important;
            align-items: center !important;
            height: 46px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px !important;
            right: 10px !important;
        }
    </style>
@stop

@section('js')
    <script>
        $(function() {

            $('.select2').select2({
                width: '100%',
                placeholder: 'Semua Dokter',
                allowClear: true
            });

            let table = $('#tableAntrol').DataTable({
                processing: true,
                serverSide: false,
                responsive: true,
                autoWidth: false,

                ajax: {
                    url: "{{ route('antrol.report.data') }}",

                    data: function(d) {
                        d.tanggal = $('#tanggal').val();
                        d.dokter_id = $('#dokter_id').val();
                    },

                    dataSrc: 'data',

                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                },

                columns: [{
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'tanggal'
                    },
                    {
                        data: 'PxRS'
                    },
                    {
                        data: 'reg_num'
                    },
                    {
                        data: 'nama'
                    },
                    {
                        data: 'dokter'
                    },
                    {
                        data: 'sub_layanan'
                    },
                    {
                        data: 't1',
                        render: renderTask
                    },
                    {
                        data: 't2',
                        render: renderTask
                    },
                    {
                        data: 't3',
                        render: renderTask
                    },
                    {
                        data: 't4',
                        render: function(data, type, row) {

                            if (!data) {
                                return '<span class="badge badge-secondary">-</span>';
                            }

                            let warna = 'badge-warning';
                            let icon = 'fa-exclamation-circle';

                            if (row.t4_status === 'hijau') {
                                warna = 'badge-success';
                                icon = 'fa-check-circle';
                            }

                            if (row.t4_status === 'merah') {
                                warna = 'badge-danger';
                                icon = 'fa-times-circle';
                            }

                            return '<span class="badge ' + warna + '">' +
                                '<i class="fas ' + icon + ' mr-1"></i>' +
                                data +
                                '</span>';
                        }
                    },
                    {
                        data: 'jam_bpjs',
                        render: function(data) {
                            if (!data) {
                                return '<span class="badge badge-secondary">-</span>';
                            }

                            return '<span class="badge badge-info">' + data + '</span>';
                        }
                    },
                    {
                        data: 't5',
                        render: renderTask
                    },
                    {
                        data: 't6',
                        render: renderTask
                    },
                    {
                        data: 't7',
                        render: renderTask
                    },

                ]
            });

            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {

                if (settings.nTable.id !== 'tableAntrol') {
                    return true;
                }

                let selectedStatus = $('#status_t4').val();

                if (!selectedStatus) {
                    return true;
                }

                let row = table.row(dataIndex).data();

                return row && row.t4_status === selectedStatus;
            });

            $('#status_t4').on('change', function() {
                table.draw();
            });

            $('#formFilter').on('submit', function(e) {
                e.preventDefault();
                table.ajax.reload();
            });

            $('#reload').on('click', function() {
                table.ajax.reload();
            });

            function renderTask(data) {
                if (data === null || data === '') {
                    return '<span class="badge badge-danger">-</span>';
                }

                return '<span class="badge badge-success">' + data + '</span>';
            }

            function normalisasiJam(jam) {

                if (!jam) {
                    return '';
                }

                let bagian = jam
                    .trim()
                    .replace(/\./g, ':')
                    .split(':');

                let jamAngka = bagian[0] || '00';
                let menit = bagian[1] || '00';
                let detik = bagian[2] || '00';

                return jamAngka.padStart(2, '0') + ':' +
                    menit.padStart(2, '0') + ':' +
                    detik.padStart(2, '0');
            }

        });
    </script>
@stop
