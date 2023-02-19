<?php
class login_model extends ci_model{

	public function cek_login($where, $table)
	{
		return $this->db->get_where($table, $where);
	}

	public function cek_email($where, $table)
	{
		return $this->db->get_where($table, $where);
	}

}
