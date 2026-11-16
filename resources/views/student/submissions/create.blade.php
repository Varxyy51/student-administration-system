@extends('layouts.app')

@section('title', 'Ajukan Surat Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold mb-0">Form Pengajuan Surat</h4>
            <a href="{{ route('student.dashboard') }}" class="btn btn-sm btn-outline-secondary">← Kembali</a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                @if ($errors->any())
                    <div class="alert alert-danger small">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('student.submissions.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pilih Jenis Surat</label>
                        <select name="letter_type_id" id="letter_type_id" class="form-select" required>
                            <option value="">-- Pilih Jenis Surat --</option>
                            @foreach ($letterTypes as $type)
                                <option value="{{ $type->id }}"
                                    data-desc="{{ $type->description }}"
                                    data-req="{{ implode(', ', $type->requirements ?? []) }}"
                                    {{ old('letter_type_id') == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                        <div id="letter-info" class="alert alert-info mt-2 small d-none">
                            <p class="mb-1" id="letter-desc"></p>
                            <strong>Syarat Dokumen:</strong> <span id="letter-req"></span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Keperluan / Tujuan Pengajuan</label>
                        <textarea name="purpose" rows="4" class="form-control" placeholder="Jelaskan secara singkat tujuan pembuatan surat (contoh: Untuk persyaratan pendaftaran beasiswa / magang di PT...)" required>{{ old('purpose') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Upload Dokumen Persyaratan</label>
                        <input type="file" name="documents[]" class="form-control" multiple accept=".pdf,.jpg,.jpeg,.png" required>
                        <div class="form-text">Bisa pilih lebih dari 1 file sekaligus (PDF, JPG, PNG — Maks. 2MB per file).</div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Kirim Pengajuan Surat</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const select = document.getElementById('letter_type_id');
    const infoBox = document.getElementById('letter-info');
    const descEl = document.getElementById('letter-desc');
    const reqEl = document.getElementById('letter-req');

    select.addEventListener('change', function () {
        const selected = this.options[this.selectedIndex];
        if (this.value) {
            descEl.textContent = selected.dataset.desc;
            reqEl.textContent = selected.dataset.req || 'Tidak ada syarat khusus';
            infoBox.classList.remove('d-none');
        } else {
            infoBox.classList.add('d-none');
        }
    });
</script>
@endsection