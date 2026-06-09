<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Approval_log_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function insert($data) {
        return $this->db->insert('approval_log', $data);
    }

    public function get_by_tka($tka_id) {
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get_where('approval_log', ['tka_id' => $tka_id])->result();
    }

    public function get_last_reject($tka_id) {
        $this->db->where('tka_id', $tka_id);
        $this->db->where('status', 'reject');
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit(1);
        return $this->db->get('approval_log')->row();
    }

    /**
     * Ambil SLA untuk level tertentu
     */
    public function get_sla_by_level($level) {
        $this->db->where('level', $level);
        return $this->db->get('approval_sla')->row();
    }

    /**
     * Catat approval baru dengan deadline SLA
     * @param int $tka_id
     * @param int $level
     * @param string $status
     * @param int|null $user_id approver (NULL jika sistem)
     * @param string|null $catatan
     * @return int inserted id
     */
    public function insert_with_sla($tka_id, $level, $status, $user_id = null, $catatan = null) {
        $sla = $this->get_sla_by_level($level);
        $deadline = null;
        if ($sla && $sla->sla_jam > 0) {
            $deadline = date('Y-m-d H:i:s', strtotime("+{$sla->sla_jam} hours"));
        }
        
        $data = [
            'tka_id'      => $tka_id,
            'level'       => $level,
            'status'      => $status,
            'user_id'     => $user_id,
            'catatan'     => $catatan,
            'sla_deadline'=> $deadline,
            'created_at'  => date('Y-m-d H:i:s')
        ];
        $this->db->insert('approval_log', $data);
        return $this->db->insert_id();
    }

    /**
     * Ambil log approval yang masih aktif (belum di-approve/reject pada level tsb)
     */
    public function get_active_log($tka_id, $level) {
        $this->db->where('tka_id', $tka_id);
        $this->db->where('level', $level);
        $this->db->where_in('status', ['MENUNGGU_KASI','MENUNGGU_KABID','MENUNGGU_SEKDIS','MENUNGGU_KADIS']);
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('approval_log')->row();
    }

    public function set_warned($log_id) {
        $this->db->where('id', $log_id);
        $this->db->update('approval_log', ['warned_at' => date('Y-m-d H:i:s')]);
    }

    public function set_overdue($log_id) {
        $this->db->where('id', $log_id);
        $this->db->update('approval_log', ['is_overdue' => 1]);
    }

    public function set_escalated($log_id) {
        $this->db->where('id', $log_id);
        $this->db->update('approval_log', ['escalated_at' => date('Y-m-d H:i:s')]);
    }

    public function get_approaching_deadline() {
        $this->db->where('warned_at IS NULL');
        $this->db->where('sla_deadline IS NOT NULL');
        $this->db->where('sla_deadline >', date('Y-m-d H:i:s'));
        $this->db->where_in('status', ['MENUNGGU_KASI','MENUNGGU_KABID','MENUNGGU_SEKDIS','MENUNGGU_KADIS']);
        return $this->db->get('approval_log')->result();
    }

    public function get_new_overdue() {
        $this->db->where('is_overdue', 0);
        $this->db->where('sla_deadline IS NOT NULL');
        $this->db->where('sla_deadline <', date('Y-m-d H:i:s'));
        $this->db->where_in('status', ['MENUNGGU_KASI','MENUNGGU_KABID','MENUNGGU_SEKDIS','MENUNGGU_KADIS']);
        return $this->db->get('approval_log')->result();
    }

    public function get_not_escalated_overdue() {
        $this->db->where('is_overdue', 1);
        $this->db->where('escalated_at IS NULL');
        return $this->db->get('approval_log')->result();
    }
}