@extends('layout.backend.app', [
'title' => 'Welcome',
'pageTitle' => 'Dashboard ' . ucfirst(Auth::user()->role),
])
@section('content')
<hr>
@if(session()->has('success'))
<div class="notify">

    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}

        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>

<script>
    setTimeout(function(){
      $('.alert').alert('close');
    }, 2000);
</script>
@endif

@if(session()->has('error'))
<div class="notify">

    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fa-solid fa-circle-check"></i> {{ session('error') }}

        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>

<script>
    setTimeout(function(){
      $('.alert').alert('close');
    }, 2000);
</script>
@endif
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="card m-0">
                    <div class="row no-gutters">
                        <div class="col-md-4">
                            @foreach($mahasiswas as $mahasiswa)
                            @if(empty($mahasiswa->foto))
                                <img src="{{ asset('images/backend/ava.jpg') }}" class="card-img" alt="" width="207" height="250">
                            @else
                                <img src= "{{ asset('storage/foto/' . $mahasiswa->foto) }}" class="card-img" alt="" width="207" height="250">
                            @endif
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title text-dark">{{ $mahasiswa->nama }}</h5>
                                <h5 class="card-title text-dark">{{ $mahasiswa->nim }}</h5>
                                <h5 class="card-title text-dark">S1 Informatika</h5>
                                <h5 class="card-title text-dark">{{ $mahasiswa->angkatan }}</h5>
                                <h5 class="card-title text-dark">Dosen Wali: {{ $mahasiswa->dosen->nama }} ({{
                                    $mahasiswa->dosen->nip }})</h5>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body text-center">
                                <h5 class="card-title text-dark">IPK</h5>
                                @if(isset($IPK["AVG(CAST(ips AS DECIMAL(10, 2)))"]) && $IPK["AVG(CAST(ips AS DECIMAL(10, 2)))"] > 0)
                                    {{ number_format($IPK["AVG(CAST(ips AS DECIMAL(10, 2)))"], 2) }}
                                @else
                                    Belum Entry Data
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card mb-3">
                            <div class="card-body text-center">
                                <h5 class="card-title text-dark">Semester Studi</h5>
                                <p class="card-text">{{ $semester ?: 1 }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body text-center">
                                <h5 class="card-title text-dark">SKSk</h5>
                                <p class="card-text">{{ $sksk != null && $sksk > 0 ? $sksk : 'Belum Entry Data' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card ">
                            <div class="card-body text-center">
                                <h5 class="card-title text-dark">Status Akademik</h5>
                                <p class="card-text">
                                    <span class="badge badge-success">@if ($mahasiswa->status === 'aktif')
                                        Aktif
                                    @elseif ($mahasiswa->status === 'do')
                                        DO
                                    @elseif ($mahasiswa->status === 'mangkir')
                                        Mangkir
                                    @elseif ($mahasiswa->status === 'mengundurkan_diri')
                                        Mengundurkan Diri
                                    @elseif ($mahasiswa->status === 'cuti')
                                        Cuti
                                    @elseif ($mahasiswa->status === 'meninggal_dunia')
                                        Meninggal Dunia
                                    @elseif ($mahasiswa->status === 'lulus')
                                        Lulus
                                    @endif</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    
</div>
<div class="container mt-2">
    <div class="row">
        @for($i = 1; $i <= 14; $i++)
            <div class="col-md-2">
                <button class="btn btn-md btn-block mb-2
                    @if($skripsi->isNotEmpty() && $skripsi->first()->semester == $i) btn-success
                    @elseif($pkl->isNotEmpty() && $pkl->first()->semester == $i) btn-warning
                    @elseif($irs->where('semester', $i)->isNotEmpty() && $khs->where('semester', $i)->isNotEmpty()) btn-primary
                    @else btn-danger
                    @endif"
                    data-toggle="modal" data-target="#semesterModal{{ $i }}">
                    {{ $i }}
                </button>
            </div>
            
            <!-- Modal for Semester {{$i}} -->
            <div class="modal fade" id="semesterModal{{ $i }}" tabindex="-1" role="dialog" aria-labelledby="semesterModalLabel{{ $i }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="semesterModalLabel{{ $i }}">Informasi Semester {{ $i }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Tambahkan informasi sesuai kebutuhan, contoh dengan jumlah_sks dari IRS -->
                            @if($skripsi->isNotEmpty() && $skripsi->first()->semester == $i)
                                <p>Jumlah SKS: {{ $irs->where('semester', $i)->first()->jumlah_sks }}</p>
                                <p>Jumlah IP Semester: {{ $khs->where('semester', $i)->first()->ips }}</p>
                                <p>Nilai Skripsi: {{ $skripsi->where('semester', $i)->first()->nilai }}</p>
                                <p>Tanggal Sidang: {{ $skripsi->where('semester', $i)->first()->tanggal_sidang }}</p>
                                <p>Lama Studi: {{ $skripsi->where('semester', $i)->first()->lama_studi }}</p>
                                <!-- Tambahkan informasi lainnya jika diperlukan -->
                            @elseif($pkl->isNotEmpty() && $pkl->first()->semester == $i)
                                <p>Jumlah SKS: {{ $irs->where('semester', $i)->first()->jumlah_sks }}</p>
                                <p>Jumlah IP Semester: {{ $khs->where('semester', $i)->first()->ips }}</p>
                                <p>Nilai PKL: {{ $pkl->where('semester', $i)->first()->nilai }}</p>
                            @elseif($irs->where('semester', $i)->isNotEmpty() && $khs->where('semester', $i)->isNotEmpty())
                                <p>Jumlah SKS: {{ $irs->where('semester', $i)->first()->jumlah_sks }}</p>
                                <p>Jumlah IP Semester: {{ $khs->where('semester', $i)->first()->ips }}</p>
                            @else 
                                <p>INFORMASI BELUM TERSEDIA</p>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        @endfor
    </div>
</div>

<!-- resources/views/modal/address.blade.php -->
<div class="modal fade" id="addressModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Data Tidak lengkap<i class="fa-solid fa-triangle-exclamation"></i></h5>
            </div>
            <div class="modal-body">
                <p>Silakan Lengkapi Data Anda Terlebih Dahulu!!</p>
            </div>
            <div class="modal-footer">
                <a href="{{ route('profile') }}" class="btn btn-primary">Lihat Profil</a>
            </div>
        </div>
    </div>
</div>
</div>
<script>
    // Periksa apakah alamat, kota, provinsi, dan handphone kosong
  var mahasiswaAddress = '{{ $mahasiswa->alamat }}'; // Gantilah ini dengan cara Anda mendapatkan alamat mahasiswa
  var mahasiswaKota = '{{ $mahasiswa->kota_id }}'; // Gantilah ini dengan cara Anda mendapatkan kota mahasiswa
  var mahasiswaProvinsi = '{{ $mahasiswa->provinsi_id }}'; // Gantilah ini dengan cara Anda mendapatkan provinsi mahasiswa
  var mahasiswaHandphone = '{{ $mahasiswa->handphone }}'; // Gantilah ini dengan cara Anda mendapatkan handphone mahasiswa
  var mahasiswaFoto = '{{ $mahasiswa->foto }}'; // Gantilah ini dengan cara Anda mendapatkan handphone mahasiswa

  $(document).ready(function() {
      if (mahasiswaAddress === '' || mahasiswaKota === '' || mahasiswaProvinsi === '' || mahasiswaHandphone === '' || mahasiswaFoto === '' ) {
        $('#addressModal').modal({
            backdrop: 'static', // Modal tidak akan ditutup saat mengklik latar belakang
            keyboard: false,   // Modal tidak akan ditutup dengan tombol keyboard
        });
          // Jika salah satu dari data kosong, tampilkan modal secara otomatis
          $('#addressModal').modal('show');
          
      }

  });
</script>
@endsection
