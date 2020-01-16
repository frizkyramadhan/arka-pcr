<div class="main">
    <div class="main-inner">
        <div class="container">
          <div class="row">
            <div class="span12">      		
                <div class="widget ">
                    <div class="widget-header">
                        <i class="icon-th-large"></i>
                        <h3>Model Lists</h3>
                    </div> <!-- /widget-header -->
                    <div class="widget-content">
                        <h4><span style="float: right"><a href="<?php echo site_url('model/add'); ?>" class="btn btn-success">+ Add Model</a></span></h4><br><br>
                        <div class="form-horizontal">
                        <table id="example" class="table table-bordered table-condensed" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th><div align="center">No</div></th>
                                    <th>Model No. </th>
                                    <th>Manufacture</th>
                                    <th>Description</th>
                                    <th><div align="center">Action</div></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php $i=1; ?>
                                    <?php foreach ($model as $row): ?>
                                    <td><div align="center"><?php echo $i++; ?></div></td>
                                    <td><?php echo $row->model_no; ?></td>
                                    <td><?php echo $row->manufacture; ?></td>
                                    <td><?php echo $row->description; ?></td>
                                    <td>
                                        <div align="center">
                                        <a href="<?php echo base_url('model/detail/'.$row->id_model); ?>" class="btn btn-mini btn-warning">&nbsp;&nbsp;Detail&nbsp;&nbsp;</a>
                                        <!--<a href="<?php echo base_url('model/edit/'.$row->id_model); ?>" class="btn btn-mini btn-info">&nbsp;&nbsp;Edit&nbsp;&nbsp;</a>-->
                                        <!--<a href="<?php echo base_url('model/delete/'.$row->id_model); ?>" class="btn btn-mini btn-danger" onclick="return confirm('Are you want to delete this model?')">Delete</a>-->    
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