<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) redirect('auth/login');
        $this->load->model('Chat_model');
        $this->load->model('User_model');
    }

    // Halaman utama chat
    public function index() {
        $user_id = $this->session->userdata('user_id');
        $role = $this->session->userdata('role');

        if ($role == 'user') {
            $admin = $this->db->where('role', 'admin')->get('users')->row();
            $data['partner'] = $admin;
            $data['messages'] = $this->Chat_model->get_conversation($user_id, $admin->id);
            $this->Chat_model->mark_as_read_user($admin->id, $user_id);
            $this->load->view('user/chat', $data);
        } 
        elseif ($role == 'admin') {
            // Ambil daftar perusahaan dengan pesan terakhir dan unread count
            $users = $this->Chat_model->get_users_with_last_message($user_id);
            // Urutkan berdasarkan last_message_time DESC (pesan terbaru di atas)
            usort($users, function($a, $b) {
                return strtotime($b->last_message_time) - strtotime($a->last_message_time);
            });
            $data['users'] = $users;

            $selected = $this->input->get('user_id');
            if ($selected) {
                $data['selected_user'] = $this->User_model->get_by_id($selected);
                $data['messages'] = $this->Chat_model->get_conversation($user_id, $selected);
                // Tandai pesan dari perusahaan tersebut sudah dibaca
                $this->Chat_model->mark_as_read_admin($selected, $user_id);
            }
            $this->load->view('admin/chat', $data);
        }
    }

    // Kirim pesan (AJAX)
    public function send() {
        if ($this->input->method() !== 'post') show_404();

        $to = $this->input->post('to');
        $message = trim($this->input->post('message'));

        if (empty($message)) {
            $this->output
                ->set_content_type('application/json')
                ->set_header('X-CSRF-Token: ' . $this->security->get_csrf_hash())
                ->set_output(json_encode(['status' => 'error', 'message' => 'Pesan kosong']));
            return;
        }

        $from = $this->session->userdata('user_id');
        $this->Chat_model->send_message($from, $to, $message);

        $this->output
            ->set_content_type('application/json')
            ->set_header('X-CSRF-Token: ' . $this->security->get_csrf_hash())
            ->set_output(json_encode(['status' => 'success']));
    }

    // Ambil pesan baru (AJAX)
    public function get_new() {
        if ($this->input->method() !== 'post') show_404();

        $user_id = $this->session->userdata('user_id');
        $role = $this->session->userdata('role');
        $last_id = (int)$this->input->post('last_id');
        $partner_id = (int)$this->input->post('partner_id');

        if ($role == 'user') {
            $admin = $this->db->where('role', 'admin')->get('users')->row();
            $partner_id = $admin->id;
        }

        $sql = "SELECT * FROM chat_messages 
                WHERE ((from_user_id = ? AND to_user_id = ?) OR (from_user_id = ? AND to_user_id = ?))";
        $params = [$partner_id, $user_id, $user_id, $partner_id];
        if ($last_id > 0) {
            $sql .= " AND id > ?";
            $params[] = $last_id;
        }
        $sql .= " ORDER BY created_at ASC";
        $messages = $this->db->query($sql, $params)->result();

        // Tandai pesan yang diterima sebagai sudah dibaca
        if ($role == 'user') {
            $this->Chat_model->mark_as_read_user($partner_id, $user_id);
        } else {
            if ($partner_id > 0) {
                $this->Chat_model->mark_as_read_admin($partner_id, $user_id);
            }
        }

        $this->output
            ->set_content_type('application/json')
            ->set_header('X-CSRF-Token: ' . $this->security->get_csrf_hash())
            ->set_output(json_encode($messages));
    }

    // Ambil daftar user (untuk polling update sidebar) – khusus admin
    public function get_user_list() {
        if ($this->session->userdata('role') != 'admin') return;
        $admin_id = $this->session->userdata('user_id');

        $users = $this->Chat_model->get_users_with_last_message($admin_id);
        // Urutkan berdasarkan last_message_time terbaru
        usort($users, function($a, $b) {
            return strtotime($b->last_message_time) - strtotime($a->last_message_time);
        });

        // Siapkan data tambahan untuk frontend
        foreach ($users as $u) {
            $words = explode(' ', trim($u->perusahaan));
            $u->initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
            $u->perusahaan = htmlspecialchars($u->perusahaan);
            $u->last_message = htmlspecialchars($u->last_message);
            $u->last_message_time = $u->last_message_time;
        }

        $this->output
            ->set_content_type('application/json')
            ->set_header('X-CSRF-Token: ' . $this->security->get_csrf_hash())
            ->set_output(json_encode($users));
    }

    // Tandai pesan sudah dibaca (AJAX)
    public function mark_read() {
        $partner_id = $this->input->post('partner_id');
        $admin_id = $this->session->userdata('user_id');
        $this->Chat_model->mark_as_read_admin($partner_id, $admin_id);
        $this->output
            ->set_content_type('application/json')
            ->set_header('X-CSRF-Token: ' . $this->security->get_csrf_hash())
            ->set_output(json_encode(['status' => 'ok']));
    }

    // Hitung unread count untuk badge (AJAX)
    public function unread_count() {
        $user_id = $this->session->userdata('user_id');
        $role = $this->session->userdata('role');
        $count = 0;
        if ($role == 'user') {
            $count = $this->Chat_model->count_unread_user($user_id);
        } else {
            $count = $this->Chat_model->count_unread_admin($user_id);
        }
        $this->output
            ->set_content_type('application/json')
            ->set_header('X-CSRF-Token: ' . $this->security->get_csrf_hash())
            ->set_output(json_encode(['unread' => (int)$count]));
    }
}
?>