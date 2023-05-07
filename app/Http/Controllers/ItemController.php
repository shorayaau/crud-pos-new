<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get item
        $item = Item::latest()->paginate(5);

        //render view with item
        return view('menu/item.index', compact('item'))->with([
            'user' => Auth::user()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('menu/item.create')->with([
            'user' => Auth::user()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate form
        $this->validate($request, [
            'nama'     => 'required',
            'jenis_barang'     => 'required',
            'deskripsi'     => 'required',
            'gambar'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'harga_beli'     => 'required',
            'harga_jual'   => 'required',
            'stok'     => 'required'
        ]);

        //upload image
        $image = $request->file('gambar');
        $image->storeAs('public/item', $image->hashName());

        // dd($request);
        //create item
        Item::create([
            'nama'     => $request->nama,
            'jenis_barang'     => $request->jenis_barang,
            'deskripsi'     => $request->deskripsi,
            'gambar'     => $image->hashName(),
            'harga_beli'   => floatval(str_replace(",", "", $request->harga_beli)),
            'harga_jual'   => floatval(str_replace(",", "", $request->harga_jual)),
            'stok'   => floatval(str_replace(",", "", $request->stok))
            // 'password'   => Hash::make($request->password)
        ]);

        //redirect to index
        return redirect()->route('item.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        return view('menu/item.edit', compact('item'))->with([
            'user' => Auth::user()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        //validate form
        $this->validate($request, [
            'nama'     => 'required',
            'jenis_barang'     => 'required',
            'deskripsi'     => 'required',
            'gambar'     => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'harga_beli'     => 'required',
            'harga_jual'   => 'required',
            'stok'     => 'required'
        ]);
        if ($request->hasFile('gambar')) {
            //upload image
            $image = $request->file('gambar');
            $image->storeAs('public/item', $image->hashName());

            //delete old image
            Storage::delete('public/item/' . $item->gambar);

            // dd($request);
            //create item
            $item->update([
                'nama'     => $request->nama,
                'jenis_barang'     => $request->jenis_barang,
                'deskripsi'     => $request->deskripsi,
                'gambar'     => $image->hashName(),
                'harga_beli'   => floatval(str_replace(",", "", $request->harga_beli)),
                'harga_jual'   => floatval(str_replace(",", "", $request->harga_jual)),
                'stok'   => floatval(str_replace(",", "", $request->stok))
                // 'password'   => Hash::make($request->password)
            ]);
        } else {
            $item->update([
                'nama'     => $request->nama,
                'jenis_barang'     => $request->jenis_barang,
                'deskripsi'     => $request->deskripsi,
                'harga_beli'   => floatval(str_replace(",", "", $request->harga_beli)),
                'harga_jual'   => floatval(str_replace(",", "", $request->harga_jual)),
                'stok'   => floatval(str_replace(",", "", $request->stok))
                // 'password'   => Hash::make($request->password)
            ]);
        }

        //redirect to index
        return redirect()->route('item.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        //delete image
        Storage::delete('public/item/' . $item->image);

        //delete item
        $item->delete();

        //redirect to index
        return redirect()->route('item.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }

    public function stokkurang(Request $request, Item $item)
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
        // // $item = Item::all()->whereIn('id_barang', array($request->id_barang));


        // //create item
        DB::table('items')->where('id', $request->id_barang)->update(['stok' => $request->stok - floatval(str_replace(",", "", $request->qty))]);
        // $item->update([
        //     // 'nama_barang'     => $item->nama,
        //     'stok' => $item->stok - floatval(str_replace(",", "", $request->qty))
        //     // 'password'   => Hash::make($request->password)
        // ]);

        // //redirect to index
        return redirect()->route('sales.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }
}
