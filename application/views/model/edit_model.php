<div class="main">
    <div class="main-inner">
        <div class="container">
          <div class="row">
            <div class="span12">      		
                <div class="widget ">
                    <div class="widget-header">
                        <i class="icon-th-large"></i>
                        <h3>Edit Model Lists</h3>
                    </div> <!-- /widget-header -->
                    <div class="widget-content">
                        <div class="tab-pane" id="formcontrols">
                            <form class="form-horizontal" role="form" action="" method="post">
                                <fieldset>
                                    <div class="control-group">											
                                        <label class="control-label">Model No.</label>
                                        <div class="controls">
                                            <input type="text" class="span4" name="model_no" value="<?php echo $model->model_no; ?>"/>
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
                                    <div class="control-group">											
                                        <label class="control-label">Manufacture</label>
                                        <div class="controls">
                                            <input type="text" class="span4" name="manufacture" value="<?php echo $model->manufacture; ?>"/>
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
                                    <div class="control-group">											
                                        <label class="control-label">Description</label>
                                        <div class="controls">
                                            <?php $options = array(
                                                        "Bulldozer" => "Bulldozer",
                                                        "Compactor" => "Compactor",
                                                        "Drilling" => "Drilling",
                                                        "Dump Truck" => "Dump Truck",
                                                        "Excavator" => "Excavator",
                                                        "Genset" => "Genset",
                                                        "Grader" => "Grader",
                                                        "Lighting Plant" => "Lighting Plant",
                                                        "Off-Highway Truck" => "Off-Highway Truck",
                                                        "Rigid Truck" => "Rigid Truck"
                                                    );
                                            echo form_dropdown('description', $options, $select_comp,"class='span4'");
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