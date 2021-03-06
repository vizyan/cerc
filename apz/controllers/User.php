<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

  public function __construct(){
    parent::__construct();
    $this->cekLogin();
    $this->load->model('user_model');
  }

  private function cekLogin(){
    if(!$this->session->userdata('login')){
      redirect(site_url('login'));
    }
  }

  public function index(){
    $this->cekLogin();
    
    $this->load->model('event_model');
    $data['events'] = $this->event_model->getEvent();

    $data['view_name'] = 'home';
    $this->load->view('user/index_view', $data);
  }

  public function add_event(){
    $this->cekLogin();

    if($this->input->post('tambah')){
      $this->load->model('event_model');

      if($this->event_model->add()){
        $this->session->set_flashdata('msg', 'Event berhasil dimasukkan');
        $this->session->set_flashdata('type', 'success');
      }
      else{
        $this->session->set_flashdata('msg', 'Event gagal dimasukkan');
        $this->session->set_flashdata('type', 'danger');
      }

      redirect(site_url('u'));
    }
    else {
      $data['view_name'] = 'add_event';
      $this->load->view('user/index_view', $data);
    }
  }

  public function edit_event($id){
    $this->cekLogin();

    $this->load->model('event_model');
    
    if($this->input->post('update')){
      if($this->event_model->update($id)){
        $this->session->set_flashdata('msg', 'Event berhasil diupdate');
        $this->session->set_flashdata('type', 'success');
      }
      else{
        $this->session->set_flashdata('msg', 'Event gagal diupdate');
        $this->session->set_flashdata('type', 'danger');
      }

      redirect(site_url('u'));
    }
    else {
      if($this->event_model->checkId($id)->num_rows() > 0){
        $data['event'] = $this->event_model->getEventById($id);

        $data['view_name'] = 'edit_event';
        $this->load->view('user/index_view', $data);
      }
      else {
        // tidak ada id tersebut
        show_404();
      }
    }
  }

  public function hapus_event($id = null){
    $this->cekLogin();

    if($id === null){
      show_404();
    }
    else {
      $this->load->model('event_model');

      if($this->event_model->checkId($id)->num_rows() > 0){
        if($this->event_model->delete($id)){
          $this->session->set_flashdata('msg', 'Event berhasil dihapus');
          $this->session->set_flashdata('type', 'success');
        }
        else {
          $this->session->set_flashdata('msg', 'Event gagal dihapus');
          $this->session->set_flashdata('type', 'danger');
        }
      }
      else {
        show_404();
      }

      redirect(site_url('u'));
    }
  }

  public function user_home(){
    $this->cekLogin();
    
    $data['users'] = $this->user_model->getUser();

    $data['view_name'] = 'user_home';
    $this->load->view('user/index_view', $data);
  }

  public function add_user(){
    $this->cekLogin();

    if($this->input->post('tambah')){
      $cek_user = $this->user_model->checkUserByUsername($this->input->post('username'));

      if($cek_user->num_rows() > 0){
        $this->session->set_flashdata('msg', 'Username sudah terpakai');
        $this->session->set_flashdata('type', 'warning');
      }
      else {
        $this->user_model->add();
        $this->session->set_flashdata('msg', 'User berhasil ditambah');
        $this->session->set_flashdata('type', 'success');
      }
      
      redirect(site_url('u/user'));
    }
    else {
      $data['view_name'] = 'add_user';
      $this->load->view('user/index_view', $data);
    }
  }

  public function edit_user($id_user){
    $this->cekLogin();

    if($this->input->post('simpan')){
      $cek_user = $this->user_model->checkUserByUsername($this->input->post('username'));

      $this->user_model->update($id_user);
      $this->session->set_flashdata('msg', 'User '. $this->input->post('username') .' berhasil di-update');
      $this->session->set_flashdata('type', 'success');

      redirect(site_url('u/user'));
    }
    else {
      $data['user'] = $this->user_model->getUserById($id_user);

      $data['view_name'] = 'edit_user';
      $this->load->view('user/index_view', $data);
    }

  }

  public function hapus_user($id_user){
    $this->cekLogin();

    $cek_user = $this->user_model->checkUserById($id_user);
    
    if($cek_user->num_rows() == 0){
      $this->session->set_flashdata('msg', 'User tidak ditemukan');
      $this->session->set_flashdata('type', 'danger');
    }
    else {
      $user = $this->user_model->getUserById($id_user);

      $this->user_model->delete($id_user);
      $this->session->set_flashdata('msg', 'User '. $user->nama .' berhasil dihapus');
      $this->session->set_flashdata('type', 'success');
    }

    redirect(site_url('u/user'));
  }

  public function reset_pass_user($id_user){
    $this->cekLogin();

    $cek_user = $this->user_model->checkUserById($id_user);

    if($cek_user->num_rows() == 0){
      $this->session->set_flashdata('msg', 'User tidak ditemukan');
      $this->session->set_flashdata('type', 'danger');
    }
    else {
      $user = $this->user_model->getUserById($id_user);

      $this->user_model->updateUserPass($id_user);
      $this->session->set_flashdata('msg', 'Password '. $user->nama .' berhasil direset : 12345678');
      $this->session->set_flashdata('type', 'success');
    }

    redirect(site_url('u/user'));
  }

  public function project_home(){
    $this->cekLogin();
    
    $this->load->model('project_model');
    $data['projects'] = $this->project_model->getProject();

    $data['view_name'] = 'project_home';
    $this->load->view('user/index_view', $data);
  }

  public function add_project(){
    $this->cekLogin();
    $this->load->model('project_model');

    if($this->input->post('tambah')){
      $this->project_model->add();
      $this->session->set_flashdata('msg', 'Proyek berhasil diupload');
      $this->session->set_flashdata('type', 'success');
      
      redirect(site_url('u/project'));
    }
    else {
      $data['view_name'] = 'add_project';
      $data['kategori']  = $this->project_model->getKategori();
      $this->load->view('user/index_view', $data);
    }
  }

  public function edit_project($id_project){
    $this->cekLogin();
    $this->load->model('project_model');

    $cek_project = $this->project_model->checkProject($id_project);
    if($cek_project->num_rows() == 0){
      $this->session->set_flashdata('msg', 'Proyek tidak ditemukan');
      $this->session->set_flashdata('type', 'danger');

      redirect(site_url('u/project'));
    }
    else {
      if($this->input->post('simpan')){
        $this->project_model->update($id_project);

        $project = $this->project_model->getProjectById($id_project);

        $this->session->set_flashdata('msg', 'Proyek '. $project->nama .' berhasil disimpan');
        $this->session->set_flashdata('type', 'success');

        redirect(site_url('u/project'));
      }
      else {
        $data['view_name'] = 'edit_project';
        $data['project']   = $this->project_model->getProjectById($id_project);
        $data['kategori']  = $this->project_model->getKategori();
        $this->load->view('user/index_view', $data);
      }
    }
  }

  public function hapus_project($id_project){
    $this->cekLogin();
    $this->load->model('project_model');

    $cek_project = $this->project_model->checkProject($id_project);
    if($cek_project->num_rows() == 0){
      $this->session->set_flashdata('msg', 'Proyek tidak ditemukan');
      $this->session->set_flashdata('type', 'danger');
    }
    else {
      $project = $this->project_model->getProjectById($id_project);
      
      $this->project_model->delete($id_project);

      $this->session->set_flashdata('msg', 'Proyek '. $project->nama .' berhasil dihapus');
      $this->session->set_flashdata('type', 'success');
    }

    redirect(site_url('u/project'));
  }

  public function kategori_project(){
    $this->cekLogin();
    
    $this->load->model('project_model');
    $data['kategori'] = $this->project_model->getKategori();

    $data['view_name'] = 'kategori_project_home';
    $this->load->view('user/index_view', $data);
  }

  public function add_kategori(){
    $this->cekLogin();
    $this->load->model('project_model');

    if($this->input->post('tambah')){
      $this->project_model->addKategori();
      $this->session->set_flashdata('msg', 'Kategori berhasil ditambahkan');
      $this->session->set_flashdata('type', 'success');
      
      redirect(site_url('u/kategori-project'));
    }
    else {
      $data['view_name'] = 'add_kategori';
      $this->load->view('user/index_view', $data);
    }
  }

  public function edit_kategori($id_kategori){
    $this->cekLogin();
    $this->load->model('project_model');

    $cek_kategori = $this->project_model->checkKategori($id_kategori);
    if($cek_kategori->num_rows() == 0){
      $this->session->set_flashdata('msg', 'Kategori tidak ditemukan');
      $this->session->set_flashdata('type', 'danger');

      redirect(site_url('u/kategori-project'));
    }
    else {
      if($this->input->post('simpan')){
        $this->project_model->updateKategori($id_kategori);

        $kategori = $this->project_model->getKategoriById($id_kategori);

        $this->session->set_flashdata('msg', 'Kategori '. $kategori->nama .' berhasil disimpan');
        $this->session->set_flashdata('type', 'success');

        redirect(site_url('u/kategori-project'));
      }
      else {
        $data['view_name'] = 'edit_kategori';
        $data['kategori']  = $this->project_model->getKategoriById($id_kategori);
        $this->load->view('user/index_view', $data);
      }
    }
  }

  public function request(){
    $this->cekLogin();
    $this->load->model('pengajuan_model');
    
    $data['requests'] = $this->pengajuan_model->getPengajuan();

    $data['view_name'] = 'pengajuan_home';
    $this->load->view('user/index_view', $data);
  }

  public function request_detail($id_pengajuan){
    $this->cekLogin();
    $this->load->model('pengajuan_model');

    $cek_pengajuan = $this->pengajuan_model->check($id_pengajuan);
    if($cek_pengajuan->num_rows() == 0){
      $this->session->set_flashdata('msg', 'Request tidak ditemukan');
      $this->session->set_flashdata('type', 'danger');

      redirect(site_url('u/request'));
    }
    else {
      $data['request'] = $this->pengajuan_model->getPengajuanById($id_pengajuan);

      $data['view_name'] = 'detail_pengajuan';
      $this->load->view('user/index_view', $data);
    }

  }

}