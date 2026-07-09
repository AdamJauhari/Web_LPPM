<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HkiSubmission extends Model
{
    protected $table = 'hki_submissions';

    protected $fillable = [
        'user_id', 'fakultas', 'judul', 'abstrak', 'jenis_hki',
        'tahun_pengajuan', 'tanggal_pengajuan', 'nomor_pendaftaran', 'team_members',
        'status', 'admin_notes', 'rejection_reason',
        'assigned_to', 'reviewed_by', 'reviewed_at',
    ];

    protected $casts = [
        'tanggal_pengajuan' => 'date',
        'reviewed_at'       => 'datetime',
    ];

    const JENIS_HKI = ['Paten', 'HAKI', 'Non-Scopus / Hak Cipta Lainnya'];

    const STATUS_LABELS = [
        'pending'      => ['label' => 'Menunggu',     'badge' => 'warning text-dark'],
        'assigned'     => ['label' => 'Ditugaskan',   'badge' => 'info'],
        'under_review' => ['label' => 'Dalam Review', 'badge' => 'primary'],
        'approved'     => ['label' => 'Disetujui',    'badge' => 'success'],
        'rejected'     => ['label' => 'Ditolak',      'badge' => 'danger'],
    ];

    public function user()     { return $this->belongsTo(User::class); }
    public function assignee() { return $this->belongsTo(User::class, 'assigned_to'); }
    public function reviewer() { return $this->belongsTo(User::class, 'reviewed_by'); }

    public function getStatusLabelAttribute() { return self::STATUS_LABELS[$this->status]['label'] ?? $this->status; }
    public function getStatusBadgeAttribute() { return self::STATUS_LABELS[$this->status]['badge'] ?? 'secondary'; }
}
