<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Security_attempts_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_attempts($email) {
        $this->db->where('email', $email);
        return $this->db->get('security_attempts')->row();
    }

    public function record_failed_attempt($email) {
        $row = $this->get_attempts($email);
        if (!$row) {
            // First failed attempt
            $this->db->insert('security_attempts', [
                'email' => $email,
                'attempts' => 1,
                'locked_until' => null
            ]);
            return;
        }

        $new_attempts = $row->attempts + 1;
        $locked_until = $row->locked_until;

        // Check if currently locked
        if ($locked_until && strtotime($locked_until) > time()) {
            // Already locked, just increment attempts (but still locked)
            $this->db->where('email', $email)->update('security_attempts', ['attempts' => $new_attempts]);
            return;
        }

        // If not locked, check if we need to lock after this attempt
        if ($new_attempts >= 5) {
            // Calculate lock duration: start from 2 hours, double every time locked_until was set before
            $last_lock = $row->locked_until ? strtotime($row->locked_until) : 0;
            if ($last_lock && $last_lock < time()) {
                // Previous lock expired, we still double the duration based on previous lock period
                $previous_duration = $last_lock ? (strtotime($row->locked_until) - strtotime($row->updated_at)) : 0;
                $duration = max(7200, $previous_duration * 2); // double, minimum 2 hours
            } else {
                $duration = 7200; // 2 hours
            }
            $locked_until = date('Y-m-d H:i:s', time() + $duration);
            $this->db->where('email', $email)->update('security_attempts', [
                'attempts' => $new_attempts,
                'locked_until' => $locked_until
            ]);
        } else {
            // Just increment attempts, not locked
            $this->db->where('email', $email)->update('security_attempts', [
                'attempts' => $new_attempts,
                'locked_until' => null
            ]);
        }
    }

    public function reset_attempts($email) {
        $this->db->where('email', $email)->delete('security_attempts');
    }

    public function get_lock_remaining($email) {
        $row = $this->get_attempts($email);
        if (!$row || !$row->locked_until) return 0;
        $locked_until = strtotime($row->locked_until);
        $remaining = $locked_until - time();
        return $remaining > 0 ? $remaining : 0;
    }
}
?>