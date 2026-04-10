<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }

    // Tanya Gemini AI
    public function ask_ai() {
        $message = $this->input->post('message');
        $settings = $this->_get_settings();
        
        $api_key = isset($settings['gemini_api_key']) ? $settings['gemini_api_key'] : '';
        if(empty($api_key)) {
            echo json_encode(['reply' => 'Maaf, sistem AI sedang tidak tersedia. Anda bisa langsung chat dengan admin kami.']);
            return;
        }

        $site_name = isset($settings['title']) ? $settings['title'] : 'Fotoboot';
        $site_about = isset($settings['site_about']) ? $settings['site_about'] : 'Layanan photobooth digital otomatis.';

        // Prompt Engineering (System Instruction)
        $prompt = "Kamu adalah asisten virtual cerdas bernama {$site_name} AI. 
        Website ini adalah: {$site_name}. 
        Tentang Website: {$site_about}. 
        Tugasmu: Menjawab pertanyaan pengunjung seputar layanan photobooth, tema (Classic/Dramatic), pengiriman foto via WhatsApp (Fonnte), dan galeri dokumentasi. 
        Gaya Bicara: Sopan, profesional, dan informatif. 
        Jika ditanya hal di luar photobooth, jawablah dengan ramah bahwa kamu hanya fokus pada layanan {$site_name}.
        Pengguna bertanya: " . $message;

        $response = $this->_call_gemini($api_key, $prompt);
        echo json_encode(['reply' => $response]);
    }

    // Mengirim Pesan ke Admin (Manusia)
    public function send_to_admin() {
        $chat_user_id = $this->input->post('chat_user_id');
        $name = $this->input->post('name');
        $phone = $this->input->post('phone');
        $message = $this->input->post('message');

        $insert = [
            'session_id' => $chat_user_id, // Store persistent ID in session_id column
            'name' => $name,
            'phone' => $phone,
            'message' => $message,
            'sender' => 'user',
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->db->insert('tb_chats', $insert);
        echo json_encode(['status' => 'success']);
    }

    // Cek Pesan Baru (Untuk Widget di Frontend)
    public function check_new_messages() {
        $chat_user_id = $this->input->get('chat_user_id');
        $chats = $this->db->order_by('created_at', 'ASC')->get_where('tb_chats', ['session_id' => $chat_user_id])->result();
        echo json_encode($chats);
    }

    private function _call_gemini($api_key, $prompt) {
        // 1. Deteksi Model yang tersedia untuk API Key ini secara otomatis
        $model_name = $this->_detect_available_model($api_key);
        
        if(!$model_name) {
            return "Maaf, API Key Anda sepertinya tidak memiliki akses ke model AI manapun atau API Key salah. Silakan periksa kembali di Google AI Studio.";
        }

        $url = "https://generativelanguage.googleapis.com/v1beta/{$model_name}:generateContent?key=" . $api_key;

        $data = [
            "contents" => [
                [
                    "role" => "user",
                    "parts" => [
                        ["text" => $prompt]
                    ]
                ]
            ]
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $result = json_decode($response, true);
        
        if($httpCode == 200 && isset($result['candidates'][0]['content']['parts'][0]['text'])) {
            return $result['candidates'][0]['content']['parts'][0]['text'];
        } else {
            $err = isset($result['error']['message']) ? $result['error']['message'] : 'Terjadi gangguan koneksi.';
            
            // Penjelasan yang lebih ramah jika limit kuota habis
            if(strpos($err, 'quota') !== false) {
                return "Maaf, akun AI Anda sedang mencapai batas limit (Quota Exceeded). Anda bisa mencoba lagi dalam beberapa saat atau gunakan API Key lain yang masih aktif.";
            }

            return "AI sedang sibuk (Model: $model_name). Error: " . $err;
        }
    }

    private function _detect_available_model($api_key) {
        $url = "https://generativelanguage.googleapis.com/v1beta/models?key=" . $api_key;
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if($httpCode != 200) return null;

        $result = json_decode($response, true);
        if(!isset($result['models'])) return null;

        // Urutan prioritas model yang paling stabil dan gratis tier-nya tinggi
        $order = [
            'gemini-1.5-flash', 
            'gemini-1.5-flash-8b',
            'gemini-1.5-pro', 
            'gemini-2.0-flash',
            'gemini-2.5-flash', // Menambah dukungan model terbaru
            'gemini-pro', 
            'gemini-1.0-pro'
        ];

        // Cari yang paling pas sesuai urutan prioritas
        foreach($order as $pref) {
            foreach($result['models'] as $m) {
                if(strpos($m['name'], $pref) !== false && in_array('generateContent', $m['supportedGenerationMethods'])) {
                    return $m['name']; 
                }
            }
        }

        // Cari apa saja yang mengandung kata 'gemini' dan bisa 'generateContent'
        foreach($result['models'] as $m) {
            if(stripos($m['name'], 'gemini') !== false && in_array('generateContent', $m['supportedGenerationMethods'])) {
                return $m['name'];
            }
        }

        return null;
    }

    private function _get_settings() {
        $res = $this->db->get('tb_settings')->result();
        $settings = [];
        foreach($res as $r) {
            $settings[$r->options] = $r->value;
        }
        return $settings;
    }
}
