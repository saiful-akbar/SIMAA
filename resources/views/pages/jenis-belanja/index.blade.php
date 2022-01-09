@extends('templates.main')

@section('title', 'Akun Belanja')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title mt-2">Tabel Akun Belanja</h4>
                </div>

                <div class="card-body">

                    {{-- button tambah & form search --}}
                    <div class="row align-items-center">
                        <div class="col-md-6 col-sm-12 mb-3">
                            @if ($userAccess->pivot->create == 1)
                                <a href="{{ route('jenis-belanja.create') }}" class="btn btn-rounded btn-primary btn-sm">
                                    <i class="mdi mdi-plus-circle mr-1"></i>
                                    <span>Tambah Akun Belanja</span>
                                </a>
                            @endif
                        </div>

                        <div class="col-md-6 col-sm-12 mb-3">
                            <form action="{{ route('jenis-belanja') }}" method="GET" autocomplete="off">
                                <div class="input-group">
                                    <input type="search" name="search" placeholder="Cari akun belanja..."
                                        class="form-control" value="{{ request('search') }}" />
                                    <div class="input-group-append">
                                        <button class="btn btn-secondary" type="submit">
                                            <i class="uil-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    {{-- end button tambah & form search --}}

                    {{-- table --}}
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="table-responsive">
                                <table class="table nowrap table-centered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Ketergori Belanja</th>
                                            <th>Aktif</th>
                                            <th>Dibuat</th>
                                            <th>Diperbarui</th>

                                            @if ($userAccess->pivot->update == 1 || $userAccess->pivot->delete == 1)
                                                <th class="text-center">Aksi</th>
                                            @endif
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($jenisBelanja as $data)
                                            <tr>
                                                <td>
                                                    {{ $jenisBelanja->count() * ($jenisBelanja->currentPage() - 1) + $loop->iteration }}
                                                </td>
                                                <td>{{ $data->kategori_belanja }}</td>
                                                <td>
                                                    @if ($data->active == 1)
                                                        <i class="mdi mdi-check text-success h3"></i>
                                                    @else
                                                        <i class="mdi mdi mdi-close text-danger h3"></i>
                                                    @endif
                                                </td>
                                                <td>{{ $data->created_at }}
                                                <td>{{ $data->updated_at }}
                                                </td>

                                                @if ($userAccess->pivot->update == 1 || $userAccess->pivot->delete == 1)
                                                    <td class="text-center">
                                                        @if ($userAccess->pivot->update == 1)
                                                            <a href="{{ route('jenis-belanja.edit', ['jenisBelanja' => $data->id]) }}"
                                                                class="btn btn-sm btn-light btn-icon mr-1"
                                                                data-toggle="tooltip" data-original-title="Edit"
                                                                data-placement="top">
                                                                <i class="mdi mdi-square-edit-outline"></i>
                                                            </a>
                                                        @endif

                                                        @if ($userAccess->pivot->delete == 1)
                                                            <button class="btn btn-sm btn-light btn-icon"
                                                                data-toggle="tooltip" data-original-title="Hapus"
                                                                data-placement="top"
                                                                onclick="handleDelete({{ $data->id }})">
                                                                <i class="mdi mdi-delete"></i>
                                                            </button>
                                                        @endif
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- paginasi --}}
                        <div class="col-12 d-flex justify-content-end">
                            {{ $jenisBelanja->links() }}
                        </div>
                    </div>
                    {{-- end table --}}

                </div>
            </div>
        </div>
    </div>

    {{-- form delete --}}
    <form method="POST" id="form-delete-jenis-belanja">
        @method('DELETE') @csrf
    </form>
@endsection

@section('js')
    <script>
        /**
         * Fungsi handle hapus data user
         *
         * @param {int} id
         * @param {string} username
         */
        function handleDelete(id) {
            bootbox.confirm({
                title: `Anda ingin menghapus akun belanja ?`,
                message: `
                    <div class="alert alert-danger" role="alert">
                        <h4 class="alert-heading">
                            <i class="dripicons-warning mr-1"></i>
                            Peringatan!
                        </h4>

                        <ul>
                            <li>Tindakan ini tidak dapat dibatalkan.</li>
                            <li>Akun belanja yang dihapus tidak dapat dikembalikan.</li>
                            <li>Pastikan anda berhati-hati dalam menghapus.</li>
                        </ul>

                        <p>
                            <b>NB:</b> Akun belanja tidak dapat dihapus jika memilikin data pada relasi <b>budget</b>!
                        </p>
                    </div>
                `,
                buttons: {
                    confirm: {
                        label: "<i class='mdi mdi-delete mr-1'></i> Hapus",
                        className: "btn btn-danger btn-sm btn-rounded",
                    },
                    cancel: {
                        label: "<i class='mdi mdi-close-circle mr-1'></i> Batal",
                        className: "btn btn-sm btn-dark btn-rounded mr-2",
                    },
                },
                callback: (result) => {
                    if (result) {
                        const form = $("#form-delete-jenis-belanja");

                        form.attr("action", `${main.baseUrl}/jenis-belanja/${id}`);
                        form.submit();
                    }
                },
            });
        }
    </script>
@endsection
