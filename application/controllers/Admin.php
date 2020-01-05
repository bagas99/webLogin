<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller 
{
    // start fungsi user access
    public function __construct()   //fungsi ini dijalankan ketika pertama kalli kontrol ini dijalankan
    {
        parent::__construct();
        // if(!$this->session->userdata('email')) {            //jika TIDAK ada sessionnya (login), maka di redirect ke halaman login (auth)
        //     redirect('auth');
        // }
        is_logged_in();     //membuat fungsi helper (namanya bebas). tujuannya untuk cek sudah login atau belum, dan role_id nya apa
                            //setelah buat fungsi, buat helpaer di folder 'helpers'
    }

    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(); //digunakan mengambil data dari user berdasarkan email yang ada di session
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer');
    }

    public function role()
    {
        $data['title'] = 'Role';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(); //digunakan mengambil data dari user berdasarkan email yang ada di session
        
        $data['role'] = $this->db->get('user_role')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role', $data);
        $this->load->view('templates/footer');
    }

    public function roleAccess($role_id) //(1)
    {
        $data['title'] = 'Role Access';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(); //digunakan mengambil data dari user berdasarkan email yang ada di session
        
        $data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array(); //select * from user_role where id = role_id (1)

        $this->db->where('id !=', 1);
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role-access', $data);
        $this->load->view('templates/footer');
    }

    public function changeAccess()
    {
        $menu_id = $this->input->post('menuId'); //diambil dari fungsi ajax pada footer.php (line 61, dan 62)
        $role_id = $this->input->post('roleId');

        //query
        $data = [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ];

        $result = $this->db->get_where('user_access_menu', $data);

        if($result->num_rows() < 1) {
            $this->db->insert('user_access_menu', $data);
        } else {
            $this->db->delete('user_access_menu', $data);
        }

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Access Changed!</div>');
    }

}