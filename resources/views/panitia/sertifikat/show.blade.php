@extends('layouts.app2')

@section('content')
<div class="card my-4">
    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
        <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
            <h6 class="text-white text-capitalize ps-3">Peserta Hadir - {{ $event->nama }}</h6>
        </div>
    </div>

    <div class="card-body px-3 pb-2">
        <div class="table-responsive">
            <table class="table align-items-center mb-0">
                <thead>
                    <tr>
                        <th class="text-uppercase text-dark text-xs font-weight-bolder ps-3">Nama</th>
                        <th class="text-uppercase text-dark text-xs font-weight-bolder">Waktu Hadir</th>
                        <th class="text-uppercase text-dark text-xs font-weight-bolder">Sertifikat</th>
                        <th class="text-uppercase text-dark text-xs font-weight-bolder">Upload Sertifikat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kehadiran as $k)
                    <tr>
                        <td class="text-sm font-weight-bold mb-0">{{ $k->user->name }}</td>
                        <td class="text-sm font-weight-bold mb-0">{{ \Carbon\Carbon::parse($k->waktu_kehadiran)->format('d-m-Y H:i') }}</td>
                        <td class="text-sm font-weight-bold mb-0">
                            @if($k->sertifikat)
                                <button class="btn btn-outline-primary btn-sm rounded-pill"
                                    data-bs-toggle="modal" data-bs-target="#sertifikatModal{{ $k->id }}">
                                    <i class="fa fa-eye me-1"></i> Lihat Sertifikat
                                </button>

                                <!-- Modal Preview Sertifikat -->
                                <div class="modal fade" id="sertifikatModal{{ $k->id }}" tabindex="-1" aria-labelledby="sertifikatLabel{{ $k->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content border-0 shadow-lg rounded-4">
                                            <div class="modal-header bg-gradient-dark text-white rounded-top-4">
                                                <h5 class="modal-title" id="sertifikatLabel{{ $k->id }}">
                                                    <i class="fa fa-file-pdf me-2"></i> Preview Sertifikat
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <iframe src="{{ asset('storage/' . $k->sertifikat->file_sertifikat) }}" 
                                                        width="100%" height="500px" frameborder="0"></iframe>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <span class="text-muted fst-italic">Belum ada</span>
                            @endif
                        </td>
                        <td class="text-sm font-weight-bold mb-0">
                            <form action="{{ route('panitia.sertifikat.upload', $k->id) }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center gap-2">
                                @csrf
                                <input type="file" name="file_sertifikat" class="form-control form-control-sm" required>
                                <button type="submit" class="btn btn-success btn-sm rounded-pill">
                                    <i class="fa fa-upload me-1"></i> Upload
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-sm font-weight-bold mb-0">
                            <i class="fa fa-calendar-times fa-2x d-block mb-2"></i>
                            Tidak ada peserta yang hadir.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
