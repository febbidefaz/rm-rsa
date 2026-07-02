@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard Pendaftaran</h1>
@stop

@section('content')
    <div class="row">

        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>150</h3>
                    <p>Pasien Hari Ini</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-injured"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>12</h3>
                    <p>Poliklinik</p>
                </div>
                <div class="icon">
                    <i class="fas fa-hospital"></i>
                </div>
            </div>
        </div>

    </div>
@stop
