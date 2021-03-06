<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Club extends CI_Controller {
  public function __construct(){
    parent::__construct();
    $this->load->model('club_model');
  }

  public function index(){
    redirect(site_url());
  }

  private function cekLogin(){
    if(!$this->session->userdata('login_club')){
      redirect(site_url('login'));
    }
  }

  private function generateAlamat(){
    $alamat = "";
    $n = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
    for($i=0;$i<20;$i++){
      $alamat .= $n[rand(0, strlen($n) - 1)];
    }

    return 'cerc-club-'.$alamat;
  }

  public function profile($club_slug){
    $data['club']   = $this->club_model->get($club_slug);
    $data['materi'] = $this->club_model->getMateriByClubSlug($club_slug);
    $data['post']   = $this->club_model->getPostByClubSlug($club_slug);

    $data['view_name'] = 'profile';
    $this->load->view('club/home_view', $data);
  }

  public function profile_edit(){
    $this->cekLogin();

    if($this->input->post('simpan')){
      // cek apakah ada file upload
      if(!empty($_FILES['foto']['name'])){
        $alamat = $this->generateAlamat();

        $config['upload_path']   = './uploads/club/photo';
        $config['file_name']     = $alamat;
        $config['allowed_types'] = 'jpeg|jpg|png';
        $config['max_size']      = 500;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('foto')){
          $message = '<p>'. $this->upload->display_errors() .'</p>';
          $this->session->set_flashdata('msg', $message);
          $this->session->set_flashdata('type', 'danger');
        }
        else {
          $data = $this->upload->data();

          $this->club_model->update($this->session->userdata('club_slug'), $data['file_name']);

          $this->session->set_flashdata('msg', 'Profil berhasil disimpan');
          $this->session->set_flashdata('type', 'success');
        }
      }
      else {
        $this->club_model->update($this->session->userdata('club_slug'), NULL);

        $this->session->set_flashdata('msg', 'Profil berhasil disimpan');
        $this->session->set_flashdata('type', 'success');
      }

      redirect(site_url('c'));
    }
    else {
      $data['view_name'] = 'home_profile';
      $data['club'] = $this->club_model->get($this->session->userdata('club_slug'));
      $this->load->view('club/index_view', $data);
    }
  }

  public function request(){
    $this->cekLogin();
    $this->load->model('pengajuan_model');
    
    $data['requests'] = $this->pengajuan_model->getPengajuan();

    $data['view_name'] = 'pengajuan_home';
    $this->load->view('club/index_view', $data);
  }

  public function request_detail($id_pengajuan){
    $this->cekLogin();
    $this->load->model('pengajuan_model');

    $cek_pengajuan = $this->pengajuan_model->check($id_pengajuan);
    if($cek_pengajuan->num_rows() == 0){
      $this->session->set_flashdata('msg', 'Request tidak ditemukan');
      $this->session->set_flashdata('type', 'danger');

      redirect(site_url('c/request'));
    }
    else {
      $data['request'] = $this->pengajuan_model->getPengajuanById($id_pengajuan);
      $data['riwayat'] = $this->pengajuan_model->getRiwayatById($id_pengajuan);

      $data['view_name'] = 'detail_pengajuan';
      $this->load->view('club/index_view', $data);
    }
  }

  public function konfirmasi_request($action, $id_pengajuan){
    $this->cekLogin();

    if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] == site_url('c/request/'.$id_pengajuan)){
      $this->load->model('pengajuan_model');
      $cek = $this->pengajuan_model->check($id_pengajuan);
      if($cek > 0){
        switch($action){
          case 'tolak_request': $this->tolak_request($id_pengajuan); break;
          case 'terima_request': $this->terima_request($id_pengajuan); break;
          case 'selesai_request': $this->selesai_request($id_pengajuan); break;
        }
      }
    }
    
    $this->session->set_flashdata('msg', 'Request tidak ditemukan');
    $this->session->set_flashdata('type', 'danger');
    redirect(site_url('c/request'));
  }

  private function tolak_request($id_pengajuan){
    $this->pengajuan_model->updateStatusTolak($id_pengajuan);

    $this->session->set_flashdata('msg', 'Request berhasil ditolak');
    $this->session->set_flashdata('type', 'success');
    redirect(site_url('c/request/'.$id_pengajuan));
  }

  private function terima_request($id_pengajuan){
    $this->pengajuan_model->updateStatusTerima($id_pengajuan);

    $this->session->set_flashdata('msg', 'Request berhasil diterima');
    $this->session->set_flashdata('type', 'success');
    redirect(site_url('c/request/'.$id_pengajuan));
  }

  private function selesai_request($id_pengajuan){
    $req = $this->pengajuan_model->getPengajuanById($id_pengajuan);
    if($req->status == 'Y'){
      $this->pengajuan_model->updateStatusSelesai($id_pengajuan);
      $this->session->set_flashdata('msg', 'Request ditandai selesai');
      $this->session->set_flashdata('type', 'success');
      redirect(site_url('c/request'));
    }
    else {
      $this->session->set_flashdata('msg', 'Request tidak ditemukan');
      $this->session->set_flashdata('type', 'danger');
      redirect(site_url('c/request'));
    }
  }

  public function materi(){
    $this->cekLogin();

    $data['materi'] = $this->club_model->getMateriByClub($this->session->userdata('level'));
    $data['view_name'] = 'home_materi';
    $this->load->view('club/index_view', $data);
  }

  public function add_materi(){
    $this->cekLogin();

    if($this->input->post('tambah')){
      if(!empty($_FILES['file_content']['name'])){
        $config['upload_path']   = './uploads/club/materi/';
        $config['allowed_types'] = 'pdf|docx|doc|xls|xlsx|ppt|pptx|zip|rar';
        $config['max_size']      = 3000;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('file_content')){
          $message = '<p>'. $this->upload->display_errors() .'</p>';
          $this->session->set_flashdata('msg', $message);
          $this->session->set_flashdata('type', 'danger');

          redirect(site_url('c/materi'));
        }
        else {
          $data = $this->upload->data();
          $this->club_model->addMateri($data['file_name']);
        }
      }
      else {
        $this->club_model->addMateri(NULL);
      }

      $this->session->set_flashdata('msg', 'Materi berhasil diupload');
      $this->session->set_flashdata('type', 'success');
      redirect(site_url('c/materi'));
    }
    else {
      $data['view_name'] = 'add_materi';
      $this->load->view('club/index_view', $data);
    }
  }

  public function edit_materi($id_materi){
    $this->cekLogin();

    $cek_materi = $this->club_model->checkMateriById($id_materi);
    if($cek_materi->num_rows() == 0){
      $this->session->set_flashdata('msg', 'Materi tidak ditemukan');
      $this->session->set_flashdata('type', 'danger');
      redirect(site_url('c/materi'));
    }
    else {
      $materi = $this->club_model->getMateriById($id_materi);

      if($materi->id_club != $this->session->userdata('level')){
        $this->session->set_flashdata('msg', 'Materi tidak ditemukan');
        $this->session->set_flashdata('type', 'danger');
        redirect(site_url('c/materi'));
      }
      else {
        /**
          *
          * Ada materi
          *
          */

        if($this->input->post('simpan')){
          if(!empty($_FILES['file_content']['name'])){
            $config['upload_path']   = './uploads/club/materi/';
            $config['allowed_types'] = 'pdf|docx|doc|xls|xlsx|ppt|pptx|zip|rar';
            $config['max_size']      = 3000;

            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload('file_content')){
              $message = '<p>'. $this->upload->display_errors() .'</p>';
              $this->session->set_flashdata('msg', $message);
              $this->session->set_flashdata('type', 'danger');

              redirect(site_url('c/materi'));
            }
            else {
              $data = $this->upload->data();
              $this->club_model->updateMateri($id_materi, $data['file_name']);
            }
          }
          else {
            $this->club_model->updateMateri($id_materi, null);
          }

          $this->session->set_flashdata('msg', 'Materi berhasil disimpan');
          $this->session->set_flashdata('type', 'success');

          redirect(site_url('c/materi'));
        }
        else {
          $data['materi'] = $materi;
          $data['view_name'] = 'edit_materi';
          $this->load->view('club/index_view', $data);
        }
      }
    }
  }

  public function hapus_materi($id_materi){
    $this->cekLogin();
    
    $cek_materi = $this->club_model->checkMateriById($id_materi);
    if($cek_materi->num_rows() == 0){
      $this->session->set_flashdata('msg', 'Materi tidak ditemukan');
      $this->session->set_flashdata('type', 'danger');
      redirect(site_url('c/materi'));
    }
    else {
      $materi = $this->club_model->getMateriById($id_materi);

      if($materi->id_club != $this->session->userdata('level')){
        $this->session->set_flashdata('msg', 'Materi tidak ditemukan');
        $this->session->set_flashdata('type', 'danger');
      }
      else {
        $this->club_model->deleteMateri($id_materi);

        $this->session->set_flashdata('msg', 'Materi berhasil dihapus');
        $this->session->set_flashdata('type', 'success');
      }

      redirect(site_url('c/materi'));
    }
  }

  public function materi_detail($slug_materi){
    $materi = $this->club_model->checkMateriBySlug($slug_materi);
    if($materi->num_rows() == 0){
      show_404();
    }
    else {
      $data['materi'] = $materi->row();
      $data['view_name'] = 'detail_materi';
      $this->load->view('club/home_view', $data);
    }
  }

  public function post(){
    $this->cekLogin();

    $data['post'] = $this->club_model->getPost();

    $data['view_name'] = 'home_post';
    $this->load->view('club/index_view', $data);
  }

  public function add_post(){
    $this->cekLogin();

    if($this->input->post('tambah_post')){
      if(!empty($_FILES['file_content']['name'])){
        $alamat = $this->generateAlamat();

        $config['upload_path']   = './uploads/club/post';
        $config['allowed_types'] = 'jpeg|jpg|png';
        $config['allowed_types'] = 'jpg';
        $config['file_name']     = $alamat;
        $config['max_size']      = 800;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('file_content')){
          $message = $this->upload->display_errors();
          $this->session->set_flashdata('msg', $message);
          $this->session->set_flashdata('type', 'danger');

          redirect(site_url('c/post'));
        }
        else {
          $data = $this->upload->data();
          $this->club_model->addPost($data['file_name']);
        }
      }
      else {
        $this->club_model->addPost(NULL);
      }

      $this->session->set_flashdata('msg', 'Post berhasil diupload');
      $this->session->set_flashdata('type', 'success');
      redirect(site_url('c/post'));
    }
    else {
      $data['view_name'] = 'add_post';
      $this->load->view('club/index_view', $data);
    }
  }

  public function edit_post($id_post){
    $this->cekLogin();

    $data['post'] = $this->club_model->getPostById($id_post);

    if($data['post'] == NULL){
      $this->session->set_flashdata('msg', 'Post tidak ditemukan');
      $this->session->set_flashdata('type', 'danger');
      redirect(site_url('c/post'));
    }
    else {
      /**
        * Ada post
        *
        */

      if($data['post']->id_club != $this->session->userdata('level')){
        $this->session->set_flashdata('msg', 'Post tidak ditemukan');
        $this->session->set_flashdata('type', 'danger');
        redirect(site_url('c/post'));
      }
      else {
        if($this->input->post('edit_post')){
          if(!empty($_FILES['file_content']['name'])){
            $alamat = $this->generateAlamat();

            $config['upload_path']   = './uploads/club/post';
            $config['allowed_types'] = 'jpeg|jpg|png';
            $config['allowed_types'] = 'jpg';
            $config['file_name']     = $alamat;
            $config['max_size']      = 800;

            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload('file_content')){
              $message = $this->upload->display_errors();
              $this->session->set_flashdata('msg', $message);
              $this->session->set_flashdata('type', 'danger');

              redirect(site_url('c/post'));
            }
            else {
              $data = $this->upload->data();
              $this->club_model->updatePost($id_post, $data['file_name']);
            }
          }
          else {
            $this->club_model->updatePost($id_post, NULL);
          }

          $this->session->set_flashdata('msg', 'Post berhasil disimpan');
          $this->session->set_flashdata('type', 'success');
          redirect(site_url('c/post'));
        }
        else {
          $data['view_name'] = 'edit_post';
          $this->load->view('club/index_view', $data);
        }
      }
    }

  }

}
