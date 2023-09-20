<div class="main">
    <div class="main-inner">
        <div class="container">
            <div class="row">
                <div class="span12">
                    <div class="widget">
                        <div class="widget-header">
                            <i class="icon-random"></i>
                            <h3>Replacement Detail</h3>
                        </div> <!-- /widget-header -->
                        <div class="widget-content">
                            <!-- set session message -->
                            <?php if ($this->session->flashdata('message')) : ?>
                                <div class="alert alert-success">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <?php echo $this->session->flashdata('message'); ?>
                                </div>
                            <?php endif; ?>

                            <h4><span style="float: left"><a href="<?php echo site_url('unit/detail/' . $mod->id_unit); ?>" class="btn btn-info"><i class="icon-arrow-left"></i> Back</a></span></h4>
                            <h4><span style="float: right"><a href="<?php echo site_url('unit/export_pcr/' . $mod->id_unit . '/' . $mod->id_mod); ?>" class="btn btn-warning">Export</a></span></h4>
                            <h4><span style="float: right">&nbsp;</span></h4>
                            <?php // if(empty($reps)):
                            ?>
                            <h4><span style="float: right"><a href="<?php echo site_url('unit/add_replacement/' . $mod->id_unit . '/' . $mod->id_mod); ?>" class="btn btn-success"><i class="icon-plus"></i> Add Replacement</a></span></h4><br><br>
                            <?php // endif;
                            ?>
                            <div class="form-horizontal">
                                <?php
                                //                                if(empty($last)||empty($last_rep)){
                                //                                    
                                //                                }else{
                                //                                    $a = $last_rep['hm_rep']; 
                                //                                    $b = $last->hm_unit; 
                                //                                    $c = $last_rep['comp_hour']; 
                                //                                    $last_comp_life = ($b-$a)+$c;
                                //                                    
                                //                                    $date = new DateTime();
                                //                                    $last_policy = $last->policy;
                                //                                    $r_life = $last_comp_life/$last_policy*100;
                                //                                    $wh = round($avg->avg,0);
                                //                                    if ($wh != 0){
                                //                                        $forecast = ($last_policy-$last_comp_life)/$wh;
                                //                                    } else {
                                //                                        $forecast = ($last_policy-$last_comp_life)/1;
                                //                                    }
                                //                                    $next = date_add($date,date_interval_create_from_date_string($forecast." hours"));
                                //                                    $next_date = date_format($next,"Y-m-d");
                                //                                }
                                //                                
                                ?>
                                <!-- <pre>
                                <?php //print_r($last);
                                ?> -->
                                </pre>
                                <table cellspacing="0" width="100%">
                                    <tr>
                                        <td>Unit No.</td>
                                        <td>:</td>
                                        <td><b><?php echo $mod->unit_no ?></b></td>
                                        <td>Model</td>
                                        <td>:</td>
                                        <td><b><?php echo $mod->model_no ?></b></td>
                                    </tr>
                                    <tr>
                                        <td>Unit Description</td>
                                        <td>:</td>
                                        <td><b><?php echo $mod->unit_desc ?></b></td>
                                        <td>Component Description</td>
                                        <td>:</td>
                                        <td><b><?php echo $mod->comp_desc ?></b></td>
                                    </tr>
                                    <tr>
                                        <td>Site</td>
                                        <td>:</td>
                                        <td><b><?php echo $mod->kode_project ?> | <?php echo $mod->nama_project ?></b></td>
                                        <td>Policy</td>
                                        <td>:</td>
                                        <td><b><?php echo $mod->policy ?></b></td>
                                    </tr>
                                </table>
                                <!--                                <div class="pricing-plans plans-3">
                                    <div class="plan-container">
                                        <div class="plan green">
                                            <div class="plan-header">
                                                <div class="plan-title">
                                                    Hour Meter Unit : 
                                                        <?php if (empty($hm)) {
                                                            echo "-";
                                                        } else {
                                                            echo $hm->hm_unit;
                                                        }
                                                        ?>
                                                </div>  /plan-title 
                                            </div>  /plan-header 	        
                                        </div>  /plan 
                                    </div>  /plan-container 
                                    <div class="plan-container">
                                        <div class="plan orange">
                                            <div class="plan-header">
                                                <div class="plan-title">
                                                    Last Replacement Date : 
                                                        <?php if (empty($last_rep_close)) {
                                                            echo "-";
                                                        } else {
                                                            echo $last_rep_close->wo_end_date;
                                                        }
                                                        ?>
                                                </div>  /plan-title 
                                            </div>  /plan-header 	        
                                        </div>  /plan 
                                    </div>  /plan-container 
                                    <div class="plan-container">
                                        <div class="plan red">
                                            <div class="plan-header">
                                                <div class="plan-title">
                                                    Next Replacement Date : 
                                                        <?php if (empty($next_date)) {
                                                            echo "-";
                                                        } else {
                                                            echo $next_date;
                                                        }
                                                        ?>
                                                </div>  /plan-title 
                                            </div>  /plan-header 	        
                                        </div>  /plan 
                                    </div>  /plan-container 
                                </div>-->
                                <br>
                                <table id="example1" class="table table-bordered table-condensed" cellspacing="0" width="100%" style="display: block; overflow-x: auto">
                                    <thead>
                                        <tr>
                                            <th>
                                                <div align="center">No</div>
                                            </th>
                                            <th width="40px">
                                                <div align="center">% Life</div>
                                            </th>
                                            <th>
                                                <div align="center">Comp. Life</div>
                                            </th>
                                            <th>
                                                <div align="center">Comp. Condition</div>
                                            </th>
                                            <th>
                                                <div align="center">H/M Unit</div>
                                            </th>
                                            <th>
                                                <div align="center">WH/day</div>
                                            </th>
                                            <th>
                                                <div align="center">Work Order</div>
                                            </th>
                                            <th>
                                                <div align="center">WO Schedule Date</div>
                                            </th>
                                            <th>
                                                <div align="center">WO Status</div>
                                            </th>
                                            <th>
                                                <div align="center">WO Complete Date</div>
                                            </th>
                                            <th>
                                                <div align="center">Installed Comp. Hrs</div>
                                            </th>
                                            <th>
                                                <div align="center">Last Replacement H/M</div>
                                            </th>
                                            <th>
                                                <div align="center">Last Replacement Date</div>
                                            </th>
                                            <th>
                                                <div align="center">Next Replacement Date</div>
                                            </th>
                                            <?php if ($mod->comp_type == "MAJOR") : ?>
                                                <th>
                                                    <div align="center">Report</div>
                                                </th>
                                            <?php endif; ?>
                                            <th>
                                                <div align="center">Remarks</div>
                                            </th>
                                            <th>
                                                <div align="center">Act</div>
                                            </th>
                                            <?php if ($pengguna->level == "Admin") : ?>
                                                <th>
                                                    <div align="center">Del</div>
                                                </th>
                                            <?php endif; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <?php if (empty($reps)) : ?>
                                                <td colspan="16">
                                                    <div align="center">No Data Available</div>
                                                </td>
                                            <?php else : ?>
                                                <?php $i = 1; ?>
                                                <?php foreach ($reps as $row) : ?>
                                                    <?php
                                                    $hm_rep = $hm->hm_unit;
                                                    // $l_hm = $last->hm_rep; //diaktifkan saat replacement sudah berjalan
                                                    $l_hm = $row['last_hm_rep']; //dinonaktifkan saat replacement sudah berjalan
                                                    $ich = $row['comp_hour'];
                                                    $comp_life = ($hm_rep - $l_hm) + $ich;
                                                    $policy = $row['policy'];
                                                    $life = ($comp_life / $policy) * 100;
                                                    $wh_day = round($avg->avg, 0);
                                                    $date = date('Y-m-d');
                                                    if ($wh_day == 0) {
                                                        $forecast = 0;
                                                    } else {
                                                        $forecast = round(($policy - $comp_life) / $wh_day, 0);
                                                    }
                                                    $next = date('Y-m-d', strtotime($date . '+' . $forecast . 'days'));
                                                    ?>
                                                    <td>
                                                        <div align="center"><?php echo $i++; ?></div>
                                                    </td>
                                                    <?php if ($row['wo_status'] == "OPEN") : ?>
                                                        <td>
                                                            <div align="right"><?php echo round($life, 1); ?> %</div>
                                                        </td>
                                                        <td>
                                                            <div align="right"><?php echo $comp_life; ?></div>
                                                        </td>
                                                    <?php else : ?>
                                                        <td>
                                                            <div align="right"><?php echo $row['life_percent']; ?> %</div>
                                                        </td>
                                                        <td>
                                                            <div align="right"><?php echo $row['comp_life']; ?></div>
                                                        </td>
                                                    <?php endif; ?>
                                                    <td>
                                                        <div align="center"><?php echo $row['comp_cond']; ?></div>
                                                    </td>
                                                    <?php if ($row['wo_status'] == "OPEN") : ?>
                                                        <td>
                                                            <div align="center"><?php echo $hm->hm_unit; ?></div>
                                                        </td>
                                                    <?php else : ?>
                                                        <td>
                                                            <div align="center"><?php echo $row['hm_rep']; ?></div>
                                                        </td>
                                                    <?php endif; ?>
                                                    <td>
                                                        <div align="center"><?php echo $wh_day; ?></div>
                                                    </td>
                                                    <td>
                                                        <div align="center"><?php echo $row['wo_no']; ?></div>
                                                    </td>
                                                    <td>
                                                        <div align="center"><?php echo $row['wo_date']; ?></div>
                                                    </td>
                                                    <td>
                                                        <div align="center"><?php echo $row['wo_status']; ?></div>
                                                    </td>
                                                    <td>
                                                        <div align="center"><?php echo $row['wo_end_date']; ?></div>
                                                    </td>
                                                    <td>
                                                        <div align="center"><?php echo $row['comp_hour']; ?></div>
                                                    </td>
                                                    <td>
                                                        <div align="center"><?php echo $row['last_hm_rep']; ?></div>
                                                    </td>
                                                    <td>
                                                        <div align="center"><?php echo $row['last_rep_date']; ?></div>
                                                    </td>
                                                    <?php if ($row['wo_status'] == "OPEN") : ?>
                                                        <td>
                                                            <div align="center"><?php echo $next; ?></div>
                                                        </td>
                                                    <?php else : ?>
                                                        <td></td>
                                                    <?php endif; ?>
                                                    <?php if ($mod->comp_type == "MAJOR") : ?>
                                                        <?php if ($row['report']) : ?>
                                                            <td>
                                                                <div align="center"><a href="<?= base_url('assets/file/' . $row['report']) ?>" target="_blank"><i class="icon-large icon-download-alt"></i></a></div>
                                                            </td>
                                                        <?php else : ?>
                                                            <td></td>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                    <td>
                                                        <div align="center"><?php echo $row['remarks']; ?></div>
                                                    </td>
                                                    <?php if ($row['wo_status'] == "OPEN") : ?>
                                                        <td>
                                                            <div align="center">
                                                                <a href="<?php echo base_url('unit/edit_replacement/' . $row['id_rep'] . '/' . $row['id_unit'] . '/' . $row['id_mod']); ?>" class="btn btn-mini btn-info"><i class="icon-edit" title="Edit"></i></a>
                                                                <a href="<?php echo base_url('unit/close_replacement/' . $row['id_rep'] . '/' . $row['id_unit'] . '/' . $row['id_mod']); ?>" class="btn btn-mini btn-danger" onclick="return confirm('Are you want to close this replacement?')">&nbsp;<i class="icon-lock" title="Close"></i>&nbsp;</a>
                                                            </div>
                                                        </td>
                                                    <?php elseif ($row['wo_status'] == "CLOSE" && $pengguna->level != "User") : ?>
                                                        <td>
                                                            <div align="center"><a href="<?php echo base_url('unit/edit_replacement/' . $row['id_rep'] . '/' . $row['id_unit'] . '/' . $row['id_mod']); ?>" class="btn btn-mini btn-info"><i class="icon-edit" title="Edit"></i></a></div>
                                                        </td>
                                                    <?php else : ?>
                                                        <td>
                                                            <div align="center">&nbsp;</div>
                                                        </td>
                                                    <?php endif; ?>
                                                    <?php if ($pengguna->level == "Admin") : ?>
                                                        <td>
                                                            <div align="center"><a href="<?php echo base_url('unit/delete_replacement/' . $row['id_rep'] . '/' . $row['id_unit'] . '/' . $row['id_mod']); ?>" class="btn btn-mini btn-danger" onclick="return confirm('Do you want to delete this replacement?')">&nbsp;<i class="icon-remove" title="Delete"></i>&nbsp;</a></div>
                                                        </td>
                                                    <?php endif; ?>
                                        </tr>
                                        <!--                                        <pre>
                                            <?php // print_r($date);
                                            ?>
                                            <?php // print_r($forecast);
                                            ?>
                                            <?php // print_r($next);
                                            ?>
                                        </pre>-->
                                    <?php endforeach ?>
                                <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div> <!-- /widget-content -->
                    </div> <!-- /widget -->
                </div> <!-- /span12 -->
            </div> <!-- /row -->
        </div> <!-- /container -->
    </div> <!-- /main-inner -->
</div> <!-- /main -->