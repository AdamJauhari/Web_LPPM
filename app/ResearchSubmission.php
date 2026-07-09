<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResearchSubmission extends Model
{
    protected $table = 'research_submissions';

    protected $fillable = [
        'user_id', 'title', 'abstract', 'research_type', 'team_members',
        'fakultas', 'semester', 'tahun', 'nama_dosen',
        'sumber_dana', 'total_dana', 'kategori_luaran',
        'status', 'admin_notes', 'rejection_reason',
        'assigned_to', 'reviewed_by', 'reviewed_at',
    ];

    protected $casts = ['reviewed_at' => 'datetime'];

    const STATUS_LABELS = [
        'pending'      => ['label' => 'Menunggu',         'badge' => 'warning text-dark'],
        'assigned'     => ['label' => 'Ditugaskan',       'badge' => 'info'],
        'under_review' => ['label' => 'Dalam Review',     'badge' => 'primary'],
        'approved'     => ['label' => 'Disetujui',        'badge' => 'success'],
        'rejected'     => ['label' => 'Ditolak',          'badge' => 'danger'],
    ];

    const SUMBER_DANA = ['Internal', 'Eksternal'];
    const SEMESTER    = ['Ganjil', 'Genap'];

    public function user()        { return $this->belongsTo(User::class); }
    public function assignee()    { return $this->belongsTo(User::class, 'assigned_to'); }
    public function reviewer()    { return $this->belongsTo(User::class, 'reviewed_by'); }

    public function getStatusLabelAttribute()
    {
        return self::STATUS_LABELS[$this->status]['label'] ?? $this->status;
    }
    public function getStatusBadgeAttribute()
    {
        return self::STATUS_LABELS[$this->status]['badge'] ?? 'secondary';
    }
}
