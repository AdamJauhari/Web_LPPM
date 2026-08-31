/* === App State === */
let API_URL = 'http://127.0.0.1:8000';
let TOKEN = '';
let currentSection = 'dashboard';
let currentData = [];
let editingId = null;

const TABLE_CONFIG = {
    berita:                { label:'Berita',            icon:'fa-newspaper',    fields:['judul','ringkasan','konten','kategori','status','tanggal','penulis','gambar'], colors:'#2c5282' },
    researches:            { label:'Penelitian',        icon:'fa-flask',         fields:['title','ringkasan','body','kategori','status','tanggal','penulis','thumbnail'], colors:'#1a4d2e' },
    community_services:    { label:'Pengabdian',        icon:'fa-hands-helping', fields:['title','ringkasan','body','kategori','status','tanggal','penulis','thumbnail'], colors:'#2d6b42' },
    publications:          { label:'Publikasi',  icon:'fa-file-alt',      fields:['title','author','date','abstract','file'],      colors:'#c4992a' },
    organization_members:  { label:'Struktur Organisasi', icon:'fa-sitemap', fields:['position','name','photo','photo_position','sort_order'], colors:'#0d2b1a' },
    users:                 { label:'Users',      icon:'fa-users',         fields:['name','username','email','password','role','nim_nip','nidn','fakultas','jabatan_fungsional','is_approved','approval_notes'],  colors:'#6b4c1a' },
    publikasis:            { label:'Data Publikasi', icon:'fa-book',      fields:['user_id','judul','abstrak','jenis_publikasi','kategori_reputasi','url_jurnal','url_repository'], colors:'#1a6b3a' },
    pelaksanaans:          { label:'Data Pelaksanaan', icon:'fa-tasks',   fields:['user_id','judul','deskripsi_singkat','jenis_kegiatan','sumber_dana','url'], colors:'#4a6b1a' },
    research_submissions:  { label:'Ajuan Proposal', icon:'fa-paper-plane', fields:['status','admin_notes','rejection_reason'], colors:'#2d6b42', reviewOnly:true },
    pkm_submissions:       { label:'Ajuan PKM',      icon:'fa-hands-helping', fields:['status','admin_notes','rejection_reason'], colors:'#1a4d2e', reviewOnly:true },
    hki_submissions:       { label:'Ajuan HKI',      icon:'fa-certificate', fields:['status','admin_notes','rejection_reason'], colors:'#0d2b1a', reviewOnly:true },
    journal_submissions:   { label:'Ajuan Jurnal',   icon:'fa-journal-whills', fields:['title','journal_name','authors','abstrak','status','admin_notes'], colors:'#c4992a', reviewOnly:true },
    pending_users:         { label:'Persetujuan Dosen', icon:'fa-user-clock',    fields:['name','username','email','nidn','fakultas','jabatan_fungsional','is_approved','approval_notes'], colors:'#d97706', reviewOnly:true, table:'users', filterParam:'pending_dosen=1' },
    // === ERD Tables ===
    fakultas:              { label:'Fakultas',         icon:'fa-university',    fields:['nama_fakultas','nama_dekan','nama_dosen','no_hp'], colors:'#1a3d5e' },
    prodi:                 { label:'Program Studi',    icon:'fa-graduation-cap',fields:['nama_prodi','nama_koordinator','fakultas_id','no_hp','email'], colors:'#2d5a7a' },
    dosen:                 { label:'Dosen',            icon:'fa-chalkboard-teacher', fields:['user_id','nama_dosen','nidn','nupk','pangkat_jabatan','id_prodi','no_hp','sk_dosen'], colors:'#3d7a9a' },
    penelitian:            { label:'Penelitian Formal',icon:'fa-microscope',    fields:['dosen_id','judul','klasifikasi','tahun','dana','jumlah_dana','status_proposal','status_verifikasi'], colors:'#1a5e3d' },
    pengajuan_proposal:    { label:'Pengajuan Proposal',icon:'fa-file-signature',fields:['penelitian_id','user_id','catatan_pengajuan','status','tanggal_ajuan'], colors:'#3a7a5e', reviewOnly:true },
    verifikasi_penelitian: { label:'Verifikasi Penelitian',icon:'fa-check-circle',fields:['penelitian_id','user_id','catatan_verifikasi','tanggal_verifikasi'], colors:'#2a6a4e', reviewOnly:true },
    hki:                   { label:'HKI (Formal)',     icon:'fa-shield-alt',    fields:['penelitian_id','jenis_hki','judul_hki','nomor_pendaftaran','file_sertifikat'], colors:'#5e3d1a' },
    laporan_sidang:        { label:'Laporan Sidang',   icon:'fa-gavel',         fields:['penelitian_id','tanggal_sidang','berita_acara_file','hasil_sidang'], colors:'#7a5e2d' },
    laporan_jurnal:        { label:'Laporan Jurnal',   icon:'fa-newspaper',     fields:['penelitian_id','kategori_jurnal','nama_jurnal','url_jurnal','file_bukti'], colors:'#9a7e4d' }
};


/* === Opsi Kategori Reputasi (Dinamis) === */
const KATEGORI_OPTIONS = {
    'Jurnal': [
        'Internasional Bereputasi (Q1)', 'Internasional Bereputasi (Q2)',
        'Internasional Bereputasi (Q3)', 'Internasional Bereputasi (Q4)',
        'Internasional',
        'Nasional Bereputasi (Sinta 1)', 'Nasional Bereputasi (Sinta 2)',
        'Nasional Bereputasi (Sinta 3)', 'Nasional Bereputasi (Sinta 4)',
        'Nasional Bereputasi (Sinta 5)', 'Nasional Bereputasi (Sinta 6)',
        'Nasional'
    ],
    'Prosiding': [
        'Internasional Scopus', 'Internasional', 'Nasional Garuda', 'Nasional'
    ]
};

/* === API Helper === */
async function api(method, path, body = null) {
    const opts = { method, headers: { 'X-Admin-Token': TOKEN, 'Content-Type': 'application/json', 'Accept': 'application/json' } };
    if (body) opts.body = JSON.stringify(body);
    const res = await fetch(API_URL + path, opts);
    return res.json();
}

/* === Login === */
document.getElementById('token-input').addEventListener('keydown', e => { if (e.key === 'Enter') doLogin(); });

async function doLogin() {
    const input = document.getElementById('token-input');
    const errEl = document.getElementById('login-error');
    TOKEN = input.value.trim().toUpperCase();
    API_URL = document.getElementById('server-url').value.trim().replace(/\/+$/, '');

    if (TOKEN.length !== 12) { errEl.textContent = 'Token harus 12 digit!'; errEl.style.display = 'block'; return; }
    try {
        const res = await api('POST', '/api/admin/verify');
        if (res.status === 'ok') {
            document.getElementById('login-screen').style.display = 'none';
            document.getElementById('main-app').style.display = 'flex';
            loadDashboard();
        } else { errEl.textContent = res.message || 'Token tidak valid!'; errEl.style.display = 'block'; }
    } catch (e) { errEl.textContent = 'Tidak bisa terhubung ke server!'; errEl.style.display = 'block'; }
}

function doLogout() { TOKEN = ''; document.getElementById('main-app').style.display = 'none'; document.getElementById('login-screen').style.display = 'flex'; document.getElementById('token-input').value = ''; }

/* === Dashboard === */
async function loadDashboard() {
    try {
        const stats = await api('GET', '/api/admin/stats');
        updateBadges(stats);
        loadReferences();
        const grid = document.getElementById('stats-grid');
        const items = [
            { key:'berita',      label:'Berita',     icon:'fa-newspaper', color:'#2c5282' },
            { key:'penelitian', label:'Penelitian', icon:'fa-flask', color:'#1a4d2e' },
            { key:'pengabdian', label:'Pengabdian', icon:'fa-hands-helping', color:'#2d6b42' },
            { key:'publikasi',  label:'Publikasi',  icon:'fa-file-alt', color:'#c4992a' },
            { key:'struktur_organisasi', label:'Struktur Organisasi', icon:'fa-sitemap', color:'#0d2b1a' },
            { key:'users',      label:'Users (Semua)',      icon:'fa-users', color:'#6b4c1a' },
            { key:'pending_dosen', label:'Pending Approval Dosen', icon:'fa-user-clock', color:'#d97706', value: stats.pending_counts?.users ?? 0 },
            { key:'data_publikasi', label:'Data Publikasi', icon:'fa-book', color:'#1a6b3a' },
            { key:'data_pelaksanaan', label:'Data Pelaksanaan', icon:'fa-tasks', color:'#4a6b1a' },
            { key:'ajuan_proposal', label:'Ajuan Proposal', icon:'fa-paper-plane', color:'#2d6b42' },
            { key:'ajuan_pkm', label:'Ajuan PKM', icon:'fa-hands-helping', color:'#1a4d2e' },
            { key:'ajuan_hki', label:'Ajuan HKI', icon:'fa-certificate', color:'#0d2b1a' },
            { key:'ajuan_jurnal',   label:'Ajuan Jurnal',   icon:'fa-journal-whills', color:'#c4992a' }
        ];
        grid.innerHTML = items.map(i => `
            <div class="stat-card" style="${i.key==='pending_dosen'&&i.value>0?'border-left:4px solid #e74c3c;background:#fffaf0;cursor:pointer;':''}" ${i.key==='pending_dosen'?'onclick="switchSection(\'pending_users\')"':''}>
                <div class="stat-icon" style="background:${i.color}"><i class="fas ${i.icon}"></i></div>
                <div class="stat-value">${i.value !== undefined ? i.value : (stats[i.key] ?? 0)}</div>
                <div class="stat-label">${i.label} ${i.key==='pending_dosen'&&i.value>0?'<span style="color:#e74c3c;font-weight:700;">(Perlu Ditinjau)</span>':''}</div>
            </div>`).join('');
        document.getElementById('connection-badge').innerHTML = '<i class="fas fa-circle"></i> Terhubung';
        document.getElementById('connection-badge').style.color = '#2d6b42';
    } catch(e) {
        document.getElementById('connection-badge').innerHTML = '<i class="fas fa-circle"></i> Terputus';
        document.getElementById('connection-badge').style.color = '#c0392b';
    }
}

let seenSectionCounts = JSON.parse(localStorage.getItem('admin_seen_counts') || '{}');
let lastStatsData = null;

function updateBadges(stats) {
    if (!stats || !stats.pending_counts) return;
    lastStatsData = stats;
    const p = stats.pending_counts;
    const map = {
        'badge-users': { key:'users', count: p.users },
        'badge-pending_users': { key:'pending_users', count: p.pending_users },
        'badge-research_submissions': { key:'research_submissions', count: p.research_submissions },
        'badge-pkm_submissions': { key:'pkm_submissions', count: p.pkm_submissions },
        'badge-hki_submissions': { key:'hki_submissions', count: p.hki_submissions },
        'badge-journal_submissions': { key:'journal_submissions', count: p.journal_submissions },
        'badge-pengajuan_proposal': { key:'pengajuan_proposal', count: p.pengajuan_proposal }
    };

    for (const [id, item] of Object.entries(map)) {
        const el = document.getElementById(id);
        if (el) {
            // Jika section saat ini sedang aktif dipilih, tandai sudah dilihat
            if (currentSection === item.key || (currentSection === 'pending_users' && item.key === 'users') || (currentSection === 'users' && item.key === 'pending_users')) {
                seenSectionCounts[item.key] = item.count;
                localStorage.setItem('admin_seen_counts', JSON.stringify(seenSectionCounts));
                el.style.display = 'none';
                continue;
            }

            const seen = seenSectionCounts[item.key] || 0;
            // Badge merah hanya muncul jika ada data pending DAN belum dilihat (atau ada penambahan baru)
            if (item.count > 0 && item.count > seen) {
                const unreadCount = item.count - seen;
                el.textContent = unreadCount > 0 ? unreadCount : item.count;
                el.style.display = 'inline-block';
            } else {
                el.style.display = 'none';
            }
        }
    }
}

async function refreshStatsBadges() {
    try {
        const stats = await api('GET', '/api/admin/stats');
        updateBadges(stats);
    } catch(e) {}
}

// Auto-refresh notifikasi titik merah setiap 15 detik
setInterval(refreshStatsBadges, 15000);

/* === Switch Section === */
function switchSection(section) {
    currentSection = section;
    document.querySelectorAll('.menu-btn').forEach(b => b.classList.toggle('active', b.dataset.section === section));
    const cfg = TABLE_CONFIG[section];
    const titleEl = document.getElementById('page-title');

    // Hilangkan titik/badge merah pada menu yang dipilih langsung
    const badgeEl = document.getElementById('badge-' + section);
    if (badgeEl) badgeEl.style.display = 'none';
    if (section === 'pending_users') {
        const bu = document.getElementById('badge-users');
        if (bu) bu.style.display = 'none';
        if (lastStatsData && lastStatsData.pending_counts) {
            seenSectionCounts['users'] = lastStatsData.pending_counts.users;
            seenSectionCounts['pending_users'] = lastStatsData.pending_counts.pending_users;
        }
    } else if (section === 'users') {
        const bpu = document.getElementById('badge-pending_users');
        if (bpu) bpu.style.display = 'none';
        if (lastStatsData && lastStatsData.pending_counts) {
            seenSectionCounts['users'] = lastStatsData.pending_counts.users;
            seenSectionCounts['pending_users'] = lastStatsData.pending_counts.pending_users;
        }
    } else if (lastStatsData && lastStatsData.pending_counts && lastStatsData.pending_counts[section] !== undefined) {
        seenSectionCounts[section] = lastStatsData.pending_counts[section];
    }
    localStorage.setItem('admin_seen_counts', JSON.stringify(seenSectionCounts));

    if (section === 'dashboard') {
        titleEl.innerHTML = '<i class="fas fa-th-large"></i> Dashboard';
        document.getElementById('section-dashboard').style.display = 'block';
        document.getElementById('section-table').style.display = 'none';
        loadDashboard();
    } else {
        titleEl.innerHTML = `<i class="fas ${cfg.icon}"></i> ${cfg.reviewOnly ? 'Tinjau' : 'Kelola'} ${cfg.label}`;
        document.getElementById('section-dashboard').style.display = 'none';
        document.getElementById('section-table').style.display = 'block';
        document.getElementById('search-input').value = '';
        // Hide Tambah button for review-only sections
        document.getElementById('btn-tambah').style.display = cfg.reviewOnly ? 'none' : '';
        loadTableData();
    }
}

/* === Load Table Data === */
async function loadTableData() {
    const search = document.getElementById('search-input').value;
    const cfg = TABLE_CONFIG[currentSection];
    const targetTable = cfg && cfg.table ? cfg.table : currentSection;
    let url = `/api/admin/list/${targetTable}?search=${encodeURIComponent(search)}`;
    if (cfg && cfg.filterParam) {
        url += `&${cfg.filterParam}`;
    }
    const data = await api('GET', url);
    currentData = data;
    renderTable();
    refreshStatsBadges();
}

function refreshData() { loadTableData(); }
function searchData() { clearTimeout(window._st); window._st = setTimeout(loadTableData, 300); }

let seenItemIds = JSON.parse(localStorage.getItem('admin_seen_item_ids') || '{}');

function isRowNew(row) {
    const cfg = TABLE_CONFIG[currentSection];
    const targetTable = cfg && cfg.table ? cfg.table : currentSection;
    const tableSeen = seenItemIds[targetTable] || [];
    
    // Jika ID data ini sudah pernah dibuka/dilihat oleh admin, tanda BARU hilang
    if (tableSeen.includes(row.id)) {
        return false;
    }

    // Hanya anggap baru jika berstatus pending / belum disetujui
    if (currentSection === 'pending_users' || currentSection === 'users') {
        if (row.role === 'dosen' && (row.is_approved == 0 || row.is_approved === '0' || row.is_approved === false || row.is_approved === null)) {
            return true;
        }
    }
    if (row.status === 'pending') {
        return true;
    }
    return false;
}

function markCurrentDataAsSeen() {
    const cfg = TABLE_CONFIG[currentSection];
    const targetTable = cfg && cfg.table ? cfg.table : currentSection;
    if (!seenItemIds[targetTable]) seenItemIds[targetTable] = [];
    currentData.forEach(row => {
        if (!seenItemIds[targetTable].includes(row.id)) {
            seenItemIds[targetTable].push(row.id);
        }
    });
    localStorage.setItem('admin_seen_item_ids', JSON.stringify(seenItemIds));
}

let referenceData = { users: [], fakultas: [], prodi: [], dosen: [], penelitian: [] };

async function loadReferences() {
    try {
        const res = await api('GET', '/api/admin/references');
        if (res && !res.error) {
            referenceData = res;
        }
    } catch(e) {}
}

function formatCellValue(k, val, row) {
    if (k === 'is_approved') {
        if (val == 1 || val === true || val === '1') {
            return '<span style="background:#d4edda;color:#155724;padding:3px 8px;border-radius:10px;font-size:11px;font-weight:600;"><i class="fas fa-check-circle"></i> Disetujui</span>';
        } else {
            return '<span style="background:#fee2e2;color:#991b1b;padding:3px 8px;border-radius:10px;font-size:11px;font-weight:600;display:inline-flex;align-items:center;gap:4px;"><i class="fas fa-clock"></i> Belum Disetujui</span>';
        }
    }
    if (k === 'status') {
        if (val === 'pending') {
            return '<span style="background:#fee2e2;color:#991b1b;padding:3px 8px;border-radius:10px;font-size:11px;font-weight:600;"><i class="fas fa-clock"></i> Pending</span>';
        } else if (val === 'approved' || val === 'published') {
            return '<span style="background:#d4edda;color:#155724;padding:3px 8px;border-radius:10px;font-size:11px;font-weight:600;"><i class="fas fa-check"></i> ' + (val === 'published' ? 'Published' : 'Disetujui') + '</span>';
        } else if (val === 'rejected') {
            return '<span style="background:#f8d7da;color:#721c24;padding:3px 8px;border-radius:10px;font-size:11px;font-weight:600;"><i class="fas fa-times"></i> Ditolak</span>';
        } else if (val === 'revision') {
            return '<span style="background:#cce5ff;color:#004085;padding:3px 8px;border-radius:10px;font-size:11px;font-weight:600;"><i class="fas fa-edit"></i> Revisi</span>';
        }
    }

    // Tampilkan label nama yang informatif untuk kolom Foreign Key ID
    if (k === 'user_id' && referenceData.users && val) {
        const u = referenceData.users.find(x => x.id == val);
        if (u) return `<span title="${u.email}">${u.name} (ID: ${val})</span>`;
    }
    if (k === 'dosen_id' && referenceData.dosen && val) {
        const d = referenceData.dosen.find(x => x.id == val);
        if (d) return `<span title="NIDN: ${d.nidn || '-'}">${d.nama_dosen || d.name} (ID: ${val})</span>`;
    }
    if (k === 'fakultas_id' && referenceData.fakultas && val) {
        const f = referenceData.fakultas.find(x => x.id == val);
        if (f) return `<span>${f.nama_fakultas} (ID: ${val})</span>`;
    }
    if ((k === 'id_prodi' || k === 'prodi_id') && referenceData.prodi && val) {
        const p = referenceData.prodi.find(x => x.id == val);
        if (p) return `<span>${p.nama_prodi} (ID: ${val})</span>`;
    }
    if (k === 'penelitian_id' && referenceData.penelitian && val) {
        const p = referenceData.penelitian.find(x => x.id == val);
        if (p) return `<span title="${p.judul}">${truncate(p.judul, 25)} (ID: ${val})</span>`;
    }

    // Beri penanda badge BARU jika baris data baru belum pernah dilihat
    if ((k === 'name' || k === 'title' || k === 'judul' || k === 'judul_hki') && isRowNew(row)) {
        return `<span style="background:#dc2626;color:#fff;font-size:10px;font-weight:700;padding:2px 6px;border-radius:4px;margin-right:6px;display:inline-flex;align-items:center;gap:3px;vertical-align:middle;box-shadow:0 1px 4px rgba(220,38,38,0.35);"><i class="fas fa-bolt" style="font-size:8px;"></i> BARU</span> ` + truncate(val, 50);
    }

    // Kolom file ditampilkan sebagai link / badge download yang rapi
    if (isFileField(k)) {
        if (!val) return '<span style="color:#bbb;">-</span>';
        const fileUrl = getFileUrl(k, val);
        return `<a href="${fileUrl}" target="_blank" style="display:inline-flex;align-items:center;gap:5px;background:#e8f4ec;color:#155724;padding:3px 8px;border-radius:6px;font-size:11px;font-weight:600;text-decoration:none;border:1px solid #c3e6cb;" title="${val}"><i class="fas fa-file-download"></i> ${truncate(val, 20)}</a>`;
    }

    return truncate(val, 60);
}

function renderTable() {
    if (!currentData.length) {
        document.getElementById('table-head').innerHTML = '';
        document.getElementById('table-body').innerHTML = '<tr><td colspan="20" style="text-align:center;padding:40px;color:#999">Tidak ada data</td></tr>';
        document.getElementById('data-count').textContent = '0 data';
        return;
    }
    const keys = Object.keys(currentData[0]).filter(k => k !== 'password' && k !== 'remember_token' && k !== 'email_verified_at');
    document.getElementById('table-head').innerHTML = '<tr>' + keys.map(k => `<th>${k}</th>`).join('') + '<th>Aksi</th></tr>';
    document.getElementById('table-body').innerHTML = currentData.map(row => {
        const isNew = isRowNew(row);
        const rowStyle = isNew ? 'background:rgba(254, 243, 199, 0.35);border-left:4px solid #dc2626;' : '';
        const cells = keys.map(k => `<td title="${(row[k]||'').toString().replace(/"/g,'&quot;')}">${formatCellValue(k, row[k], row)}</td>`).join('');
        const isPendingDosen = (currentSection === 'users' || currentSection === 'pending_users') && (row.is_approved == 0 || row.is_approved === '0' || row.is_approved === false || row.is_approved === null);
        const approveBtn = isPendingDosen
            ? `<button class="btn btn-green btn-sm" title="Setujui Akun Dosen" style="background:#2d6b42;color:#fff;margin-right:4px;padding:4px 8px;font-size:12px;border-radius:4px;border:none;cursor:pointer;font-weight:600;" onclick="approveUser(${row.id})"><i class="fas fa-check"></i> Setujui</button>`
            : '';
        return `<tr style="${rowStyle}">${cells}<td>${approveBtn}<button class="btn btn-gold btn-sm" onclick="openEditModal(${row.id})"><i class="fas fa-edit"></i></button> <button class="btn btn-red btn-sm" onclick="deleteRow(${row.id})"><i class="fas fa-trash"></i></button></td></tr>`;
    }).join('');
    document.getElementById('data-count').textContent = `${currentData.length} data`;

    // Tandai data saat ini sudah dilihat sehingga tanda BARU tidak muncul lagi pada kunjungan berikutnya
    markCurrentDataAsSeen();
}

async function approveUser(id) {
    if (!confirm('Setujui akun Dosen ini agar dapat login dan mengakses sistem LPPM?')) return;
    try {
        const cfg = TABLE_CONFIG[currentSection];
        const targetTable = cfg && cfg.table ? cfg.table : currentSection;
        const res = await api('PUT', `/api/admin/update/${targetTable}/${id}`, { is_approved: 1 });
        if (res.status === 'ok') {
            loadTableData();
            refreshStatsBadges();
        } else {
            alert('Gagal menyetujui akun: ' + (res.error || 'Terjadi kesalahan'));
        }
    } catch(e) {
        alert('Terjadi kesalahan koneksi.');
    }
}

function truncate(str, n) { if (!str) return ''; str = str.toString(); return str.length > n ? str.slice(0, n) + '...' : str; }

/* === Modal === */
function getFieldLabel(f) {
    const labels = {
        'nim_nip':'NIM / NIP', 'admin_notes':'Catatan Admin', 'photo':'Foto',
        'photo_position':'Posisi Foto', 'sort_order':'Urutan', 'position':'Jabatan',
        'name':'Nama', 'judul':'Judul', 'abstrak':'Abstrak', 'jenis_publikasi':'Jenis Publikasi',
        'kategori_reputasi':'Kategori Reputasi', 'url_jurnal':'URL Jurnal/Prosiding',
        'url_repository':'URL Repository', 'jenis_kegiatan':'Jenis Kegiatan',
        'deskripsi_singkat':'Deskripsi Singkat', 'sumber_dana':'Sumber Dana',
        'url':'URL Laporan/Bukti', 'user_id':'User / Pemilik Akun', 'rejection_reason':'Alasan Penolakan',
        'author':'Penulis', 'date':'Tanggal', 'title':'Judul', 'body':'Isi Berita / Konten', 'thumbnail':'Gambar (nama file)',
        'username':'Username', 'fakultas':'Fakultas', 'jabatan_fungsional':'Jabatan Fungsional',
        'is_approved':'Status Persetujuan (Approval)', 'approval_notes':'Catatan Persetujuan',
        // Berita fields
        'konten':'Isi Berita', 'ringkasan':'Ringkasan', 'kategori':'Kategori', 'status':'Status',
        'tanggal':'Tanggal', 'penulis':'Penulis/Sumber', 'gambar':'Gambar (nama file)',
        // ERD fields
        'nama_fakultas':'Nama Fakultas', 'nama_dekan':'Nama Dekan', 'nama_dosen':'Nama Dosen',
        'no_hp':'No. HP', 'nama_prodi':'Nama Program Studi', 'nama_koordinator':'Nama Koordinator',
        'fakultas_id':'Pilih Fakultas', 'email':'Email', 'id_prodi':'Pilih Program Studi',
        'nidn':'NIDN', 'nupk':'NUPK', 'pangkat_jabatan':'Pangkat/Jabatan',
        'dosen_luaran':'Luaran Dosen', 'sk_dosen':'SK Dosen',
        'dosen_id':'Pilih Dosen', 'universitas_id':'ID Universitas', 'klasifikasi':'Klasifikasi Dana',
        'tahun':'Tahun', 'dana':'Dana (Rp)', 'jumlah_dana':'Jumlah Dana (Rp)',
        'status_proposal':'Status Proposal', 'status_verifikasi':'Status Verifikasi',
        'penelitian_id':'Pilih Penelitian Formal', 'catatan_pengajuan':'Catatan Pengajuan',
        'tanggal_ajuan':'Tanggal Ajuan',
        'catatan_verifikasi':'Catatan Verifikasi', 'tanggal_verifikasi':'Tanggal Verifikasi',
        'jenis_hki':'Jenis HKI', 'judul_hki':'Judul HKI', 'nomor_pendaftaran':'Nomor Pendaftaran',
        'file_sertifikat':'File Sertifikat', 'tanggal_sidang':'Tanggal Sidang',
        'berita_acara_file':'File Berita Acara', 'hasil_sidang':'Hasil Sidang',
        'kategori_jurnal':'Kategori Jurnal', 'nama_jurnal':'Nama Jurnal', 'file_bukti':'File Bukti'
    };
    return labels[f] || f.charAt(0).toUpperCase() + f.slice(1);
}

function isFileField(f) {
    return [
        'photo', 'thumbnail', 'gambar', 'file', 
        'file_sertifikat', 'file_bukti', 'berita_acara_file', 
        'sk_dosen', 'dosen_luaran'
    ].includes(f) || f.endsWith('_file') || f.startsWith('file_');
}

function getFileUrl(f, filename) {
    if (!filename) return '#';
    if (f === 'photo') return `${API_URL}/img/organisasi/${filename}`;
    if (f === 'thumbnail') {
        const p = currentSection === 'community_services' ? 'pengabdian' : 'penelitian';
        return `${API_URL}/img/${p}/${filename}`;
    }
    if (f === 'gambar') return `${API_URL}/img/berita/${filename}`;
    if (f === 'file') return `${API_URL}/download/publikasi/${filename}`;
    if (f === 'file_sertifikat') return `${API_URL}/uploads/hki/${filename}`;
    if (f === 'file_bukti') return `${API_URL}/uploads/laporan_jurnal/${filename}`;
    if (f === 'berita_acara_file') return `${API_URL}/uploads/laporan_sidang/${filename}`;
    if (f === 'sk_dosen' || f === 'dosen_luaran') return `${API_URL}/uploads/dosen/${filename}`;
    return `${API_URL}/uploads/documents/${filename}`;
}

function renderField(f, value) {
    const selStyle = 'width:100%;padding:9px 12px;border:1px solid #ddd;border-radius:6px;font-size:13px';
    const val = value !== undefined && value !== null ? value : '';
    const valAttr = val.toString().replace(/"/g, '&quot;');

    // Foreign Key / ID Select Dropdowns
    if (f === 'dosen_id') {
        const options = (referenceData.dosen || []).map(d => 
            `<option value="${d.id}" ${val == d.id ? 'selected' : ''}>ID: ${d.id} - ${d.nama_dosen || d.name} (NIDN: ${d.nidn || '-'})</option>`
        ).join('');
        return `<select id="field-${f}" style="${selStyle}"><option value="">-- Pilih Dosen --</option>${options}</select>`;
    }
    if (f === 'fakultas_id') {
        const options = (referenceData.fakultas || []).map(fak => 
            `<option value="${fak.id}" ${val == fak.id ? 'selected' : ''}>ID: ${fak.id} - ${fak.nama_fakultas}</option>`
        ).join('');
        return `<select id="field-${f}" style="${selStyle}"><option value="">-- Pilih Fakultas --</option>${options}</select>`;
    }
    if (f === 'id_prodi' || f === 'prodi_id') {
        const options = (referenceData.prodi || []).map(p => 
            `<option value="${p.id}" ${val == p.id ? 'selected' : ''}>ID: ${p.id} - ${p.nama_prodi}</option>`
        ).join('');
        return `<select id="field-${f}" style="${selStyle}"><option value="">-- Pilih Program Studi --</option>${options}</select>`;
    }
    if (f === 'penelitian_id') {
        const options = (referenceData.penelitian || []).map(pen => 
            `<option value="${pen.id}" ${val == pen.id ? 'selected' : ''}>ID: ${pen.id} - ${pen.judul} (${pen.tahun || '-'})</option>`
        ).join('');
        return `<select id="field-${f}" style="${selStyle}"><option value="">-- Pilih Penelitian Formal --</option>${options}</select>`;
    }
    if (f === 'user_id') {
        const options = (referenceData.users || []).map(u => 
            `<option value="${u.id}" ${val == u.id ? 'selected' : ''}>ID: ${u.id} - ${u.name} [${(u.role || 'user').toUpperCase()}] (${u.email})</option>`
        ).join('');
        return `<select id="field-${f}" style="${selStyle}"><option value="">-- Pilih User / Pengguna --</option>${options}</select>`;
    }

    // Enum / Predefined Choice Dropdowns
    if (f === 'klasifikasi') {
        const opts = ['Dasar', 'Terapan', 'Pengembangan', 'Mandiri', 'Hibah Dikti', 'Hibah Internal', 'Kerjasama Mitra'];
        return `<select id="field-${f}" style="${selStyle}"><option value="">-- Pilih Klasifikasi Dana --</option>${opts.map(o => `<option value="${o}" ${val===o?'selected':''}>${o}</option>`).join('')}</select>`;
    }
    if (f === 'status_proposal') {
        const opts = [
            { v:'diajukan', l:'Diajukan' },
            { v:'diterima', l:'Diterima / Disetujui' },
            { v:'ditolak', l:'Ditolak' },
            { v:'revisi', l:'Revisi' }
        ];
        return `<select id="field-${f}" style="${selStyle}"><option value="">-- Pilih Status Proposal --</option>${opts.map(o => `<option value="${o.v}" ${val===o.v?'selected':''}>${o.l}</option>`).join('')}</select>`;
    }
    if (f === 'status_verifikasi') {
        const opts = [
            { v:'belum', l:'Belum Diverifikasi' },
            { v:'diverifikasi', l:'Sudah Diverifikasi' },
            { v:'ditolak', l:'Ditolak' }
        ];
        return `<select id="field-${f}" style="${selStyle}"><option value="">-- Pilih Status Verifikasi --</option>${opts.map(o => `<option value="${o.v}" ${val===o.v||(!val&&o.v==='belum')?'selected':''}>${o.l}</option>`).join('')}</select>`;
    }
    if (f === 'jenis_hki') {
        const opts = ['Hak Cipta', 'Paten', 'Paten Sederhana', 'Merek', 'Desain Industri', 'Rahasia Dagang'];
        return `<select id="field-${f}" style="${selStyle}"><option value="">-- Pilih Jenis HKI --</option>${opts.map(o => `<option value="${o}" ${val===o?'selected':''}>${o}</option>`).join('')}</select>`;
    }
    if (f === 'kategori_jurnal') {
        const opts = ['SINTA 1', 'SINTA 2', 'SINTA 3', 'SINTA 4', 'SINTA 5', 'SINTA 6', 'Scopus Q1', 'Scopus Q2', 'Scopus Q3', 'Scopus Q4', 'Internasional', 'Nasional'];
        return `<select id="field-${f}" style="${selStyle}"><option value="">-- Pilih Kategori Jurnal --</option>${opts.map(o => `<option value="${o}" ${val===o?'selected':''}>${o}</option>`).join('')}</select>`;
    }
    if (f === 'hasil_sidang') {
        const opts = ['Lulus', 'Lulus Bersyarat (Revisi)', 'Tidak Lulus'];
        return `<select id="field-${f}" style="${selStyle}"><option value="">-- Pilih Hasil Sidang --</option>${opts.map(o => `<option value="${o}" ${val===o?'selected':''}>${o}</option>`).join('')}</select>`;
    }

    if (f === 'body' || f === 'abstract' || f === 'admin_notes' || f === 'abstrak' || f === 'deskripsi_singkat' || f === 'rejection_reason' || f === 'konten' || f === 'ringkasan')
        return `<textarea id="field-${f}">${val}</textarea>`;
    if (f === 'photo')
        return `${val ? `<div style="margin-bottom:8px"><img src="${API_URL}/img/organisasi/${val}" style="width:80px;height:100px;border-radius:12px;object-fit:cover;border:3px solid #c4992a"><small style="margin-left:8px;color:#888">${val}</small></div>` : ''}<input type="file" id="field-${f}" accept="image/*" style="width:100%;padding:8px;border:2px dashed #c4992a;border-radius:6px;background:rgba(196,153,42,.05);cursor:pointer">${val ? '<small style="color:#888;font-size:11px">Kosongkan jika tidak ingin mengganti foto</small>' : ''}`;
    if (f === 'thumbnail') {
        const p = currentSection === 'community_services' ? 'pengabdian' : 'penelitian';
        return `${val ? `<div style="margin-bottom:8px"><img src="${API_URL}/img/${p}/${val}" style="width:150px;height:auto;border-radius:6px;border:1px solid #ccc"><small style="margin-left:8px;color:#888">${val}</small></div>` : ''}<input type="file" id="field-${f}" accept="image/*" style="width:100%;padding:8px;border:2px dashed #c4992a;border-radius:6px;background:rgba(196,153,42,.05);cursor:pointer">${val ? '<small style="color:#888;font-size:11px">Kosongkan jika tidak ingin mengganti thumbnail</small>' : ''}`;
    }
    if (f === 'gambar') {
        return `${val ? `<div style="margin-bottom:8px"><img src="${API_URL}/img/berita/${val}" style="width:150px;height:auto;border-radius:6px;border:1px solid #ccc"><small style="margin-left:8px;color:#888">${val}</small></div>` : ''}<input type="file" id="field-${f}" accept="image/*" style="width:100%;padding:8px;border:2px dashed #c4992a;border-radius:6px;background:rgba(196,153,42,.05);cursor:pointer">${val ? '<small style="color:#888;font-size:11px">Kosongkan jika tidak ingin mengganti gambar</small>' : ''}`;
    }
    if (isFileField(f)) {
        const fileUrl = getFileUrl(f, val);
        return `${val ? `<div style="margin-bottom:8px"><a href="${fileUrl}" target="_blank" class="badge btn-success" style="padding:5px 10px;border-radius:4px;background:#2d6b42;color:#fff;text-decoration:none;display:inline-flex;align-items:center;gap:6px;font-size:12px;"><i class="fas fa-download"></i> Buka / Download File</a><small style="margin-left:8px;color:#888">${val}</small></div>` : ''}<input type="file" id="field-${f}" accept=".pdf,.doc,.docx,.zip,.rar,.jpg,.jpeg,.png" style="width:100%;padding:10px;border:2px dashed #c4992a;border-radius:6px;background:rgba(196,153,42,.05);cursor:pointer">${val ? '<small style="color:#888;font-size:11px">Kosongkan jika tidak ingin mengganti file</small>' : '<small style="color:#888;font-size:11px">Format: PDF, DOC, DOCX, ZIP, JPG, PNG (Maks: 10MB)</small>'}`;
    }
    if (f === 'photo_position')
        return `<select id="field-${f}" style="${selStyle}"><option value="top" ${val==='top'?'selected':''}>Atas (Wajah)</option><option value="center" ${(!val||val==='center')?'selected':''}>Tengah</option><option value="bottom" ${val==='bottom'?'selected':''}>Bawah</option><option value="20% 20%" ${val==='20% 20%'?'selected':''}>Kiri Atas</option><option value="80% 20%" ${val==='80% 20%'?'selected':''}>Kanan Atas</option></select>`;
    if (f === 'role')
        return `<select id="field-${f}" style="${selStyle}"><option value="mahasiswa" ${val==='mahasiswa'?'selected':''}>Mahasiswa</option><option value="dosen" ${val==='dosen'?'selected':''}>Dosen</option></select>`;
    if (f === 'is_approved')
        return `<select id="field-${f}" style="${selStyle}"><option value="1" ${val==1||val==='1'||val===true?'selected':''}>1 - Disetujui (Approved / Aktif)</option><option value="0" ${val==0||val==='0'||val===false||val===''?'selected':''}>0 - Menunggu Persetujuan (Pending)</option></select>`;
    if (f === 'approval_notes')
        return `<input type="text" id="field-${f}" value="${valAttr}" placeholder="Catatan approval (opsional)" style="${selStyle}">`;
    if (f === 'status') {
        if (currentSection === 'berita' || currentSection === 'researches' || currentSection === 'community_services') {
            return `<select id="field-${f}" style="${selStyle}"><option value="published" ${(!val || val==='published')?'selected':''}>Published</option><option value="draft" ${val==='draft'?'selected':''}>Draft</option></select>`;
        }
        return `<select id="field-${f}" style="${selStyle}"><option value="pending" ${val==='pending'?'selected':''}>Pending</option><option value="approved" ${val==='approved'?'selected':''}>Approved</option><option value="rejected" ${val==='rejected'?'selected':''}>Rejected</option><option value="revision" ${val==='revision'?'selected':''}>Revision</option></select>`;
    }
    if (f === 'jenis_publikasi')
        return `<select id="field-${f}" style="${selStyle}" onchange="updateKategoriDropdown()"><option value="">-- Pilih --</option><option value="Jurnal" ${val==='Jurnal'?'selected':''}>Jurnal</option><option value="Prosiding" ${val==='Prosiding'?'selected':''}>Prosiding</option></select>`;
    if (f === 'kategori_reputasi')
        return `<select id="field-${f}" style="${selStyle}"><option value="">-- Pilih Jenis Publikasi Dulu --</option></select>`;
    if (f === 'jenis_kegiatan')
        return `<select id="field-${f}" style="${selStyle}"><option value="">-- Pilih --</option><option value="Penelitian" ${val==='Penelitian'?'selected':''}>Penelitian</option><option value="Pengabdian" ${val==='Pengabdian'?'selected':''}>Pengabdian</option></select>`;
    if (f === 'sumber_dana')
        return `<select id="field-${f}" style="${selStyle}"><option value="">-- Pilih --</option><option value="Internasional" ${val==='Internasional'?'selected':''}>Internasional</option><option value="Nasional (Dikti/Saintek)" ${val==='Nasional (Dikti/Saintek)'?'selected':''}>Nasional (Dikti/Saintek)</option><option value="Nasional (Kemenag)" ${val==='Nasional (Kemenag)'?'selected':''}>Nasional (Kemenag)</option><option value="Internal" ${val==='Internal'?'selected':''}>Internal</option><option value="Mitra" ${val==='Mitra'?'selected':''}>Mitra</option></select>`;
    if (f === 'date' || f === 'tanggal' || f === 'tanggal_ajuan' || f === 'tanggal_verifikasi' || f === 'tanggal_sidang')
        return `<input type="date" id="field-${f}" value="${valAttr}" style="${selStyle}">`;
    // Placeholder untuk field khusus
    const placeholders = {
        'nim_nip': 'Contoh: 2322105018',
        'sort_order': 'Angka urutan (1,2,3,...)',
        'nidn': 'Contoh: 0012345678',
        'nupk': 'Nomor Urut Pendidik Berkala',
        'tahun': 'Tahun pelaksanaan (Contoh: 2026)',
        'dana': 'Nominal dana penelitian (Contoh: 15000000)',
        'jumlah_dana': 'Total jumlah dana',
        'username': 'Username unik (opsional)',
        'fakultas': 'Contoh: FTI, FEB, dll',
        'jabatan_fungsional': 'Contoh: Asisten Ahli, Lektor, Guru Besar',
    };
    return `<input type="${f==='password'?'password':'text'}" id="field-${f}" value="${f==='password'?'':valAttr}" placeholder="${placeholders[f]||''}">`;
}

function updateKategoriDropdown(selectedValue) {
    const jenisEl = document.getElementById('field-jenis_publikasi');
    const katEl = document.getElementById('field-kategori_reputasi');
    if (!jenisEl || !katEl) return;
    const jenis = jenisEl.value;
    katEl.innerHTML = '';
    if (!jenis || !KATEGORI_OPTIONS[jenis]) {
        katEl.innerHTML = '<option value="">-- Pilih Jenis Publikasi Dulu --</option>';
        return;
    }
    katEl.innerHTML = '<option value="">-- Pilih Kategori --</option>' +
        KATEGORI_OPTIONS[jenis].map(k => `<option value="${k}" ${k===selectedValue?'selected':''}>${k}</option>`).join('');
}

async function openAddModal() {
    editingId = null;
    await loadReferences();
    const cfg = TABLE_CONFIG[currentSection];
    document.getElementById('modal-title').textContent = `Tambah ${cfg.label}`;
    document.getElementById('modal-body').innerHTML = cfg.fields.map(f => `
        <div class="form-group">
            <label>${getFieldLabel(f)}</label>
            ${renderField(f, '')}
        </div>`).join('');
    document.getElementById('modal-overlay').style.display = 'flex';
    if (currentSection === 'publikasis') setTimeout(() => updateKategoriDropdown(), 50);
}

async function openEditModal(id) {
    editingId = id;
    await loadReferences();
    const cfg = TABLE_CONFIG[currentSection];
    const data = await api('GET', `/api/admin/show/${currentSection}/${id}`);
    document.getElementById('modal-title').textContent = cfg.reviewOnly ? `Tinjau ${cfg.label}` : `Edit ${cfg.label}`;

    let html = '';
    // For review-only sections, show submission info as read-only first
    if (cfg.reviewOnly) {
        let infoFields = [];
        if (currentSection === 'research_submissions') {
            infoFields = ['title','research_type','abstract','team_members','file'];
        } else if (currentSection === 'pkm_submissions') {
            infoFields = ['judul','sumber_dana','abstrak','team_members','file'];
        } else if (currentSection === 'hki_submissions') {
            infoFields = ['judul','jenis_hki','abstrak','team_members','file'];
        } else {
            infoFields = ['title','journal_name','abstract','authors','file'];
        }
        
        html += '<div style="background:#f8f9fa;border-radius:8px;padding:14px;margin-bottom:16px;border-left:4px solid #1a4d2e">';
        html += '<strong style="color:#1a4d2e;font-size:12px;text-transform:uppercase">Detail Ajuan</strong>';
        infoFields.forEach(f => {
            if (data[f] === undefined && f === 'file') return; // Skip if file field doesn't exist
            
            let label = f.charAt(0).toUpperCase() + f.slice(1);
            if (f === 'research_type') label = 'Jenis';
            if (f === 'team_members') label = 'Anggota Tim';
            if (f === 'journal_name') label = 'Jurnal Tujuan';
            if (f === 'authors') label = 'Penulis';
            if (f === 'judul') label = 'Judul';
            if (f === 'sumber_dana') label = 'Sumber Dana';
            if (f === 'jenis_hki') label = 'Jenis HKI';
            if (f === 'abstrak') label = 'Abstrak';
            if (f === 'file') label = 'File Lampiran';
            
            let valRender = data[f] || '-';
            
            if (f === 'file' && data[f]) {
                let downloadUrl = API_URL + '/uploads/journals/' + data[f];
                if (currentSection === 'research_submissions') downloadUrl = API_URL + '/uploads/research/' + data[f];
                valRender = `<a href="${downloadUrl}" target="_blank" class="badge btn-gold" style="padding:4px 8px;border-radius:4px;text-decoration:none;color:#fff;background:#c4992a;display:inline-block;margin-top:4px;"><i class="fas fa-file-download"></i> Buka / Download File</a>`;
            }

            html += `<div style="margin-top:8px"><small style="color:#888">${label}</small><div style="font-size:13px;color:#333">${valRender}</div></div>`;
        });
        html += '</div><hr style="border-color:#eee">';
    }

    html += cfg.fields.map(f => `
        <div class="form-group">
            <label>${getFieldLabel(f)}</label>
            ${renderField(f, data[f])}
        </div>`).join('');

    document.getElementById('modal-body').innerHTML = html;
    document.getElementById('modal-save').textContent = cfg.reviewOnly ? ' Simpan Keputusan' : ' Simpan';
    document.getElementById('modal-overlay').style.display = 'flex';

    // Populate dynamic dropdown for publikasis edit
    if (currentSection === 'publikasis') {
        setTimeout(() => updateKategoriDropdown(data.kategori_reputasi), 50);
    }
}

function closeModal() { document.getElementById('modal-overlay').style.display = 'none'; }

async function saveData() {
    const cfg = TABLE_CONFIG[currentSection];
    
    // Check all fields that are file inputs
    for (let fName of cfg.fields) {
        if (!isFileField(fName)) continue;
        const fileField = document.getElementById(`field-${fName}`);
        if (fileField && fileField.type === 'file' && fileField.files.length > 0) {
            const formData = new FormData();
            formData.append('file', fileField.files[0]);
            
            let uploadUrl = API_URL + '/api/admin/upload-file';
            if (fName === 'photo') {
                formData.delete('file');
                formData.append('photo', fileField.files[0]);
                uploadUrl = API_URL + '/api/admin/upload-photo';
            } else {
                formData.append('type', fName);
            }

            try {
                const uploadRes = await fetch(uploadUrl, {
                    method: 'POST',
                    headers: { 'X-Admin-Token': TOKEN },
                    body: formData
                });
                const uploadData = await uploadRes.json();
                if (uploadData.filename) {
                    fileField.dataset.uploadedFile = uploadData.filename;
                } else {
                    alert(`Gagal upload ${getFieldLabel(fName)}: ` + (uploadData.error || 'Unknown'));
                    return;
                }
            } catch(e) { 
                alert(`Gagal upload ${getFieldLabel(fName)}`); 
                return; 
            }
        }
    }
    
    const body = {};
    cfg.fields.forEach(f => {
        const el = document.getElementById('field-'+f);
        if (!el) return;
        if (isFileField(f)) {
            // Use uploaded filename if a new file was chosen
            if (el.dataset && el.dataset.uploadedFile) {
                body[f] = el.dataset.uploadedFile;
            }
        } else if (el.value !== undefined) {
            body[f] = el.value;
        }
    });

    let res;
    if (editingId) {
        res = await api('PUT', `/api/admin/update/${currentSection}/${editingId}`, body);
    } else {
        res = await api('POST', `/api/admin/store/${currentSection}`, body);
    }
    if (res.status === 'ok') { 
        closeModal(); 
        loadTableData(); 
        if(currentSection==='dashboard') loadDashboard(); 
    } else {
        alert(res.error || 'Terjadi kesalahan');
    }
}

async function deleteRow(id) {
    if (!confirm('Yakin ingin menghapus data ini?')) return;
    const res = await api('DELETE', `/api/admin/delete/${currentSection}/${id}`);
    if (res.status === 'ok') loadTableData();
    else alert(res.error || 'Gagal menghapus');
}
