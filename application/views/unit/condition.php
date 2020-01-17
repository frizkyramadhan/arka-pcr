<div class="main">
    <div class="main-inner">
        <div class="container">
            <div class="row">
                <div class="span12">
                    <div class="widget">
                        <div class="widget-header">
                            <i class="icon-check"></i>
                            <h3>Component Condition Detail</h3>
                        </div> <!-- /widget-header -->
                        <div class="widget-content">
                            <h4><span style="float: left"><a href="<?php echo site_url('unit/detail/'.$mod->id_unit); ?>" class="btn btn-info"><i class="icon-arrow-left"></i> Back</a></span></h4>
                            <h4><span style="float: right"><a href="<?php echo site_url('unit/export_condition/'.$mod->id_unit.'/'.$mod->id_mod); ?>" class="btn btn-warning">Export</a></span></h4>
                            <br><br>
                            <div class="form-horizontal">
                                <table cellspacing="0" width="100%">
                                    <tr>
                                        <td>Unit No.</td>
                                        <td>:</td>
                                        <td><b><?php echo $mod->unit_no?></b></td>
                                        <td>Model</td>
                                        <td>:</td>
                                        <td><b><?php echo $mod->model_no?></b></td>
                                    </tr>
                                    <tr>
                                        <td>Unit Description</td>
                                        <td>:</td>
                                        <td><b><?php echo $mod->unit_desc?></b></td>
                                        <td>Component Description</td>
                                        <td>:</td>
                                        <td><b><?php echo $mod->comp_desc?></b></td>
                                    </tr>
                                    <tr>
                                        <td>Site</td>
                                        <td>:</td>
                                        <td><b><?php echo $mod->kode_project?> | <?php echo $mod->nama_project?></b></td>
                                        <td>Policy</td>
                                        <td>:</td>
                                        <td><b><?php echo $mod->policy?></b></td>
                                    </tr>
                                </table>
                                <br>
                                <div align="center">
                                    <?php
                                    $this->db->where('id_unit',$mod->id_unit);
                                    $this->db->where('id_mod',$mod->id_mod);
                                    $this->db->from('condition');
                                    $check = $this->db->get()->num_rows();
                                    $cond = "";
                                    if (empty($rating_i)){
                                        if (empty($rating_s)){
                                        }else{
                                            $result_s = $rating_s;
                                            $array_s = array_map(function($value1){
                                                       return $value1['eval_code'];
                                                   }, $result_s);
                                            $str_s = implode($array_s);
                                            if (strpos($str_s, 'A') !== false || strpos($str_s, 'B') !== false || strpos($str_s, 'Normal') !== false){
                                                $cond = "NORMAL";
                                                if ($check == 0){
                                                    $this->db->set('condition',$cond);
                                                    $this->db->set('id_unit', $mod->id_unit);
                                                    $this->db->set('id_mod', $mod->id_mod);
                                                    $this->db->insert('condition');
                                                } else {
                                                    $this->db->set('condition',$cond);
                                                    $this->db->where('id_unit', $mod->id_unit);
                                                    $this->db->where('id_mod', $mod->id_mod);
                                                    $this->db->update('condition');
                                                }
                                            } elseif (strpos($str_s, 'C') !== false || strpos($str_s, 'Attention') !== false){
                                                $cond = "ATTENTION";
                                                if ($check == 0){
                                                    $this->db->set('condition',$cond);
                                                    $this->db->set('id_unit', $mod->id_unit);
                                                    $this->db->set('id_mod', $mod->id_mod);
                                                    $this->db->insert('condition');
                                                } else {
                                                    $this->db->set('condition',$cond);
                                                    $this->db->where('id_unit', $mod->id_unit);
                                                    $this->db->where('id_mod', $mod->id_mod);
                                                    $this->db->update('condition');
                                                }
                                            } elseif (strpos($str_s, 'D') !== false || strpos($str_s, 'X') !== false || strpos($str_s, 'Urgent') !== false){
                                                $cond = "CRITICAL";
                                                if ($check == 0){
                                                    $this->db->set('condition',$cond);
                                                    $this->db->set('id_unit', $mod->id_unit);
                                                    $this->db->set('id_mod', $mod->id_mod);
                                                    $this->db->insert('condition');
                                                } else {
                                                    $this->db->set('condition',$cond);
                                                    $this->db->where('id_unit', $mod->id_unit);
                                                    $this->db->where('id_mod', $mod->id_mod);
                                                    $this->db->update('condition');
                                                }
                                            }
                                        }
                                    } else {
                                        $result_i = $rating_i;
                                        $array_i = array_map(function($value){
                                                       return $value['rating'];
                                                   }, $result_i);
                                        $str_i = implode($array_i);
                                        if ((strpos($str_i, 'A') !== false || strpos($str_i, 'B') !== false) && strpos($str_i, 'C') === false && strpos($str_i, 'X') === false){
                                            $cond = "NORMAL";
                                            if ($check == 0){
                                                $this->db->set('condition',$cond);
                                                $this->db->set('id_unit', $mod->id_unit);
                                                $this->db->set('id_mod', $mod->id_mod);
                                                $this->db->insert('condition');
                                            } else {
                                                $this->db->set('condition',$cond);
                                                $this->db->where('id_unit', $mod->id_unit);
                                                $this->db->where('id_mod', $mod->id_mod);
                                                $this->db->update('condition');
                                            }
                                        } elseif (substr_count($str_i, "C") == 1 && strpos($str_i, 'X') === false){
                                            $cond = "ATTENTION";
                                            if ($check == 0){
                                                $this->db->set('condition',$cond);
                                                $this->db->set('id_unit', $mod->id_unit);
                                                $this->db->set('id_mod', $mod->id_mod);
                                                $this->db->insert('condition');
                                            } else {
                                                $this->db->set('condition',$cond);
                                                $this->db->where('id_unit', $mod->id_unit);
                                                $this->db->where('id_mod', $mod->id_mod);
                                                $this->db->update('condition');
                                            }
                                        } elseif (substr_count($str_i, "C") > 1 || strpos($str_i, 'X') !== false){
                                            $cond ="CRITICAL";
                                            if ($check == 0){
                                                $this->db->set('condition',$cond);
                                                $this->db->set('id_unit', $mod->id_unit);
                                                $this->db->set('id_mod', $mod->id_mod);
                                                $this->db->insert('condition');
                                            } else {
                                                $this->db->set('condition',$cond);
                                                $this->db->where('id_unit', $mod->id_unit);
                                                $this->db->where('id_mod', $mod->id_mod);
                                                $this->db->update('condition');
                                            }
                                        }
                                    }
                                    ?>
                                    <table cellspacing="0" width="100%">
                                        <tr>
                                            <?php
                                                $warna = "";
                                                if ($cond == "NORMAL"){
                                                    $warna = "#00ff00";
                                                } elseif ($cond == "ATTENTION") {
                                                    $warna = "#ff9900";
                                                } elseif ($cond == "CRITICAL") {
                                                    $warna = "#ff0000";
                                                }
                                            ?>
                                            <td style="background-color: <?php echo $warna;?>"><div align="center"><h3 style="color: white"><?php echo $cond;?></h3></div></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div> <!-- /widget-content -->	
                    </div> <!-- /widget -->					
		</div> <!-- /span12 -->   
<!--                <pre><?php // echo print_r($fc);?></pre>-->
                <div class="span6">
                    <div class="widget widget-table action-table">
                        <div class="widget-header" align="center"> <i class="icon-th-list"></i>
                            <a href="<?php echo base_url('unit/sos/'.$mod->id_unit.'/'.$mod->id_mod); ?>" target="__blank"><h3>Schedule Oil Sampling Rating</h3></a>
                        </div>
                    <!-- /widget-header -->
                    <div class="widget-content">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th><div align="center">Inspection Date</div></th>
                                    <th><div align="center">Hour Meter</div></th>
                                    <th><div align="center">Rating</div></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <?php if(empty($sos)):?>
                                <td colspan="3"><div align="center">No Data Available</div></td>
                                <?php else:?>
                                <?php foreach ($sos as $s): ?>
                                    <?php
                                        $warna = "";
                                        if ($s->eval_code == "A" || $s->eval_code == "Normal"){
                                            $warna = "#00ff00";
                                        } elseif ($s->eval_code == "B") {
                                            $warna = "#ffff00";
                                        } elseif ($s->eval_code == "C" || $s->eval_code == "Attention") {
                                            $warna = "#ff9900";
                                        } elseif ($s->eval_code == "D" || $s->eval_code == "X" || $s->eval_code == "Urgent") {
                                            $warna = "#ff0000";
                                        }
                                    ?>
                                    <td><div align="center"><?php echo $s->sample_date;?></div></td>
                                    <td><div align="center"><?php echo $s->h_unit?></div></td>
                                    <td style="background-color: <?php echo $warna;?>"><div align="center"><b><?php echo $s->eval_code?></b></div></td>
                                </tr>
                                <?php endforeach; ?>
                                <?php endif;?>
                            </tbody>
                        </table>
                    </div>
                        <!-- /widget-content --> 
                </div>
                <!-- /widget --> 
                <div class="widget widget-table action-table">
                    <div class="widget-header" align="center"> <i class="icon-th-list"></i>
                        <a href="<?php echo base_url('unit/magnetic_plug_screen/'.$mod->id_unit.'/'.$mod->id_mod); ?>" target="__blank"><h3>Magnetic Plug/Screen Rating</h3></a>
                    </div>
                    <!-- /widget-header -->
                    <div class="widget-content">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th><div align="center">Inspection Date</div></th>
                                    <th><div align="center">Hour Meter</div></th>
                                    <th><div align="center">Rating</div></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <?php if(empty($mps)):?>
                                <td colspan="3"><div align="center">No Data Available</div></td>
                                <?php else:?>
                                <?php foreach ($mps as $m): ?>
                                    <?php
                                        $warna = "";
                                        if ($m->rating == "A"){
                                            $warna = "#00ff00";
                                        } elseif ($m->rating == "B") {
                                            $warna = "#ffff00";
                                        } elseif ($m->rating == "C") {
                                            $warna = "#ff9900";
                                        } elseif ($m->rating == "X") {
                                            $warna = "#ff0000";
                                        }
                                    ?>
                                    <td><div align="center"><?php echo $m->ins_date;?></div></td>
                                    <td><div align="center"><?php echo $m->ins_hm?></div></td>
                                    <td style="background-color: <?php echo $warna;?>"><div align="center"><b><?php echo $m->rating?></b></div></td>
                                </tr>
                                <?php endforeach; ?>
                                <?php endif;?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /widget-content --> 
                </div>
                <!-- /widget --> 
                <div class="widget widget-table action-table">
                    <div class="widget-header" align="center"> <i class="icon-th-list"></i>
                        <a href="<?php echo base_url('unit/ta2/'.$mod->id_unit.'/'.$mod->id_mod); ?>" target="_blank"><h3>Technical Analysis 2 Rating</h3></a>
                    </div>
                    <!-- /widget-header -->
                    <div class="widget-content">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th><div align="center">Inspection Date</div></th>
                                    <th><div align="center">Hour Meter</div></th>
                                    <th><div align="center">Rating</div></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <?php if(empty($ta2)):?>
                                <td colspan="3"><div align="center">No Data Available</div></td>
                                <?php else:?>
                                <?php foreach ($ta2 as $t): ?>
                                    <?php
                                        $warna = "";
                                        if ($t->rating == "A"){
                                            $warna = "#00ff00";
                                        } elseif ($t->rating == "B") {
                                            $warna = "#ffff00";
                                        } elseif ($t->rating == "C") {
                                            $warna = "#ff9900";
                                        } elseif ($t->rating == "X") {
                                            $warna = "#ff0000";
                                        }
                                    ?>
                                    <td><div align="center"><?php echo $t->ins_date;?></div></td>
                                    <td><div align="center"><?php echo $t->ins_hm?></div></td>
                                    <td style="background-color: <?php echo $warna;?>"><div align="center"><b><?php echo $t->rating?></b></div></td>
                                </tr>
                                <?php endforeach; ?>
                                <?php endif;?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /widget-content --> 
                </div>
                <!-- /widget --> 
            </div>
            <!-- /span6 -->
            <div class="span6">
                <div class="widget widget-table action-table">
                        <div class="widget-header" align="center"> <i class="icon-th-list"></i>
                            <a href="<?php echo base_url('unit/filter_cut/'.$mod->id_unit.'/'.$mod->id_mod); ?>" target="_blank"><h3>Filter Cut Rating</h3></a>
                        </div>
                    <!-- /widget-header -->
                    <div class="widget-content">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th><div align="center">Inspection Date</div></th>
                                    <th><div align="center">Hour Meter</div></th>
                                    <th><div align="center">Rating</div></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <?php if(empty($fc)):?>
                                <td colspan="3"><div align="center">No Data Available</div></td>
                                <?php else:?>
                                <?php foreach ($fc as $f): ?>
                                    <?php
                                        $warna = "";
                                        if ($f->rating == "A"){
                                            $warna = "#00ff00";
                                        } elseif ($f->rating == "B") {
                                            $warna = "#ffff00";
                                        } elseif ($f->rating == "C") {
                                            $warna = "#ff9900";
                                        } elseif ($f->rating == "X") {
                                            $warna = "#ff0000";
                                        }
                                    ?>
                                    <td><div align="center"><?php echo $f->ins_date;?></div></td>
                                    <td><div align="center"><?php echo $f->ins_hm?></div></td>
                                    <td style="background-color: <?php echo $warna;?>"><div align="center"><b><?php echo $f->rating?></b></div></td>
                                </tr>
                                <?php endforeach; ?>
                                <?php endif;?>
                            </tbody>
                        </table>
                    </div>
                        <!-- /widget-content --> 
                </div>
                <!-- /widget --> 
                <div class="widget widget-table action-table">
                    <div class="widget-header" align="center"> <i class="icon-th-list"></i>
                        <a href="<?php echo base_url('unit/visual_inspection/'.$mod->id_unit.'/'.$mod->id_mod); ?>" target="_blank"><h3>Visual Inpection Rating</h3></a>
                    </div>
                    <!-- /widget-header -->
                    <div class="widget-content">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th><div align="center">Inspection Date</div></th>
                                    <th><div align="center">Hour Meter</div></th>
                                    <th><div align="center">Rating</div></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <?php if(empty($vi)):?>
                                <td colspan="3"><div align="center">No Data Available</div></td>
                                <?php else:?>
                                <?php foreach ($vi as $v): ?>
                                    <?php
                                        $warna = "";
                                        if ($v->rating == "A"){
                                            $warna = "#00ff00";
                                        } elseif ($v->rating == "B") {
                                            $warna = "#ffff00";
                                        } elseif ($v->rating == "C") {
                                            $warna = "#ff9900";
                                        } elseif ($v->rating == "X") {
                                            $warna = "#ff0000";
                                        }
                                    ?>
                                    <td><div align="center"><?php echo $v->ins_date;?></div></td>
                                    <td><div align="center"><?php echo $v->ins_hm?></div></td>
                                    <td style="background-color: <?php echo $warna;?>"><div align="center"><b><?php echo $v->rating?></b></div></td>
                                </tr>
                                <?php endforeach; ?>
                                <?php endif;?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /widget-content --> 
                </div>
                <!-- /widget --> 
                <div class="widget widget-table action-table">
                    <div class="widget-header" align="center"> <i class="icon-th-list"></i>
                        <a href="<?php echo base_url('unit/ed/'.$mod->id_unit.'/'.$mod->id_mod); ?>" target="_blank"><h3>Electronic Data Rating</h3></a>
                    </div>
                    <!-- /widget-header -->
                    <div class="widget-content">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th><div align="center">Inspection Date</div></th>
                                    <th><div align="center">Hour Meter</div></th>
                                    <th><div align="center">Rating</div></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <?php if(empty($ed)):?>
                                <td colspan="3"><div align="center">No Data Available</div></td>
                                <?php else:?>
                                <?php foreach ($ed as $e): ?>
                                    <?php
                                        $warna = "";
                                        if ($e->rating == "A"){
                                            $warna = "#00ff00";
                                        } elseif ($e->rating == "B") {
                                            $warna = "#ffff00";
                                        } elseif ($e->rating == "C") {
                                            $warna = "#ff9900";
                                        } elseif ($e->rating == "X") {
                                            $warna = "#ff0000";
                                        }
                                    ?>
                                    <td><div align="center"><?php echo $e->ins_date;?></div></td>
                                    <td><div align="center"><?php echo $e->ins_hm?></div></td>
                                    <td style="background-color: <?php echo $warna;?>"><div align="center"><b><?php echo $e->rating?></b></div></td>
                                </tr>
                                <?php endforeach; ?>
                                <?php endif;?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /widget-content --> 
                </div>
                <!-- /widget --> 
            </div>
            <!-- /span6 -->
            </div> <!-- /row -->
        </div> <!-- /container -->
    </div> <!-- /main-inner -->
</div> <!-- /main -->