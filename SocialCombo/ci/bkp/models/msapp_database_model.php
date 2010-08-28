<?php

class msapp_database_model extends Model {

	function replace_user($data) {
		if($this->get_user($data['user_id'])) {
			return $this->update_user($data['user_id'], $data);
		} else {
			return $this->add_user($data);
		}
	}

	function get_user($id) {
		$this->db->where('user_id', (int)$id);
		$result = $this->db->get('facebook');
		if($result->num_rows()) {
			$row = $result->row_array();
			$result->free_result();
			return $row;
		}
		return false;
	}

	function add_user($data) {
		if($this->db->insert('facebook', $data)) {
			return $this->db->insert_id();
		}
	}

	function delete_user($id) {
		$this->db->where('user_id', $id);
		$this->db->delete('facebook');
	}

	function update_user($id, $data) {
		$this->db->where('user_id', $id);
		return $this->db->update('facebook', $data);
	}

}

?>
