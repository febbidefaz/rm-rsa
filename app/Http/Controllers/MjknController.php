<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MjknController extends Controller
{
    public function index()
    {
        return view('mjkn.batal-mjkn');
    }

    public function batal(Request $request)
    {
        $request->validate([
            'kodebooking' => 'required'
        ]);

        $response = Http::post(
            'https://bpjs.rsabjn.com:8000/api/batal',
            [
                'kodebooking' => $request->kodebooking,
                'keterangan'  => $request->keterangan
            ]
        );

        $data = $response->json();

        return back()->with([
            'response' => $data
        ]);
    }
}

