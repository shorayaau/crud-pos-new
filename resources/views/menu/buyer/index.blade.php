@extends('layouts.admin')
@section('header', 'Pembeli')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card-header">
                <a href="{{ url('buyer/create') }}" class="btn btn-sm btn-primary pull-right"><i
                        class="bi bi-plus-square-dotted"></i>&nbsp; Tambah Pembeli</a>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Nama Pembeli</th>
                            <th>Tempat Lahir</th>
                            <th>Tanggal Lahir</th>
                            <th>Jenis Kelamin</th>
                            <th>Username</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($buyer as $num => $value)
                            <tr>
                                <td>{{ $num + 1 }}</td>
                                <td>{{ $value->nama }}</td>
                                <td>{{ $value->tempat_lahir }}</td>
                                <td>{{ $value->tanggal_lahir }}</td>
                                <td>{{ $value->jenis_kelamin }}</td>
                                <td>{{ $value->username }}</td>
                                <td class="text-center">
                                    <form onsubmit="return confirm('Apakah Anda Yakin ?');"
                                        action="{{ route('buyer.destroy', $value->id) }}" method="POST">
                                        <a href="{{ route('buyer.edit', $value->id) }}"
                                            class="btn btn-sm btn-primary">EDIT</a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">HAPUS</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <div class="alert alert-danger">
                                Data Pembeli belum Tersedia.
                            </div>
                        @endforelse
                    </tbody>
                </table>
                {{ $buyer->links() }}
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
