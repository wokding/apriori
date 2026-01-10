<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-eye mr-2"></i>View Rule Details
        </h1>
        <a href="<?= base_url('admin/hasil'); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left fa-sm mr-2"></i>Back to Results
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-info-circle mr-2"></i>Rule Information - ID: <span class="badge badge-primary badge-pill"><?php echo !empty($RuleID->process_id) ? $RuleID->process_id : 'DM-' . str_pad($RuleID->id, 3, '0', STR_PAD_LEFT) ?></span>
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="info-item mb-3">
                        <label class="text-muted mb-1">
                            <i class="fas fa-chart-line mr-2"></i>Min Support
                        </label>
                        <div class="font-weight-bold"><?php echo $RuleID->min_support ?></div>
                    </div>
                    <div class="info-item mb-3">
                        <label class="text-muted mb-1">
                            <i class="fas fa-calendar-alt mr-2"></i>Start Date
                        </label>
                        <div class="font-weight-bold"><?php echo date('d M Y', strtotime($RuleID->start_date)) ?></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-item mb-3">
                        <label class="text-muted mb-1">
                            <i class="fas fa-percentage mr-2"></i>Min Confidence
                        </label>
                        <div class="font-weight-bold"><?php echo $RuleID->min_confidence ?></div>
                    </div>
                    <div class="info-item mb-3">
                        <label class="text-muted mb-1">
                            <i class="fas fa-calendar-check mr-2"></i>End Date
                        </label>
                        <div class="font-weight-bold"><?php echo date('d M Y', strtotime($RuleID->end_date)) ?></div>
                    </div>
                </div>
            </div>
		 
							 
							 
		</div>
    </div>

    <!-- initial array $data_confidence -->
    <?php $data_confidence = []; ?>

    <div class="card shadow mb-4">
        <a href="javascript:void(0)" class="d-block card-header py-3 collapsed" data-toggle="collapse" data-target="#collapseConfidence3" role="button" aria-expanded="false" aria-controls="collapseConfidence3">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-percentage mr-2"></i>Confidence from Itemset 3
                <?php if(isset($show_warning_3) && $show_warning_3): ?>
                    <span class="badge badge-warning ml-2"><i class="fas fa-info-circle mr-1"></i>Showing 500 of <?php echo $total_rules_3; ?> rules</span>
                <?php endif; ?>
                <i class="fas fa-chevron-down float-right"></i>
            </h6>
        </a>
        <div class="collapse" id="collapseConfidence3">
        <div class="card-body">
            <?php if(isset($show_warning_3) && $show_warning_3): ?>
                <div class="alert alert-info mb-3">
                    <i class="fas fa-info-circle mr-2"></i>
                    <strong>Note:</strong> Showing first 500 rules (out of <?php echo $total_rules_3; ?> total). This limit is applied to prevent memory exhaustion with low confidence thresholds.
                </div>
            <?php endif; ?>
            <div class="table-responsive">
                <table class="table table-hover table-bordered" style="width:100%">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th class="text-center" width="60">No.</th>
                            <th>X => Y</th>
                            <th class="text-center">Support X U Y</th>
                            <th class="text-center">Support X</th>
                            <th class="text-center">Confidence</th>
                            <th class="text-center" width="130">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $j = 1; ?>
                        <?php foreach ($ConfidenceItemset3 as $ConfidenceItemset3): ?>
                        <tr>
                            <td class="text-center font-weight-bold"><?php echo $j ?></td>
                            <td>
                                <strong><?php echo $ConfidenceItemset3->kombinasi1 ?></strong>
                                <i class="fas fa-arrow-right mx-2 text-primary"></i>
                                <strong><?php echo $ConfidenceItemset3->kombinasi2 ?></strong>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-info"><?php echo angka($ConfidenceItemset3->support_xUy) ?></span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-info"><?php echo angka($ConfidenceItemset3->support_x) ?></span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-primary"><?php echo angka($ConfidenceItemset3->confidence) ?></span>
                            </td>
                            <?php $keterangan = ($ConfidenceItemset3->confidence <= $ConfidenceItemset3->min_confidence)?"Tidak Lolos":"Lolos"; ?>
                            <td class="text-center">
                                <?php if($keterangan == "Lolos"): ?>
                                    <span class="badge badge-success"><i class="fas fa-check mr-1"></i><?php echo $keterangan ?></span>
                                <?php else: ?>
                                    <span class="badge badge-danger"><i class="fas fa-times mr-1"></i><?php echo $keterangan ?></span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php 
                            $j++;
                            if($ConfidenceItemset3->lolos == 1){
                                $data_confidence[] = $ConfidenceItemset3;
                            } 
                        ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <a href="javascript:void(0)" class="d-block card-header py-3 collapsed" data-toggle="collapse" data-target="#collapseConfidence2" role="button" aria-expanded="false" aria-controls="collapseConfidence2">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-percentage mr-2"></i>Confidence from Itemset 2
                <?php if(isset($show_warning_2) && $show_warning_2): ?>
                    <span class="badge badge-warning ml-2"><i class="fas fa-info-circle mr-1"></i>Showing 500 of <?php echo $total_rules_2; ?> rules</span>
                <?php endif; ?>
                <i class="fas fa-chevron-down float-right"></i>
            </h6>
        </a>
        <div class="collapse" id="collapseConfidence2">
        <div class="card-body">
            <?php if(isset($show_warning_2) && $show_warning_2): ?>
                <div class="alert alert-info mb-3">
                    <i class="fas fa-info-circle mr-2"></i>
                    <strong>Note:</strong> Showing first 500 rules (out of <?php echo $total_rules_2; ?> total). This limit is applied to prevent memory exhaustion with low confidence thresholds.
                </div>
            <?php endif; ?>
            <div class="table-responsive">
                <table class="table table-hover table-bordered" style="width:100%">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th class="text-center" width="60">No.</th>
                            <th>X => Y</th>
                            <th class="text-center">Support X U Y</th>
                            <th class="text-center">Support X</th>
                            <th class="text-center">Confidence</th>
                            <th class="text-center" width="130">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $j = 1; ?>
                        <?php foreach ($ConfidenceItemset2 as $ConfidenceItemset2): ?>
                        <tr>
                            <td class="text-center font-weight-bold"><?php echo $j ?></td>
                            <td>
                                <strong><?php echo $ConfidenceItemset2->kombinasi1 ?></strong>
                                <i class="fas fa-arrow-right mx-2 text-primary"></i>
                                <strong><?php echo $ConfidenceItemset2->kombinasi2 ?></strong>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-info"><?php echo angka($ConfidenceItemset2->support_xUy) ?></span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-info"><?php echo angka($ConfidenceItemset2->support_x) ?></span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-primary"><?php echo angka($ConfidenceItemset2->confidence) ?></span>
                            </td>
                            <?php $keterangan = ($ConfidenceItemset2->confidence <= $ConfidenceItemset2->min_confidence)?"Tidak Lolos":"Lolos"; ?>
                            <td class="text-center">
                                <?php if($keterangan == "Lolos"): ?>
                                    <span class="badge badge-success"><i class="fas fa-check mr-1"></i><?php echo $keterangan ?></span>
                                <?php else: ?>
                                    <span class="badge badge-danger"><i class="fas fa-times mr-1"></i><?php echo $keterangan ?></span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php 
                            $j++;
                            if($ConfidenceItemset2->lolos == 1){
                                $data_confidence[] = $ConfidenceItemset2;
                            } 
                        ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <a href="javascript:void(0)" class="d-block card-header py-3 collapsed" data-toggle="collapse" data-target="#collapseAssociation" role="button" aria-expanded="false" aria-controls="collapseAssociation">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-project-diagram mr-2"></i>Association Rules
                <i class="fas fa-chevron-down float-right"></i>
            </h6>
        </a>
        <div class="collapse" id="collapseAssociation">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered" style="width:100%">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th class="text-center" width="60">No.</th>
                            <th>X => Y</th>
                            <th class="text-center">Confidence</th>
                            <th class="text-center">Lift Value</th>
                            <th class="text-center">Rule Correlation</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $j = 1; ?>
                        <?php foreach($data_confidence as $val){?>
                        <tr>
                            <td class="text-center font-weight-bold"><?php echo $j ?></td>
                            <td>
                                <strong><?php echo $val->kombinasi1 ?></strong>
                                <i class="fas fa-arrow-right mx-2 text-primary"></i>
                                <strong><?php echo $val->kombinasi2 ?></strong>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-primary"><?php echo angka($val->confidence) ?></span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-success"><?php echo angka($val->nilai_uji_lift) ?></span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-info"><?php echo $val->korelasi_rule ?></span>
                            </td>
                        </tr>
                        <?php 
                            $j++;
                        } 
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <a href="javascript:void(0)" class="d-block card-header py-3 collapsed" data-toggle="collapse" data-target="#collapseAnalysis" role="button" aria-expanded="false" aria-controls="collapseAnalysis">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-chart-bar mr-2"></i>Analysis Results
                <i class="fas fa-chevron-down float-right"></i>
            </h6>
        </a>
        <div class="collapse" id="collapseAnalysis">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered" style="width:100%">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th class="text-center" width="60">No.</th>
                            <th>Rule Interpretation</th>
                            <th class="text-center" width="150">Confidence</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $j = 1; ?>
                        <?php foreach($data_confidence as $val){?>
                        <tr>
                            <td class="text-center font-weight-bold"><?php echo $j ?></td>
                            <td>
                                <i class="fas fa-lightbulb mr-2 text-warning"></i>
                                If customers buy <strong class="text-primary"><?php echo $val->kombinasi1 ?></strong>, 
                                then customers will also buy <strong class="text-success"><?php echo $val->kombinasi2 ?></strong>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-primary badge-pill"><?php echo angka($val->confidence) ?></span>
                            </td>
                        </tr>
                        <?php 
                            $j++;
                        } 
                        ?>
                    </tbody>
                </table>
            </div>        </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <a href="javascript:void(0)" class="d-block card-header py-3 collapsed" data-toggle="collapse" data-target="#collapseCardExample1" role="button" aria-expanded="false" aria-controls="collapseCardExample1">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-calculator mr-2"></i>Itemset 1 Calculation
                <i class="fas fa-chevron-down float-right"></i>
            </h6>
        </a>
        <div class="collapse" id="collapseCardExample1">
            <div class="card-body">
                <!-- initial array $ItemSet1Lolos -->
                <?php $ItemSet1Lolos = []; ?>
                
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" style="width:100%">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th class="text-center" width="60">No.</th>
                                <th>Item 1</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Support</th>
                                <th class="text-center" width="130">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $j = 1; ?>
                            <?php foreach($ItemSet1 as $ItemSet1){?>
                            <tr>
                                <td class="text-center font-weight-bold"><?php echo $j ?></td>
                                <td><strong><?php echo $ItemSet1->atribut ?></strong></td>
                                <td class="text-center">
                                    <span class="badge badge-info"><?php echo $ItemSet1->jumlah ?></span>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-primary"><?php echo angka($ItemSet1->support) ?></span>
                                </td>
                                <td class="text-center">
                                    <?php if($ItemSet1->lolos == 1): ?>
                                        <span class="badge badge-success"><i class="fas fa-check mr-1"></i>Lolos</span>
                                    <?php else: ?>
                                        <span class="badge badge-danger"><i class="fas fa-times mr-1"></i>Tidak Lolos</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php
                                if($ItemSet1->lolos==1){
                                    $ItemSet1Lolos[] = $ItemSet1;//item yg lolos itemset1
                                }
                                $j++;
                            } 
                            ?>
                        </tbody>
                    </table>
                </div>

                <hr class="my-4">
                <h5 class="mb-3">
                    <i class="fas fa-check-circle mr-2 text-success"></i>Qualified Itemset 1
                </h5>
					
<div class="table-responsive">
                    <table class="table table-hover table-bordered" style="width:100%">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th class="text-center" width="60">No.</th>
                                <th>Item 1</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Support</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $j = 1; ?>
                            <?php foreach($ItemSet1Lolos as $ItemSet1Lolos){?>
                            <tr>
                                <td class="text-center font-weight-bold"><?php echo $j ?></td>
                                <td><strong><?php echo $ItemSet1Lolos->atribut ?></strong></td>
                                <td class="text-center">
                                    <span class="badge badge-info"><?php echo $ItemSet1Lolos->jumlah ?></span>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-primary"><?php echo angka($ItemSet1Lolos->support) ?></span>
                                </td>
                            </tr>
                            <?php
                                $j++;
                            } 
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

			  
					 
		

 <div class="card shadow mb-4">
        <a href="javascript:void(0)" class="d-block card-header py-3 collapsed" data-toggle="collapse" data-target="#collapseCardExample2" role="button" aria-expanded="false" aria-controls="collapseCardExample2">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-calculator mr-2"></i>Itemset 2 Calculation
                <i class="fas fa-chevron-down float-right"></i>
            </h6>
        </a>
        <div class="collapse" id="collapseCardExample2">
            <div class="card-body">
                <?php $ItemSet2Lolos = []; ?>
                
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" style="width:100%">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th class="text-center" width="60">No.</th>
                                <th>Item 1</th>
                                <th>Item 2</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Support</th>
                                <th class="text-center" width="130">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $j = 1; ?>
                            <?php foreach($ItemSet2 as $ItemSet2){?>
                            <tr>
                                <td class="text-center font-weight-bold"><?php echo $j ?></td>
                                <td><strong><?php echo $ItemSet2->atribut1 ?></strong></td>
                                <td><strong><?php echo $ItemSet2->atribut2 ?></strong></td>
                                <td class="text-center">
                                    <span class="badge badge-info"><?php echo $ItemSet2->jumlah ?></span>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-primary"><?php echo angka($ItemSet2->support) ?></span>
                                </td>
                                <td class="text-center">
                                    <?php if($ItemSet2->lolos == 1): ?>
                                        <span class="badge badge-success"><i class="fas fa-check mr-1"></i>Lolos</span>
                                    <?php else: ?>
                                        <span class="badge badge-danger"><i class="fas fa-times mr-1"></i>Tidak Lolos</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php
                                if($ItemSet2->lolos==1){
                                    $ItemSet2Lolos[] = $ItemSet2;
                                }
                                $j++;
                            } 
                            ?>
                        </tbody>
                    </table>
                </div>

                <hr class="my-4">
                <h5 class="mb-3">
                    <i class="fas fa-check-circle mr-2 text-success"></i>Qualified Itemset 2
                </h5>
                
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" style="width:100%">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th class="text-center" width="60">No.</th>
                                <th>Item 1</th>
                                <th>Item 2</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Support</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $j = 1; ?>
                            <?php foreach($ItemSet2Lolos as $ItemSet2Lolos){?>
                            <tr>
                                <td class="text-center font-weight-bold"><?php echo $j ?></td>
                                <td><strong><?php echo $ItemSet2Lolos->atribut1 ?></strong></td>
                                <td><strong><?php echo $ItemSet2Lolos->atribut2 ?></strong></td>
                                <td class="text-center">
                                    <span class="badge badge-info"><?php echo $ItemSet2Lolos->jumlah ?></span>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-primary"><?php echo angka($ItemSet2Lolos->support) ?></span>
                                </td>
                            </tr>
                            <?php
                                $j++;
                            } 
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

					 
					 
	<div class="card shadow mb-4">
        <a href="javascript:void(0)" class="d-block card-header py-3 collapsed" data-toggle="collapse" data-target="#collapseCardExample3" role="button" aria-expanded="false" aria-controls="collapseCardExample3">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-calculator mr-2"></i>Itemset 3 Calculation
                <i class="fas fa-chevron-down float-right"></i>
            </h6>
        </a>
        <div class="collapse" id="collapseCardExample3">
            <div class="card-body">
                <?php $ItemSet3Lolos = []; ?>
                
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" style="width:100%">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th class="text-center" width="60">No.</th>
                                <th>Item 1</th>
                                <th>Item 2</th>
                                <th>Item 3</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Support</th>
                                <th class="text-center" width="130">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $j = 1; ?>
                            <?php foreach($ItemSet3 as $ItemSet3){?>
                            <tr>
                                <td class="text-center font-weight-bold"><?php echo $j ?></td>
                                <td><strong><?php echo $ItemSet3->atribut1 ?></strong></td>
                                <td><strong><?php echo $ItemSet3->atribut2 ?></strong></td>
                                <td><strong><?php echo $ItemSet3->atribut3 ?></strong></td>
                                <td class="text-center">
                                    <span class="badge badge-info"><?php echo $ItemSet3->jumlah ?></span>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-primary"><?php echo angka($ItemSet3->support) ?></span>
                                </td>
                                <td class="text-center">
                                    <?php if($ItemSet3->lolos == 1): ?>
                                        <span class="badge badge-success"><i class="fas fa-check mr-1"></i>Lolos</span>
                                    <?php else: ?>
                                        <span class="badge badge-danger"><i class="fas fa-times mr-1"></i>Tidak Lolos</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php
                                if($ItemSet3->lolos==1){
                                    $ItemSet3Lolos[] = $ItemSet3;
                                }
                                $j++;
                            } 
                            ?>
                        </tbody>
                    </table>
                </div>

                <hr class="my-4">
                <h5 class="mb-3">
                    <i class="fas fa-check-circle mr-2 text-success"></i>Qualified Itemset 3
                </h5>
                
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" style="width:100%">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th class="text-center" width="60">No.</th>
                                <th>Item 1</th>
                                <th>Item 2</th>
                                <th>Item 3</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Support</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $j = 1; 
                            if ($ItemSet3Lolos != ""){
                                foreach($ItemSet3Lolos as $ItemSet3Lolos){
                            ?>
                            <tr>
                                <td class="text-center font-weight-bold"><?php echo $j ?></td>
                                <td><strong><?php echo $ItemSet3Lolos->atribut1 ?></strong></td>
                                <td><strong><?php echo $ItemSet3Lolos->atribut2 ?></strong></td>
                                <td><strong><?php echo $ItemSet3Lolos->atribut3 ?></strong></td>
                                <td class="text-center">
                                    <span class="badge badge-info"><?php echo $ItemSet3Lolos->jumlah ?></span>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-primary"><?php echo angka($ItemSet3Lolos->support) ?></span>
                                </td>
                            </tr>
                            <?php
                                $j++;
                                } 
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

			  
					 
 



					</div>
			
</div>