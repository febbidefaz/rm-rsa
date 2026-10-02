<?php

namespace App\Http\Controllers;

use App\Data\ResponseData;
use App\Http\Controllers\Controller;
use App\Models\API\Patient;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SKDPController extends Controller
{
   

    protected $patient;

    //protected string $api = '192.168.1.200:6000';
    protected $api = "http://192.168.1.200:6000";

    protected string $apiLokal = 'http://192.168.1.200:5000';


    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index(Request $request, $patient_id)
    {
        $modelPatient = new Patient();

        $patientResponse = $modelPatient->detailRJ(
            $patient_id,
            true
        );

        $patient = $patientResponse['data'];

        $this->patient = $patient;


        /*
        |--------------------------------------------------------------------------
        | DATA SKDP
        |--------------------------------------------------------------------------
        */

        if (
            !empty($request->tgl_awal)
            && !empty($request->tgl_akhir)
        ) {

            $getSkdp = $this->getCekSkdpByDate(
                $request->tgl_awal,
                $request->tgl_akhir,
                $request->filter ?? 1
            );

            $getSkdp = $getSkdp->getData();

            $status = 'Cek SKDP';

            $tahun = date('Y');
            $bulan = date('m');

        } else {

            $filter = $request->filter ?? 1;

            $date = !empty($request->date)
                ? Carbon::parse($request->date)
                : Carbon::now();

            $tahun = $date->format('Y');
            $bulan = $date->format('m');

            $getSkdp = $this->getSKDP(
                $bulan,
                $tahun,
                $patient['NoJKN'],
                $filter
            );

            $getSkdp = $getSkdp->getData();

            $status = 'History SKDP';

        }


        /*
        |--------------------------------------------------------------------------
        | DOKTER
        |--------------------------------------------------------------------------
        */

        $dokter = $this->getDokter(
            $patient['DokterID']
        );

        $dokter = $dokter->getData();


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        $data = [

            'page' => 'outpatient.SKDP',

            'title' => 'SKDP',

            'patient' => $patient,

            'filter' => $request->filter ?? 1,

            'tahun' => $tahun,

            'bulan' => $bulan,

            'tgl_awal' => $request->tgl_awal ?? '',

            'tgl_akhir' => $request->tgl_akhir ?? '',

            'status' => $status,

            'dokter' => $dokter->data ?? [],

            'data' => $getSkdp,

            'select2' => true,

            'error' => $getSkdp->message ?? null,

        ];


        return view(
            'outpatient.skdp.index',
            $data
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PRINT SKDP
    |--------------------------------------------------------------------------
    */
/*
    public function print($no_skdp, Request $request)
    {
        $patientId = $request->patient_id;

        $modelPatient = new Patient();

        $patientResponse = $modelPatient->detailRJ(
            $patientId,
            false
        );

        $patient = $patientResponse['data'];


        $response = Http::apiClient()->get(
            $this->api . '/api/rencanakontrol/search',
            [
                'nokon' => $no_skdp,
            ]
        );


        if (!$response->successful()) {

            Log::channel('skdp')->error(
                'Gagal mendapatkan data SKDP untuk print',
                [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]
            );

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Gagal mendapatkan data SKDP'
                );
        }


        $data = $response->json();


        $qrCodeNoSkdp = $this->generateQrCode(
            $no_skdp,
            100
        );

        $qrCodeNik = $this->generateQrCode(
            $patient['NIK'] ?? '123',
            100
        );


        return view(
            'outpatient.skdp.print',
            [
                'data' => $data,

                'qr_code_no_skdp' => $qrCodeNoSkdp,

                'qr_code_nik' => $qrCodeNik,

                'patient' => $patient,
            ]
        );
    }
*/

    /*
    |--------------------------------------------------------------------------
    | HISTORY SKDP
    |--------------------------------------------------------------------------
    */

    public function getSKDP( $bulan, $tahun, $noJkn, $filter)
    {

        $response = Http::apiClient()->get(
            $this->api . '/api/HistoriSukonWeb',
            [
                'bln' => $bulan,

                'thn' => $tahun,

                'noka' => $noJkn,

                'filter' => $filter,
            ]
        );


        if ($response->successful()) {

            return ResponseData::success(
                'Berhasil mendapatkan data SKDP',
                $response->json()
            );
        }


        Log::channel('skdp')->error(
            'Gagal mendapatkan history SKDP',
            [
                'status' => $response->status(),
                'body' => $response->body(),
            ]
        );


        return ResponseData::error(
            'Gagal mendapatkan data SKDP'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CEK SKDP BERDASARKAN TANGGAL
    |--------------------------------------------------------------------------
    */

    public function getCekSkdpByDate(
        $tglAwal,
        $tglAkhir,
        $filter
    ) {

        $response = Http::apiClient()->get(
            $this->api . '/api/WebRencanakontrol/list',
            [
                'tglaw' => $tglAwal,

                'tglak' => $tglAkhir,

                'filter' => $filter,
            ]
        );


        if ($response->successful()) {

            return ResponseData::success(
                'Berhasil mendapatkan data SKDP',
                $response->json()
            );
        }


        Log::channel('skdp')->error(
            'Gagal cek SKDP berdasarkan tanggal',
            [
                'status' => $response->status(),
                'body' => $response->body(),
            ]
        );


        return ResponseData::error(
            'Gagal mendapatkan data SKDP / SKDP Kosong'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | AJAX LIST SKDP
    |--------------------------------------------------------------------------
    */

    public function listData(Request $request)
    {
        $bulan  = $request->get('bulan', date('m'));
        $tahun  = $request->get('tahun', date('Y'));
        $noJkn  = $request->get('noka');
        $filter = $request->get('filter', 1);
    
        if (empty($noJkn)) {
            return response()->json([
                'data' => [],
                'message' => 'No JKN pasien kosong',
            ], 200);
        }
    
        try {
    
            $url = 'http://192.168.1.200:6000/api/HistoriSukonWeb';
    
            /*
            |--------------------------------------------------------------------------
            | SENGAJA PAKAI Http::timeout(), BUKAN Http::apiClient()
            |--------------------------------------------------------------------------
            */
    
            $response = Http::timeout(30)
                ->acceptJson()
                ->get($url, [
                    'bln'    => $bulan,
                    'thn'    => $tahun,
                    'noka'   => $noJkn,
                    'filter' => $filter,
                ]);
    
            /*
            |--------------------------------------------------------------------------
            | API HTTP ERROR
            |--------------------------------------------------------------------------
            */
    
            if (!$response->successful()) {
    
                return response()->json([
                    'data' => [],
                    'message' => 'API History SKDP gagal',
                    'debug' => [
                        'status' => $response->status(),
                        'body'   => $response->body(),
                        'url'    => $url,
                        'param'  => [
                            'bln'    => $bulan,
                            'thn'    => $tahun,
                            'noka'   => $noJkn,
                            'filter' => $filter,
                        ],
                    ],
                ], 200);
            }
    
            $json = $response->json();
    
            $list = [];
    
    
            /*
            |--------------------------------------------------------------------------
            | FORMAT 1
            |--------------------------------------------------------------------------
            |
            | {
            |     "response": {
            |         "list": [...]
            |     }
            | }
            |
            */
    
            if (
                isset($json['response']['list'])
                && is_array($json['response']['list'])
            ) {
    
                $list = $json['response']['list'];
    
            }
    
    
            /*
            |--------------------------------------------------------------------------
            | FORMAT 2
            |--------------------------------------------------------------------------
            |
            | {
            |     "response": "{\"list\":[...]}"
            | }
            |
            */
    
            elseif (
                isset($json['response'])
                && is_string($json['response'])
            ) {
    
                $decoded = json_decode(
                    $json['response'],
                    true
                );
    
                if (
                    is_array($decoded)
                    && isset($decoded['list'])
                    && is_array($decoded['list'])
                ) {
    
                    $list = $decoded['list'];
    
                }
    
            }
    
    
            /*
            |--------------------------------------------------------------------------
            | FORMAT 3
            |--------------------------------------------------------------------------
            |
            | {
            |     "list": [...]
            | }
            |
            */
    
            elseif (
                isset($json['list'])
                && is_array($json['list'])
            ) {
    
                $list = $json['list'];
    
            }
    
    
            /*
            |--------------------------------------------------------------------------
            | FORMAT 4
            |--------------------------------------------------------------------------
            |
            | API langsung [...]
            |
            */
    
            elseif (
                is_array($json)
                && array_keys($json) === range(0, count($json) - 1)
            ) {
    
                $list = $json;
    
            }
    
    
            return response()->json([
                'data' => $list,
                'message' => count($list)
                    ? 'Berhasil mendapatkan data SKDP'
                    : 'Data SKDP kosong',
            ], 200);
    
        } catch (\Throwable $e) {
    
            /*
             * Jangan Log::channel('skdp') dulu.
             * Kalau channel belum terdaftar justru dapat menyebabkan 500 lagi.
             */
    
            return response()->json([
                'data' => [],
                'message' => 'Error koneksi SKDP',
                'debug' => [
                    'error' => $e->getMessage(),
                    'file'  => $e->getFile(),
                    'line'  => $e->getLine(),
                ],
            ], 200);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | GET DOKTER
    |--------------------------------------------------------------------------
    */

    public function getDokter($id)
    {
        $response = Http::apiClient()->get(
            $this->apiLokal . '/his/new/DokterOp',
            [
                'id' => $id,
            ]
        );


        if ($response->successful()) {

            return ResponseData::success(
                'Berhasil mendapatkan data Dokter',
                $response->json()
            );
        }


        Log::channel('skdp')->error(
            'Gagal mendapatkan data Dokter',
            [
                'status' => $response->status(),

                'body' => $response->body(),
            ]
        );


        return ResponseData::error(
            'Gagal mendapatkan data Dokter'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | INSERT SKDP
    |--------------------------------------------------------------------------
    */

    public function post(Request $request)
    {
        $payload = $request->all();
    
        $payload['user'] = auth()->user()?->name ?? 'WEB-RJ';
    
        $response = Http::apiClient()->post(
            $this->api . '/api/rencanakontrol/insertWeb',
            $payload
        );
    
        if ($response->successful()) {
    
            return redirect()
                ->back()
                ->with(
                    'success',
                    'Berhasil post data SKDP'
                );
        }
    
        $error = $response->json();
    
        $message =
            $error['metaData']['message']
            ?? 'Terjadi kesalahan saat post data SKDP';
    
        Log::channel('skdp')->error($error);
    
        return redirect()
            ->back()
            ->with(
                'error',
                $message
            );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE SKDP
    |--------------------------------------------------------------------------
    */

    public function edit(Request $request)
    {
        $response = Http::apiClient()->post(
            $this->api . '/api/rencanakontrol/updateWeb',
            $request->all()
        );


        if ($response->successful()) {

            return redirect()
                ->back()
                ->with(
                    'success',
                    'Berhasil update data SKDP'
                );
        }


        Log::channel('skdp')->error(
            'Gagal update SKDP',
            [
                'status' => $response->status(),

                'body' => $response->body(),
            ]
        );


        return redirect()
            ->back()
            ->with(
                'error',
                'Gagal update data SKDP'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DELETE SKDP
    |--------------------------------------------------------------------------
    */

    public function delete(Request $request)
    {
        $response = Http::apiClient()->post(
            $this->api . '/api/rencanakontrol/deleteWeb',
            $request->all()
        );


        if ($response->successful()) {

            return redirect()
                ->back()
                ->with(
                    'success',
                    'Berhasil delete data SKDP'
                );
        }


        Log::channel('skdp')->error(
            'Gagal delete SKDP',
            [
                'status' => $response->status(),

                'body' => $response->body(),
            ]
        );


        return redirect()
            ->back()
            ->with(
                'error',
                'Gagal delete data SKDP'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | SELECT2 SPESIALIS
    |--------------------------------------------------------------------------
    */

    public function getSpesialis(Request $request)
    {
        $response = Http::apiClient()->get(
            $this->apiLokal . '/his/new/Spesialis',
            [
                'nama' => $request->q,
            ]
        );


        if (!$response->successful()) {

            Log::channel('skdp')->error(
                'Gagal mendapatkan spesialis',
                [
                    'status' => $response->status(),

                    'body' => $response->body(),
                ]
            );


            return response()->json(
                [
                    'results' => [],
                ],
                500
            );
        }


        $json = $response->json();


        if (!is_array($json)) {

            return response()->json([
                'results' => [],
            ]);
        }


        $results = collect($json)
            ->map(function ($item) {

                return [

                    'id' =>
                        $item['kdBPJS']
                        ?? null,

                    'text' =>
                        $item['name']
                        ?? 'Tanpa Nama',

                ];
            })
            ->filter(
                fn ($item) =>
                    !empty($item['id'])
            )
            ->values();


        return response()->json([
            'results' => $results,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | SELECT2 DOKTER SKDP
    |--------------------------------------------------------------------------
    */

    public function getDokterSkdp(Request $request)
    {
        $response = Http::apiClient()->get(
            $this->apiLokal . '/his/new/DokterOp',
            [
                'namaOp' => $request->q,
            ]
        );


        if (!$response->successful()) {

            Log::channel('skdp')->error(
                'Gagal mendapatkan dokter SKDP',
                [
                    'status' => $response->status(),

                    'body' => $response->body(),
                ]
            );


            return response()->json(
                [
                    'results' => [],
                ],
                500
            );
        }


        $json = $response->json();


        if (!is_array($json)) {

            return response()->json([
                'results' => [],
            ]);
        }


        $results = collect($json)
            ->map(function ($item) {

                return [

                    'id' =>
                        $item['kdBPJS']
                        ?? null,

                    'text' =>
                        $item['dokterOp']
                        ?? 'Tanpa Nama',

                ];
            })
            ->filter(
                fn ($item) =>
                    !empty($item['id'])
            )
            ->values();


        return response()->json([
            'results' => $results,
        ]);
    }
}