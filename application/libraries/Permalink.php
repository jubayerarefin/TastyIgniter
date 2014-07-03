<?php  if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Permalink {
	var $permalinks = array();

	public function __construct() {
		$this->CI =& get_instance();
		$this->fetchPermalinks();
	}

	public function fetchPermalinks() {
		if (empty($this->permalinks)) {
			$this->CI->load->database();
			$this->CI->db->from('permalinks');	
			$query = $this->CI->db->get();

			if ($query->num_rows() > 0) {
				$results = array();
		
				foreach ($query->result_array() as $row) {
					if (isset($row['permalink']) AND isset($row['query'])) {
						$results[$row['permalink']] = $row['query'];
					}
				}
			
				$this->permalinks = $results;
			}
		}
	}

	public function setPermalink($query = '') {
        $permalinks = array_flip($this->permalinks);

	  	if (isset($permalinks[$query])) {
			return $permalinks[$query];
	  	}
	}

	public function setQuery() {
		if ($this->CI->uri->segment(1) !== ADMIN_URI AND $this->CI->uri->segment(2)) {		
			$permalink = $this->CI->uri->segment(2);
			
			if (isset($this->permalinks[$permalink])) {
				$query = $this->permalinks[$permalink];
				$query = explode('=', $query);
		
				if (isset($query[1])) {
					$_GET[$query[0]] = $query[1];
				}
			}
		}
	}
}

// END Permalink class

/* End of file Permalink.php */
/* Location: ./application/libraries/Permalink.php */