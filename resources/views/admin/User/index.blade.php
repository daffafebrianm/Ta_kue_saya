@extends('admin.layouts.main')

@section('title', 'Data User')

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar User</h1>


    <table class="table table-bordered table-hover text-center align-middle">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Nomor Hp</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $index => $dataUser)
                <tr>
                    <td>{{ $users->firstItem() + $index }}</td>
                    <td>{{ $dataUser->nama }}</td>
                    <td>{{ $dataUser->username }}</td>
                    <td>{{ $dataUser->email }}</td>
                    <td>{{ ucfirst($dataUser->role) }}</td>
                    <td>{{ $dataUser->phone_number ?? '-' }}</td>
                    <td>
                        <a href="{{ route('user.edit', $dataUser->id) }}" class="btn btn-warning btn-sm">Edit</a>

                        <form action="{{ route('user.destroy', $dataUser->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
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

    <div class="d-flex justify-content-center mt-3">
        {{ $users->links() }}
    </div>
</div>
@endsection
