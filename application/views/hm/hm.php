<div class="main">
    <div class="main-inner">
        <div class="container">
          <div class="row">
            <div class="span12">      		
                <div class="widget ">
                    <div class="widget-header">
                        <i class="icon-time"></i>
                        <h3>Hour Meter Lists</h3>
                    </div> <!-- /widget-header -->
                    <div class="widget-content">
                        <h4><span style="float: left"><a href="<?php echo site_url('unit/upload_hm'); ?>" class="btn btn-info">Upload HM</a></span></h4>
                        <h4><span style="float: right"><a href="<?php echo site_url('hm/add'); ?>" class="btn btn-success">+ Add HM</a></span></h4><br><br>
                        <?php 
                        $attr = array("class" => "form-horizontal", "role" => "form", "id" => "form1", "name" => "form1");
                        echo form_open("hm/search", $attr);
                        ?>
                        <div class="form-horizontal">
                            <div align="left">
                                <input class="form-control" name="search" placeholder="Search..." type="text" value="<?php echo set_value('unit_no'); ?>" />
                                <input name="btn_search" type="submit" class="btn btn-danger" value="Search" />
                                <a href="<?php echo base_url(). "hm/index"; ?>" class="btn btn-primary">Show All</a>
                            </div>
                        <?php echo form_close(); ?>
                            <br>
                        <table class="table table-striped table-bordered table-condensed" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th><div align="center">No</div></th>
                                    <th><div align="center">Unit No</div></th>
                                    <th><div align="center">HM Unit</div></th>
                                    <th><div align="center">WH/Day</div></th>
                                    <th width="150px"><div align="center">Date</div></th>
                                    <th width="150px"><div align="center">Action</div></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php if (empty($hmlist)):?>
                                    <td colspan="6"><div align="center">No Data Available</div></td>
                                    <?php else:?>
                                    <?php for ($i = 0; $i < count($hmlist); ++$i) { ?>
                                    <td><div align="center"><?php echo ($page+$i+1); ?></div></td>
                                    <td><?php echo $hmlist[$i]->unit_no; ?></td>
                                    <td><div align="right"><?php echo $hmlist[$i]->hm_unit; ?></div></td>
                                    <td><div align="right"><?php echo $hmlist[$i]->wh_day; ?></div></td>
                                    <td><div align="right"><?php echo $hmlist[$i]->date_hm; ?></div></td>
                                    <td>
                                        <div align="center">
                                        <a href="<?php echo base_url('hm/edit/'.$hmlist[$i]->id_hm); ?>" class="btn btn-mini btn-info">&nbsp;&nbsp;Edit&nbsp;&nbsp;</a>
                                        <a href="<?php echo base_url('hm/delete/'.$hmlist[$i]->id_hm); ?>" class="btn btn-mini btn-danger" onclick="return confirm('Are you want to delete this record?')">Delete</a>    
                                        </div>
                                    </td>
                                </tr>
                                <?php } ?>
                                <?php endif;?>
                            </tbody>
                        </table>
                            <div align="center"><?php echo $this->pagination->create_links(); ?></div>
                        </div>
                    </div> <!-- /widget-content -->	
                </div> <!-- /widget -->	
                </div> <!-- /span8 -->
            </div> <!-- /row -->
        </div> <!-- /container -->
    </div> <!-- /main-inner -->
</div> <!-- /main -->