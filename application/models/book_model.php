<?php
    class Book_Model extends CI_Model {

        var $table = "book";

        public function book_add($data){
            $this->db->insert($this->table, $data);
            return $this->db->insert_id();
        }

        public function get_books(){
            $this->db->from('book');
            $query =  $this->db->get();
            return $query->result();
        }

        public function get_book_by_id($id){
            $this->db->from($this->table);
            $this->db->where('book_id', $id);
            $query =  $this->db->get();
            return $query->row();
        }

        public function book_edit($where, $data){
            $this->db->update($this->table, $data, $where);
            return $this->db->affected_rows();
        }

        public function delete_by_id($id){
            $this->db->where('book_id', $id);
            $this->db->delete($this->table);
        }

    }
?>