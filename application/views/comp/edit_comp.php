<div class="main">
    <div class="main-inner">
        <div class="container">
            <div class="row">
                <div class="span12">
                    <div class="widget ">
                        <div class="widget-header">
                            <i class="icon-cogs"></i>
                            <h3>Edit Component Lists</h3>
                        </div> <!-- /widget-header -->
                        <div class="widget-content">
                            <div class="tab-pane" id="formcontrols">
                                <form class="form-horizontal" role="form" action="" method="post">
                                    <fieldset>
                                        <div class="control-group">
                                            <label class="control-label">Component</label>
                                            <div class="controls">
                                                <input type="text" class="span4" name="comp_desc" value="<?php echo $component->comp_desc; ?>" />
                                            </div> <!-- /controls -->
                                        </div> <!-- /control-group -->
                                        <div class="control-group">
                                            <label class="control-label">Component Type</label>
                                            <div class="controls">
                                                <?php $options = array(
                                                    "MAJOR" => "MAJOR",
                                                    "MID LIFE" => "MID LIFE",
                                                    "MINOR" => "MINOR",
                                                    "TYRE" => "TYRE",
                                                    "UNDER CARRIAGE" => "UNDER CARRIAGE"
                                                );
                                                echo form_dropdown('comp_type', $options, $select_type);
                                                ?>
                                            </div> <!-- /controls -->
                                        </div> <!-- /control-group -->
                                        <div class="control-group">
                                            <label class="control-label">Component Status</label>
                                            <div class="controls">
                                                <?php $status = array(
                                                    "Active" => "Active",
                                                    "Inactive" => "Inactive"
                                                );
                                                echo form_dropdown('status', $status, $select_status);
                                                ?>
                                            </div> <!-- /controls -->
                                        </div> <!-- /control-group -->
                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-primary">Save</button>
                                            <button type="reset" class="btn">Reset</button>
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