@extends('layouts.admin')
@section('header', 'Sales')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card-header">
                @if ($user->level == 'pembeli')
                    <a href="{{ url('sales/create') }}" class="btn btn-sm btn-primary pull-right"><i
                            class="bi bi-plus-square-dotted"></i>&nbsp; Beli Barang</a>
                @endif
            </div>
            <div class="card-body p-0">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Nama Pembeli</th>
                            <th>Nama Barang</th>
                            <th>Qty</th>
                            <th>Harga Jual</th>
                            <th>Total</th>
                            @if ($user->level == 'admin' || $user->level == 'user')
                                <th class="text-center">Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            function rupiah($angka)
                            {
                                $hasil_rupiah = number_format($angka, 0, '.', ',');
                                return $hasil_rupiah;
                            }
                        @endphp
                        @forelse($sales as $num => $value)
                            <tr>
                                <td>{{ $num + 1 }}</td>
                                <td>{{ $value->nama_user }}</td>
                                <td>{{ $value->nama_barang }}</td>
                                <td>{{ rupiah($value->qty) }}</td>
                                <td>{{ rupiah($value->harga_jual) }}</td>
                                <td>{{ rupiah($value->total) }}</td>
                                @if ($user->level == 'admin' || $user->level == 'user')
                                    <td class="text-center">
                                        <form onsubmit="return confirm('Apakah Anda Yakin ?');"
                                            action="{{ route('item.stokkurang', $value->id_barang) }}" method="POST">
                                            @csrf
                                            {{-- @method('PUT') --}}
                                            <div class="form-group">
                                                <input type="hidden"
                                                    class="form-control @error('id_barang') is-invalid @enderror" name="id_barang"
                                                    id="id_barang" value="{{ $value->id_barang }}">
                                                @error('id_barang')
                                                    <div class="alert alert-danger mt-2">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <input type="hidden"
                                                    class="form-control @error('stok') is-invalid @enderror" name="stok"
                                                    id="stok" value="{{ $value->stok }}">
                                                @error('stok')
                                                    <div class="alert alert-danger mt-2">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <input type="hidden"
                                                    class="form-control @error('qty') is-invalid @enderror" name="qty"
                                                    id="qty" value="{{ $value->qty }}">
                                                @error('qty')
                                                    <div class="alert alert-danger mt-2">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            {{-- <a href="{{ route('sales.edit', $value->id) }}" class="btn btn-sm btn-primary">
                                                DETAIL</a> --}}
                                            <button type="submit" class="btn btn-sm btn-danger">VALIDASI</button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <div class="alert alert-danger">
                                Data Sales belum Tersedia.
                            </div>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        //message with toastr
        @if (session()->has('success'))

            toastr.success('{{ session('success') }}', 'BERHASIL!');
        @elseif (session()->has('error'))

            toastr.error('{{ session('error') }}', 'GAGAL!');
        @endif
    </script>
@endpush
