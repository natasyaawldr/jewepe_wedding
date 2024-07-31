<?php
// Membatasi akses langsung ke file
defined('BASEPATH') OR exit('No direct script access allowed');

// Mendefinisikan class Beranda yang merupakan turunan dari CI_Controller
class Beranda extends CI_Controller {

    // Konstruktor untuk inisialisasi awal
	public function __construct()
	{
		// Memanggil konstruktor parent dari CI_Controller
		parent::__construct();
		// Memuat database
		$this->load->database();
        // Memuat model 'katalog_model'
        $this->load->model('katalog_model');
		// Memuat model 'pesanan_model'
		$this->load->model('pesanan_model');
		// Memuat helper 'text' untuk fungsi word_limiter()
		$this->load->helper('text');
	} 

    // Method untuk menampilkan halaman utama (beranda)
	public function index()
	{   
		// Membuat array data yang akan dikirim ke view
		$data = array( 
               'title' => 'JeWePe Wedding Organizer',  // Judul halaman
			   'page' => 'landing/beranda',  // Nama halaman untuk view
			   'getAllKatalog' => $this->katalog_model->get_all_katalog_landing()->result()  // Mendapatkan semua data katalog
		);
		// Memuat view dengan data yang telah dibuat
		$this->load->view('landing/templates/sites' ,$data);
	}

    // Method untuk menampilkan detail katalog
	public function detail()  {
		// Mengecek apakah ada parameter 'id' di URL
		if ($this->input->get('id')) {
            // Mengecek apakah data katalog dengan ID tersebut ada
			$cek_data = $this->katalog_model->get_katalog_by_id($this->input->get('id'))->num_rows();
			
            // Jika data ada
			if ($cek_data > 0) {
				// Membuat array data yang akan dikirim ke view
				$data = array(
					'title' => 'JeWePe Wedding Organizer',  // Judul halaman
					'page' => 'landing/detail',  // Nama halaman untuk view
					'katalog' => $this->katalog_model->get_katalog_by_id($this->input->get('id'))->row()  // Mendapatkan data katalog berdasarkan ID
				);
				// Memuat view dengan data yang telah dibuat
				$this->load->view('landing/templates/sites', $data);
			} else {
				// Jika data tidak ada, redirect ke halaman utama
				redirect('/');
			}
		} else {
			// Jika tidak ada parameter 'id', redirect ke halaman utama
			redirect('/');
		}
	}

    // Method untuk memproses pemesanan
	public function pesan() {
		// Mengecek apakah ada data yang dikirim melalui method POST
		if ($this->input->post()) {
            // Mengambil data dari POST
			$post = $this->input->post();
            // Mengecek apakah data pesanan sudah ada berdasarkan ID, email, dan tanggal pernikahan
			$cek_data = $this->pesanan_model->cek_data_pesanan($post['id'], $post['email'], $post['wedding_date'])->num_rows();
		
            // Jika data pesanan belum ada
			if ($cek_data == 0) {
				// Mengambil waktu sekarang
				$datetime = date("Y-m-d H:i:s");
				// Mengambil nomor telepon dari data POST
				$phone_number = $post['phone_number'];
				// Membuat array data pesanan yang akan disimpan
				$data = array(
					'catalogue_id' => $post['id'],
					'name' => $post['name'],
					'email' => $post['email'],
					'phone_number' => $phone_number,
					'wedding_date' => $post['wedding_date'],
					'status' => 'requested',
					'created_at' => $datetime
				);
		
				// Menyimpan data pesanan ke database
				$insert = $this->pesanan_model->insert($data);
				if ($insert) {
					// Jika berhasil disimpan, set flash data untuk pesan sukses
					$this->session->set_flashdata('message', 
						'<div class="alert alert-success alert-dismissible fade show" role="alert">
							<strong>Success</strong> Terimakasih, permintaan pesanan anda telah kami terima. Silahkan tunggu konfirmasi kami melalui email.
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						</div>'
					);
					// Redirect ke halaman detail katalog dengan ID yang dipesan
					redirect('Beranda/detail?id=' . $post['id']);
				} else {
					// Jika gagal disimpan, set flash data untuk pesan error
					$this->session->set_flashdata('message', 
						'<div class="alert alert-danger alert-dismissible fade show" role="alert">
							<strong>Error</strong> Maaf, Permintaan pesanan Gagal!
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						</div>'
					);
					// Redirect ke halaman detail katalog dengan ID yang dipesan
					redirect('Beranda/detail?id=' . $post['id']);
				}
			} else {
				// Jika data pesanan sudah ada, set flash data untuk pesan peringatan
				$this->session->set_flashdata('message', 
					'<div class="alert alert-warning alert-dismissible fade show" role="alert">
						<strong>Notice</strong> Maaf, Paket dan tanggal pernikahan sudah anda pesan sebelumnya, silahkan tunggu konfirmasi dari kami.
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>'
				);
				// Redirect ke halaman detail katalog dengan ID yang dipesan
				redirect('Beranda/detail?id=' . $post['id']);
			}
		} else {
			// Jika tidak ada data POST, redirect ke halaman utama
			redirect('Beranda');
		}
	}
}
