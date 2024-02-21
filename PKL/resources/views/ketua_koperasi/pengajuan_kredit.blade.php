@extends('layout.main')

@section('content')
<div class="col-lg-50 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-2"> 
                <h2 class="card-title" style="font-size: 1.5rem;">TABEL PENGAJUAN KREDIT</h2>
                
                <div class="d-flex">
                    <!-- <a href="#" class="btn btn-primary btn-sm rounded-2 ml-1">Excel</a> -->
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-bordered text-center table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama</th>
                            <th>No Telepon</th>
                            <th>Jenis</th>
                            <th>Deskripsi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $counter = 1;
                        @endphp

                        @forelse ($pengajuan_kredits as $pengajuan_kredit)

                        <tr>
                            <td class="py-1">{{ $counter++ }}</td>
                            <td>{{ $pengajuan_kredit->tanggal_pengajuan }}</td>
                            <td>{{ $pengajuan_kredit->anggota->nama }}</td>
                            <td>{{ $pengajuan_kredit->anggota->no_telp }}</td>
                            <td>{{ ucfirst($pengajuan_kredit->jenis_pengajuan) }}</td>
                            <td class="text-left">
                                @if($pengajuan_kredit->jenis_pengajuan == 'uang')
                                    Nominal : {{ number_format($pengajuan_kredit->nominal, 0, ',', ',') }}
                                @elseif($pengajuan_kredit->jenis_pengajuan == 'barang')
                                    <div class="mb-1">
                                        Nama Barang: {{ $pengajuan_kredit->nama_barang }}
                                    </div>
                                    <div class="mb-1">
                                        Merk: {{ $pengajuan_kredit->merk }}
                                    </div>
                                    <div>
                                        Jenis: {{ $pengajuan_kredit->jenis_barang }}
                                    </div>
                                @else
                                    Deskripsi Tidak Diketahui
                                @endif
                            </td>
                            <td class="font-weight-medium">
                                <div class="badge 
                                    {{ $pengajuan_kredit->status == 'Menunggu' ? 'badge-warning' : 
                                    ($pengajuan_kredit->status == 'Disetujui' ? 'badge-success' : 
                                    ($pengajuan_kredit->status == 'Ditolak' ? 'badge-danger' : 'badge-secondary')) }}">
                                    {{ $pengajuan_kredit->status }}
                                </div>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('ketua_koperasi.setujuiPengajuan', ['id' => $pengajuan_kredit->id]) }}" class="btn btn-primary btn-sm rounded-2" onclick="return confirm('Apakah Anda yakin ingin menyetujui pengajuan ini?')">Setujui</a>
                                    <a href="{{ route('ketua_koperasi.tolakPengajuan', ['id' => $pengajuan_kredit->id]) }}" class="btn btn-danger btn-sm rounded-2" onclick="return confirm('Apakah Anda yakin ingin menolak pengajuan ini?')">Tolak</a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8">Tidak ada data pengajuan kredit.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
