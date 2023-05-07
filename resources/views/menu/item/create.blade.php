@extends('layouts.admin')
@section('header', 'Barang')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Tambah Barang</h3>
                </div>
                <form method="POST" action="{{ route('item.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label>Nama Barang</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama"
                                value="{{ old('nama') }}">
                            @error('nama')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Jenis Barang</label>
                            <input type="text" class="form-control @error('jenis_barang') is-invalid @enderror"
                                name="jenis_barang" value="{{ old('jenis_barang') }}">
                            @error('jenis_barang')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Gambar</label>
                            <input type="file" class="form-control @error('gambar') is-invalid @enderror" name="gambar"
                                value="{{ old('gambar') }}">
                            @error('gambar')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" cols="3" class="form-control @error('deskripsi') is-invalid @enderror"
                                value="{{ old('deskripsi') }}"></textarea>
                            @error('deskripsi')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Harga Beli</label>
                            <input type="text" class="form-control @error('harga_beli') is-invalid @enderror"
                                name="harga_beli" value="{{ old('harga_beli') }}">
                            @error('harga_beli')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Harga Jual</label>
                            <input type="text" class="form-control @error('harga_jual') is-invalid @enderror"
                                name="harga_jual" value="{{ old('harga_jual') }}">
                            @error('harga_jual')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Stok</label>
                            <input type="text" class="form-control @error('stok') is-invalid @enderror" name="stok"
                                value="{{ old('stok') }}">
                            @error('stok')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            function FormatRupiah(angka, prefix) {
                if (!angka) {
                    return '';
                }
                var vangka = angka.toString();
                var number_string = vangka.replace(/[^.\d]/g, '').replace(/[^\w\s]/gi, '').toString(),
                    split = number_string.split('.'),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                // tambahkan titik jika yang di input sudah menjadi angka ribuan
                if (ribuan) {
                    separator = sisa ? ',' : '';
                    rupiah += separator + ribuan.join(',');
                }

                rupiah = split[1] != undefined ? rupiah + '.' + split[1] : rupiah;
                return prefix == undefined ? rupiah : (rupiah ? rupiah : '');
            };

            $("input[name='harga_beli']").keyup(function() {
                $(this).val(FormatRupiah($(this).val()));
            })

            $("input[name='harga_jual']").keyup(function() {
                $(this).val(FormatRupiah($(this).val()));
            })

            $("input[name='stok']").keyup(function() {
                $(this).val(FormatRupiah($(this).val()));
            })
        });
    </script>
@endpush
