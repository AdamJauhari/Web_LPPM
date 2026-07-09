<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PkmSubmission extends Model
{
    protected $table = 'pkm_submissions';

    protected $fillable = [
        'user_id', 'fakultas', 'semester', 'tahun', 'nama_dosen',
        'judul', 'abstrak', 'sumber_dana', 'total_dana',
        'pelaksanaan', 'luaran_jurnal', 'sumber_dana_eksternal', 'team_members',
        'status', 'admin_notes', 'rejection_reason',
        'assigned_to', 'reviewed_by', 'reviewed_at',
    ];

    protected $casts = ['reviewed_at' => 'datetime'];

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
