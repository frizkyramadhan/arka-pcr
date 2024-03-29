<div class="main">
    <div class="main-inner">
        <div class="container">
          <div class="row">
            <div class="span12">      		
                <div class="widget ">
                    <div class="widget-header">
                        <i class="icon-truck"></i>
                        <h3>Add Unit Lists</h3>
                    </div> <!-- /widget-header -->
                    <div class="widget-content">
                        <div class="tab-pane" id="formcontrols">
                            <form class="form-horizontal" role="form" action="" method="post">
                                <fieldset>
                                    <div class="control-group">											
                                        <label class="control-label">Unit No.</label>
                                        <div class="controls">
                                            <input type="text" class="span4" name="unit_no" value="<?php echo set_value('unit_no');?>"/>
											<?php echo form_error('unit_no', '<p class="help-block" style="color:red">', '</p>')?>
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
                                    <div class="control-group">											
                                        <label class="control-label">Description</label>
                                        <div class="controls">
                                            <input type="text" class="span4" name="unit_desc" />
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
                                    <div class="control-group">											
                                        <label class="control-label">Serial No. Unit</label>
                                        <div class="controls">
                                            <input type="text" class="span4" name="sn_unit" />
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
                                    <div class="control-group">											
                                        <label class="control-label">Model</label>
                                        <div class="controls">
                                            <?php
                                            echo form_dropdown('id_model', $model_options, '',"class='span4'");
                                            ?>
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
                                    <div class="control-group">											
                                        <label class="control-label">Project</label>
                                        <div class="controls">
                                            <?php
                                            echo form_dropdown('id_project', $proj_options, '',"class='span4'");
                                            ?>
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-primary">Save</button> 
                                        <button type="reset"class="btn">Reset</button>
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