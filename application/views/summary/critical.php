<div class="main">
    <div class="main-inner">
        <div class="container">
          <div class="row">
            <div class="span12">      		
                <div class="widget ">
                    <div class="widget-header">
                        <i class="icon-warning-sign"></i>
                        <h3>PCR - Critical Component Condition</h3>
                    </div> <!-- /widget-header -->
                    <div class="widget-content">
                        <table id="example" class="table table-bordered table-condensed" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th><div align="center"><i class="icon-arrow-down"></i></div></th>
                                    <th><div align="center">Site</div></th>
                                    <th><div align="center">Unit No.</div></th>
                                    <th><div align="center">Model</div></th>
                                    <th><div align="center">Component</div></th>
                                    <th><div align="center">Component Condition</div></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php if (empty($critical)):?>
                                    <td colspan="16"><div align="center">No Data Available</div></td>
                                    <?php else:?>
                                            <?php foreach ($critical as $row): ?>
                                            <td><div align="center"><a href="<?php echo base_url('unit/condition/'.$row->id_unit.'/'.$row->id_mod);?>" target="blank"><i class="icon-circle-arrow-right"></i></a></div></td>
                                            <td><div align="center"><?php echo $row->kode_project; ?></div></td>
                                            <td><div align="center"><?php echo $row->unit_no; ?></div></td>
                                            <td><?php echo $row->model_no; ?></td>
                                            <td><?php echo $row->comp_desc; ?></td>
                                            <td><div align="center"><?php echo $row->condition; ?></div></td>
                                        </tr>
                                        <?php endforeach?>
                                <?php endif;?>
                            </tbody>
                        </table>
                    </div> <!-- /widget-content -->	
                </div> <!-- /widget -->	
                </div> <!-- /span8 -->
            </div> <!-- /row -->
        </div> <!-- /container -->
    </div> <!-- /main-inner -->
</div> <!-- /main -->