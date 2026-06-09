/* === App State === */
let API_URL = 'http://127.0.0.1:8000';
let TOKEN = '';
let currentSection = 'dashboard';
let currentData = [];
let editingId = null;

const TABLE_CONFIG = {
    researches:            { label:'Penelitian', icon:'fa-flask',         fields:['title','body','thumbnail'], colors:'#1a4d2e' },
    community_services:    { label:'Pengabdian', icon:'fa-hands-helping', fields:['title','body','thumbnail'], colors:'#2d6b42' },
    publications:          { label:'Publikasi',  icon:'fa-file-alt',      fields:['title','body','file'],      colors:'#c4992a' },
    organization_members:  { label:'Struktur Organisasi', icon:'fa-sitemap', fields:['position','name','photo','photo_position','sort_order'], colors:'#0d2b1a' },
    users:                 { label:'Users',      icon:'fa-users',         fields:['name','email','password','role','nim_nip'],  colors:'#6b4c1a' },
    publikasis:            { label:'Data Publikasi', icon:'fa-book',      fields:['user_id','judul','abstrak','jenis_publikasi','kategori_reputasi','url_jurnal','url_repository'], colors:'#1a6b3a' },
    pelaksanaans:          { label:'Data Pelaksanaan', icon:'fa-tasks',   fields:['user_id','judul','deskripsi_singkat','jenis_kegiatan','sumber_dana','url'], colors:'#4a6b1a' },
    research_submissions:  { label:'Ajuan Proposal', icon:'fa-paper-plane', fields:['status','admin_notes'], colors:'#2d6b42', reviewOnly:true },
    journal_submissions:   { label:'Ajuan Jurnal',   icon:'fa-journal-whills', fields:['status','admin_notes'], colors:'#c4992a', reviewOnly:true }
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
        const grid = document.getElementById('stats-grid');
        const items = [
            { key:'penelitian', label:'Penelitian', icon:'fa-flask', color:'#1a4d2e' },
            { key:'pengabdian', label:'Pengabdian', icon:'fa-hands-helping', color:'#2d6b42' },
            { key:'publikasi',  label:'Publikasi',  icon:'fa-file-alt', color:'#c4992a' },
            { key:'struktur_organisasi', label:'Struktur Organisasi', icon:'fa-sitemap', color:'#0d2b1a' },
            { key:'users',      label:'Users',      icon:'fa-users', color:'#6b4c1a' },
            { key:'data_publikasi', label:'Data Publikasi', icon:'fa-book', color:'#1a6b3a' },
            { key:'data_pelaksanaan', label:'Data Pelaksanaan', icon:'fa-tasks', color:'#4a6b1a' },
            { key:'ajuan_proposal', label:'Ajuan Proposal', icon:'fa-paper-plane', color:'#2d6b42' },
            { key:'ajuan_jurnal',   label:'Ajuan Jurnal',   icon:'fa-journal-whills', color:'#c4992a' }
        ];
        grid.innerHTML = items.map(i => `
            <div class="stat-card">
                <div class="stat-icon" style="background:${i.color}"><i class="fas ${i.icon}"></i></div>
                <div class="stat-value">${stats[i.key] ?? 0}</div>
                <div class="stat-label">${i.label}</div>
            </div>`).join('');
        document.getElementById('connection-badge').innerHTML = '<i class="fas fa-circle"></i> Terhubung';
        document.getElementById('connection-badge').style.color = '#2d6b42';
    } catch(e) {
        document.getElementById('connection-badge').innerHTML = '<i class="fas fa-circle"></i> Terputus';
        document.getElementById('connection-badge').style.color = '#c0392b';
    }
}

/* === Switch Section === */
function switchSection(section) {
    currentSection = section;
    document.querySelectorAll('.menu-btn').forEach(b => b.classList.toggle('active', b.dataset.section === section));
    const cfg = TABLE_CONFIG[section];
    const titleEl = document.getElementById('page-title');

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
    const data = await api('GET', `/api/admin/list/${currentSection}?search=${encodeURIComponent(search)}`);
    currentData = data;
    renderTable();
}

function refreshData() { loadTableData(); }
function searchData() { clearTimeout(window._st); window._st = setTimeout(loadTableData, 300); }

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
        const cells = keys.map(k => `<td title="${(row[k]||'').toString().replace(/"/g,'&quot;')}">${truncate(row[k],60)}</td>`).join('');
        return `<tr>${cells}<td><button class="btn btn-gold btn-sm" onclick="openEditModal(${row.id})"><i class="fas fa-edit"></i></button> <button class="btn btn-red btn-sm" onclick="deleteRow(${row.id})"><i class="fas fa-trash"></i></button></td></tr>`;
    }).join('');
    document.getElementById('data-count').textContent = `${currentData.length} data`;
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
        'url':'URL Laporan/Bukti', 'user_id':'User ID'
    };
    return labels[f] || f.charAt(0).toUpperCase() + f.slice(1);
}

function renderField(f, value) {
    const selStyle = 'width:100%;padding:9px 12px;border:1px solid #ddd;border-radius:6px;font-size:13px';
    const val = value || '';
    const valAttr = val.toString().replace(/"/g, '&quot;');

    if (f === 'body' || f === 'abstract' || f === 'admin_notes' || f === 'abstrak' || f === 'deskripsi_singkat')
        return `<textarea id="field-${f}">${val}</textarea>`;
    if (f === 'photo')
        return `${val ? `<div style="margin-bottom:8px"><img src="${API_URL}/img/organisasi/${val}" style="width:80px;height:100px;border-radius:12px;object-fit:cover;border:3px solid #c4992a"><small style="margin-left:8px;color:#888">${val}</small></div>` : ''}<input type="file" id="field-${f}" accept="image/*" style="width:100%;padding:8px;border:2px dashed #c4992a;border-radius:6px;background:rgba(196,153,42,.05);cursor:pointer">${val ? '<small style="color:#888;font-size:11px">Kosongkan jika tidak ingin mengganti foto</small>' : ''}`;
    if (f === 'photo_position')
        return `<select id="field-${f}" style="${selStyle}"><option value="top" ${val==='top'?'selected':''}>Atas (Wajah)</option><option value="center" ${(!val||val==='center')?'selected':''}>Tengah</option><option value="bottom" ${val==='bottom'?'selected':''}>Bawah</option><option value="20% 20%" ${val==='20% 20%'?'selected':''}>Kiri Atas</option><option value="80% 20%" ${val==='80% 20%'?'selected':''}>Kanan Atas</option></select>`;
    if (f === 'role')
        return `<select id="field-${f}" style="${selStyle}"><option value="mahasiswa" ${val==='mahasiswa'?'selected':''}>Mahasiswa</option><option value="dosen" ${val==='dosen'?'selected':''}>Dosen</option></select>`;
    if (f === 'status')
        return `<select id="field-${f}" style="${selStyle}"><option value="pending" ${val==='pending'?'selected':''}>Pending</option><option value="approved" ${val==='approved'?'selected':''}>Approved</option><option value="rejected" ${val==='rejected'?'selected':''}>Rejected</option><option value="revision" ${val==='revision'?'selected':''}>Revision</option></select>`;
    if (f === 'jenis_publikasi')
        return `<select id="field-${f}" style="${selStyle}" onchange="updateKategoriDropdown()"><option value="">-- Pilih --</option><option value="Jurnal" ${val==='Jurnal'?'selected':''}>Jurnal</option><option value="Prosiding" ${val==='Prosiding'?'selected':''}>Prosiding</option></select>`;
    if (f === 'kategori_reputasi')
        return `<select id="field-${f}" style="${selStyle}"><option value="">-- Pilih Jenis Publikasi Dulu --</option></select>`;
    if (f === 'jenis_kegiatan')
        return `<select id="field-${f}" style="${selStyle}"><option value="">-- Pilih --</option><option value="Penelitian" ${val==='Penelitian'?'selected':''}>Penelitian</option><option value="Pengabdian" ${val==='Pengabdian'?'selected':''}>Pengabdian</option></select>`;
    if (f === 'sumber_dana')
        return `<select id="field-${f}" style="${selStyle}"><option value="">-- Pilih --</option><option value="Internasional" ${val==='Internasional'?'selected':''}>Internasional</option><option value="Nasional (Dikti/Saintek)" ${val==='Nasional (Dikti/Saintek)'?'selected':''}>Nasional (Dikti/Saintek)</option><option value="Nasional (Kemenag)" ${val==='Nasional (Kemenag)'?'selected':''}>Nasional (Kemenag)</option><option value="Internal" ${val==='Internal'?'selected':''}>Internal</option><option value="Mitra" ${val==='Mitra'?'selected':''}>Mitra</option></select>`;
    return `<input type="${f==='password'?'password':'text'}" id="field-${f}" value="${f==='password'?'':valAttr}" placeholder="${f==='nim_nip'?'Contoh: 2322105018':f==='sort_order'?'Angka urutan (1,2,3,...)':f==='user_id'?'ID user pemilik data':''}">`;
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

function openAddModal() {
    editingId = null;
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
    const cfg = TABLE_CONFIG[currentSection];
    const data = await api('GET', `/api/admin/show/${currentSection}/${id}`);
    document.getElementById('modal-title').textContent = cfg.reviewOnly ? `Tinjau ${cfg.label}` : `Edit ${cfg.label}`;

    let html = '';
    // For review-only sections, show submission info as read-only first
    if (cfg.reviewOnly) {
        const infoFields = currentSection === 'research_submissions'
            ? ['title','research_type','abstract','team_members']
            : ['title','journal_name','abstract','authors'];
        html += '<div style="background:#f8f9fa;border-radius:8px;padding:14px;margin-bottom:16px;border-left:4px solid #1a4d2e">';
        html += '<strong style="color:#1a4d2e;font-size:12px;text-transform:uppercase">Detail Ajuan</strong>';
        infoFields.forEach(f => {
            const label = f === 'research_type' ? 'Jenis' : f === 'team_members' ? 'Anggota Tim' : f === 'journal_name' ? 'Jurnal Tujuan' : f === 'authors' ? 'Penulis' : f.charAt(0).toUpperCase() + f.slice(1);
            html += `<div style="margin-top:8px"><small style="color:#888">${label}</small><div style="font-size:13px;color:#333">${data[f] || '-'}</div></div>`;
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
    
    // Check if there's a file upload field
    const photoField = document.getElementById('field-photo');
    const hasFileUpload = photoField && photoField.type === 'file' && photoField.files.length > 0;
    
    if (hasFileUpload) {
        // Upload photo first
        const formData = new FormData();
        formData.append('photo', photoField.files[0]);
        try {
            const uploadRes = await fetch(API_URL + '/api/admin/upload-photo', {
                method: 'POST',
                headers: { 'X-Admin-Token': TOKEN },
                body: formData
            });
            const uploadData = await uploadRes.json();
            if (uploadData.filename) {
                // Set a hidden value for photo field
                photoField.dataset.uploadedFile = uploadData.filename;
            } else {
                alert('Gagal upload foto: ' + (uploadData.error || 'Unknown'));
                return;
            }
        } catch(e) { alert('Gagal upload foto'); return; }
    }
    
    const body = {};
    cfg.fields.forEach(f => {
        const el = document.getElementById('field-'+f);
        if (!el) return;
        if (f === 'photo') {
            // Use uploaded filename if available
            if (el.dataset && el.dataset.uploadedFile) body[f] = el.dataset.uploadedFile;
        } else if (el.value) {
            body[f] = el.value;
        }
    });

    let res;
    if (editingId) {
        res = await api('PUT', `/api/admin/update/${currentSection}/${editingId}`, body);
    } else {
        res = await api('POST', `/api/admin/store/${currentSection}`, body);
    }
    if (res.status === 'ok') { closeModal(); loadTableData(); if(currentSection==='dashboard') loadDashboard(); }
    else alert(res.error || 'Terjadi kesalahan');
}

async function deleteRow(id) {
    if (!confirm('Yakin ingin menghapus data ini?')) return;
    const res = await api('DELETE', `/api/admin/delete/${currentSection}/${id}`);
    if (res.status === 'ok') loadTableData();
    else alert(res.error || 'Gagal menghapus');
}
