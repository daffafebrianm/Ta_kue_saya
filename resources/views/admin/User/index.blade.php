@extends('admin.layouts.main')

@section('title', 'Data User')

@section('content')
<div class="container">
  <h1 class="mb-4">Daftar User</h1>

  <div class="table-responsive">
    <table class="table table-bordered table-hover table-striped table-sm align-middle">
      <thead class="table-light">
        <tr class="text-nowrap">
          <th class="text-center">No</th>
          <th class="text-start">Nama</th>
          <th class="text-start">Username</th>
          <th class="text-start">Email</th>
          <th class="text-center">Role</th>
          <th class="text-start">Nomor HP</th>
          <th class="text-center">Aksi</th>
        </tr>
      </thead>
      <tbody class="table-group-divider">
        @forelse ($users as $index => $dataUser)
          <tr>
            <td class="text-center">{{ $users->firstItem() + $index }}</td>
            <td class="text-start fw-semibold text-dark">{{ $dataUser->nama }}</td>
            <td class="text-start text-dark">{{ $dataUser->username }}</td>
            <td class="text-start">
              @if($dataUser->email)
                <a href="mailto:{{ $dataUser->email }}">{{ $dataUser->email }}</a>
              @else
                <span class="text-muted">-</span>
              @endif
            </td>
            <td class="text-center">
              @php
                $role = strtolower($dataUser->role ?? '');
                $badge = $role === 'admin' ? 'bg-success' : ($role === 'staff' ? 'bg-warning' : 'bg-warning');
              @endphp
              <span class="badge rounded-pill {{ $badge }}">{{ ucfirst($dataUser->role) }}</span>
            </td>
            <td class="text-start">
              {{ $dataUser->phone_number ? preg_replace('/(\d{3})(\d{3,4})(\d+)/','$1-$2-$3',$dataUser->phone_number) : '-' }}
            </td>
            <td class="text-center text-nowrap">
              <a href="{{ route('user.edit', $dataUser->id) }}" class="btn btn-warning btn-sm" title="Edit">
                <i class="bi bi-pencil-square"></i>
              </a>
              <form action="{{ route('user.destroy', $dataUser->id) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                  <i class="bi bi-trash-fill"></i>
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7" class="text-center text-muted">Belum ada data user.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="d-flex justify-content-center mt-3">
    {{ $users->links() }}
  </div>
</div>

{{-- Kontras tabel ringan (opsional; bisa pindah ke file CSS) --}}
<style>
  .table td, .table th { color:#111827 !important; }            /* teks gelap */
  .table thead th { background:#f8fafc !important; color:#0f172a !important; }
  .table { border-color:#e5e7eb !important; }
  .table tbody tr:hover { background:#f3f4f6 !important; }
</style>
@endsection
