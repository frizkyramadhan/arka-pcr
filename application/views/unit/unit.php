<div class="main">
    <div class="main-inner">
        <div class="container">
          <div class="row">
            <div class="span12">      		
                <div class="widget ">
                    <div class="widget-header">
                        <i class="icon-truck"></i>
                        <h3>Unit Lists</h3>
                    </div> <!-- /widget-header -->
                    <div class="widget-content">
                        <h4><span style="float: left"><a href="<?php echo site_url('unit/upload_hm'); ?>" class="btn btn-info">Upload HM</a> <a href="<?php echo site_url('unit/download_hm'); ?>" class="btn btn-info">Download Last HM</a></span></h4>
                        <h4><span style="float: right"><a href="<?php echo site_url('unit/add'); ?>" class="btn btn-success">+ Add Unit</a></span></h4><br><br>
                        <div class="form-horizontal">
                            <?php 
                            $attr = array("class" => "form-horizontal", "role" => "form", "id" => "form1", "name" => "form1");
                            echo form_open("unit/search", $attr);
                            ?>
                            <div class="form-horizontal">
                                <div align="right">
                                    <input class="form-control" name="search" placeholder="Search..." type="text" value="<?php echo set_value('unit_no'); ?>" />
                                    <input name="btn_search" type="submit" class="btn btn-danger" value="Search" />
                                    <a href="<?php echo base_url(). "unit/index"; ?>" class="btn btn-primary">Show All</a>
                                </div>
                            <?php echo form_close(); ?>
                            <br>
                            <!--<pre><?php // print_r($pengguna);?><br><?php // print_r($unitlist);?></pre>-->
                            <table class="table table-striped table-bordered table-condensed" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><div align="center">No</div></th>
                                        <th style="width: 50px">Unit No</th>
                                        <th>Description</th>
                                        <th>Model</th>
                                        <th><div align="center">HM End</div></th>
                                        <th><div align="center">WH/Day</div></th>
                                        <th width="70px"><div align="center">HM Date</div></th>
                                        <th>Project</th>
                                        <th style="width: 100px"><div align="center">Action</div></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <?php if (empty($unitlist)):?>
                                        <td colspan="9"><div align="center">No Data Available</div></td>
                                        <?php else:?>
                                        <?php for ($i = 0; $i < count($unitlist); ++$i) { ?>
                                        <?php
                                        $query = $this->db->query("select * from hm left join unit on hm.id_unit = unit.id_unit where hm.id_unit = ".$unitlist[$i]->id_unit." order by hm.id_hm desc limit 1")->row();
                                        ?>
                                        <td><div align="center"><?php echo ($page+$i+1); ?></div></td>
                                        <td><?php echo $unitlist[$i]->unit_no; ?></td>
                                        <td><?php echo $unitlist[$i]->unit_desc; ?></td>
                                        <td><?php echo $unitlist[$i]->model_no; ?></td>
                                        <td><div align="center">
                                            <?php if (empty($query)){
                                                echo "-";
                                            }else{
                                                echo $query->hm_unit;
                                            }?>
                                        </div></td>
                                        <td><div align="center">
                                            <?php if (empty($query)){
                                                echo "-";
                                            }else{
                                                echo $query->wh_day;
                                            }?>
                                        </div></td>
                                        <td><div align="center">
                                            <?php if (empty($query)){
                                                echo "-";
                                            }else{
                                                echo $query->date_hm;
                                            }?>
                                        </div></td>
                                        <td><div align="center"><?php echo $unitlist[$i]->kode_project; ?></div></td>
                                        <td>
                                            <div align="center">
                                            <a href="<?php echo base_url('unit/detail/'.$unitlist[$i]->id_unit); ?>" class="btn btn-mini btn-warning">Detail</a>
                                            <!--<a href="<?php echo base_url('unit/edit/'.$unitlist[$i]->id_unit); ?>" class="btn btn-mini btn-info">&nbsp;&nbsp;Edit&nbsp;&nbsp;</a>-->
                                            <a href="<?php echo base_url('unit/delete/'.$unitlist[$i]->id_unit); ?>" class="btn btn-mini btn-danger" onclick="return confirm('Are you want to delete this unit?')">Delete</a>    
                                            </div>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                    <?php endif;?>
                                </tbody>
                            </table>
                            <div align="right"><?php echo $this->pagination->create_links(); ?></div>
                            </div>
                        </div>
                    </div> <!-- /widget-content -->	
                </div> <!-- /widget -->	
                </div> <!-- /span8 -->
            </div> <!-- /row -->
        </div> <!-- /container -->
    </div> <!-- /main-inner -->
</div> <!-- /main -->

