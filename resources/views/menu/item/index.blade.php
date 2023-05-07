@extends('layouts.admin')
@section('header', 'Barang')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card-header">
                <a href="{{ url('item/create') }}" class="btn btn-sm btn-primary pull-right"><i
                        class="bi bi-plus-square-dotted"></i>&nbsp; Tambah Barang</a>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Nama Barang</th>
                            <th>Jenis Barang</th>
                            <th>Deskripsi</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>Stok</th>
                            <th class="text-center">Action</th>
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
                        @forelse($item as $num => $value)
                            <tr>
                                <td>{{ $num + 1 }}</td>
                                <td>{{ $value->nama }}</td>
                                <td>{{ $value->jenis_barang }}</td>
                                <td>{{ $value->deskripsi }}</td>
                                <td>{{ rupiah($value->harga_beli) }}</td>
                                <td>{{ rupiah($value->harga_jual) }}</td>
                                <td>{{ rupiah($value->stok) }}</td>
                                <td class="text-center">
                                    <form onsubmit="return confirm('Apakah Anda Yakin ?');"
                                        action="{{ route('item.destroy', $value->id) }}" method="POST">
                                        <a href="{{ route('item.edit', $value->id) }}"
                                            class="btn btn-sm btn-primary">EDIT</a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">HAPUS</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <div class="alert alert-danger">
                                Data Barang belum Tersedia.
                            </div>
                        @endforelse
                    </tbody>
                </table>
                {{ $item->links() }}
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
