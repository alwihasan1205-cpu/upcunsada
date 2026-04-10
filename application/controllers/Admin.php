<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        if(!$this->session->userdata('logged_in') && $this->router->fetch_method() != 'login') {
            redirect('admin/login');
        }
    }

	public function index()
	{
        $data['title'] = 'Dashboard';
        $data['total_photos'] = $this->db->count_all('tb_photos');
        $data['total_gallery'] = $this->db->count_all('tb_gallery');
        $data['recent_photos'] = $this->db->order_by('created_at', 'DESC')->limit(5)->get('tb_photos')->result();
        
        // Data untuk Chart Dashboard
        $chart_query = $this->db->query("SELECT DATE(created_at) as date, COUNT(*) as count FROM tb_photos GROUP BY DATE(created_at) ORDER BY date DESC LIMIT 7");
        $data['chart_data'] = array_reverse($chart_query->result());

		$this->load->view('admin/layout/v_header', $data);
		$this->load->view('admin/v_dashboard', $data);
		$this->load->view('admin/layout/v_footer');
	}

    public function laporan()
    {
        $data['title'] = 'Laporan Statistik Harian';
        
        // Ambil data statistik harian
        $query = $this->db->query("SELECT DATE(created_at) as date, COUNT(*) as total FROM tb_photos GROUP BY DATE(created_at) ORDER BY date DESC");
        $data['stats'] = $query->result();
        
		$this->load->view('admin/layout/v_header', $data);
		$this->load->view('admin/v_laporan', $data);
		$this->load->view('admin/layout/v_footer');
    }

    public function live_chat()
    {
        $data['title'] = 'Live Chat Pelanggan';
        // Ambil daftar user unik yang chat (group by session_id)
        $data['sessions'] = $this->db->query("SELECT session_id, name, phone, MAX(created_at) as last_chat FROM tb_chats GROUP BY session_id ORDER BY last_chat DESC")->result();
        
		$this->load->view('admin/layout/v_header', $data);
		$this->load->view('admin/v_live_chat', $data);
		$this->load->view('admin/layout/v_footer');
    }

    public function get_chat_history($session_id)
    {
        $chats = $this->db->order_by('created_at', 'ASC')->get_where('tb_chats', ['session_id' => $session_id])->result();
        // Mark as read
        $this->db->where('session_id', $session_id)->update('tb_chats', ['is_read' => 1]);
        echo json_encode($chats);
    }

    public function send_chat_reply()
    {
        $session_id = $this->input->post('session_id');
        $message = $this->input->post('message');
        
        $insert = [
            'session_id' => $session_id,
            'message' => $message,
            'sender' => 'admin',
            'is_read' => 1
        ];
        $this->db->insert('tb_chats', $insert);
        echo json_encode(['status' => 'success']);
    }

    public function menus()
    {
        $data['title'] = 'Manajemen Navigasi';
        $data['menus'] = $this->db->order_by('order_no', 'ASC')->get('tb_menus')->result();
        $this->load->view('admin/layout/v_header', $data);
        $this->load->view('admin/v_menus', $data);
        $this->load->view('admin/layout/v_footer');
    }

    public function save_menu()
    {
        $data = [
            'name' => $this->input->post('name'),
            'url' => $this->input->post('url'),
            'order_no' => $this->input->post('order_no')
        ];
        if($id = $this->input->post('id')) {
            $this->db->where('id', $id)->update('tb_menus', $data);
        } else {
            $this->db->insert('tb_menus', $data);
        }
        redirect('admin/menus');
    }


    public function delete_menu($id)
    {
        $this->db->delete('tb_menus', ['id' => $id]);
        redirect('admin/menus');
    }

    public function pages()
    {
        $data['title'] = 'Manajemen Halaman';
        $data['pages'] = $this->db->order_by('created_at', 'DESC')->get('tb_pages')->result();
        $this->load->view('admin/layout/v_header', $data);
        $this->load->view('admin/v_pages', $data);
        $this->load->view('admin/layout/v_footer');
    }

    public function add_page()
    {
        $data['title'] = 'Tambah Halaman Baru';
        $this->load->view('admin/layout/v_header', $data);
        $this->load->view('admin/v_pages_form', $data);
        $this->load->view('admin/layout/v_footer');
    }

    public function edit_page($id)
    {
        $data['title'] = 'Edit Halaman';
        $data['page'] = $this->db->get_where('tb_pages', ['id' => $id])->row();
        $this->load->view('admin/layout/v_header', $data);
        $this->load->view('admin/v_pages_form', $data);
        $this->load->view('admin/layout/v_footer');
    }

    public function save_page()
    {
        $id = $this->input->post('id');
        $data = [
            'title' => $this->input->post('title'),
            'slug' => $this->input->post('slug'),
            'content' => $this->input->post('content')
        ];

        if($id) {
            $this->db->where('id', $id)->update('tb_pages', $data);
        } else {
            $this->db->insert('tb_pages', $data);
        }
        redirect('admin/pages');
    }

    public function delete_page($id)
    {
        $this->db->where('id', $id)->delete('tb_pages');
        redirect('admin/pages');
    }

    // --- MANAJEMEN TAMU ---
    public function tamu()
    {
        $data['title'] = 'Manajemen Tamu';
        $data['guests'] = $this->db->order_by('created_at', 'DESC')->get('tb_guests')->result();
        $this->load->view('admin/layout/v_header', $data);
        $this->load->view('admin/v_tamu_list', $data);
        $this->load->view('admin/layout/v_footer');
    }

    public function scan_tamu()
    {
        $data['title'] = 'Scan Kehadiran Tamu';
        $this->load->view('admin/layout/v_header', $data);
        $this->load->view('admin/v_tamu_scan', $data);
        $this->load->view('admin/layout/v_footer');
    }

    public function konfirmasi_kehadiran()
    {
        $code = $this->input->post('code');
        $guest = $this->db->get_where('tb_guests', ['guest_code' => $code])->row();

        if($guest) {
            if($guest->status == 'Hadir') {
                echo json_encode(['status' => 'info', 'message' => 'Tamu atas nama '.$guest->name.' sudah absen sebelumnya.']);
            } else {
                $this->db->where('id', $guest->id)->update('tb_guests', ['status' => 'Hadir']);
                echo json_encode(['status' => 'success', 'message' => 'Berhasil! Selamat Datang '.$guest->name]);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Kode Barcode Tidak Valid!']);
        }
    }

    public function export_tamu()
    {
        $filename = "Daftar_Tamu_".date('Ymd').".xls";
        header("Content-Type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        
        $data = $this->db->order_by('created_at', 'DESC')->get('tb_guests')->result();
        
        echo "<table>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Instansi</th>
                    <th>Kode</th>
                    <th>Status</th>
                    <th>Mendaftar Pada</th>
                </tr>";
        $no = 1;
        foreach($data as $d) {
            echo "<tr>
                    <td>".$no++."</td>
                    <td>".$d->name."</td>
                    <td>'".$d->phone."'</td>
                    <td>".$d->email."</td>
                    <td>".$d->institution."</td>
                    <td>".$d->guest_code."</td>
                    <td>".$d->status."</td>
                    <td>".$d->created_at."</td>
                </tr>";
        }
        echo "</table>";
    }

    public function export_laporan()
    {
        $filename = "Laporan_Harian_".date('Ymd').".xls";
        header("Content-Type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        
        $query = $this->db->query("SELECT DATE(created_at) as date, COUNT(*) as total FROM tb_photos GROUP BY DATE(created_at) ORDER BY date DESC");
        $stats = $query->result();
        
        echo "<table>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Total Foto Diambil</th>
                </tr>";
        $no = 1;
        foreach($stats as $s) {
            echo "<tr>
                    <td>".$no++."</td>
                    <td>".$s->date."</td>
                    <td>".$s->total."</td>
                </tr>";
        }
        echo "</table>";
    }

    public function login()
    {
        if($_POST) {
            $user = $this->input->post('username');
            $pass = md5($this->input->post('password'));
            $check = $this->db->get_where('tb_users', ['username'=>$user, 'password'=>$pass])->row();
            
            if($check) {
                $this->session->set_userdata('logged_in', true);
                redirect('admin');
            } else {
                $this->session->set_flashdata('error', 'Username atau Password salah');
                redirect('admin/login');
            }
        }
        $this->load->view('admin/v_login');
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('admin/login');
    }

    public function hasil_foto()
    {
        $data['title'] = 'Hasil Foto Photobox';
        $data['photos'] = $this->db->order_by('created_at', 'DESC')->get('tb_photos')->result();
        
		$this->load->view('admin/layout/v_header', $data);
		$this->load->view('admin/v_hasil_foto', $data);
		$this->load->view('admin/layout/v_footer');
    }

    public function delete_foto($id)
    {
        $photo = $this->db->get_where('tb_photos', ['id'=>$id])->row();
        if($photo) {
            @unlink(FCPATH . 'uploads/' . $photo->filename);
            $this->db->delete('tb_photos', ['id'=>$id]);
        }
        $this->session->set_flashdata('success', 'Foto berhasil dihapus');
        redirect('admin/hasil_foto');
    }

    public function gallery()
    {
        $data['title'] = 'Galeri Dokumentasi';
        $data['gallery'] = $this->db->order_by('created_at', 'DESC')->get('tb_gallery')->result();

        if($_FILES && !empty($_FILES['photo']['name'])) {
            $config['upload_path']      = './uploads/gallery/';
            $config['allowed_types']    = 'gif|jpg|png|jpeg';
            $config['file_name']        = 'gallery_'.time();

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('photo')) {
                $uploadData = $this->upload->data();
                $filename = $uploadData['file_name'];
                
                $insert = array(
                    'filename' => $filename,
                    'caption'  => $this->input->post('caption')
                );
                $this->db->insert('tb_gallery', $insert);
                $this->session->set_flashdata('success', 'Foto galeri berhasil ditambahkan');
                redirect('admin/gallery');
            } else {
                $data['error'] = $this->upload->display_errors();
            }
        }
        
		$this->load->view('admin/layout/v_header', $data);
		$this->load->view('admin/v_gallery', $data);
		$this->load->view('admin/layout/v_footer');
    }

    public function delete_gallery($id)
    {
        $item = $this->db->get_where('tb_gallery', ['id'=>$id])->row();
        if($item) {
            @unlink(FCPATH . 'uploads/gallery/' . $item->filename);
            $this->db->delete('tb_gallery', ['id'=>$id]);
        }
        $this->session->set_flashdata('success', 'Item galeri berhasil dihapus');
        redirect('admin/gallery');
    }

    public function settings()
    {
        $data['title'] = 'Pengaturan Website';
        
        if($_POST) {
            $settings = $this->input->post('settings');
            
            // Handle Logo Upload
            if(!empty($_FILES['logo']['name'])) {
                $config['upload_path']      = './uploads/logo/';
                $config['allowed_types']    = 'gif|jpg|png|jpeg';
                $config['file_name']        = 'app_logo_'.time();
                
                $this->load->library('upload', $config);
                
                if ($this->upload->do_upload('logo')) {
                    $uploadData = $this->upload->data();
                    $settings['site_logo'] = $uploadData['file_name'];
                }
            }

            foreach($settings as $key => $val) {
                // Cek apakah opsi sudah ada
                $check = $this->db->get_where('tb_settings', ['options' => $key])->row();
                if($check) {
                    $this->db->where('options', $key)->update('tb_settings', ['value' => $val]);
                } else {
                    $this->db->insert('tb_settings', ['groups' => 'site', 'options' => $key, 'value' => $val]);
                }
            }
            $this->session->set_flashdata('success', 'Pengaturan berhasil diperbarui');
            redirect('admin/settings');
        }

        $res = $this->db->get('tb_settings')->result();
        $settings = [];
        foreach($res as $r) {
            $settings[$r->options] = $r->value;
        }
        $data['settings'] = $settings;

		$this->load->view('admin/layout/v_header', $data);
		$this->load->view('admin/v_settings', $data);
		$this->load->view('admin/layout/v_footer');
    }
}
