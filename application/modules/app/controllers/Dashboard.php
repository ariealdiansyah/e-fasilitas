<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	public function index()
	{

		$this->load->model('Model_dashboard');

		$arrStatus = get_enum_values('peminjaman','statusPeminjaman');

		for ($i=6; $i >= 0; $i--) { 
			$arr = array();
			$num = 0;
			foreach ($arrStatus as $key) {
				$date = date("Y-m-d", strtotime("-" . $i ." day"));
				$arr["peminjaman_$num"] = $this->db->from('peminjaman')->where(array(
					'statusPeminjaman' => $key,
					'DATE(tanggalPinjam)' => $date
					))->count_all_results();
				$num++;
			}
			$response['chart']['peminjaman'][] = array(
				'date' => $date,
				"data" => $arr
				);
		}

		$data = array(
			'count_users' => count_all('user'),
			'count_barang' => count_all('barang'),
			'count_rr' => count_all('item',array('kondisiItem'=>'RR')),
			'count_rb' => count_all('item',array('kondisiItem'=>'RB')),
			'count_item' => count_all('item'),
			'count_peminjaman' => count_all('peminjaman'),
			'last_peminjaman' => $this->Model_dashboard->getLastPeminjaman(),
			'top_barang' => $this->Model_dashboard->getTopBarang(),
			'top_peminjam' => $this->Model_dashboard->getTopPeminjam(),
			'arrStatus' => $arrStatus,
			'arrDaily' => json_encode($response)
			);

		$data['other_css'] = 'backend/plugins/morris.js/morris.css';

		$data['other_js_top'] = array(
			'backend/plugins/raphael.js/raphael.min.js',
			'backend/plugins/morris.js/morris.min.js'
			);

		$data['content'] = 'dashboard_content';
		$this->load->view('backend/main',$data,FALSE);
	}

}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */