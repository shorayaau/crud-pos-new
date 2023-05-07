@extends('layouts.admin')
@section('header', 'Barang')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Beli Barang</h3>
                </div>
                <form method="POST" action="{{ route('sales.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label>Nama User</label>
                            <input type="text" class="form-control @error('nama_user') is-invalid @enderror"
                                name="nama_user" value="{{ $user->nama }}">
                            @error('nama_user')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Nama Barang</label>
                            <select name="id_barang" class="form-control @error('id_barang') is-invalid @enderror"
                                id="id_barang">
                                <option value="">Pilih Barang</option>
                                @foreach ($item as $value)
                                    <option value="{{ $value->id }}" data-harga="{{ $value->harga_jual }}">
                                        {{ $value->nama }}</option>
                                @endforeach
                            </select>
                            @error('id_barang')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Qty</label>
                            <input type="text" class="form-control @error('qty') is-invalid @enderror" name="qty"
                                id="qty" value="{{ old('qty') }}">
                            @error('qty')
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
                            <label>Total</label>
                            <input type="text" class="form-control @error('total') is-invalid @enderror" name="total"
                                id="total" value="{{ old('total') }}">
                            @error('total')
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

            function DeFormatRupiah(angka) {
                var result = angka.replace(/,/g, '');
                return result;
            };

            $(document).on('change', '#id_barang', function() {
                // var tr = $(this).parent().parent();
                const selected = $(this).find('option:selected');
                const nb = selected.data('harga');
                console.log(nb);
                // var i = $(this).data('index');

                $("input[name='harga_jual']").val(FormatRupiah(nb));
                // $(".harga_satuan").eq(i).val(nb);
            });

            $('#qty').keyup(function() {
                $(this).val(FormatRupiah($(this).val()));
                var qty = parseFloat(DeFormatRupiah($(this).val()));
                var harga_jual = parseFloat(DeFormatRupiah($("input[name='harga_jual']").val()));
                $('#total').val(FormatRupiah(qty * harga_jual));
            })
        });
    </script>
@endpush
