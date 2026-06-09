<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tka_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function insert($data) {
        $this->db->insert('tka', $data);
        return $this->db->insert_id();
    }

    public function delete($id) {
        $this->db->where('id', $id)->delete('tka');
    }

    public function get_by_user($user_id) {
        $this->db->order_by('id', 'DESC');
        return $this->db->get_where('tka', ['user_id' => $user_id])->result();
    }

    public function get_by_id($id) {
        return $this->db->get_where('tka', ['id' => $id])->row();
    }

    public function get_by_status($status) {
        $this->db->order_by('created_at', 'ASC');
        return $this->db->get_where('tka', ['status' => $status])->result();
    }

    public function update_status($id, $status) {
        $this->db->where('id', $id);
        return $this->db->update('tka', ['status' => $status]);
    }

    public function update_detail($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('tka', $data);
    }

    public function get_selesai_belum_kirim() {
        $this->db->where('status', 'SELESAI');
        $this->db->where('surat_dikirim', 0);
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('tka')->result();
    }

    public function mark_surat_dikirim($id) {
        $this->db->where('id', $id);
        return $this->db->update('tka', ['surat_dikirim' => 1]);
    }

    public function get_approval_stage($status) {
        $stages = [
            'DRAFT'            => ['stage' => 0, 'label' => 'Data Belum Lengkap', 'color' => 'secondary'],
            'MENUNGGU_KASI'    => ['stage' => 1, 'label' => 'Menunggu Verifikasi Kasi', 'color' => 'warning'],
            'MENUNGGU_KABID'   => ['stage' => 2, 'label' => 'Menunggu Verifikasi Kabid', 'color' => 'info'],
            'MENUNGGU_SEKDIS'  => ['stage' => 3, 'label' => 'Menunggu Verifikasi Sekdis', 'color' => 'primary'],
            'MENUNGGU_KADIS'   => ['stage' => 4, 'label' => 'Menunggu Verifikasi Kadis', 'color' => 'success'],
            'SELESAI'          => ['stage' => 5, 'label' => 'Selesai - Surat Terbit', 'color' => 'success'],
            'DITOLAK'          => ['stage' => 0, 'label' => 'Ditolak', 'color' => 'danger']
        ];
        return isset($stages[$status]) ? $stages[$status] : ['stage' => 0, 'label' => $status, 'color' => 'secondary'];
    }

    // Method untuk total semua pengajuan (digunakan di operator dashboard)
    public function count_all() {
        return $this->db->count_all('tka');
    }


    // =============================================
    // File: application/models/Tka_model.php
    // Tambahkan method berikut di dalam class
    // =============================================

    /**
     * Menghitung dan menyimpan estimasi selesai berdasarkan total SLA semua level
     * Dipanggil saat pertama kali submit dari DRAFT/REVISI ke MENUNGGU_KASI
     */
    public function set_estimasi_selesai($tka_id) {
        // Ambil total jam semua level dari tabel approval_sla
        $this->db->select_sum('sla_jam');
        $query = $this->db->get('approval_sla');
        $total_jam = $query->row()->sla_jam;
        
        if ($total_jam) {
            $estimasi = date('Y-m-d H:i:s', strtotime("+{$total_jam} hours"));
            $this->db->where('id', $tka_id);
            $this->db->update('tka', ['estimasi_selesai' => $estimasi]);
        }
    }

    /**
     * Reset estimasi saat pengajuan dikembalikan untuk revisi
     */
    public function reset_estimasi($tka_id) {
        $this->db->where('id', $tka_id);
        $this->db->update('tka', [
            'estimasi_selesai' => NULL,
            'overdue_flag' => 0
        ]);
    }

    /**
     * Tandai TKA sebagai memiliki overdue aktif
     */
    public function set_overdue_flag($tka_id, $flag = 1) {
        $this->db->where('id', $tka_id);
        $this->db->update('tka', ['overdue_flag' => $flag]);
    }

    /**
     * Mendapatkan data lengkap TKA beserta progres approval
     */
    public function get_detail_tka($tka_id) {
        $this->db->select('tka.*, 
            (SELECT deadline FROM approval_log WHERE tka_id = tka.id AND level = 1 AND status = "MENUNGGU_KASI" ORDER BY created_at DESC LIMIT 1) as kasi_deadline,
            (SELECT deadline FROM approval_log WHERE tka_id = tka.id AND level = 2 AND status = "MENUNGGU_KABID" ORDER BY created_at DESC LIMIT 1) as kabid_deadline,
            (SELECT deadline FROM approval_log WHERE tka_id = tka.id AND level = 3 AND status = "MENUNGGU_SEKDIS" ORDER BY created_at DESC LIMIT 1) as sekdis_deadline,
            (SELECT deadline FROM approval_log WHERE tka_id = tka.id AND level = 4 AND status = "MENUNGGU_KADIS" ORDER BY created_at DESC LIMIT 1) as kadis_deadline,
        ');
        $this->db->where('id', $tka_id);
        return $this->db->get('tka')->row();
    }

    // =========================================================================
// METHOD UNTUK ADMIN CONTROLLER
// =========================================================================

/**
 * Menghitung TKA berdasarkan status (untuk dashboard admin)
 */
    public function count_by_status(string $status): int
    {
        return $this->db->where('status', $status)->count_all_results('tka');
    }

    /**
     * Mengambil semua TKA dengan join perusahaan (untuk admin/semua_tka)
     */
    public function get_all_with_company(): array
    {
        return $this->db
            ->select('tka.*, users.perusahaan, users.nama as pic')
            ->from('tka')
            ->join('users', 'users.id = tka.user_id')
            ->order_by('tka.created_at', 'DESC')
            ->get()
            ->result();
    }

    /**
     * Mengambil TKA berdasarkan rentang tanggal (untuk laporan bulanan)
     */
    public function get_by_date_range(string $start_date, string $end_date): array
    {
        return $this->db
            ->select('tka.*, users.perusahaan, users.nama as pic')
            ->from('tka')
            ->join('users', 'users.id = tka.user_id')
            ->where('tka.created_at >=', $start_date)
            ->where('tka.created_at <=', $end_date)
            ->get()
            ->result();
    }

    /**
     * Mendapatkan ID TKA terbesar (untuk polling notifikasi)
     */
    public function get_max_id(): int
    {
        $row = $this->db->select_max('id')->get('tka')->row();
        return $row ? (int) $row->id : 0;
    }

    /**
     * Mendapatkan TKA baru setelah ID tertentu (untuk polling)
     */
    public function get_new_submissions(int $last_id): array
    {
        return $this->db
            ->select('tka.id, tka.nama_tka, users.perusahaan')
            ->from('tka')
            ->join('users', 'users.id = tka.user_id')
            ->where('tka.id >', $last_id)
            ->order_by('tka.id', 'ASC')
            ->get()
            ->result();
    }

    /**
     * Update data TKA (umum)
     */
    public function update(int $id, array $data): bool
    {
        return $this->db->where('id', $id)->update('tka', $data);
    }

    // ================================================================
// METHOD UNTUK DASHBOARD ADMIN
// ================================================================

/**
 * Rata-rata waktu (hari) yang dihabiskan di setiap tahap approval
 * Menggunakan approval_log yang mencatat waktu masuk dan keluar tiap level
 */
/**
 * Rata-rata waktu per tahap (versi aman, tanpa updated_at)
 * Jika kolom updated_at tidak ada, hitung berdasarkan selisih tanggal created_at antar log
 */
public function get_avg_time_per_stage(): array
{
    // Cek apakah kolom updated_at ada
    $has_updated = $this->db->field_exists('updated_at', 'approval_log');

    $stages = ['MENUNGGU_KASI', 'MENUNGGU_KABID', 'MENUNGGU_SEKDIS', 'MENUNGGU_KADIS', 'SELESAI'];
    $result = [];

    foreach ($stages as $stage) {
        if ($has_updated && $stage !== 'SELESAI') {
            // Gunakan updated_at jika ada
            $sql = "SELECT AVG(TIMESTAMPDIFF(HOUR, created_at, updated_at)) / 24 AS avg_days 
                    FROM approval_log WHERE status = ? AND updated_at IS NOT NULL";
            $query = $this->db->query($sql, [$stage]);
            $avg = (float) $query->row()->avg_days;
        } else {
            // Fallback: hitung perbedaan timestamp dari created_at log saat ini ke created_at log berikutnya?
            // Untuk sederhana, kembalikan 0 untuk sementara.
            $avg = 0;
        }
        $result[$stage] = round($avg, 1);
    }
    $result['DITOLAK'] = 0;
    return $result;
}

/**
 * Rata-rata hari dari submit hingga selesai (pakai created_at & updated_at di tka)
 */
public function get_avg_conversion_days(): int
{
    if (!$this->db->field_exists('updated_at', 'tka')) {
        return 0;
    }
    $sql = "SELECT AVG(TIMESTAMPDIFF(DAY, created_at, updated_at)) AS avg_days 
            FROM tka WHERE status = 'SELESAI' AND updated_at IS NOT NULL";
    $query = $this->db->query($sql);
    return (int) round($query->row()->avg_days ?? 0);
}

/**
 * Data untuk chart 6 bulan (berdasarkan created_at TKA)
 * closed_won  = SELESAI dalam bulan itu
 * closed_lost = DITOLAK dalam bulan itu
 * in_progress = semua TKA yang dibuat sebelum bulan itu dan belum selesai/ditolak (bukan per bulan, tapi cumulative)
 * Agar grafik tampil lebih baik, kita gunakan pendekatan per bulan: jumlah TKA yang statusnya SELESAI/DITOLAK pada bulan tersebut.
 */
public function get_chart_data_6months(): array
{
    $months = [];
    $closed_won = [];
    $closed_lost = [];
    $in_progress = [];

    for ($i = 5; $i >= 0; $i--) {
        $month_start = date('Y-m-01', strtotime("-$i months"));
        $month_end   = date('Y-m-t', strtotime($month_start));
        $month_label = date('M Y', strtotime($month_start));
        $months[] = $month_label;

        // Hitung SELESAI dalam bulan ini (berdasarkan updated_at, atau created_at jika updated_at tidak ada)
        if ($this->db->field_exists('updated_at', 'tka')) {
            $won = $this->db->where('status', 'SELESAI')
                ->where('updated_at >=', $month_start)
                ->where('updated_at <=', $month_end)
                ->count_all_results('tka');
        } else {
            // Jika tidak ada updated_at, gunakan created_at (kurang akurat tapi tetap)
            $won = $this->db->where('status', 'SELESAI')
                ->where('created_at >=', $month_start)
                ->where('created_at <=', $month_end)
                ->count_all_results('tka');
        }

        // DITOLAK dalam bulan ini
        if ($this->db->field_exists('updated_at', 'tka')) {
            $lost = $this->db->where('status', 'DITOLAK')
                ->where('updated_at >=', $month_start)
                ->where('updated_at <=', $month_end)
                ->count_all_results('tka');
        } else {
            $lost = $this->db->where('status', 'DITOLAK')
                ->where('created_at >=', $month_start)
                ->where('created_at <=', $month_end)
                ->count_all_results('tka');
        }

        // Dalam proses: semua TKA yang dibuat pada bulan itu dan statusnya belum final (tidak SELESAI/DITOLAK)
        $process = $this->db->where('created_at >=', $month_start)
            ->where('created_at <=', $month_end)
            ->where('status NOT IN ("SELESAI","DITOLAK")')
            ->count_all_results('tka');

        $closed_won[] = $won;
        $closed_lost[] = $lost;
        $in_progress[] = $process;
    }

    return [
        'months'       => $months,
        'closed_won'   => $closed_won,
        'closed_lost'  => $closed_lost,
        'in_progress'  => $in_progress,
    ];
}

/**
 * Ambil alasan penolakan terbaru
 */
public function get_recent_reject_reasons(int $limit = 5): array
{
    $this->db->select('approval_log.catatan, approval_log.created_at, users.role')
        ->from('approval_log')
        ->join('users', 'users.id = approval_log.user_id', 'left')
        ->where('approval_log.status', 'DITOLAK')
        ->where('approval_log.catatan IS NOT NULL')
        ->order_by('approval_log.created_at', 'DESC')
        ->limit($limit);
    return $this->db->get()->result();
}



}
?>