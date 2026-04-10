<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
        // Ambil Pengaturan Website
        $res = $this->db->get('tb_settings')->result();
        $settings = [];
        foreach($res as $r) {
            $settings[$r->options] = $r->value;
        }
        $data['settings'] = $settings;

        // Ambil Foto Galeri Dokumentasi
        $data['gallery'] = $this->db->order_by('created_at', 'DESC')->get('tb_gallery')->result();

        // Ambil Menu Navigasi Kustom
        $data['menus'] = $this->db->order_by('order_no', 'ASC')->get('tb_menus')->result();

        // Tentukan Template Aktif
        $template = isset($settings['active_template']) ? $settings['active_template'] : 'modern';
        $view_name = "v_landing_" . $template;
        
        // Cek jika file view ada, jika tidak default ke modern
        if(!file_exists(APPPATH . 'views/' . $view_name . '.php')) {
            $view_name = 'v_landing_modern';
        }

		$this->load->view($view_name, $data);
	}

    public function booth()
    {
        $this->load->view('v_booth');
    }

    public function save_photo()
    {
        $img = $this->input->post('image');
        $phone = $this->input->post('phone');
        $name = $this->input->post('name');
        
        if($img) {
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);

            $filename = 'foto_' . date('Ymd_His') . '_' . uniqid() . '.png';
            $file_path = FCPATH . 'uploads/' . $filename;
            
            if(file_put_contents($file_path, $data)) {
                // save to db
                $this->db->insert('tb_photos', array(
                    'filename' => $filename,
                    'nama_user' => $name
                ));
                
                $wa_status = "Not Requested";
                if(!empty($phone)) {
                    // Buat link download otomatis
                    $download_link = base_url('home/download/' . $filename);
                    $wa_status = $this->_send_to_fonnte($download_link, $phone);
                }

                echo json_encode([
                    'status' => 'success', 
                    'filename' => $filename, 
                    'wa_status' => $wa_status
                ]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan file']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Tidak ada gambar']);
        }
    }

    public function download($filename)
    {
        $file_path = FCPATH . 'uploads/' . $filename;
        
        if (file_exists($file_path)) {
            $this->load->helper('download');
            
            // Ambil nama user dari DB untuk jadi nama file download
            $q = $this->db->get_where('tb_photos', ['filename' => $filename])->row();
            
            // Bersihkan nama dari karakter aneh agar aman jadi nama file
            $display_name = "Hasil_Foto";
            if($q && !empty($q->nama_user)) {
                $display_name = preg_replace('/[^A-Za-z0-9_\-]/', '_', $q->nama_user);
            }
            
            $alias_name = $display_name . '.png';
            
            // Gunakan force_download dengan alias
            $data = file_get_contents($file_path);
            force_download($alias_name, $data);
        } else {
            show_404();
        }
    }

    public function view_page($slug)
    {
        // Ambil Pengaturan Website
        $res = $this->db->get('tb_settings')->result();
        $settings = [];
        foreach($res as $r) {
            $settings[$r->options] = $r->value;
        }
        $data['settings'] = $settings;

        // Ambil Data Halaman
        $data['page'] = $this->db->get_where('tb_pages', ['slug' => $slug])->row();
        
        if(!$data['page']) {
            show_404();
        }

        $data['title'] = $data['page']->title;
        $this->load->view('v_page_detail', $data);
    }

    private function _send_to_fonnte($download_link, $phone)
    {
        // Ambil token dari DB Settings
        $setting = $this->db->get_where('tb_settings', ['options' => 'fonnte_token'])->row();
        $token = ($setting) ? $setting->value : $this->config->item('fonnte_token');
        
        // Membersihkan nomor telepon
        $phone = preg_replace('/[^0-9]/', '', $phone); 
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        }

        $curl = curl_init();

        $message = "Halo! Ini adalah hasil foto dari Fotoboot Anda. ✨\n\n";
        $message .= "Klik link di bawah untuk DOWNLOAD foto Anda:\n" . $download_link . "\n\n";
        $message .= "Terima kasih telah menggunakan layanan kami! 📸";

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => array(
                'target' => $phone,
                'message' => $message,
                'delay' => '2',
            ),
            CURLOPT_HTTPHEADER => array(
                "Authorization: $token"
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        
        return $response;
    }

    public function tamu()
    {
        // Ambil Pengaturan Website
        $res = $this->db->get('tb_settings')->result();
        $settings = [];
        foreach($res as $r) {
            $settings[$r->options] = $r->value;
        }
        $data['settings'] = $settings;
        $data['title'] = 'Pendaftaran Tamu';
        $this->load->view('v_tamu_daftar', $data);
    }

    public function daftar_tamu()
    {
        $name = $this->input->post('name');
        $phone = $this->input->post('phone');
        $email = $this->input->post('email');
        $institution = $this->input->post('institution');
        
        // Generate Unique Guest Code
        $guest_code = 'GP-' . strtoupper(substr(md5(time() . $phone), 0, 8));

        $insert = [
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
            'institution' => $institution,
            'guest_code' => $guest_code,
            'status' => 'Waiting'
        ];

        $this->db->insert('tb_guests', $insert);

        // Ambil Pengaturan Website
        $res = $this->db->get('tb_settings')->result();
        $settings = [];
        foreach($res as $r) {
            $settings[$r->options] = $r->value;
        }
        $data['settings'] = $settings;
        $data['guest'] = $this->db->get_where('tb_guests', ['guest_code' => $guest_code])->row();
        $data['title'] = 'Pendaftaran Berhasil';

        $this->load->view('v_tamu_sukses', $data);
    }
}
