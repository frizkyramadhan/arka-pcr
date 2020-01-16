<div class="main">
    <div class="main-inner">
        <div class="container">
            <div class="row">
                <div class="span12">
                    <div class="widget">
                        <div class="widget-header">
                            <i class="icon-check"></i>
                            <h3>Magnetic Plug/Screen Inspection Detail</h3>
                        </div> <!-- /widget-header -->
                        <div class="widget-content">
                            <h4><span style="float: left"><a href="<?php echo site_url('unit/detail/'.$mod->id_unit); ?>" class="btn btn-info"><i class="icon-arrow-left"></i> Back</a></span></h4>
                            <h4><span style="float: right"><a href="<?php echo site_url('unit/export_inspection_m/'.$mod->id_unit.'/'.$mod->id_mod); ?>" class="btn btn-warning">Export</a></span></h4>
                            <h4><span style="float: right">&nbsp;</span></h4>
                            <?php // if(empty($reps)):?>
                            <h4><span style="float: right"><a href="<?php echo site_url('unit/add_inspection_m/'.$mod->id_unit.'/'.$mod->id_mod); ?>" class="btn btn-success"><i class="icon-plus"></i> Add Inspection</a></span></h4><br><br>
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
                                <table id="example1" class="table table-bordered table-condensed" cellspacing="0" width="100%">
                                    <thead>
                                        <tr style="font-weight: bold">
                                            <td><div align="center">No</div></td>
                                            <td><div align="center">Inspection Date</div></td>
                                            <td><div align="center">Hour Meter</div></td>
                                            <td><div align="center">Rating</div></td>
                                            <td><div align="center">Type</div></td>
                                            <td><div align="center">Action</div></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <?php if(empty($magnetic)):?>
                                            <td colspan="6"><div align="center">No Data Available</div></td>
                                            <?php else:?>
                                            <?php $i=1; ?>
                                            <?php foreach ($magnetic as $row): ?>
                                            <?php
                                            $warna = "";
                                            if ($row['rating'] == "A"){
                                                $warna = "#00ff00";
                                            } elseif ($row['rating'] == "B") {
                                                $warna = "#ffff00";
                                            } elseif ($row['rating'] == "C") {
                                                $warna = "#ff9900";
                                            } elseif ($row['rating'] == "X") {
                                                $warna = "#ff0000";
                                            }
                                            ?>
                                            <td><div align="center"><?php echo $i++; ?></div></td>
                                            <td><div align="center"><?php echo $row['ins_date']; ?></div></td>
                                            <td><div align="center"><?php echo $row['ins_hm']; ?></div></td>
                                            <td bgcolor=<?php echo $warna;?>><div align="center"><b><?php echo $row['rating']; ?></b></div></td>
                                            <td><div align="center"><?php echo $row['type']; ?></div></td>
                                            <td>
                                                <div align="center">
                                                    <a href="<?php echo base_url('unit/edit_inspection_m/'.$row['id_ins'].'/'.$row['id_unit'].'/'.$row['id_mod']); ?>" class="btn btn-mini btn-info"><i class="icon-edit" title="Edit"></i></a>
                                                    <a href="<?php echo base_url('unit/delete_inspection_m/'.$row['id_ins'].'/'.$row['id_unit'].'/'.$row['id_mod']); ?>" class="btn btn-mini btn-danger" onclick="return confirm('Are you want to delete this record?')"><i class="icon-trash" title="Delete"></i></a>
                                                </div>
                                            </td>
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