@extends('adminlte::page')

@section('title', 'Pembatalan Antrean MJKN')

@section('content_header')
    <h1>Pembatalan Antrean MJKN</h1>
@stop

@section('content')

    <div class="card shadow custom-card">
        <div class="card-header text-white" style="background:#0F766E;">
            <h3 class="card-title">
                <i class="fas fa-calendar-times mr-2"></i>
                Pembatalan Antrean Mobile JKN
            </h3>
        </div>

        <form method="POST" action="{{ route('mjkn.batal-mjkn.batal') }}">
            @csrf

            <div class="card-body">

                <div class="form-group">
                    <label for="kodebooking">Kode Booking</label>
                    <input type="text" name="kodebooking" id="kodebooking" class="form-control"
                        placeholder="Masukkan kode booking" required>
                </div>

                <div class="form-group">
                    <label for="keterangan">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" class="form-control" rows="3">Terjadi perubahan jadwal dokter, silahkan daftar kembali</textarea>
                </div>

                @if (session('response'))
                    <div class="alert alert-info">
                        <strong>Kode:</strong> {{ session('response.metadata.code') ?? '-' }} <br>
                        <strong>Pesan:</strong> {{ session('response.metadata.message') ?? '-' }}
                    </div>
                @endif

            </div>

            <div class="card-footer text-left">
                <button class="btn text-white" style="background:#0F766E;border-color:#0F766E;">
                    <i class="fas fa-paper-plane"></i>
                    Kirim Pembatalan
                </button>
            </div>
        </form>
    </div>

@stop

@section('css')
    <style>
        .card {
            border-radius: 15px;
            border: none;
        }

        .card-header {
            border-radius: 15px 15px 0 0 !important;
        }

        .form-control {
            border-radius: 10px;
            box-shadow: none;
        }

        .form-control:focus {
            border-color: #28a745;
            box-shadow: 0 0 0 .15rem rgba(40, 167, 69, .15);
        }

        .btn-success {
            border-radius: 10px;
            padding: 10px 25px;
            font-weight: 600;
        }
    </style>
@stop
