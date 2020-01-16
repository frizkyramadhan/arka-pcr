<div class="main">
    <div class="main-inner">
        <div class="container">
            <div class="row">
                <div class="span12">
                    <div class="widget">
                        <div class="widget-header">
                            <i class="icon-truck"></i>
                            <h3>Unit Detail</h3>
                        </div> <!-- /widget-header -->
                        <div class="widget-content">
                            <h4><span style="float: left"><a href="<?php echo site_url('unit'); ?>" class="btn btn-info"><i class="icon-arrow-left"></i>&nbsp;&nbsp;Back</a></span></h4>
                            <h4><span style="float: right"><a href="<?php echo base_url('unit/edit/'.$unit->id_unit); ?>" class="btn btn-success">&nbsp;&nbsp;Edit&nbsp;&nbsp;</a></span></h4><br><br>
                            <div class="pricing-plans plans-1">
                                <div class="plan-container">
                                    <div class="plan orange">
<!--                                        <pre>
                                            <?php //print_r($unit);?>
                                            <?php // print_r($comp);?>
                                        </pre>-->
                                        <div class="plan-header">
                                            <div class="plan-title">
                                                <?php echo $unit->kode_project;?>
					    </div> <!-- /plan-title -->
					    <div class="plan-price">
                                                <?php echo $unit->unit_no;?>
                                                <span class="term" style="font-size: 10pt; font-weight: bold"><?php echo $unit->unit_desc;?> | <?php echo $unit->sn_unit;?></span>
                                            </div> <!-- /plan-price -->
					</div> <!-- /plan-header -->	          
                                        <br>
                                        <div class="form-horizontal">
                                            <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th><div align="center">No</div></th>
                                                        <th>Component </th>
                                                        <th>Type</th>
                                                        <th><div align="center">Policy</div></th>
                                                        <th><div align="center">Price (IDR)</div></th>
                                                        <th><div align="center">Condition</div></th>
                                                        <th width="5%"><div align="center"></div></th>
                                                        <th width="5%"><div align="center"></div></th>
                                                        <th width="5%"><div align="center"></div></th>
                                                        <th width="5%"><div align="center"></div></th>
                                                        <th width="5%"><div align="center"></div></th>
                                                        <th width="5%"><div align="center"></div></th>
                                                        <th width="5%"><div align="center"></div></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <?php if(empty($comp)):?>
                                                        <td colspan="13"><div align="center">No Data Available</div></td>
                                                        <?php else:?>
                                                        <?php $i=1; ?>
                                                        <?php foreach ($comp as $row): ?>
                                                        <td><div align="center"><?php echo $i++; ?></div></td>
                                                        <td><a href="<?php echo base_url('unit/condition/'.$row->id_unit.'/'.$row->id_mod); ?>"><?php echo $row->comp_desc; ?></a></td>
                                                        <td><?php echo $row->comp_type; ?></td>
                                                        <td><div align="right"><?php echo $row->policy; ?></div></td>
                                                        <td><div align="right"><?php echo $row->price; ?></div></td>
                                                        <?php
                                                        $rating_i = $this->db->query("select type, rating
                                                        from inspection a
                                                        where a.ins_date = (
                                                                select max(ins_date)
                                                            from inspection b
                                                            where a.type = b.type and a.id_unit = b.id_unit and a.id_mod = b.id_mod
                                                        ) and a.id_unit = ".$row->id_unit." and a.id_mod = ".$row->id_mod."")->result_array();
                                                        $rating_s = $this->db->query("select type,eval_code from sos c where c.id_unit = ".$row->id_unit." and c.id_mod = ".$row->id_mod." order by sample_date desc limit 1")->row();

                                                        $cond = "";
                                                        if (empty($rating_i)){
                                                            if (empty($rating_s)){
                                                            }else{
                                                                if ($rating_s->eval_code == 'A' || $rating_s->eval_code == 'B' || $rating_s->eval_code == 'Normal'){
                                                                    $cond = "NORMAL";
                                                                    $this->db->set('condition',$cond);
                                                                    $this->db->where('id_mod', $row->id_mod);
                                                                    $this->db->update('commod');
                                                                } elseif ($rating_s->eval_code == 'C' || $rating_s->eval_code == 'Attention'){
                                                                    $cond = "ATTENTION";
                                                                    $this->db->set('condition',$cond);
                                                                    $this->db->where('id_mod', $row->id_mod);
                                                                    $this->db->update('commod');
                                                                } elseif ($rating_s->eval_code == 'D' || $rating_s->eval_code == 'X' || $rating_s->eval_code == 'Urgent'){
                                                                    $cond = "CRITICAL";
                                                                    $this->db->set('condition',$cond);
                                                                    $this->db->where('id_mod', $row->id_mod);
                                                                    $this->db->update('commod');
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
                                                                $this->db->set('condition',$cond);
                                                                $this->db->where('id_mod', $row->id_mod);
                                                                $this->db->update('commod');
                                                            } elseif (substr_count($str_i, "C") == 1 && strpos($str_i, 'X') === false){
                                                                $cond = "ATTENTION";
                                                                $this->db->set('condition',$cond);
                                                                $this->db->where('id_mod', $row->id_mod);
                                                                $this->db->update('commod');
                                                            } elseif (substr_count($str_i, "C") > 1 || strpos($str_i, 'X') !== false){
                                                                $cond = "CRITICAL";
                                                                $this->db->set('condition',$cond);
                                                                $this->db->where('id_mod', $row->id_mod);
                                                                $this->db->update('commod');
                                                            }
                                                        }
                                                        $warna = "";
                                                        if ($cond == "NORMAL"){
                                                            $warna = "#00ff00";
                                                        } elseif ($cond == "ATTENTION") {
                                                            $warna = "#ff9900";
                                                        } elseif ($cond == "CRITICAL") {
                                                            $warna = "#ff0000";
                                                        }
                                                        ?>
                                                        <td style="background-color: <?php echo $warna;?>">
                                                            <div align="center">
                                                                <b><?php echo $cond;?></b>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div align="center">
                                                                <a href="<?php echo base_url('unit/replacement/'.$row->id_unit.'/'.$row->id_mod); ?>" class="btn btn-mini btn-success">&nbsp;&nbsp;PCR&nbsp;&nbsp;</a>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div align="center">
                                                                <b>
                                                                <a href="<?php echo base_url('unit/sos/'.$row->id_unit.'/'.$row->id_mod); ?>" class="btn btn-mini btn-warning">&nbsp;&nbsp;SOS&nbsp;&nbsp;</a>
                                                                <br>
                                                                <?php
                                                                $sos = $this->db->query("select eval_code from sos c where c.sample_date = (select max(sample_date) from sos d where c.type = d.type and c.id_unit = d.id_unit and c.id_mod = d.id_mod) and c.id_unit = ".$row->id_unit." and c.id_mod = ".$row->id_mod."")->row();
                                                                if (empty($sos)){
                                                                    echo "-";
                                                                }else{
                                                                    echo $sos->eval_code;
                                                                }
                                                                ?>
                                                                </b>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div align="center">
                                                                <b>
                                                                <a href="<?php echo base_url('unit/filter_cut/'.$row->id_unit.'/'.$row->id_mod); ?>" class="btn btn-mini btn-danger">&nbsp;&nbsp;FC&nbsp;&nbsp;</a>
                                                                <br>
                                                                <?php
                                                                $fc = $this->db->query("select rating from inspection a where a.ins_date = ( select max(ins_date) from inspection b where a.type = b.type and a.id_unit = b.id_unit and a.id_mod = b.id_mod ) and a.id_unit = ".$row->id_unit." and a.id_mod = ".$row->id_mod." and a.type = 'FC'")->row();
                                                                if (empty($fc)){
                                                                    echo "-";
                                                                }else{
                                                                    echo $fc->rating;
                                                                }
                                                                ?>
                                                                </b>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div align="center">
                                                                <b>
                                                                <a href="<?php echo base_url('unit/magnetic_plug_screen/'.$row->id_unit.'/'.$row->id_mod); ?>" class="btn btn-mini btn-primary">&nbsp;&nbsp;MP/S&nbsp;&nbsp;</a>
                                                                <br>
                                                                <?php
                                                                $mps = $this->db->query("select rating from inspection a where a.ins_date = ( select max(ins_date) from inspection b where a.type = b.type and a.id_unit = b.id_unit and a.id_mod = b.id_mod ) and a.id_unit = ".$row->id_unit." and a.id_mod = ".$row->id_mod." and a.type = 'MPS'")->row();
                                                                if (empty($mps)){
                                                                    echo "-";
                                                                }else{
                                                                    echo $mps->rating;
                                                                }
                                                                ?>
                                                                </b>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div align="center">
                                                                <b>
                                                                <a href="<?php echo base_url('unit/visual_inspection/'.$row->id_unit.'/'.$row->id_mod); ?>" class="btn btn-mini btn-inverse">&nbsp;&nbsp;VI&nbsp;&nbsp;</a>
                                                                <br>
                                                                <?php
                                                                $vi = $this->db->query("select rating from inspection a where a.ins_date = ( select max(ins_date) from inspection b where a.type = b.type and a.id_unit = b.id_unit and a.id_mod = b.id_mod ) and a.id_unit = ".$row->id_unit." and a.id_mod = ".$row->id_mod." and a.type = 'VI'")->row();
                                                                if (empty($vi)){
                                                                    echo "-";
                                                                }else{
                                                                    echo $vi->rating;
                                                                }
                                                                ?>
                                                                </b>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div align="center">
                                                                <b>
                                                                <a href="<?php echo base_url('unit/ta2/'.$row->id_unit.'/'.$row->id_mod); ?>" class="btn btn-mini">&nbsp;&nbsp;TA2&nbsp;&nbsp;</a>
                                                                <br>
                                                                <?php
                                                                $ta2 = $this->db->query("select rating from inspection a where a.ins_date = ( select max(ins_date) from inspection b where a.type = b.type and a.id_unit = b.id_unit and a.id_mod = b.id_mod ) and a.id_unit = ".$row->id_unit." and a.id_mod = ".$row->id_mod." and a.type = 'TA2'")->row();
                                                                if (empty($ta2)){
                                                                    echo "-";
                                                                }else{
                                                                    echo $ta2->rating;
                                                                }
                                                                ?>
                                                                </b>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div align="center">
                                                                <b>
                                                                <a href="<?php echo base_url('unit/ed/'.$row->id_unit.'/'.$row->id_mod); ?>" class="btn btn-mini btn-info">&nbsp;&nbsp;ED&nbsp;&nbsp;</a>
                                                                <br>
                                                                <?php
                                                                $ed = $this->db->query("select rating from inspection a where a.ins_date = ( select max(ins_date) from inspection b where a.type = b.type and a.id_unit = b.id_unit and a.id_mod = b.id_mod ) and a.id_unit = ".$row->id_unit." and a.id_mod = ".$row->id_mod." and a.type = 'ED'")->row();
                                                                if (empty($ed)){
                                                                    echo "-";
                                                                }else{
                                                                    echo $ed->rating;
                                                                }
                                                                ?>
                                                                </b>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach?>
                                                    <?php endif;?>
                                                </tbody>
                                            </table>
					</div> <!-- /plan-features -->
                                    </div> <!-- /plan -->
				</div> <!-- /plan-container -->
                            </div> <!-- /pricing-plans -->
			</div> <!-- /widget-content -->
                    </div> <!-- /widget -->					
		</div> <!-- /span12 -->     	
            </div> <!-- /row -->
        </div> <!-- /container -->
    </div> <!-- /main-inner -->
</div> <!-- /main -->