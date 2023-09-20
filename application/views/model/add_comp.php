<div class="main">
    <div class="main-inner">
        <div class="container">
            <div class="row">
                <div class="span12">
                    <div class="widget ">
                        <div class="widget-header">
                            <i class="icon-th-large"></i>
                            <h3>Add Component Detail</h3>
                        </div> <!-- /widget-header -->
                        <div class="widget-content">
                            <div class="tab-pane" id="formcontrols">
                                <form class="form-horizontal" role="form" action="" method="post">
                                    <fieldset>
                                        <div class="control-group">
                                            <label class="control-label">Model No.</label>
                                            <div class="controls">
                                                <input type="text" class="span4" value="<?php echo $model->model_no; ?>" disabled />
                                                <input type="hidden" class="span4" name="id_model" value="<?php echo $model->id_model; ?>" />
                                            </div> <!-- /controls -->
                                        </div> <!-- /control-group -->
                                        <div class="control-group">
                                            <label class="control-label">Manufacture</label>
                                            <div class="controls">
                                                <input type="text" class="span4" value="<?php echo $model->manufacture; ?>" disabled />
                                            </div> <!-- /controls -->
                                        </div> <!-- /control-group -->
                                        <div class="control-group">
                                            <label class="control-label">Description</label>
                                            <div class="controls">
                                                <input type="text" class="span4" value="<?php echo $model->description; ?>" disabled />
                                            </div> <!-- /controls -->
                                        </div> <!-- /control-group -->
                                        <div class="control-group">
                                            <label class="control-label">Component</label>
                                            <div class="controls">
                                                <?php echo form_dropdown('id_comp', $comp_options, "", "class='span4'"); ?>
                                            </div> <!-- /controls -->
                                        </div> <!-- /control-group -->
                                        <div class="control-group">
                                            <label class="control-label">Policy</label>
                                            <div class="controls">
                                                <input type="text" class="span4" name="policy" />
                                            </div> <!-- /controls -->
                                        </div> <!-- /control-group -->
                                        <div class="control-group">
                                            <label class="control-label">Price</label>
                                            <div class="controls">
                                                <input type="text" class="span4" name="price" placeholder="IDR" />
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