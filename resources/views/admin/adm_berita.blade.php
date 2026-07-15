@extends('layout/admin_dashboard')

@section('title', 'Admin - Kelola Berita')

@section('main')
<div class="col">
    <div class="mt-4">
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4" style="flex-wrap: wrap; gap: 12px;">
            <div>
                <h4 style="font-weight: 700; color: #1a4d2e; margin: 0;">
                    <i class="fas fa-newspaper" style="color: #c4992a;"></i> Kelola Berita
                </h4>
                <p style="color: #888; font-size: 13px; margin: 4px 0 0;">Tambah, edit, dan hapus berita yang tampil di website publik.</p>
            </div>
            <a href="{{ url('/admin/successlogin/berita/create') }}"
               style="background: linear-gradient(135deg, #1a4d2e, #2d6b42); color: #fff; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-size: 14px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fas fa-plus"></i> Tambah Berita
            </a>
        </div>

        {{-- Alert Status --}}
        @if(session('status'))
        <div class="alert alert-success" style="border-radius: 8px; border: none; background: #d4edda; color: #155724;">
            <i class="fas fa-check-circle"></i> {{ session('status') }}
        </div>
        @endif

        {{-- Statistik Card --}}
        <div class="row mb-4">
            <div class="col-4">
                <div style="background: #fff; border-radius: 12px; padding: 20px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); text-align: center;">
                    <div style="font-size: 28px; font-weight: 800; color: #1a4d2e;">{{ $stats['total'] }}</div>
                    <div style="font-size: 12px; color: #888;">Total Berita</div>
                </div>
            </div>
            <div class="col-4">
                <div style="background: #fff; border-radius: 12px; padding: 20px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); text-align: center;">
                    <div style="font-size: 28px; font-weight: 800; color: #28a745;">{{ $stats['published'] }}</div>
                    <div style="font-size: 12px; color: #888;">Published</div>
                </div>
            </div>
            <div class="col-4">
                <div style="background: #fff; border-radius: 12px; padding: 20px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); text-align: center;">
                    <div style="font-size: 28px; font-weight: 800; color: #6c757d;">{{ $stats['draft'] }}</div>
                    <div style="font-size: 12px; color: #888;">Draft</div>
                </div>
            </div>
        </div>

        {{-- Tabel Berita --}}
        <div style="background: #fff; border-radius: 14px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.07);">
            <div class="table-responsive">
                <table class="table table-hover" style="margin: 0;">
                    <thead style="background: #f8f9fa;">
                        <tr>
                            <th style="padding: 14px 20px; font-size: 12px; text-transform: uppercase; color: #888; font-weight: 700; border: none;">#</th>
                            <th style="padding: 14px 20px; font-size: 12px; text-transform: uppercase; color: #888; font-weight: 700; border: none;">Judul Berita</th>
                            <th style="padding: 14px 20px; font-size: 12px; text-transform: uppercase; color: #888; font-weight: 700; border: none;">Kategori</th>
                            <th style="padding: 14px 20px; font-size: 12px; text-transform: uppercase; color: #888; font-weight: 700; border: none;">Status</th>
                            <th style="padding: 14px 20px; font-size: 12px; text-transform: uppercase; color: #888; font-weight: 700; border: none;">Tanggal</th>
                            <th style="padding: 14px 20px; font-size: 12px; text-transform: uppercase; color: #888; font-weight: 700; border: none;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($beritas as $b)
                        <tr>
                            <td style="padding: 14px 20px; vertical-align: middle; color: #aaa; font-size: 13px;">{{ $loop->iteration }}</td>
                            <td style="padding: 14px 20px; vertical-align: middle;">
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    @if($b->gambar)
                                    <img src="{{ asset('img/berita/' . $b->gambar) }}" alt="" style="width: 44px; height: 44px; object-fit: cover; border-radius: 8px; flex-shrink: 0;">
                                    @else
                                    <div style="width: 44px; height: 44px; background: linear-gradient(135deg, #1a4d2e, #2d6b42); border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                        <i class="fas fa-newspaper" style="color: rgba(255,255,255,0.5); font-size: 16px;"></i>
                                    </div>
                                    @endif
                                    <div>
                                        <div style="font-weight: 600; color: #222; font-size: 14px; line-height: 1.3;">
                                            {{ Str::limit($b->judul, 55) }}
                                        </div>
                                        @if($b->penulis)
                                        <div style="font-size: 12px; color: #aaa; margin-top: 2px;">oleh {{ $b->penulis }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 14px 20px; vertical-align: middle;">
                                <span style="background: #f0f4f1; color: #1a4d2e; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600;">
                                    {{ $b->kategori }}
                                </span>
                            </td>
                            <td style="padding: 14px 20px; vertical-align: middle;">
                                @if($b->status === 'published')
                                    <span style="background: #d4edda; color: #155724; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600;">
                                        <i class="fas fa-circle" style="font-size: 7px;"></i> Published
                                    </span>
                                @else
                                    <span style="background: #e2e3e5; color: #383d41; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600;">
                                        <i class="fas fa-circle" style="font-size: 7px;"></i> Draft
                                    </span>
                                @endif
                            </td>
                            <td style="padding: 14px 20px; vertical-align: middle; color: #666; font-size: 13px;">
                                {{ $b->tanggal->format('d M Y') }}
                            </td>
                            <td style="padding: 14px 20px; vertical-align: middle;">
                                <div style="display: flex; gap: 6px;">
                                    <a href="{{ url('/berita/' . $b->slug) }}" target="_blank"
                                       style="background: #e8f5e9; color: #1a4d2e; padding: 6px 10px; border-radius: 6px; text-decoration: none; font-size: 12px; font-weight: 600;" title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ url('/admin/successlogin/berita/' . $b->id . '/edit') }}"
                                       style="background: #fff3cd; color: #856404; padding: 6px 10px; border-radius: 6px; text-decoration: none; font-size: 12px; font-weight: 600;" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ url('/admin/successlogin/berita/' . $b->id) }}" method="POST" style="display: inline;"
                                          onsubmit="return confirm('Yakin ingin menghapus berita ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            style="background: #f8d7da; color: #721c24; padding: 6px 10px; border-radius: 6px; border: none; cursor: pointer; font-size: 12px; font-weight: 600;" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 50px; color: #bbb;">
                                <i class="fas fa-newspaper" style="font-size: 36px; margin-bottom: 10px; display: block;"></i>
                                Belum ada berita. <a href="{{ url('/admin/successlogin/berita/create') }}" style="color: #1a4d2e;">Tambah sekarang</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $beritas->links() }}
        </div>
    </div>
</div>
@endsection
