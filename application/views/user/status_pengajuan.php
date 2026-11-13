<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container mt-4">
    <h3><?= $this->lang->line('tka_status_title') ?? 'Status Pengajuan TKA #' ?><?= $tka->id; ?></h3>
    
    <!-- Progress Bar -->
    <div class="progress mb-3" style="height: 25px;">
      <div class="progress-bar bg-success" role="progressbar" 
           style="width: <?= progress_persen($tka); ?>%;" 
           aria-valuenow="<?= progress_persen($tka); ?>" aria-valuemin="0" aria-valuemax="100">
        <?= progress_persen($tka); ?>%
      </div>
    </div>
    
    <!-- Estimasi Selesai -->
    <?php if (!empty($tka->estimasi_selesai) && $tka->status != 'SELESAI') : ?>
        <p><?= $this->lang->line('tka_est_done') ?? 'Estimasi selesai:' ?> <strong><?= date('d M Y, H:i', strtotime($tka->estimasi_selesai)); ?></strong></p>
    <?php endif; ?>
    
    <!-- Timeline 4 Tahap -->
    <ul class="timeline list-unstyled mt-4">
        <?php
        $levels = [
            1 => ['label' => $this->lang->line('tka_chk_kasi') ?? 'Pemeriksaan Kepala Seksi', 'deadline' => $tka->kasi_deadline ?? null],
            2 => ['label' => $this->lang->line('tka_chk_kabid') ?? 'Pemeriksaan Kepala Bidang', 'deadline' => $tka->kabid_deadline ?? null],
            3 => ['label' => $this->lang->line('tka_chk_sekdis') ?? 'Pemeriksaan Sekretaris Dinas', 'deadline' => $tka->sekdis_deadline ?? null],
            4 => ['label' => $this->lang->line('tka_chk_kadis') ?? 'Pemeriksaan Kepala Dinas', 'deadline' => $tka->kadis_deadline ?? null],
        ];
        
        // Tentukan status setiap level berdasarkan data approval_log
        // Ini contoh sederhana, sesuaikan dengan data approval_log yang ada
        $status_approval = $this->approval_log_model->get_status_per_level($tka->id);
        
        foreach ($levels as $lvl => $info) :
            // Tentukan state
            $state = 'pending'; // ○
            $icon = '○';
            $color = 'text-muted';
            $keterangan = '';
            
            if (isset($status_approval[$lvl])) {
                $log = $status_approval[$lvl];
                if ($log->status == 'SELESAI' || in_array($log->status, ['MENUNGGU_KASI','MENUNGGU_KABID','MENUNGGU_SEKDIS','MENUNGGU_KADIS']) && $log->approved_at) {
                    // Jika sudah ada approved_at berarti pada level ini sudah selesai
                    $state = 'done';
                    $icon = '✓';
                    $color = 'text-success';
                    $keterangan = ($this->lang->line('tka_approved_at') ?? 'Disetujui ') . date('d M H:i', strtotime($log->approved_at));
                } elseif ($log->is_overdue) {
                    $state = 'overdue';
                    $icon = '⚠';
                    $color = 'text-warning';
                    $keterangan = $this->lang->line('tka_overdue_escalated') ?? 'Melewati batas waktu – sedang dieskalasi ke atasan';
                } elseif ($log->sla_deadline && strtotime($log->sla_deadline) < time()) {
                    // overdue tapi flag belum? fallback
                    $state = 'overdue';
                    $icon = '⚠';
                    $color = 'text-warning';
                    $keterangan = $this->lang->line('tka_overdue') ?? 'Melewati batas waktu';
                } elseif ($log->status == 'DITOLAK') {
                    $state = 'rejected';
                    $icon = '✗';
                    $color = 'text-danger';
                    $keterangan = $this->lang->line('tka_rejected_level') ?? 'Ditolak pada level ini';
                } else {
                    // status menunggu (aktif)
                    $state = 'active';
                    $icon = '●';
                    $color = 'text-primary';
                    if ($log->sla_deadline) {
                        $keterangan = sisa_waktu_label($log->sla_deadline);
                    } else {
                        $keterangan = $this->lang->line('tka_waiting_action') ?? 'Menunggu tindakan';
                    }
                }
            } else {
                // Belum dimulai
                $keterangan = $this->lang->line('tka_not_started') ?? 'Belum dimulai';
            }
        ?>
        <li class="mb-3">
            <span class="<?= $color; ?> me-2"><?= $icon; ?></span>
            <strong><?= $info['label']; ?></strong>
            <?php if ($keterangan) : ?>
                <small class="d-block <?= $color; ?>"><?= $keterangan; ?></small>
            <?php endif; ?>
        </li>
        <?php endforeach; ?>
    </ul>
    
    <!-- Panel Revisi jika ada -->
    <?php if ($tka->status == 'DITOLAK' || $tka->status == 'REVISI') : ?>
    <div class="alert alert-warning">
        <h5><?= $this->lang->line('tka_revision_note') ?? 'Catatan Perbaikan' ?></h5>
        <p><?= nl2br($tka->catatan_revisi ?? $this->lang->line('tka_no_note') ?? 'Tidak ada catatan.'); ?></p>
        <a href="<?= base_url('user/revisi/'.$tka->id); ?>" class="btn btn-warning"><?= $this->lang->line('tka_resubmit_revision') ?? 'Kirim Ulang Revisi' ?></a>
    </div>
    <?php endif; ?>
    
    <!-- Tombol Unduh Surat -->
    <?php if ($tka->status == 'SELESAI') : ?>
    <a href="<?= base_url('user/download_surat/'.$tka->id); ?>" class="btn btn-success">
        <i class="bi bi-download"></i> <?= $this->lang->line('tka_dl_permit') ?? 'Unduh Surat Izin' ?>
    </a>
    <?php endif; ?>
</div>