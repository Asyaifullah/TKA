<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rate_limit {
    private $CI;
    
    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->driver('cache', array('adapter' => 'file'));
    }
    
    public function is_limited($action, $limit = 5, $time_window = 10) {
        $ip = $this->CI->input->ip_address();
        $key = 'rate_limit_' . $action . '_' . $ip;
        $attempts = $this->CI->cache->get($key);
        if (!$attempts) $attempts = 0;
        return ($attempts >= $limit);
    }
    
    public function add_attempt($action, $time_window = 10) {
        $ip = $this->CI->input->ip_address();
        $key = 'rate_limit_' . $action . '_' . $ip;
        $attempts = $this->CI->cache->get($key);
        $attempts = $attempts ? $attempts + 1 : 1;
        $this->CI->cache->save($key, $attempts, 60 * $time_window);
    }
    
    public function reset_attempts($action) {
        $ip = $this->CI->input->ip_address();
        $key = 'rate_limit_' . $action . '_' . $ip;
        $this->CI->cache->delete($key);
    }
}
?>