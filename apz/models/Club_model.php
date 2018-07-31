<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Club_model extends CI_Model {
  public function get($club_slug){
    $q = $this->db->get_where('club', ['slug' => $club_slug]);
    return $q->row();
  }

  public function getMateri(){
    $q = $this->db->get('materi');
    return $q->result();
  }
  
  public function update($club_slug, $alamat_foto = NULL){
    $this->db->where('slug', $club_slug);
    
    if($alamat_foto == NULL){
      $data = array(
        'ket' => purify($this->input->post('ket'))
      );
    }
    else {
      $data = array(
        'ket'  => purify($this->input->post('ket')),
        'foto' => $alamat_foto
      );
    }

    $this->db->update('club', $data);
  }
}
