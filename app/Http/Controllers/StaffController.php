<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
    public function index()
    {
        //get staff
        $staff = User::latest()->whereNotIn('level', array('admin', 'pembeli'))->paginate(5);

        //render view with staff
        return view('menu/staff.index', compact('staff'))->with([
            'user' => Auth::user()
        ]);
    }

    public function create()
    {
        return view('menu/staff.create')->with([
            'user' => Auth::user()
        ]);
    }

    public function store(Request $request)
    {
        //validate form
        $this->validate($request, [
            'nama'     => 'required',
            'jenis_kelamin'     => 'required',
            'username'   => 'required',
            'password'     => 'required|confirmed'
        ]);

        //create staff
        User::create([
            'nama'     => $request->nama,
            'jenis_kelamin'   => $request->jenis_kelamin,
            'username'   => $request->username,
            'password'   => Hash::make($request->password),
            'level' => 'user'
            // 'password'   => Hash::make($request->password)
        ]);

        //redirect to index
        return redirect()->route('staff.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function edit(User $staff)
    {
        return view('menu/staff.edit', compact('staff'))->with([
            'user' => Auth::user()
        ]);
    }

    public function update(Request $request, User $staff)
    {
        //validate form
        $this->validate($request, [
            'nama'     => 'required',
            'jenis_kelamin'     => 'required',
            'username'   => 'required',
            'password'     => 'required|confirmed'
        ]);
        $staff->update([
            'nama'     => $request->nama,
            'jenis_kelamin'   => $request->jenis_kelamin,
            'username'   => $request->username,
            'password'   => Hash::make($request->password)
            // 'password'   => Hash::make($request->password)
        ]);

        //redirect to index
        return redirect()->route('staff.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy(User $staff)
    {

        //delete staff
        $staff->delete();

        //redirect to index
        return redirect()->route('staff.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
