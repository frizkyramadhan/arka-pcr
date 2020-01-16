<div class="main">
    <div class="main-inner">
        <div class="container">
          <div class="row">
            <div class="span12">      		
                <div class="widget ">
                    <div class="widget-header">
                        <i class="icon-cogs"></i>
                        <h3>Component Lists</h3>
                    </div> <!-- /widget-header -->
                    <div class="widget-content">
                        <h4><span style="float: right"><a href="<?php echo site_url('component/add'); ?>" class="btn btn-success">+ Add Component</a></span></h4><br><br>
                        <div class="form-horizontal">
                        <table id="example" class="table table-striped table-bordered table-condensed" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th><div align="center">No</div></th>
                                    <th>Component </th>
                                    <th>Component Type</th>
                                    <th><div align="center">Action</div></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php $i=1; ?>
                                    <?php foreach ($component as $row): ?>
                                    <td><div align="center"><?php echo $i++; ?></div></td>
                                    <td><?php echo $row->comp_desc; ?></td>
                                    <td><?php echo $row->comp_type; ?></td>
                                    <td>
                                        <div align="center">
                                        <a href="<?php echo base_url('component/edit/'.$row->id_comp); ?>" class="btn btn-mini btn-info">&nbsp;&nbsp;Edit&nbsp;&nbsp;</a>
                                        <a href="<?php echo base_url('component/delete/'.$row->id_comp); ?>" class="btn btn-mini btn-danger" onclick="return confirm('Are you want to delete this component?')">Delete</a>    
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach?>
                            </tbody>
                        </table>
                        </div>
                    </div> <!-- /widget-content -->	
                </div> <!-- /widget -->	
                </div> <!-- /span8 -->
            </div> <!-- /row -->
        </div> <!-- /container -->
    </div> <!-- /main-inner -->
</div> <!-- /main -->