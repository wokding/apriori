 <style>
 	* {
 		font-size: 13px;
 		color: #000;
 	}


 	.table {
 		border-collapse: collapse;
 		margin-top: 5px;
 		width: 100%;
 	}

 	.table td {
 		border-collapse: collapse;
 		border: 1px solid #666666;
 		font-size: 13px;
 		padding-left: 6px;
 		padding-right: 6px;
 		padding-top: 2px;
 		padding-bottom: 2px;
 	}



 	.grey {
 		background-color: #ccc;
 		border: 1px solid #666666;
 		font-size: 13px;
 		padding-left: 6px;
 		padding-right: 6px;
 		padding-top: 2px;
 		padding-bottom: 2px;
 	}

 	h3 {
 		font-size: 15px;
 		font-weight: bolder;
 	}

 	h1 {
 		font-size: 20px;
 		font-weight: bolder;
 	}

 	h2 {
 		font-size: 18px;
 		font-weight: bolder;
 	}

 	.hr {
 		border-collapse: collapse;
 		border-bottom: 1px solid #000;
 		margin-bottom: 30px;
 	}
 </style>


 <div style="text-align:center;">
 	<div style="margin-bottom:-50px;">
 		<?php
			$logo_path = FCPATH . 'assets/img/kimiafarma.png';
			if (file_exists($logo_path)) {
				echo '<img src="' . base_url('assets/img/kimiafarma.png') . '" width="300" height="150">';
			}
		?>
 	</div>
 	<center>
 		<h1>APOTEK KIMIA FARMA SUMMARECON BEKASI</h1>
 	</center>
 </div>
 <div style="margin-top:-30px; text-align:center;">
 	<center>
 		<h2>HASIL PERHITUNGAN DATA MINING METODE APRIORI</h2>
 	</center>
 </div>

 <div class="hr"></div>


 <h3>PARAMETER</h3>

 <table class="table">
 	<tr>
 		<td width="20%">Min Support</td>
 		<td><?php echo $RuleID->min_support ?></td>
 	</tr>
 	<tr>
 		<td>Min Confidence</td>
 		<td><?php echo $RuleID->min_confidence ?></td>
 	</tr>
 	<tr>
 		<td>Start Date</td>
 		<td><?php echo $RuleID->start_date ?></td>
 	</tr>
 	<tr>
 		<td>End Date</td>
 		<td><?php echo $RuleID->end_date ?></td>
 	</tr>
 	<tr>
 		<td>Save As</td>
 		<td>Rule ID <?php echo $RuleID->id ?></td>
 	</tr>
 </table>






 <!-- initial array $data_confidence -->
 <?php $data_confidence = []; ?>




 <h3>CONFIDENCE DARI ITEMSET 3 </h3>



 <table class="table" style="width:100%">

 	<tr class="grey">
 		<td align="center"> No. </td>
 		<td align="center"> X => Y </td>
 		<td align="center"> Support X U Y </td>
 		<td align="center"> Support X </td>
 		<td align="center"> Confidence </td>
 		<td align="center"> Keterangan </td>
 	</tr>


 	<?php $j = 1; ?>
 	<?php foreach ($ConfidenceItemset3 as $ConfidenceItemset3) : ?>
 		<tr>
 			<td align="center"><?php echo $j ?></td>
 			<td>
 				<?php echo $ConfidenceItemset3->kombinasi1 . " => " . $ConfidenceItemset3->kombinasi2 ?>
 			</td>
 			<td align="center">
 				<?php echo angka($ConfidenceItemset3->support_xUy) ?></td>
 			<td align="center">
 				<?php echo angka($ConfidenceItemset3->support_x) ?></td>
 			<td align="center">
 				<?php echo angka($ConfidenceItemset3->confidence) ?></td>
 			<?php $keterangan = ($ConfidenceItemset3->confidence <= $ConfidenceItemset3->min_confidence) ? "Tidak Lolos" : "Lolos"; ?>
 			<td align="center" width="130"><?php echo $keterangan ?></td>
 		</tr>
 		<?php
			$j++;
			if ($ConfidenceItemset3->lolos == 1) {
				$data_confidence[] = $ConfidenceItemset3;
			}
			?>
 	<?php endforeach; ?>

 </table>

 <h3>CONFIDENCE DARI ITEMSET 2 </h3>

 <table class=" table" style="width:100%">

 	<tr class="grey">
 		<td align="center"> No. </td>
 		<td align="center"> X => Y </td>
 		<td align="center"> Support X U Y </td>
 		<td align="center"> Support X </td>
 		<td align="center"> Confidence </td>
 		<td align="center"> Keterangan </td>
 	</tr>


 	<?php $j = 1; ?>
 	<?php foreach ($ConfidenceItemset2 as $ConfidenceItemset2) : ?>
 		<tr>
 			<td align="center"><?php echo $j ?></td>
 			<td>
 				<?php echo $ConfidenceItemset2->kombinasi1 . " => " . $ConfidenceItemset2->kombinasi2 ?>
 			</td>
 			<td align="center">
 				<?php echo angka($ConfidenceItemset2->support_xUy) ?></td>
 			<td align="center">
 				<?php echo angka($ConfidenceItemset2->support_x) ?></td>
 			<td align="center">
 				<?php echo angka($ConfidenceItemset2->confidence) ?></td>
 			<?php $keterangan = ($ConfidenceItemset2->confidence <= $ConfidenceItemset2->min_confidence) ? "Tidak Lolos" : "Lolos"; ?>
 			<td align="center" width="130"><?php echo $keterangan ?></td>
 		</tr>
 		<?php
			$j++;
			if ($ConfidenceItemset2->lolos == 1) {
				$data_confidence[] = $ConfidenceItemset2;
			}
			?>
 	<?php endforeach; ?>

 </table>

 <h3>RULE ASOSIASI</h3>
 <table class=" table" style="width:100%">

 	<tr class="grey">
 		<td align="center"> No. </td>
 		<td align="center"> X => Y </td>
 		<td align="center"> Confidence </td>
 		<td align="center"> Nilai Uji Lift </td>
 		<td align="center"> Korelasi Rule </td>
 	</tr>


 	<?php $j = 1; ?>
 	<?php foreach ($data_confidence as $val) { ?>
 		<tr>
 			<td align="center" width="5"><?php echo $j ?></td>
 			<td>
 				<?php echo $val->kombinasi1 . " => " . $val->kombinasi2 ?>
 			</td>
 			<td align="center">
 				<?php echo angka($val->confidence) ?></td>
 			<td align="center">
 				<?php echo angka($val->nilai_uji_lift) ?></td>
 			<td align="center">
 				<?php echo $val->korelasi_rule ?></td>
 		</tr>
 	<?php
			$j++;
		}
		?>

 </table>

 <h3>HASIL ANALISA</h3>

 <table class=" table" style="width:100%">

 	<tr class="grey">
 		<td align="center"> No. </td>
 		<td align="center"> Rule </td>
 		<td align="center"> Confidence </td>
 	</tr>


 	<?php $j = 1; ?>
 	<?php foreach ($data_confidence as $val) { ?>
 		<tr>
 			<td align="center" width="5"><?php echo $j ?></td>
 			<td> Jika konsumen membeli <?php echo $val->kombinasi1 ?>, maka
 				konsumen juga akan membeli <?php echo $val->kombinasi2 ?>
 			</td>
 			<td align="center">
 				<?php echo angka($val->confidence) ?></td>
 		</tr>
 	<?php
			$j++;
		}
		?>

 </table>