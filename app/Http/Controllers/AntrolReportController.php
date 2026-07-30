<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Throwable;

class AntrolReportController extends Controller
{
    public function index(Request $request): View
    {
        $tanggal = $request->input(
            'tanggal',
            now()->format('Y-m-d')
        );

        try {
            $dokter = DB::select('EXEC dbo.cboDokter_SP');
        } catch (Throwable $e) {
            report($e);
            $dokter = [];
        }

        return view(
            'antrol.report-antrol',
            compact('tanggal', 'dokter')
        );
    }

    public function data(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'tanggal' => [
                'required',
                'date_format:Y-m-d',
            ],
            'dokter_id' => [
                'nullable',
                'integer',
            ],
        ]);

        try {
            $tanggal = Carbon::createFromFormat(
                'Y-m-d',
                $validated['tanggal']
            );

            $dokterId = $validated['dokter_id'] ?? null;

            $rows = DB::select(
                'EXEC dbo.AntrolReportTgl_SP
                    @BeginDate = ?,
                    @DokterID = ?',
                [
                    $tanggal->format('Y-m-d'),
                    $dokterId,
                ]
            );

            $data = collect($rows)
                ->map(function ($row) {
                    return [
                        'id' => $row->ID ?? null,
                        'id2' => $row->ID2 ?? null,
                        'PxRS' => $row->PxRS ?? null,
                        'reg_num' => $row->RegNum ?? null,
                        'nama' => $row->Nama ?? null,
                        'alamat' => $row->Addr ?? null,
                        'nik' => $row->NIK ?? null,
                        'no_jkn' => $row->NoJKN ?? null,

                        'dokter' => $row->Dokter ?? null,
                        'sub_layanan' => $row->SubLayanan ?? null,
                        'jam_praktek' => $row->Alias ?? null,

                        'tanggal' => $this->formatDate(
                            $row->Tanggal ?? null
                        ),

                        'no_rujukan' => $row->NoRujukan
                            ?? $row->Norujukanpoli
                            ?? null,

                        'no_wa' => $row->NoWA ?? null,
                        'datang' => $row->Datang ?? null,
                        'sent' => $row->sent ?? null,

                        'task_id_1' => $row->task_id_1 ?? null,
                        'task_id_2' => $row->task_id_2 ?? null,
                        'task_id_3' => $row->task_id_3 ?? null,
                        'task_id_4' => $row->task_id_4 ?? null,
                        'task_id_5' => $row->task_id_5 ?? null,
                        'task_id_6' => $row->task_id_6 ?? null,
                        'task_id_7' => $row->task_id_7 ?? null,

                        't1' => $this->formatTime(
                            $row->t1 ?? null
                        ),
                        't2' => $this->formatTime(
                            $row->t2 ?? null
                        ),
                        't3' => $this->formatTime(
                            $row->t3 ?? null
                        ),
                        't4' => $this->formatTime(
                            $row->t4 ?? null
                        ),
                        't5' => $this->formatTime(
                            $row->t5 ?? null
                        ),
                        't6' => $this->formatTime(
                            $row->t6 ?? null
                        ),
                        't7' => $this->formatTime(
                            $row->t7 ?? null
                        ),
                        'jam_bpjs' => $row->jamBPJS ?? null,  
                        't4_status' => $this->getT4Status(
                            $this->formatTime($row->t4 ?? null),
                            $row->jamBPJS ?? null
                        ),                     
                 
                    ];
                })
                ->values();

            return response()->json([
                'success' => true,
                'message' => 'Data report Antrol berhasil diambil.',
                'recordsTotal' => $data->count(),
                'recordsFiltered' => $data->count(),
                'data' => $data,
            ]);
        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data report Antrol.',
                'error' => config('app.debug')
                    ? $e->getMessage()
                    : null,
                'data' => [],
            ], 500);
        }
    }

    private function formatDate(mixed $value): ?string
    {
        if (
            $value === null ||
            $value === '' ||
            $value === 0 ||
            $value === '0'
        ) {
            return null;
        }

        try {
            return Carbon::parse($value)->format('d-m-Y');
        } catch (Throwable) {
            return (string) $value;
        }
    }

    private function formatTime(mixed $value): ?string
    {
        if (
            $value === null ||
            $value === '' ||
            $value === 0 ||
            $value === '0'
        ) {
            return null;
        }
    
        try {
            return Carbon::parse($value)->format('H:i');
        } catch (Throwable) {
            return (string) $value;
        }
    }

    private function getT4Status(?string $t4, ?string $jamBpjs): string
    {
        if (!$t4) {
            return 'kosong';
        }

        if (!$jamBpjs) {
            return 'kuning';
        }

        $jamBpjs = str_replace([' ', '.'], ['', ':'], $jamBpjs);
        $parts = explode('-', $jamBpjs);

        if (count($parts) !== 2) {
            return 'kuning';
        }

        $mulai = $this->normalizeTime($parts[0]);
        $selesai = $this->normalizeTime($parts[1]);
        $t4 = $this->normalizeTime($t4);

        return ($t4 >= $mulai && $t4 <= $selesai)
            ? 'hijau'
            : 'merah';
    }

    private function normalizeTime(?string $value): string
    {
        if (!$value) {
            return '00:00:00';
        }

        $parts = explode(':', str_replace('.', ':', trim($value)));

        $jam = str_pad($parts[0] ?? '00', 2, '0', STR_PAD_LEFT);
        $menit = str_pad($parts[1] ?? '00', 2, '0', STR_PAD_LEFT);
        $detik = str_pad($parts[2] ?? '00', 2, '0', STR_PAD_LEFT);

        return "{$jam}:{$menit}:{$detik}";
    }
}