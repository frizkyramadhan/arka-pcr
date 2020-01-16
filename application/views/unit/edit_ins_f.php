<div class="main">
    <div class="main-inner">
        <div class="container">
            <div class="row">
                <div class="span12">
                    <div class="widget">
                        <div class="widget-header">
                            <i class="icon-check"></i>
                            <h3>Edit Inspection - Filter Cut</h3>
                        </div> <!-- /widget-header -->
                        <div class="widget-content">
                            <h4><span style="float: left"><a href="<?php echo site_url('unit/filter_cut/'.$mod->id_unit.'/'.$mod->id_mod); ?>" class="btn btn-info"><i class="icon-arrow-left"></i>&nbsp;&nbsp;Back</a></span></h4><br><br>
                            <div class="form-horizontal">
                                <!--<pre><?php // print_r($hm);?></pre>-->
                                <table cellspacing="0" width="100%">
                                    <tr>
                                        <td>Unit No.</td>
                                        <td>:</td>
                                        <td><b><?php echo $mod->unit_no?></b></td>
                                        <td>Model</td>
                                        <td>:</td>
                                        <td><b><?php echo $mod->model_no?></b></td>
                                    </tr>
                                    <tr>
                                        <td>Unit Description</td>
                                        <td>:</td>
                                        <td><b><?php echo $mod->unit_desc?></b></td>
                                        <td>Component Description</td>
                                        <td>:</td>
                                        <td><b><?php echo $mod->comp_desc?></b></td>
                                    </tr>
                                    <tr>
                                        <td>Site</td>
                                        <td>:</td>
                                        <td><b><?php echo $mod->kode_project?> | <?php echo $mod->nama_project?></b></td>
                                        <td>Policy</td>
                                        <td>:</td>
                                        <td><b><?php echo $mod->policy?></b></td>
                                    </tr>
                                </table>
                                <hr>
                                <form class="form-horizontal" role="form" action="" method="post">
                                    <fieldset>
                                        <div class="span5">
                                            <input type="hidden" class="span3" name="id_unit" value="<?php echo $mod->id_unit; ?>"/>
                                            <input type="hidden" class="span3" name="id_mod" value="<?php echo $mod->id_mod; ?>"/>
                                            <input type="hidden" class="span3" name="type" value="FC"/>
                                            <div class="control-group">											
                                                <label class="control-label">Inspection Date</label>
                                                <div class="controls">
                                                    <input type="text" id="rep_date" class="span4" name="ins_date" value="<?php echo $filter['ins_date']; ?>"/>
                                                </div> <!-- /controls -->				
                                            </div> <!-- /control-group -->
                                            <div class="control-group">											
                                                <label class="control-label">Hour Meter</label>
                                                <div class="controls">
                                                    <input type="text" class="span4" name="ins_hm" value="<?php echo $filter['ins_hm']; ?>"/>
                                                </div> <!-- /controls -->				
                                            </div> <!-- /control-group -->
                                            <div class="control-group">											
                                                <label class="control-label">Rating</label>
                                                <div class="controls">
                                                    <?php $options = array(
                                                      'A'  => 'A',
                                                      'B'  => 'B',
                                                      'C'  => 'C',
                                                      'X'  => 'X'
                                                    );
                                                    echo form_dropdown('rating', $options, $select_rating, 'A', 'class=span4');
                                                    ?>
                                                </div> <!-- /controls -->				
                                            </div> <!-- /control-group -->
                                         </fieldset>    
                                    <fieldset>   
                                        <div class="form-actions span9">
                                            <button type="submit" class="btn btn-primary">Save</button> 
                                            <button type="reset"class="btn">Reset</button>
                                        </div> <!-- /form-actions -->
                                    </fieldset>
                                </form>
                            </div>
                        </div> <!-- /widget-content -->	
                    </div> <!-- /widget -->					
		</div> <!-- /span12 -->     	
            </div> <!-- /row -->
        </div> <!-- /container -->
    </div> <!-- /main-inner -->
</div> <!-- /main -->