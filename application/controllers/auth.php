<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    private $smtp_email = 'faridivanrizqy501@gmail.com';
    private $smtp_app_password = 'rydipupxvrgedyxh';

    public function __construct() {
        parent::__construct();

        $this->load->model('User_model');
        $this->load->model('Security_attempts_model');

        $this->load->library('rate_limit');
        $this->load->library('form_validation');
        $this->load->library('email');
        $this->load->library('session');

        $this->load->helper('form');
        $this->load->helper('url');
    }

    private function send_otp_email($email, $otp) {
    $config = [
    'protocol'    => 'smtp',
    'smtp_host'   => 'smtp.gmail.com',
    'smtp_port'   => 587,
    'smtp_crypto' => 'tls',
    'smtp_user'   => $this->smtp_email,
    'smtp_pass'   => trim($this->smtp_app_password),
    'mailtype'    => 'html',
    'charset'     => 'utf-8',
    'newline'     => "\r\n",
    'crlf'        => "\r\n",
    'wordwrap'    => TRUE
];

    $this->email->initialize($config);
    $this->email->clear(TRUE);

    $this->email->from($this->smtp_email, 'SITLAKEB TKA');
    $this->email->to($email);
    $this->email->subject('Kode OTP Verifikasi Akun SITLAKEB TKA');

    $message = '
    <div style="font-family:Arial,sans-serif;background:#f4f7f6;padding:30px;">
        <div style="max-width:520px;margin:auto;background:white;border-radius:16px;padding:32px;text-align:center;">
            <h2>Verifikasi OTP SITLAKEB TKA</h2>
            <p>Gunakan kode berikut untuk melanjutkan pendaftaran akun perusahaan.</p>
            <div style="font-size:38px;font-weight:bold;letter-spacing:8px;color:#087456;margin:24px 0;">
                '.$otp.'
            </div>
            <p>Kode OTP berlaku selama <b>3 menit</b>.</p>
        </div>
    </div>';

    $this->email->message($message);

    if (!$this->email->send()) {
        echo "<pre>";
        echo $this->email->print_debugger();
        echo "</pre>";
        exit;
    }

    return TRUE;
}

    public function login() {
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }

        $this->load->view('auth/login');
    }

    public function do_login() {
        if ($this->rate_limit->is_limited('login', 5, 10)) {
            $this->session->set_flashdata('error', 'Terlalu banyak percobaan login. Coba lagi setelah 10 menit.');
            redirect('auth/login');
        }

        $email = trim($this->input->post('email', TRUE));
        $password = $this->input->post('password');

        $user = $this->User_model->get_by_email($email);

        if (!$user) {
            $this->rate_limit->add_attempt('login');
            $this->session->set_flashdata('error', 'Email tidak terdaftar.');
            redirect('auth/login');
        }

        if (isset($user->is_active) && $user->is_active == 0) {
            $this->session->set_flashdata('error', 'Akun Anda telah dinonaktifkan. Hubungi admin.');
            redirect('auth/login');
        }

        if (password_verify($password, $user->password)) {
            $this->rate_limit->reset_attempts('login');

            $this->session->set_userdata([
                'logged_in'  => true,
                'user_id'    => $user->id,
                'nama'       => $user->nama,
                'role'       => $user->role,
                'perusahaan' => $user->perusahaan
            ]);

            $this->session->sess_regenerate(TRUE);
            redirect('dashboard');
        }

        $this->rate_limit->add_attempt('login');
        $this->session->set_flashdata('error', 'Password salah.');
        redirect('auth/login');
    }

    public function register() {
        $this->load->view('auth/register');
    }

    public function do_register() {
        if ($this->rate_limit->is_limited('register', 3, 60)) {
            $this->session->set_flashdata('error', 'Terlalu banyak pendaftaran. Coba lagi nanti.');
            redirect('auth/register');
        }

        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
        $this->form_validation->set_rules('perusahaan', 'Perusahaan', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
        $this->form_validation->set_rules('no_hp', 'No HP', 'required|numeric|trim');
        $this->form_validation->set_rules('security_question', 'Pertanyaan Keamanan', 'required|trim');
        $this->form_validation->set_rules('security_answer', 'Jawaban Keamanan', 'required|trim');

        $this->form_validation->set_message('numeric', 'Nomor Handphone harus berupa angka.');
        $this->form_validation->set_message('is_unique', 'Email sudah terdaftar.');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('auth/register');
        }

        $temp_data = [
            'nama'              => trim($this->input->post('nama', TRUE)),
            'email'             => trim($this->input->post('email', TRUE)),
            'password'          => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'perusahaan'        => trim($this->input->post('perusahaan', TRUE)),
            'alamat'            => trim($this->input->post('alamat', TRUE)),
            'no_hp'             => trim($this->input->post('no_hp', TRUE)),
            'security_question' => trim($this->input->post('security_question', TRUE)),
            'security_answer'   => strtolower(trim($this->input->post('security_answer', TRUE)))
        ];

        $otp = sprintf("%06d", mt_rand(0, 999999));
        $expiry = time() + (3 * 60);

        if (!$this->send_otp_email($temp_data['email'], $otp)) {
            $this->session->set_flashdata('error', 'Gagal mengirim kode OTP ke email. Pastikan SMTP Gmail dan App Password sudah benar.');
            redirect('auth/register');
        }

        $this->session->set_userdata('temp_registration', $temp_data);
        $this->session->set_userdata('otp_code', $otp);
        $this->session->set_userdata('otp_expiry', $expiry);

        $this->session->set_flashdata('success', 'Kode OTP telah dikirim ke email Anda.');
        redirect('auth/otp_form');
    }


    public function otp_form() {
        if (!$this->session->userdata('temp_registration')) {
            redirect('auth/register');
        }

        $otp_expiry = $this->session->userdata('otp_expiry');
        $remaining = $otp_expiry ? $otp_expiry - time() : 0;

        $data['remaining_seconds'] = $remaining > 0 ? $remaining : 0;

        $this->load->view('auth/otp_form', $data);
    }

    public function verify_otp() {
        if (!$this->session->userdata('temp_registration')) {
            redirect('auth/register');
        }

        $otp_input = trim($this->input->post('otp', TRUE));
        $otp_session = $this->session->userdata('otp_code');
        $otp_expiry = $this->session->userdata('otp_expiry');

        if (empty($otp_session) || empty($otp_expiry)) {
            $this->session->set_flashdata('error', 'Sesi OTP tidak valid. Silakan daftar ulang.');
            redirect('auth/register');
        }

        if (time() > $otp_expiry) {
            $this->session->set_flashdata('error', 'Kode OTP sudah kadaluarsa. Silakan kirim ulang.');
            redirect('auth/otp_form');
        }

        if ($otp_input !== $otp_session) {
            $this->session->set_flashdata('error', 'Kode OTP salah.');
            redirect('auth/otp_form');
        }

        $temp_data = $this->session->userdata('temp_registration');

        $user_data = [
            'nama'              => $temp_data['nama'],
            'email'             => $temp_data['email'],
            'password'          => $temp_data['password'],
            'perusahaan'        => $temp_data['perusahaan'],
            'alamat'            => $temp_data['alamat'],
            'no_hp'             => $temp_data['no_hp'],
            'role'              => 'user',
            'is_active'         => 1,
            'security_question' => $temp_data['security_question'],
            'security_answer'   => $temp_data['security_answer']
        ];

        $this->User_model->insert($user_data);

        $this->session->unset_userdata(['temp_registration', 'otp_code', 'otp_expiry']);
        $this->session->set_flashdata('success', 'Verifikasi berhasil! Silakan login.');
        redirect('auth/login');
    }

    public function resend_otp() {
        if (!$this->session->userdata('temp_registration')) {
            redirect('auth/register');
        }

        if ($this->rate_limit->is_limited('resend_otp', 3, 10)) {
            $this->session->set_flashdata('error', 'Terlalu banyak permintaan kirim ulang. Coba lagi setelah 10 menit.');
            redirect('auth/otp_form');
        }

        $temp_data = $this->session->userdata('temp_registration');

        if (empty($temp_data['email'])) {
            $this->session->set_flashdata('error', 'Email tidak ditemukan. Silakan daftar ulang.');
            redirect('auth/register');
        }

        $new_otp = sprintf("%06d", mt_rand(0, 999999));
        $expiry = time() + (3 * 60);

        if (!$this->send_otp_email($temp_data['email'], $new_otp)) {
            $this->session->set_flashdata('error', 'Gagal mengirim ulang OTP ke email. Periksa konfigurasi SMTP Gmail.');
            redirect('auth/otp_form');
        }

        $this->session->set_userdata('otp_code', $new_otp);
        $this->session->set_userdata('otp_expiry', $expiry);

        $this->rate_limit->add_attempt('resend_otp');
        $this->session->set_flashdata('success', 'Kode OTP baru telah dikirim ke email Anda.');
        redirect('auth/otp_form');
    }

    public function forgot_password() {
        $this->load->view('auth/forgot_password');
    }

    public function verify_security() {
        $email = trim($this->input->post('email', TRUE));

        if (empty($email)) {
            $email = $this->session->userdata('reset_email');
        }

        if (empty($email)) {
            $this->session->set_flashdata('error', 'Email tidak ditemukan. Silakan mulai ulang.');
            redirect('auth/forgot_password');
        }

        $remaining = $this->Security_attempts_model->get_lock_remaining($email);

        if ($remaining > 0) {
            $hours = floor($remaining / 3600);
            $minutes = floor(($remaining % 3600) / 60);

            $this->session->set_flashdata('error', "Terlalu banyak percobaan gagal. Coba lagi setelah {$hours} jam {$minutes} menit.");
            $this->session->unset_userdata('reset_email');
            redirect('auth/forgot_password');
        }

        $user = $this->User_model->get_security_question($email);

        if (!$user) {
            $this->session->set_flashdata('error', 'Email tidak terdaftar.');
            redirect('auth/forgot_password');
        }

        $this->session->set_userdata('reset_email', $email);

        $data['question'] = $user->security_question;
        $data['email'] = $email;

        $this->load->view('auth/verify_security', $data);
    }

    public function check_security_answer() {
        $email = $this->session->userdata('reset_email');

        if (!$email) {
            redirect('auth/forgot_password');
        }

        $remaining = $this->Security_attempts_model->get_lock_remaining($email);

        if ($remaining > 0) {
            $hours = floor($remaining / 3600);
            $minutes = floor(($remaining % 3600) / 60);

            $this->session->set_flashdata('error', "Terlalu banyak percobaan gagal. Coba lagi setelah {$hours} jam {$minutes} menit.");
            $this->session->unset_userdata('reset_email');
            redirect('auth/forgot_password');
        }

        $answer = strtolower(trim($this->input->post('security_answer', TRUE)));
        $user = $this->User_model->get_security_question($email);

        if (!$user || $user->security_answer !== $answer) {
            $this->Security_attempts_model->record_failed_attempt($email);

            $attempts_row = $this->Security_attempts_model->get_attempts($email);
            $attempts_left = 5 - ($attempts_row->attempts % 5);

            if ($attempts_left <= 0) {
                $attempts_left = 5;
            }

            $this->session->set_flashdata('error', "Jawaban keamanan salah. Sisa percobaan: {$attempts_left} kali lagi sebelum terkunci.");
            redirect('auth/verify_security');
        }

        $this->Security_attempts_model->reset_attempts($email);
        $this->session->set_userdata('reset_verified', true);

        redirect('auth/reset_password');
    }

    public function reset_password() {
        $email = $this->session->userdata('reset_email');
        $verified = $this->session->userdata('reset_verified');

        if (!$email || !$verified) {
            redirect('auth/forgot_password');
        }

        $this->load->view('auth/reset_password');
    }

    public function do_reset_password() {
        $email = $this->session->userdata('reset_email');
        $verified = $this->session->userdata('reset_verified');

        if (!$email || !$verified) {
            redirect('auth/forgot_password');
        }

        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
        $this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'required|matches[password]');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('auth/reset_password');
        }

        $new_password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);

        $this->User_model->update_password_by_email($email, $new_password);

        $this->session->unset_userdata(['reset_email', 'reset_verified']);
        $this->session->set_flashdata('success', 'Password berhasil direset. Silakan login.');

        redirect('auth/login');
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}