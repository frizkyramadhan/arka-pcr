<div class="main">
    <div class="main-inner">
        <div class="container">
          <div class="row">
            <div class="span12">      		
                <div class="widget ">
                    <div class="widget-header">
                        <i class="icon-th-large"></i>
                        <h3>Detail Model</h3>
                    </div> <!-- /widget-header -->
                    <div class="widget-content">
                        <div class="tab-pane" id="formcontrols">
                            <form class="form-horizontal" role="form" action="" method="post">
                                <fieldset>
                                    <div class="control-group">											
                                        <label class="control-label">Model No.</label>
                                        <div class="controls">
                                            <input type="text" class="span4" name="model_no" value="<?php echo $model->model_no; ?>" disabled/>
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
                                    <div class="control-group">											
                                        <label class="control-label">Manufacture</label>
                                        <div class="controls">
                                            <input type="text" class="span4" name="manufacture" value="<?php echo $model->manufacture; ?>" disabled/>
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
                                    <div class="control-group">											
                                        <label class="control-label">Description</label>
                                        <div class="controls">
                                            <input type="text" class="span4" name="description" value="<?php echo $model->description; ?>" disabled/>
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
                                    <div class="form-actions">
                                        <a href="<?php echo base_url('model/add_comp/'.$model->id_model); ?>" class="btn btn-success">&nbsp;&nbsp;Add Component&nbsp;&nbsp;</a>
                                        <a href="<?php echo base_url('model/edit/'.$model->id_model); ?>" class="btn btn-info">&nbsp;&nbsp;Edit&nbsp;&nbsp;</a>
                                        <a href="<?php echo base_url('model/delete/'.$model->id_model); ?>" class="btn btn-danger" onclick="return confirm('Are you want to delete this model? You will delete the component also!')">Delete</a>
                                    </div>
                                    <div class="form-horizontal">
                                        <table id="example" class="table table-striped table-bordered table-condensed" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th><div align="center">No</div></th>
                                                    <th>Component </th>
                                                    <th>Component Type</th>
                                                    <th><div align="center">Policy</div></th>
                                                    <th><div align="center">Price (IDR)</div></th>
                                                    <th><div align="center">Action</div></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <?php $i=1; ?>
                                                    <?php foreach ($comp as $row): ?>
                                                    <td><div align="center"><?php echo $i++; ?></div></td>
                                                    <td><?php echo $row->comp_desc; ?></td>
                                                    <td><?php echo $row->comp_type; ?></td>
                                                    <td><div align="right"><?php echo $row->policy; ?></div></td>
                                                    <td><div align="right"><?php echo $row->price; ?></div></td>
                                                    <td>
                                                        <div align="center">
                                                        
                                                        <a href="<?php echo base_url('model/edit_comp/'.$row->id_model.'/'.$row->id_mod); ?>" class="btn btn-mini btn-info">&nbsp;&nbsp;Edit&nbsp;&nbsp;</a>
                                                        <a href="<?php echo base_url('model/del_comp/'.$row->id_model.'/'.$row->id_mod); ?>" class="btn btn-mini btn-danger" onclick="return confirm('Are you want to delete this component?')">Delete</a>    
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php endforeach?>
                                            </tbody>
                                        </table>
                                    </div> <!-- /form-actions -->
                                </fieldset>
                        </form>
                        </div>
                    </div> <!-- /widget-content -->	
                </div> <!-- /widget -->	
                </div> <!-- /span8 -->
            </div> <!-- /row -->
        </div> <!-- /container -->
    </div> <!-- /main-inner -->
</div> <!-- /main -->