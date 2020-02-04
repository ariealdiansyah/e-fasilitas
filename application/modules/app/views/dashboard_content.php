<?php
$arrPeminjaman = array();
$num = 0;
foreach($arrStatus as $obj => $row){
	$arrPeminjaman[$num] = $row;
	$num++;
}
?>

<div class="container">

	<div class="row">
		<div class="col-sm-12">
			<h4 class="pull-left page-title">Dashboard</h4>
			<ol class="breadcrumb pull-right">
				<li>E-Faslitas</li>
				<li>Dashboard</li>
			</ol>
		</div>
	</div>

	<div class="row">
		
		<div class="col-sm-3">
			<div class="mini-stat clearfix bx-shadow bg-white">
				<span class="mini-stat-icon bg-info"><i class="ion-android-contacts"></i></span>
				<div class="mini-stat-info text-right text-dark">
					<span id="displayRegistration" class="counter text-dark"><?= $count_users ?></span>
					Total Pengguna
				</div>
			</div>
		</div>

		<div class="col-sm-3">
			<div class="mini-stat clearfix bx-shadow bg-white">
				<span class="mini-stat-icon bg-purple"><i class="ion-cube"></i></span>
				<div class="mini-stat-info text-right text-dark">
					<span id="displayRegistration" class="counter text-dark"><?= $count_barang ?></span>
					Total Barang
				</div>
			</div>
		</div>

		<div class="col-sm-3">
			<div class="mini-stat clearfix bx-shadow bg-white">
				<span class="mini-stat-icon bg-danger"><i class="fa fa-cubes"></i></span>
				<div class="mini-stat-info text-right text-dark">
					<span id="displayRegistration" class="counter text-dark"><?= $count_item ?></span>
					Total Item
				</div>
			</div>
		</div>

		<div class="col-sm-3">
			<div class="mini-stat clearfix bx-shadow bg-white">
				<span class="mini-stat-icon bg-success"><i class="fa fa-exchange"></i></span>
				<div class="mini-stat-info text-right text-dark">
					<span id="displayRegistration" class="counter text-dark"><?= $count_peminjaman ?></span>
					Total Peminjaman
				</div>
			</div>
		</div>

	</div>

	<div class="row">
		
		<div class="col-sm-6">
			<div class="mini-stat clearfix bx-shadow bg-white">
				<span class="mini-stat-icon bg-warning"><i class="ion-cube"></i></span>
				<div class="mini-stat-info text-right text-dark">
					<span id="displayRegistration" class="counter text-dark"><?= $count_rr ?></span>
					Total Kondisi Barang Yang Rusak Ringan
				</div>
			</div>
		</div>

		<div class="col-sm-6">
			<div class="mini-stat clearfix bx-shadow bg-white">
				<span class="mini-stat-icon bg-muted"><i class="fa fa-cubes"></i></span>
				<div class="mini-stat-info text-right text-dark">
					<span id="displayRegistration" class="counter text-dark"><?= $count_rb ?></span>
					Total Kondisi Barang Yang Rusak Berat
				</div>
			</div>
		</div>
	</div>

	<div class="row">

		<div class="col-md-6">
			<div class="panel panel-border panel-primary">
				<div class="panel-heading">
					<h4 class="panel-title">Statistik Peminjaman Seminggu Terakhir</h4>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12">
							<div id="chart-statistik" style="height: 300px;"></div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="panel panel-border panel-primary">
				<div class="panel-heading">
					<h4 class="panel-title">Persentase Peminjaman</h4>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12">
							<div id="chart-persentase" style="height: 300px;"></div>
						</div>
					</div>
				</div>
			</div>

		</div>

	</div>

	<div class="row">

		<div class="col-md-4">
			<div class="panel panel-border panel-primary">
				<div class="panel-heading">
					<h4 class="panel-title">5 Peminjaman Terakhir</h4>
				</div>
				<div class="panel-body">
					<div class="inbox-widget nicescroll mx-box" style="overflow: hidden; outline: none; min-height: 280px; max-height: 280px;" tabindex="5000">
						<?php foreach($last_peminjaman as $row){ ?>
						<!-- <a href="javascript:void(0)" onclick="vPeminjaman('<?= $row->idPeminjaman ?>')"> -->
						<div class="inbox-item">
							<p class="inbox-item-author"><?= $row->kodePeminjaman ?></p>
							<p class="inbox-item-text"><?= getDateTime(strtotime($row->createDate)) ?></p>
							<p class="inbox-item-date"><?= $row->statusPeminjaman ?></p>
						</div>
					</a>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-4">
		<div class="panel panel-border panel-primary">
			<div class="panel-heading">
				<h4 class="panel-title">Barang yang sering dipinjam</h4>
			</div>
			<div class="panel-body">
				<div class="inbox-widget nicescroll mx-box" style="overflow: hidden; outline: none; min-height: 280px; max-height: 280px;" tabindex="5000">
					<?php foreach($top_barang as $row){ ?>
					<div class="inbox-item">
						<p class="inbox-item-author"><?= $row->namaBarang ?></p>
						<p class="inbox-item-text"><?= $row->count ?>x Dipinjam</p>
					</div>
					<?php } ?>
				</div>
			</div>

		</div>
	</div>

	<div class="col-md-4">
		<div class="panel panel-border panel-primary">
			<div class="panel-heading">
				<h4 class="panel-title">Top 5 Peminjam</h4>
			</div>
			<div class="panel-body">
				<div class="inbox-widget nicescroll mx-box" style="overflow: hidden; outline: none; min-height: 280px; max-height: 280px;" tabindex="5000">
					<?php foreach($top_peminjam as $row){ ?>
					<div class="inbox-item">
						<p class="inbox-item-author"><?= $row->peminjam ?></p>
						<p class="inbox-item-text"><?= $row->count ?>x Meminjam</p>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>

</div>

</div>

<script type="text/javascript">

	!function($) {
		"use strict";

		var MorrisCharts = function() {};

		MorrisCharts.prototype.createAreaChart = function(element, pointSize, lineWidth, data, xkey, ykeys, labels, lineColors) {
			Morris.Area({
				element: element,
				pointSize: 0,
				lineWidth: 0,
				data: data,
				xkey: xkey,
				ykeys: ykeys,
				labels: labels,
				hideHover: 'auto',
				resize: true,
				lineColors: lineColors,
				gridLineColor: '#eef0f2',
			});
		},
		MorrisCharts.prototype.createDonutChart = function(element, data, colors) {
			Morris.Donut({
				element: element,
				data: data,
				resize: true,
				colors: colors,
				formatter: function(y) { return y + "%" }
			});
		},

		MorrisCharts.prototype.init = function() {

			var $areaData = [

			<?php
			$arrDaily = json_decode($arrDaily);
			foreach ($arrDaily->chart->peminjaman as $key) {
				$date = $key->date;
				$str = "";
				foreach ($key->data as $value => $count) {
					if ($value === end($key->data)) {
						$comma = "";
					}else{
						$comma = ",";
					}
					$str .= $value.": ".$count.$comma;
				}
				echo "{y: \"{$key->date}\", $str},";
			}
			?>

			];

			this.createAreaChart('chart-statistik', 0, 0, $areaData, 'y', ['peminjaman_<?php echo implode("', 'peminjaman_", array_keys($arrPeminjaman)); ?>'], ['<?php echo implode("', '", array_values($arrPeminjaman)); ?>'], ['#29B6F6', '#00b19d', '#ef5350', '#7e57c2']);

			var $donutData = [

			<?php
			$empty = TRUE;
			$arrDonut = array();
			$totalDonut = 0;
			$num = 0;
			foreach ($arrStatus as $key) {
				$count = $this->Model_dashboard->getPeminjamanByStatus($key)->count_all_results();
				$arrDonut[$num] = $count;
				$totalDonut += $count;
				$num++;
			}
			$num = 0;
			foreach ($arrStatus as $key) {
				if($totalDonut > 0){
					$count = number_format($arrDonut[$num] / $totalDonut * 100);
					echo "{label: \"{$key}\", value: {$count}},";
					$empty = FALSE;
					$num++;
				}
			}
			if($empty)
				echo "{label: \"No data\", value: 0}";
			?>
			];

			this.createDonutChart('chart-persentase', $donutData, ['#29B6F6', '#00b19d', '#ef5350', '#7e57c2']);

		},
		$.MorrisCharts = new MorrisCharts, $.MorrisCharts.Constructor = MorrisCharts
	}(window.jQuery),

	function($) {
		"use strict";
		$.MorrisCharts.init();
	}(window.jQuery);
</script>