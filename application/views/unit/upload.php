<div class="main">
    <div class="main-inner">
        <div class="container">
          <div class="row">
            <div class="span12">      		
                <div class="widget ">
                    <div class="widget-header">
                        <i class="icon-time"></i>
                        <h3>Upload Hour Meter</h3>
                    </div> <!-- /widget-header -->
                    <div class="widget-content">
                        <div class="tab-pane" id="formcontrols">
                            <!--<pre>-->
                                <?php // print_r($hm->hm_unit);?>
                            <!--</pre>-->
                            <form role="form" action="" method="post" class="form-horizontal" enctype="multipart/form-data">
                                <fieldset>
                                    <!--<div class="alert alert-block">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        <h4>Warning!</h4>
                                        Empty the table before importing file!
                                    </div>
                                    <div class="control-list">
                                    <h4><span style="float: left"><a href="<?php echo site_url('unit/truncate_hm'); ?>" class="btn btn-warning" onclick="return confirm('Are you want to empty this table?')">Empty Table</a></span></h4>
                                    </div>-->
                                    <div class="control-group">											
                                        <label class="control-label">Select File</label>
                                        <div class="controls">
                                            <input id="inputIncludeFile" name="import" type="file" placeholder="Include some file" />
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
                                    <div class="form-actions">
                                        <input type="submit" class="btn btn-primary" name="save" value="Import">
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