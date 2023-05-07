<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index()
    {
        return view('menu/laporan.index')->with([
            'user' => Auth::user()
        ]);
    }

    public function laporanpenjualan($tglawal, $tglakhir)
    {
        $users = User::select('*')
        ->get();
        // dd($tglawal);
        // dd($tglakhir);
        $tglawal = date('Y-m-d', strtotime($tglawal));
        $tglakhir = date('Y-m-d', strtotime($tglakhir));

        $penjualan = DB::table('sales')->join('items', 'items.id', '=', 'sales.id_barang')->select('sales.created_at','items.*')->where(DB::raw("strftime('%Y-%m-%d', 'sales.created_at')",[$tglawal, $tglakhir]))->get();

        $pdf = PDF::loadView('menu/laporan.laporan', ['penjualan' => $penjualan,'users' => $users],compact('tglawal','tglakhir'));
        return $pdf->stream('Laporan-Data-Penjualan.pdf');   
    }
}
