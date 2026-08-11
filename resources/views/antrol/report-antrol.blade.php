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
    <!-- Modal T4, T5, T6, T7-->
    <div class="modal fade" id="modalTask" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">

                <div class="modal-header bg-primary">
                    <h5 class="modal-title">
                        Edit <span id="taskTitle">Task</span>
                    </h5>

                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="alert alert-light border">
                        <div>
                            <strong>Pasien:</strong>
                            <span id="taskNama">-</span>
                        </div>

                        <div>
                            <strong>No RM:</strong>
                            <span id="taskRm">-</span>
                        </div>

                        <div>
                            <strong>Dokter:</strong>
                            <span id="taskDokter">-</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Task ID</label>

                        <input type="text" id="taskOriginal" class="form-control" readonly>
                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jam Saat Ini</label>

                                <input type="text" id="taskJamOriginal" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jam Baru</label>

                                <input type="text" id="taskJamBaru" class="form-control font-weight-bold" readonly>
                            </div>
                        </div>

                    </div>

                    <label>Tambah / Kurangi Waktu</label>

                    <div class="d-flex justify-content-center flex-wrap mb-3">

                        <button type="button" class="btn btn-danger m-1 btn-adjust-task" data-menit="-10">
                            -10
                        </button>

                        <button type="button" class="btn btn-danger m-1 btn-adjust-task" data-menit="-5">
                            -5
                        </button>

                        <button type="button" class="btn btn-outline-danger m-1 btn-adjust-task" data-menit="-1">
                            -1
                        </button>

                        <button type="button" class="btn btn-outline-success m-1 btn-adjust-task" data-menit="1">
                            +1
                        </button>

                        <button type="button" class="btn btn-success m-1 btn-adjust-task" data-menit="5">
                            +5
                        </button>

                        <button type="button" class="btn btn-success m-1 btn-adjust-task" data-menit="10">
                            +10
                        </button>

                    </div>

                    <div class="form-group">
                        <label>Perubahan Menit</label>

                        <input type="number" id="taskAdjust" class="form-control text-center" value="0">
                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Batal
                    </button>

                    <button type="button" id="btnSimpanTask" class="btn btn-primary">
                        Simpan
                    </button>

                </div>

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

            function renderTask(data) {

                if (data === null || data === '') {
                    return '<span class="badge badge-danger">-</span>';
                }

                return '<span class = "badge badge-success" > ' + data + ' < /span>';
            }

            function waktuKeMenit(jam) {

                if (!jam) {
                    return null;
                }

                let bagian = jam.split(':');

                let hour = parseInt(bagian[0] || 0);
                let minute = parseInt(bagian[1] || 0);

                return (hour * 60) + minute;
            }

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
                        render: function(data) {

                            if (!data) {
                                return '<span class="badge badge-danger">-</span>';
                            }

                            return '<span class="badge badge-success">' + data + '</span>';
                        }
                    },
                    {
                        data: 't2',
                        render: function(data, type, row) {

                            if (!data) {
                                return '<span class="badge badge-danger">-</span>';
                            }

                            let warning =
                                row.t1 &&
                                waktuKeMenit(data) < waktuKeMenit(row.t1);

                            return `
            <span class="badge ${warning ? 'badge-warning' : 'badge-success'}">
                ${data}
            </span>

            ${warning
                ? '<span class="badge badge-danger ml-1" title="T2 lebih awal dari T1">!</span>'
                : ''
            }
        `;
                        }
                    },
                    {
                        data: 't3',
                        render: function(data, type, row) {

                            if (!data) {
                                return '<span class="badge badge-danger">-</span>';
                            }

                            let warning =
                                row.t2 &&
                                waktuKeMenit(data) < waktuKeMenit(row.t2);

                            return `
            <span class="badge ${warning ? 'badge-warning' : 'badge-success'}">
                ${data}
            </span>

            ${warning
                ? '<span class="badge badge-danger ml-1" title="T3 lebih awal dari T2">!</span>'
                : ''
            }
        `;
                        }
                    },
                    {
                        data: 't4',
                        render: function(data, type, row) {

                            if (!data) {
                                return '<span class="badge badge-secondary">-</span>';
                            }

                            let warna = 'badge-warning';

                            if (row.t4_status === 'hijau') {
                                warna = 'badge-success';
                            }

                            if (row.t4_status === 'merah') {
                                warna = 'badge-danger';
                            }

                            let warning =
                                row.t3 &&
                                waktuKeMenit(data) < waktuKeMenit(row.t3);

                            return `
            <span
                class="badge ${warna} btn-edit-task"
                data-task-number="4"
                data-task-id="${row.task_id_4}"
                data-jam="${data}"
                data-nama="${row.nama ?? ''}"
                data-rm="${row.reg_num ?? ''}"
                data-dokter="${row.dokter ?? ''}"
                style="cursor:pointer;"
                title="Klik untuk edit T4"
            >
                ${data}
            </span>

            ${warning
                ? '<span class="badge badge-danger ml-1" title="T4 lebih awal dari T3">!</span>'
                : ''
            }
        `;
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
                        render: function(data, type, row) {

                            if (!data) {
                                return '<span class="badge badge-danger">-</span>';
                            }

                            let warning =
                                row.t4 &&
                                waktuKeMenit(data) < waktuKeMenit(row.t4);

                            return `
            <span
                class="badge ${warning ? 'badge-warning' : 'badge-success'} btn-edit-task"
                data-task-number="5"
                data-task-id="${row.task_id_5}"
                data-jam="${data}"
                data-nama="${row.nama ?? ''}"
                data-rm="${row.reg_num ?? ''}"
                data-dokter="${row.dokter ?? ''}"
                style="cursor:pointer;"
                title="Klik untuk edit T5"
            >
                ${data}
            </span>

            ${warning
                ? '<span class="badge badge-danger ml-1" title="T5 lebih awal dari T4">!</span>'
                : ''
            }
        `;
                        }
                    },
                    {
                        data: 't6',
                        render: function(data, type, row) {

                            if (!data) {
                                return '<span class="badge badge-danger">-</span>';
                            }

                            let warning =
                                row.t5 &&
                                waktuKeMenit(data) < waktuKeMenit(row.t5);

                            return `
            <span
                class="badge ${warning ? 'badge-warning' : 'badge-success'} btn-edit-task"
                data-task-number="6"
                data-task-id="${row.task_id_6}"
                data-jam="${data}"
                data-nama="${row.nama ?? ''}"
                data-rm="${row.reg_num ?? ''}"
                data-dokter="${row.dokter ?? ''}"
                style="cursor:pointer;"
                title="Klik untuk edit T6"
            >
                ${data}
            </span>

            ${warning
                ? '<span class="badge badge-danger ml-1" title="T6 lebih awal dari T5">!</span>'
                : ''
            }
        `;
                        }
                    },
                    {
                        data: 't7',
                        render: function(data, type, row) {

                            if (!data) {
                                return '<span class="badge badge-danger">-</span>';
                            }

                            let warning =
                                row.t6 &&
                                waktuKeMenit(data) < waktuKeMenit(row.t6);

                            return `
            <span
                class="badge ${warning ? 'badge-warning' : 'badge-success'} btn-edit-task"
                data-task-number="7"
                data-task-id="${row.task_id_7}"
                data-jam="${data}"
                data-nama="${row.nama ?? ''}"
                data-rm="${row.reg_num ?? ''}"
                data-dokter="${row.dokter ?? ''}"
                style="cursor:pointer;"
                title="Klik untuk edit T7"
            >
                ${data}
            </span>

            ${warning
                ? '<span class="badge badge-danger ml-1" title="T7 lebih awal dari T6">!</span>'
                : ''
            }
        `;
                        }
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

            /*
            |--------------------------------------------------------------------------
            | Filter Status T4
            |--------------------------------------------------------------------------
            */
            $('#status_t4').on('change', function() {
                table.draw();
            });

            /*
            |--------------------------------------------------------------------------
            | Filter Tanggal / Dokter
            |--------------------------------------------------------------------------
            */
            $('#formFilter').on('submit', function(e) {

                e.preventDefault();

                table.ajax.reload();
            });


            /*
            |--------------------------------------------------------------------------
            | Refresh
            |--------------------------------------------------------------------------
            */
            $('#reload').on('click', function() {

                table.ajax.reload();
            });

            let selectedTaskId = null;
            let selectedTaskNumber = null;
            let adjustTask = 0;


            /*
            |--------------------------------------------------------------------------
            | Klik T4 / T5 / T6 / T7
            |--------------------------------------------------------------------------
            */
            $('#tableAntrol').on('click', '.btn-edit-task', function() {

                selectedTaskNumber = $(this).data('task-number');
                selectedTaskId = $(this).data('task-id').toString();

                adjustTask = 0;

                $('#taskTitle').text('T' + selectedTaskNumber);

                $('#taskOriginal').val(selectedTaskId);
                $('#taskJamOriginal').val($(this).data('jam'));

                $('#taskNama').text($(this).data('nama') || '-');
                $('#taskRm').text($(this).data('rm') || '-');
                $('#taskDokter').text($(this).data('dokter') || '-');

                $('#taskAdjust').val(0);

                updatePreviewTask();

                $('#modalTask').modal('show');
            });


            /*
            |--------------------------------------------------------------------------
            | Tombol tambah / kurang
            |--------------------------------------------------------------------------
            */
            $(document).on('click', '.btn-adjust-task', function() {

                let menit = parseInt($(this).data('menit'));

                adjustTask += menit;

                $('#taskAdjust').val(adjustTask);

                updatePreviewTask();
            });


            /*
            |--------------------------------------------------------------------------
            | Input manual
            |--------------------------------------------------------------------------
            */
            $('#taskAdjust').on('input', function() {

                adjustTask = parseInt($(this).val() || 0);

                updatePreviewTask();
            });


            /*
            |--------------------------------------------------------------------------
            | Preview waktu baru
            |--------------------------------------------------------------------------
            */
            function updatePreviewTask() {

                if (!selectedTaskId) {
                    return;
                }

                let timestampLama = parseInt(selectedTaskId);

                let timestampBaru =
                    timestampLama + (adjustTask * 60000);

                let tanggal = new Date(timestampBaru);

                let jam =
                    String(tanggal.getHours()).padStart(2, '0') +
                    ':' +
                    String(tanggal.getMinutes()).padStart(2, '0') +
                    ':' +
                    String(tanggal.getSeconds()).padStart(2, '0');

                $('#taskJamBaru').val(jam);
            }

            $('#btnSimpanTask').on('click', function() {

                let menit = parseInt(
                    $('#taskAdjust').val() || 0
                );

                if (!selectedTaskId || !selectedTaskNumber) {
                    return;
                }

                if (menit === 0) {

                    Swal.fire(
                        'Tidak ada perubahan',
                        'Silakan tambah atau kurangi waktu.',
                        'info'
                    );

                    return;
                }

                let tombol = $(this);

                tombol.prop('disabled', true);

                $.ajax({

                    url: "{{ route('antrol.report.task.update') }}",

                    type: "PATCH",

                    data: {
                        _token: "{{ csrf_token() }}",

                        task_number: selectedTaskNumber,
                        task_id: selectedTaskId,
                        adjust_minutes: menit
                    },

                    success: function(response) {

                        $('#modalTask').modal('hide');

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            timer: 1500,
                            showConfirmButton: false
                        });

                        table.ajax.reload(null, false);
                    },

                    error: function(xhr) {

                        let pesan = 'Gagal memperbarui Task ID.';

                        if (
                            xhr.responseJSON &&
                            xhr.responseJSON.message
                        ) {
                            pesan = xhr.responseJSON.message;
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: pesan
                        });
                    },

                    complete: function() {

                        tombol.prop('disabled', false);
                    }
                });
            });


        });
    </script>


@stop
