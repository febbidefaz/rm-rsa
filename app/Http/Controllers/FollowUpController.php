<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;


class FollowUpController extends Controller
{
    public function index()
    {

        /*
        |--------------------------------------------------------------------------
        | COMBO DOKTER
        |--------------------------------------------------------------------------
        */

        $dokter =
            DB::connection('sqlsrv')
                ->select("
                    EXEC dbo.cboDokter_SP
                ");


        /*
        |--------------------------------------------------------------------------
        | COMBO JENIS PASIEN
        |--------------------------------------------------------------------------
        */

        $upx =
            DB::connection('sqlsrv')
                ->select("
                    EXEC dbo.cboUpx_sp
                ");


        /*
        |--------------------------------------------------------------------------
        | COMBO JAM PRAKTEK
        |--------------------------------------------------------------------------
        */

        $jam = DB::connection('sqlsrv')
        ->select("
            SELECT 
                ID,
                Alias AS JaPrak
            FROM dbo.PrakOn
            ORDER BY ID
        ");


        return view(
            'follow-up.rawatjalan',
            compact(
                'dokter',
                'upx',
                'jam'
            )
        );

    }
    
    public function data(Request $request)
    {

        /*
        |--------------------------------------------------------------------------
        | FILTER
        |--------------------------------------------------------------------------
        */

        $tglAwal =
            $request->tgl_awal
            ?: date('Y-m-d');


        $tglAkhir =
            $request->tgl_akhir
            ?: date('Y-m-d');


        $dokterId =
            $request->dokter_id
            ?: null;


        $upxId =
            $request->upx_id
            ?: null;


        $jamPraktek =
            $request->jam_praktek
            ?: null;


        /*
        |--------------------------------------------------------------------------
        | STORED PROCEDURE
        |--------------------------------------------------------------------------
        */

        $pasien =
            DB::connection('sqlsrv')
                ->select(
                    "

                    EXEC dbo.WebRMRawatJalan_SP

                        @TglAwal = ?,

                        @TglAkhir = ?,

                        @DokterID = ?,

                        @SpesialisID = ?,

                        @UPxID = ?,

                        @JamPraktek = ?

                    ",
                    [

                        $tglAwal,

                        $tglAkhir,

                        $dokterId,

                        null,

                        $upxId,

                        $jamPraktek

                    ]
                );


        /*
        |--------------------------------------------------------------------------
        | FORMAT DATATABLE
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'data' => $pasien

        ]);

    }

    public function detail($id)
    {
        $pasien = DB::connection('sqlsrv')->selectOne(
            "EXEC dbo.WebPasienRawatInapDetailByID_SP ?",
            [$id]
        );

        if (!$pasien) {
            abort(404, 'Pasien tidak ditemukan');
        }

        return view(
            'follow-up.rawatjalan.jalandetail',
            compact('pasien')
        );
    }

    // Cek SEP
    public function sepDetail(Request $request)
    {
        $nosep = $request->query('nosep');

        $response = Http::timeout(10)->get('http://192.168.1.200:6000/api/findsep', [
            'nosep' => $nosep
        ]);

        return response()->json($response->json());
    }
  
    public function updatePxRS(Request $request, $id)
    {
        $request->validate([

            'uPx' =>
                'required|integer',

        ]);


        try {

            DB::statement("
                SET NOCOUNT ON;
                EXEC dbo.WebUpdatePxRSByID_SP ?, ?
            ", [

                (int) $id,

                (int) $request->input('uPx'),

            ]);


            return response()->json([

                'success' =>
                    true,

                'message' =>
                    'PxRS berhasil diperbarui.',

            ]);


        } catch (\Throwable $e) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    $e->getMessage(),

            ], 500);
        }
    }

    public function printLabelTengah($id)
    {
        $rows = DB::select(
            'EXEC dbo.skotlet @ID = ?',
            [(int) $id]
        );
    
        if (empty($rows)) {
            abort(404, 'Data pasien tidak ditemukan.');
        }
    
        $row = $rows[0];
    
        $patient = [
            'ID' => $row->ID ?? '-',
            'RegNum' => $row->RegNum ?? '-',
            'Nama' => $row->Nama ?? '-',
            'Addr' => $row->Addr ?? '-',
            'Tanggal_Lahir' => $row->Tanggal_Lahir ?? null,
        ];
    
        return view(
            'rawatinap.label.label-tengah',
            compact('patient')
        );
    }

    public function printLabelSamping($id)
    {
        $rows = DB::select(
            'EXEC dbo.skotlet @ID = ?',
            [(int) $id]
        );
    
        if (empty($rows)) {
            abort(404, 'Data pasien tidak ditemukan.');
        }
    
        $row = $rows[0];
    
        $patient = [
            'ID' => $row->ID ?? '-',
            'RegNum' => $row->RegNum ?? '-',
            'Nama' => $row->Nama ?? '-',
            'Addr' => $row->Addr ?? '-',
            'Tanggal_Lahir' => $row->Tanggal_Lahir ?? null,
        ];
    
        return view(
            'rawatinap.label.label-samping',
            compact('patient')
        );
    }
}


