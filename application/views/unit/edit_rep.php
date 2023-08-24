<div class="main">
    <div class="main-inner">
        <div class="container">
            <div class="row">
                <div class="span12">
                    <div class="widget">
                        <div class="widget-header">
                            <i class="icon-random"></i>
                            <h3>Edit Replacement</h3>
                        </div> <!-- /widget-header -->
                        <div class="widget-content">
                            <h4><span style="float: left"><a href="<?php echo site_url('unit/replacement/' . $rep->id_unit . '/' . $rep->id_mod); ?>" class="btn btn-info"><i class="icon-arrow-left"></i>&nbsp;&nbsp;Back</a></span></h4><br><br>
                            <!--<pre><?php // print_r($rep);
                                        ?></pre>-->
                            <div class="form-horizontal">
                                <pre><?= print_r($rep); ?></pre>
                                <table cellspacing="0" width="100%">
                                    <tr>
                                        <td>Unit No.</td>
                                        <td>:</td>
                                        <td><b><?php echo $rep->unit_no ?></b></td>
                                        <td>Model</td>
                                        <td>:</td>
                                        <td><b><?php echo $rep->model_no ?></b></td>
                                    </tr>
                                    <tr>
                                        <td>Unit Description</td>
                                        <td>:</td>
                                        <td><b><?php echo $rep->unit_desc ?></b></td>
                                        <td>Component Description</td>
                                        <td>:</td>
                                        <td><b><?php echo $rep->comp_desc ?></b></td>
                                    </tr>
                                    <tr>
                                        <td>Site</td>
                                        <td>:</td>
                                        <td><b><?php echo $rep->kode_project ?> | <?php echo $rep->nama_project ?></b></td>
                                        <td>Policy</td>
                                        <td>:</td>
                                        <td><b><?php echo $rep->policy ?></b></td>
                                    </tr>
                                </table>
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
                                ?>
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
                                <hr>
                                <?php
                                $rating_i = $this->db->query("select type, rating
                                from inspection a
                                where a.ins_date = (
                                        select max(ins_date)
                                    from inspection b
                                    where a.type = b.type and a.id_unit = b.id_unit and a.id_mod = b.id_mod
                                ) and a.id_unit = " . $rep->id_unit . " and a.id_mod = " . $rep->id_mod . "")->result_array();
                                $rating_s = $this->db->query("select type,eval_code from sos c where c.id_unit = " . $rep->id_unit . " and c.id_mod = " . $rep->id_mod . " order by sample_date desc limit 1")->row();

                                $cond = "";
                                if (empty($rating_i)) {
                                    if (empty($rating_s)) {
                                    } else {
                                        if ($rating_s->eval_code == 'A' || $rating_s->eval_code == 'B' || $rating_s->eval_code == 'Normal') {
                                            $cond = "NORMAL";
                                        } elseif ($rating_s->eval_code == 'C' || $rating_s->eval_code == 'Attention') {
                                            $cond = "ATTENTION";
                                        } elseif ($rating_s->eval_code == 'D' || $rating_s->eval_code == 'X' || $rating_s->eval_code == 'Urgent') {
                                            $cond = "CRITICAL";
                                        }
                                    }
                                } else {
                                    $result_i = $rating_i;
                                    $array_i = array_map(function ($value) {
                                        return $value['rating'];
                                    }, $result_i);
                                    $str_i = implode($array_i);
                                    if ((strpos($str_i, 'A') !== false || strpos($str_i, 'B') !== false) && strpos($str_i, 'C') === false && strpos($str_i, 'X') === false) {
                                        $cond = "NORMAL";
                                    } elseif (substr_count($str_i, "C") == 1 && strpos($str_i, 'X') === false) {
                                        $cond = "ATTENTION";
                                    } elseif (substr_count($str_i, "C") > 1 || strpos($str_i, 'X') !== false) {
                                        $cond = "CRITICAL";
                                    }
                                }
                                ?>
                                <form class="form-horizontal" role="form" action="" method="post">
                                    <fieldset>
                                        <div class="span5">
                                            <input type="hidden" class="span3" name="id_unit" value="<?php echo $rep->id_unit; ?>" />
                                            <input type="hidden" class="span3" name="id_mod" value="<?php echo $rep->id_mod; ?>" />
                                            <div class="control-group">
                                                <label class="control-label">Posting Date</label>
                                                <div class="controls">
                                                    <input type="text" id="rep_date" class="span3" name="rep_date" value="<?php echo $rep->rep_date; ?>" />
                                                </div> <!-- /controls -->
                                            </div> <!-- /control-group -->
                                            <div class="control-group">
                                                <label class="control-label">H/M Unit</label>
                                                <div class="controls">
                                                    <input type="text" class="span3" name="hm_rep" value="<?php echo $hm->hm_unit ?>" />
                                                    <!--<input type="hidden" class="span3" name="hm_rep" value="<?php echo $rep->hm_rep; ?>"/>-->
                                                </div> <!-- /controls -->
                                            </div> <!-- /control-group -->
                                            <div class="control-group">
                                                <label class="control-label">Installed Comp. Hours</label>
                                                <div class="controls">
                                                    <input type="text" class="span3" name="comp_hour" value="<?php echo $rep->comp_hour; ?>" />
                                                </div> <!-- /controls -->
                                            </div> <!-- /control-group -->
                                            <div class="control-group">
                                                <label class="control-label">Component Condition</label>
                                                <div class="controls">
                                                    <input type="text" class="span3" name="comp_cond" value="<?php echo $cond; ?>" />
                                                </div> <!-- /controls -->
                                            </div> <!-- /control-group -->
                                        </div>
                                        <div class="span5">
                                            <div class="control-group">
                                                <label class="control-label">Work Order</label>
                                                <div class="controls">
                                                    <input type="text" class="span3" name="wo_no" value="<?php echo $rep->wo_no; ?>" />
                                                </div> <!-- /controls -->
                                            </div> <!-- /control-group -->
                                            <div class="control-group">
                                                <label class="control-label">WO Schedule Date</label>
                                                <div class="controls">
                                                    <input type="text" id="wo_date" class="span3" name="wo_date" value="<?php echo $rep->wo_date; ?>" />
                                                </div> <!-- /controls -->
                                            </div> <!-- /control-group -->
                                            <div class="control-group">
                                                <label class="control-label">WO Complete Date</label>
                                                <div class="controls">
                                                    <input type="text" id="wo_end_date" class="span3" name="wo_end_date" value="<?php echo $rep->wo_end_date; ?>" />
                                                </div> <!-- /controls -->
                                            </div> <!-- /control-group -->
                                            <div class="control-group">
                                                <label class="control-label">Remarks</label>
                                                <div class="controls">
                                                    <input type="text" class="span3" name="remarks" value="<?php echo $rep->remarks; ?>" />
                                                </div> <!-- /controls -->
                                            </div> <!-- /control-group -->
                                            <?php if ($pengguna->level == "Admin") : ?>
                                                <div class="control-group">
                                                    <label class="control-label">WO Status</label>
                                                    <div class="controls">
                                                        <?php $status = array(
                                                            'OPEN' => 'OPEN',
                                                            'CLOSE' => 'CLOSE'
                                                        );
                                                        echo form_dropdown('wo_status', $status, $sel_stat, 'class=span3');
                                                        ?>
                                                    </div> <!-- /controls -->
                                                </div> <!-- /control-group -->
                                            <?php endif; ?>
                                        </div>
                                        <?php if ($rep->comp_type == "MAJOR") : ?>
                                            <div class="span11">
                                                <hr>
                                                <div class="control-group">
                                                    <label class="control-label"><b>Installation Report</b></label>
                                                    <div class="controls">
                                                        <input type="file" class="span3" name="report" />
                                                    </div> <!-- /controls -->
                                                </div> <!-- /control-group -->
                                            </div>
                                        <?php endif; ?>
                                    </fieldset>
                                    <div class="form-actions span9">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                        <button type="reset" class="btn">Reset</button>
                                    </div> <!-- /form-actions -->
                                </form>
                            </div>
                        </div> <!-- /widget-content -->
                    </div> <!-- /widget -->
                </div> <!-- /span12 -->
            </div> <!-- /row -->
        </div> <!-- /container -->
    </div> <!-- /main-inner -->
</div> <!-- /main -->