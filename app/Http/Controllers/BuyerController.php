<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class BuyerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get buyer
        $buyer = User::latest()->whereNotIn('level', array('admin', 'user'))->paginate(5);

        //render view with buyer
        return view('menu/buyer.index', compact('buyer'))->with([
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
        return view('menu/buyer.create')->with([
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
            'tempat_lahir'     => 'required',
            'tanggal_lahir'     => 'required',
            'alamat'     => 'required',
            'foto_ktp'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'jenis_kelamin'     => 'required',
            'username'   => 'required',
            'password'     => 'required|confirmed'
        ]);

        //upload image
        $image = $request->file('foto_ktp');
        $image->storeAs('public/buyer', $image->hashName());

        // dd($request);
        //create buyer
        User::create([
            'nama'     => $request->nama,
            'tempat_lahir'     => $request->tempat_lahir,
            'tanggal_lahir'     => $request->tanggal_lahir,
            'alamat'     => $request->alamat,
            'foto_ktp'     => $image->hashName(),
            'jenis_kelamin'   => $request->jenis_kelamin,
            'username'   => $request->username,
            'password'   => Hash::make($request->password),
            'level' => 'pembeli'
            // 'password'   => Hash::make($request->password)
        ]);

        //redirect to index
        return redirect()->route('buyer.index')->with(['success' => 'Data Berhasil Disimpan!']);
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
    public function edit(User $buyer)
    {
        return view('menu/buyer.edit', compact('buyer'))->with([
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
    public function update(Request $request, User $buyer)
    {
        //validate form
        $this->validate($request, [
            'nama'     => 'required',
            'tempat_lahir'     => 'required',
            'tanggal_lahir'     => 'required',
            'alamat'     => 'required',
            'foto_ktp'     => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'jenis_kelamin'     => 'required',
            'username'   => 'required',
            'password'     => 'required|confirmed'
        ]);
        if ($request->hasFile('foto_ktp')) {
            //upload image
            $image = $request->file('foto_ktp');
            $image->storeAs('public/buyer', $image->hashName());

            //delete old image
            Storage::delete('public/buyer/' . $buyer->foto_ktp);

            // dd($request);
            //create buyer
            $buyer->update([
                'nama'     => $request->nama,
                'tempat_lahir'     => $request->tempat_lahir,
                'tanggal_lahir'     => $request->tanggal_lahir,
                'alamat'     => $request->alamat,
                'foto_ktp'     => $image->hashName(),
                'jenis_kelamin'   => $request->jenis_kelamin,
                'username'   => $request->username,
                'password'   => Hash::make($request->password)
                // 'password'   => Hash::make($request->password)
            ]);
        } else {
            $buyer->update([
                'nama'     => $request->nama,
                'tempat_lahir'     => $request->tempat_lahir,
                'tanggal_lahir'     => $request->tanggal_lahir,
                'alamat'     => $request->alamat,
                'jenis_kelamin'   => $request->jenis_kelamin,
                'username'   => $request->username,
                'password'   => Hash::make($request->password)
                // 'password'   => Hash::make($request->password)
            ]);
        }

        //redirect to index
        return redirect()->route('buyer.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $buyer)
    {
        //delete image
        Storage::delete('public/buyer/' . $buyer->image);

        //delete buyer
        $buyer->delete();

        //redirect to index
        return redirect()->route('buyer.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
