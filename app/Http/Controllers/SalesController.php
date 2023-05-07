<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    function index()
    {
        //get sales

        $user = Auth::user();
        if ($user->level == 'pembeli') {
            $sales = DB::table('sales')
                ->join('items', 'items.id', '=', 'sales.id_barang')
                ->select('sales.*', 'items.nama as nama_barang')->whereIn('id_user', array($user->id))
                ->get();
            // $sales = Sales::latest()->whereIn('id_user', array($user->id))->paginate(5);
            // dd($sales);
        } else {
            $sales = DB::table('sales')
                ->join('items', 'items.id', '=', 'sales.id_barang')
                ->select('sales.*', 'items.nama as nama_barang', 'items.stok')
                ->get();
            // $sales = Sales::latest()->paginate(5);
        }

        //render view with sales
        return view('menu/sales.index', compact('sales'))->with([
            'user' => Auth::user()
        ]);
    }

    public function create()
    {
        return view('menu/sales.create')->with([
            'user' => Auth::user(),
            'item' => Item::all()
        ]);
    }

    public function store(Request $request)
    {
        //validate form
        $this->validate($request, [
            // 'id_user' => 'required',
            // 'nama_user' => 'required',
            // 'id_barang' => 'required',
            // 'nama_barang' => 'required',
            'qty' => 'required',
            'harga_jual' => 'required',
            'total' => 'required'
        ]);
        $user = Auth::user();
        // $item = Item::all()->whereIn('id', array($request->id_barang));

        // dd($request->id_barang);

        //create item
        Sales::create([
            'id_user'     => $user->id,
            'nama_user'     => $user->nama,
            'id_barang'     => $request->id_barang,
            // 'nama_barang'     => $item->nama,
            'qty'   => floatval(str_replace(",", "", $request->qty)),
            'harga_jual'   => floatval(str_replace(",", "", $request->harga_jual)),
            'total'   => floatval(str_replace(",", "", $request->total))
            // 'password'   => Hash::make($request->password)
        ]);

        //redirect to index
        return redirect()->route('sales.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function edit(Sales $sales)
    {
        return view('menu/sales.edit', compact('sales'))->with([
            'user' => Auth::user()
        ]);
    }

    public function update(Request $request, Sales $sales, Item $item)
    {
        $this->validate($request, [
            // 'id_user' => 'required',
            // 'nama_user' => 'required',
            // 'id_barang' => 'required',
            // 'nama_barang' => 'required',
            'stok' => 'required',
            // 'harga_jual' => 'required',
            // 'total' => 'required'
        ]);
        // dd($request);
        $item = Sales::all()->whereIn('id_barang', array($request->id_barang));


        //create item
        $item->update([
            // 'nama_barang'     => $item->nama,
            'stok'   => $item->stok - floatval(str_replace(",", "", $request->qty)),
            // 'password'   => Hash::make($request->password)
        ]);

        //redirect to index
        return redirect()->route('sales.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function getbarang($id)
    {
        $data = Item::where('id', $id);

        return response()->json($data);
    }
}
