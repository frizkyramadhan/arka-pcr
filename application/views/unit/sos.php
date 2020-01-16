<div class="main">
    <div class="main-inner">
        <div class="container">
            <div class="row">
                <div class="span12">
                    <div class="widget">
                        <div class="widget-header">
                            <i class="icon-tint"></i>
                            <h3>Oil Sampling Detail</h3>
                        </div> <!-- /widget-header -->
                        <div class="widget-content">
                            <h4><span style="float: left"><a href="<?php echo site_url('unit/detail/'.$mod->id_unit); ?>" class="btn btn-info"><i class="icon-arrow-left"></i> Back</a></span></h4>
                            <h4><span style="float: right"><a href="<?php echo site_url('unit/export_sos/'.$mod->id_unit.'/'.$mod->id_mod); ?>" class="btn btn-warning">Export</a></span></h4>
                            <h4><span style="float: right">&nbsp;</span></h4>
                            <?php // if(empty($reps)):?>
                            <h4><span style="float: right"><a href="<?php echo site_url('unit/add_sos/'.$mod->id_unit.'/'.$mod->id_mod); ?>" class="btn btn-success"><i class="icon-plus"></i> Add Sampling</a></span></h4><br><br>
                            <?php // endif;?>
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
                                <table id="example1" class="table table-bordered table-condensed" cellspacing="0" width="100%" style="display: block; overflow-x: auto">
                                    <thead>
                                        <tr style="font-weight: bold">
                                            <td><div align="center">No</div></td>
                                            <td><div align="center">Act</div></td>
                                            <td width="40px"><div align="center">Sample Date</div></td>
                                            <td><div align="center">Lab Name</div></td>
                                            <td><div align="center">Lab No.</div></td>
                                            <td><div align="center">Oil Type</div></td>
                                            <td><div align="center">Hrs Oil</div></td>
                                            <td><div align="center">Hrs Unit</div></td>
                                            <td><div align="center">Evaluation Code</div></td>
                                            <td><div align="center">Recommendation</div></td>
                                            <td><div align="center">Oil Change</div></td>
                                            <td><div align="center">Oil Added</div></td>
<!--                                            <td><div align="center">Fe</div></td>
                                            <td><div align="center">Cu</div></td>
                                            <td><div align="center">Cr</div></td>
                                            <td><div align="center">Si</div></td>
                                            <td><div align="center">Al</div></td>
                                            <td><div align="center">Ni</div></td>
                                            <td><div align="center">Sn</div></td>
                                            <td><div align="center">Pb</div></td>
                                            <td><div align="center">PQ</div></td>
                                            <td><div align="center">Soot</div></td>
                                            <td><div align="center">Oxid</div></td>
                                            <td><div align="center">Nitr</div></td>
                                            <td><div align="center">SOX</div></td>
                                            <td><div align="center">4um</div></td>
                                            <td><div align="center">6um</div></td>
                                            <td><div align="center">14um</div></td>
                                            <td><div align="center">15um</div></td>
                                            <td><div align="center">ISO4406</div></td>
                                            <td><div align="center">ISO.14</div></td>
                                            <td><div align="center">ISO.6</div></td>
                                            <td><div align="center">Ca</div></td>
                                            <td><div align="center">Zn</div></td>
                                            <td><div align="center">Mo</div></td>
                                            <td><div align="center">Bo</div></td>
                                            <td><div align="center">P</div></td>
                                            <td><div align="center">Na</div></td>
                                            <td><div align="center">K</div></td>
                                            <td><div align="center">Mg</div></td>
                                            <td><div align="center">Visc</div></td>
                                            <td><div align="center">TBN</div></td>
                                            <td><div align="center">TAN</div></td>
                                            <td><div align="center">Gly</div></td>
                                            <td><div align="center">WATER</div></td>
                                            <td><div align="center">DILUTION</div></td>-->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <?php if(empty($sos)):?>
                                            <td colspan="46"><div align="center">No Data Available</div></td>
                                            <?php else:?>
                                            <?php $i=1; ?>
                                            <?php foreach ($sos as $row): ?>
                                            <?php
                                            $warna = "";
                                            if ($row['eval_code'] == "A" || $row['eval_code'] == "Normal"){
                                                $warna = "#00ff00";
                                            } elseif ($row['eval_code'] == "B" || $row['eval_code'] == "Attention") {
                                                $warna = "#ffff00";
                                            } elseif ($row['eval_code'] == "C" || $row['eval_code'] == "D") {
                                                $warna = "#ff9900";
                                            } elseif ($row['eval_code'] == "X" || $row['eval_code'] == "Urgent") {
                                                $warna = "#ff0000";
                                            }
                                            ?>
                                            <td><div align="center"><?php echo $i++; ?></div></td>
                                            <td>
                                                <div align="center">
                                                    <a href="<?php echo base_url('unit/edit_sos/'.$row['id_sos'].'/'.$row['id_unit'].'/'.$row['id_mod']); ?>" class="btn btn-mini btn-info"><i class="icon-edit" title="Edit"></i></a>
                                                    <?php if ($pengguna->level == 'Admin'):?>
                                                    <a href="<?php echo base_url('unit/delete_sos/'.$row['id_sos'].'/'.$row['id_unit'].'/'.$row['id_mod']); ?>" class="btn btn-mini btn-danger"><i class="icon-remove" title="Remove"></i></a>
                                                    <?php endif;?>
                                                
                                                </div>
                                            </td>
                                            <td><div align="center"><?php echo $row['sample_date']; ?></div></td>
                                            <td><div align="center"><?php echo $row['lab_name']; ?></div></td>
                                            <td><div align="center"><?php echo $row['lab_no']; ?></div></td>
                                            <td><div align="center"><?php echo $row['oil_type']; ?></div></td>
                                            <td><div align="center"><?php echo $row['h_oil']; ?></div></td>
                                            <td><div align="center"><?php echo $row['h_unit']; ?></div></td>
                                            <td bgcolor=<?php echo $warna; ?>><div align="center"><b><?php echo $row['eval_code']; ?></b></div></td>
                                            <td><div align="center"><textarea rows="1" readonly="true"><?php echo $row['recommendation']; ?></textarea></div></td>
                                            <td><div align="center"><?php echo $row['oil_change']; ?></div></td>
                                            <td><div align="center"><?php echo $row['oil_added']; ?></div></td>
<!--                                            <td><div align="center"><?php // echo $row['fe']; ?></div></td>
                                            <td><div align="center"><?php // echo $row['cu']; ?></div></td>
                                            <td><div align="center"><?php // echo $row['cr']; ?></div></td>
                                            <td><div align="center"><?php // echo $row['si']; ?></div></td>
                                            <td><div align="center"><?php // echo $row['al']; ?></div></td>
                                            <td><div align="center"><?php // echo $row['ni']; ?></div></td>
                                            <td><div align="center"><?php // echo $row['sn']; ?></div></td>
                                            <td><div align="center"><?php // echo $row['pb']; ?></div></td>
                                            <td><div align="center"><?php // echo $row['pq']; ?></div></td>
                                            <td><div align="center"><?php // echo $row['soot']; ?></div></td>
                                            <td><div align="center"><?php // echo $row['oxid']; ?></div></td>
                                            <td><div align="center"><?php // echo $row['nitr']; ?></div></td>
                                            <td><div align="center"><?php // echo $row['sox']; ?></div></td>
                                            <td><div align="center"><?php // echo $Crow['4um']; ?></div></td>
                                            <td><div align="center"><?php // echo $row['6um']; ?></div></td>
                                            <td><div align="center"><?php // echo $row['14um']; ?></div></td>
                                            <td><div align="center"><?php // echo $row['14um']; ?></div></td>
                                            <td><div align="center"><?php // echo $row['15um']; ?></div></td>
                                            <td><div align="center"><?php // echo $row['iso4406']; ?></div></td>
                                            <td><div align="center"><?php // echo $row['iso14']; ?></div></td>
                                            <td><div align="center"><?php // echo $row['iso6']; ?></div></td>
                                            <td><div align="center"><?php // echo $row['ca']; ?></div></td>
                                            <td><div align="center"><?php // echo $row['zn']; ?></div></td>
                                            <td><div align="center"><?php // echo $row['mo']; ?></div></td>
                                            <td><div align="center"><?php // echo $row['bo']; ?></div></td>
                                            <td><div align="center"><?php // echo $row['p']; ?></div></td>
                                            <td><div align="center"><?php // echo $row['na']; ?></div></td>
                                            <td><div align="center"><?php // echo $row['k']; ?></div></td>
                                            <td><div align="center"><?php // echo $row['mg']; ?></div></td>
                                            <td><div align="center"><?php // echo $row['visc']; ?></div></td>
                                            <td><div align="center"><?php // echo $row['tbn']; ?></div></td>
                                            <td><div align="center"><?php // echo $row['tan']; ?></div></td>
                                            <td><div align="center"><?php // echo $row['gly']; ?></div></td>
                                            <td><div align="center"><?php // echo $row['water']; ?></div></td>                                            
                                            <td><div align="center"><?php // echo $row['dilution']; ?></div></td>                                            -->
                                        </tr>
<!--                                        <pre>
                                            <?php // print_r($sos);?>
                                        </pre>-->
                                        <?php endforeach?>
                                        <?php endif;?>
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