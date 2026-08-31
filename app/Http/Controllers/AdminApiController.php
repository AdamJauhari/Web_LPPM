<?php
/**
 * Admin API Controller
 * Endpoint untuk Electron Admin Panel
 * Dilindungi oleh token 12 digit
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Researche;
use App\CommunityService;
use App\Publication;
use App\Expertise;
use App\User;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AdminApiController extends Controller
{
    /**
     * Verify admin token
     */
    private function verifyToken(Request $request)
    {
        $token = $request->header('X-Admin-Token');
        $storedToken = $this->getStoredToken();
        
        if (!$token || $token !== $storedToken) {
            return false;
        }
        return true;
    }

    /**
     * Get stored token from file
     */
    private function getStoredToken()
    {
        $tokenFile = storage_path('app/admin_token.txt');
        if (file_exists($tokenFile)) {
            return trim(file_get_contents($tokenFile));
        }
        return null;
    }

    /**
     * Verify token endpoint
     */
    public function verify(Request $request)
    {
        if ($this->verifyToken($request)) {
            return response()->json(['status' => 'ok', 'message' => 'Token valid']);
        }
        return response()->json(['status' => 'error', 'message' => 'Token tidak valid'], 401);
    }

    /**
     * Get lookup references for foreign key IDs (users, fakultas, prodi, dosen, penelitian)
     */
    public function references(Request $request)
    {
        if (!$this->verifyToken($request)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $users = DB::table('users')->select('id', 'name', 'email', 'role', 'nidn', 'nim_nip')->orderBy('name')->get();
        $fakultas = \Schema::hasTable('fakultas') ? DB::table('fakultas')->select('id', 'nama_fakultas')->orderBy('nama_fakultas')->get() : [];
        $prodi = \Schema::hasTable('prodi') ? DB::table('prodi')->select('id', 'nama_prodi', 'fakultas_id')->orderBy('nama_prodi')->get() : [];
        $dosen = \Schema::hasTable('dosen') ? DB::table('dosen')->select('id', 'nama_dosen', 'nidn', 'pangkat_jabatan')->orderBy('nama_dosen')->get() : [];
        $penelitian = \Schema::hasTable('penelitian') ? DB::table('penelitian')->select('id', 'judul', 'tahun')->orderBy('id', 'desc')->get() : [];

        // Fallback: if dosen table is empty, include users with role='dosen'
        if (empty($dosen) || count($dosen) === 0) {
            $dosen = DB::table('users')->where('role', 'dosen')->select('id', 'name as nama_dosen', 'nidn')->orderBy('name')->get();
        }

        return response()->json([
            'users' => $users,
            'fakultas' => $fakultas,
            'prodi' => $prodi,
            'dosen' => $dosen,
            'penelitian' => $penelitian
        ]);
    }

    /**
     * Upload photo for organization members
     */
    public function uploadPhoto(Request $request)
    {
        if (!$this->verifyToken($request)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        if (!$request->hasFile('photo')) {
            return response()->json(['error' => 'No file uploaded'], 400);
        }

        $file = $request->file('photo');
        $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
        $file->move(public_path('img/organisasi'), $filename);

        return response()->json(['status' => 'ok', 'filename' => $filename]);
    }

    public function uploadFile(Request $request)
    {
        if (!$this->verifyToken($request)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        if (!$request->hasFile('file')) {
            return response()->json(['error' => 'No file uploaded'], 400);
        }

        $type = $request->input('type', 'documents');
        $destination = '';

        if ($type === 'penelitian') {
            $destination = 'img/penelitian';
        } elseif ($type === 'pengabdian') {
            $destination = 'img/pengabdian';
        } elseif ($type === 'publikasi') {
            $destination = 'download/publikasi';
        } elseif ($type === 'berita') {
            $destination = 'img/berita';
        } elseif ($type === 'hki' || $type === 'file_sertifikat') {
            $destination = 'uploads/hki';
        } elseif ($type === 'laporan_jurnal' || $type === 'file_bukti') {
            $destination = 'uploads/laporan_jurnal';
        } elseif ($type === 'laporan_sidang' || $type === 'berita_acara_file') {
            $destination = 'uploads/laporan_sidang';
        } elseif ($type === 'dosen' || $type === 'sk_dosen' || $type === 'dosen_luaran') {
            $destination = 'uploads/dosen';
        } else {
            $destination = 'uploads/documents';
        }

        $destPath = public_path($destination);
        if (!file_exists($destPath)) {
            @mkdir($destPath, 0777, true);
        }

        $file = $request->file('file');
        $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
        $file->move($destPath, $filename);

        return response()->json(['status' => 'ok', 'filename' => $filename]);
    }

    /**
     * Get dashboard stats
     */
    public function stats(Request $request)
    {
        if (!$this->verifyToken($request)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $pendingDosen = DB::table('users')->where('role', 'dosen')->where(function($q) {
            $q->where('is_approved', 0)->orWhereNull('is_approved')->orWhere('is_approved', false);
        })->count();

        $pendingResearch = DB::table('research_submissions')->where('status', 'pending')->count();
        $pendingPkm = DB::table('pkm_submissions')->where('status', 'pending')->count();
        $pendingHki = DB::table('hki_submissions')->where('status', 'pending')->count();
        $pendingJournal = DB::table('journal_submissions')->where('status', 'pending')->count();
        $pendingProposal = \Schema::hasTable('pengajuan_proposal') ? DB::table('pengajuan_proposal')->where('status', 'pending')->count() : 0;

        return response()->json([
            'berita' => DB::table('berita')->count(),
            'penelitian' => DB::table('researches')->count(),
            'pengabdian' => DB::table('community_services')->count(),
            'publikasi' => DB::table('publications')->count(),
            'struktur_organisasi' => DB::table('organization_members')->count(),
            'users' => DB::table('users')->count(),
            'ajuan_proposal' => DB::table('research_submissions')->count(),
            'ajuan_pkm' => DB::table('pkm_submissions')->count(),
            'ajuan_hki' => DB::table('hki_submissions')->count(),
            'ajuan_jurnal' => DB::table('journal_submissions')->count(),
            'data_publikasi' => DB::table('publikasis')->count(),
            'data_pelaksanaan' => DB::table('pelaksanaans')->count(),
            'fakultas' => DB::table('fakultas')->count(),
            'prodi' => DB::table('prodi')->count(),
            'dosen' => DB::table('dosen')->count(),
            'penelitian_formal' => DB::table('penelitian')->count(),
            'pengajuan_proposal' => DB::table('pengajuan_proposal')->count(),
            'verifikasi_penelitian' => DB::table('verifikasi_penelitian')->count(),
            'hki_formal' => DB::table('hki')->count(),
            'laporan_sidang' => DB::table('laporan_sidang')->count(),
            'laporan_jurnal' => DB::table('laporan_jurnal')->count(),

            // Data untuk badge notifikasi merah:
            'pending_counts' => [
                'users' => $pendingDosen,
                'pending_users' => $pendingDosen,
                'research_submissions' => $pendingResearch,
                'pkm_submissions' => $pendingPkm,
                'hki_submissions' => $pendingHki,
                'journal_submissions' => $pendingJournal,
                'pengajuan_proposal' => $pendingProposal,
            ]
        ]);
    }

    /**
     * List data from a table
     */
    public function list(Request $request, $table)
    {
        if (!$this->verifyToken($request)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $allowed = ['berita', 'researches', 'community_services', 'publications', 'expertises', 'users', 'research_submissions', 'journal_submissions', 'organization_members', 'publikasis', 'pelaksanaans', 'pkm_submissions', 'hki_submissions', 'fakultas', 'prodi', 'dosen', 'penelitian', 'pengajuan_proposal', 'verifikasi_penelitian', 'hki', 'laporan_sidang', 'laporan_jurnal'];
        if (!in_array($table, $allowed)) {
            return response()->json(['error' => 'Table not allowed'], 400);
        }

        $search = $request->query('search', '');
        $query = DB::table($table);

        // Filter khusus pendaftaran dosen pending
        if ($table === 'users' && $request->has('pending_dosen')) {
            $query->where('role', 'dosen')->where(function($q) {
                $q->where('is_approved', 0)->orWhereNull('is_approved')->orWhere('is_approved', false);
            });
        }

        // Filter status umum (misal pending, approved)
        if ($request->has('status') && $request->query('status')) {
            $query->where('status', $request->query('status'));
        }

        if ($search) {
            $columns = \Schema::getColumnListing($table);
            $query->where(function($q) use ($columns, $search) {
                foreach ($columns as $col) {
                    $q->orWhere($col, 'LIKE', "%{$search}%");
                }
            });
        }

        $data = $query->orderBy('id', 'desc')->limit(100)->get();
        return response()->json($data);
    }

    /**
     * Get single record
     */
    public function show(Request $request, $table, $id)
    {
        if (!$this->verifyToken($request)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $allowed = ['berita', 'researches', 'community_services', 'publications', 'expertises', 'users', 'research_submissions', 'journal_submissions', 'organization_members', 'publikasis', 'pelaksanaans', 'pkm_submissions', 'hki_submissions', 'fakultas', 'prodi', 'dosen', 'penelitian', 'pengajuan_proposal', 'verifikasi_penelitian', 'hki', 'laporan_sidang', 'laporan_jurnal'];
        if (!in_array($table, $allowed)) {
            return response()->json(['error' => 'Table not allowed'], 400);
        }

        $data = DB::table($table)->where('id', $id)->first();
        if (!$data) {
            return response()->json(['error' => 'Not found'], 404);
        }
        return response()->json($data);
    }

    /**
     * Create new record
     */
    public function store(Request $request, $table)
    {
        if (!$this->verifyToken($request)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $allowed = ['berita', 'researches', 'community_services', 'publications', 'expertises', 'users', 'research_submissions', 'journal_submissions', 'organization_members', 'publikasis', 'pelaksanaans', 'pkm_submissions', 'hki_submissions', 'fakultas', 'prodi', 'dosen', 'penelitian', 'pengajuan_proposal', 'verifikasi_penelitian', 'hki', 'laporan_sidang', 'laporan_jurnal'];
        if (!in_array($table, $allowed)) {
            return response()->json(['error' => 'Table not allowed'], 400);
        }

        $data = $request->except(['_token']);
        $data['created_at'] = now();
        $data['updated_at'] = now();

        // Hash password for users
        if ($table === 'users' && isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        // Generate slug
        if (isset($data['title'])) {
            $data['slug'] = Str::slug($data['title']);
        } elseif (isset($data['judul']) && $table === 'berita') {
            $data['slug'] = Str::slug($data['judul']) . '-' . time();
        }

        try {
            $id = DB::table($table)->insertGetId($data);
            return response()->json(['status' => 'ok', 'id' => $id, 'message' => 'Data berhasil ditambahkan']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Update record
     */
    public function update(Request $request, $table, $id)
    {
        if (!$this->verifyToken($request)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $allowed = ['berita', 'researches', 'community_services', 'publications', 'expertises', 'users', 'research_submissions', 'journal_submissions', 'organization_members', 'publikasis', 'pelaksanaans', 'pkm_submissions', 'hki_submissions', 'fakultas', 'prodi', 'dosen', 'penelitian', 'pengajuan_proposal', 'verifikasi_penelitian', 'hki', 'laporan_sidang', 'laporan_jurnal'];
        if (!in_array($table, $allowed)) {
            return response()->json(['error' => 'Table not allowed'], 400);
        }

        $data = $request->except(['_token', 'id']);
        $data['updated_at'] = now();

        if ($table === 'users' && isset($data['password']) && $data['password']) {
            $data['password'] = Hash::make($data['password']);
        } elseif ($table === 'users') {
            unset($data['password']);
        }

        if (isset($data['title'])) {
            $data['slug'] = Str::slug($data['title']);
        } elseif (isset($data['judul']) && $table === 'berita') {
            $data['slug'] = Str::slug($data['judul']) . '-' . time();
        }

        try {
            DB::table($table)->where('id', $id)->update($data);
            return response()->json(['status' => 'ok', 'message' => 'Data berhasil diperbarui']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Delete record
     */
    public function destroy(Request $request, $table, $id)
    {
        if (!$this->verifyToken($request)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $allowed = ['berita', 'researches', 'community_services', 'publications', 'expertises', 'users', 'research_submissions', 'journal_submissions', 'organization_members', 'publikasis', 'pelaksanaans', 'pkm_submissions', 'hki_submissions', 'fakultas', 'prodi', 'dosen', 'penelitian', 'pengajuan_proposal', 'verifikasi_penelitian', 'hki', 'laporan_sidang', 'laporan_jurnal'];
        if (!in_array($table, $allowed)) {
            return response()->json(['error' => 'Table not allowed'], 400);
        }

        try {
            DB::table($table)->where('id', $id)->delete();
            return response()->json(['status' => 'ok', 'message' => 'Data berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
