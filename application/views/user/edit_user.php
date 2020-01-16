<div class="main">
    <div class="main-inner">
        <div class="container">
          <div class="row">
            <div class="span12">      		
                <div class="widget ">
                    <div class="widget-header">
                        <i class="icon-tags"></i>
                        <h3>Edit User Lists</h3>
                    </div> <!-- /widget-header -->
                    <div class="widget-content">
                        <div class="tab-pane" id="formcontrols">
                            <form class="form-horizontal" role="form" action="" method="post">
                                <fieldset>
                                    <div class="control-group">											
                                        <label class="control-label">Username</label>
                                        <div class="controls">
                                            <input type="text" class="span4" name="username" value="<?php echo $users->username; ?>"/>
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
                                    <div class="control-group">											
                                        <label class="control-label">Password</label>
                                        <div class="controls">
                                            <input type="password" class="span4" name="password" value="<?php echo $users->password; ?>"/>
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
                                    <div class="control-group">											
                                        <label class="control-label">Level</label>
                                        <div class="controls">
                                            <?php $options = array(
                                                      'Admin'       => 'Admin',
                                                      'Super User'  => 'Super User',
                                                      'User'        => 'User'
                                                    );
                                            echo form_dropdown('level', $options, $select_user, 'class=span4');
                                            ?>
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
                                    <div class="control-group">											
                                        <label class="control-label">Project</label>
                                        <div class="controls">
                                            <?php 
                                            echo form_dropdown('id_project', $proj_options, $select_project, 'class=span4');
                                            ?>
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
                                    <div class="control-group">											
                                        <label class="control-label">Level</label>
                                        <div class="controls">
                                            <?php $sign = array(
                                                      'L0'  => 'L0',
                                                      'L1'  => 'L1',
                                                      'L2'  => 'L2',
                                                      'L3'  => 'L3'
                                                    );
                                            echo form_dropdown('sign', $sign, $select_sign, 'class=span4');
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