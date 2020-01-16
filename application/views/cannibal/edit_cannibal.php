<div class="main">
    <div class="main-inner">
        <div class="container">
          <div class="row">
            <div class="span12">      		
                <div class="widget ">
                    <div class="widget-header">
                        <i class="icon-random"></i>
                        <h3>Edit Cannibal Records</h3>
                    </div> <!-- /widget-header -->
<!--                    <pre>
                    <?php // print_r($ba);?>
                    <?php // print_r($det_r);?>
                    <?php // print_r($det_i);?>
                    </pre>-->
                    <div class="widget-content">
                        <div class="tab-pane" id="formcontrols">
                            <form class="form-group" role="form" action="" method="post">
                                <fieldset>
                                    <div class="control-group">											
                                        <label class="control-label"><b>Project :</b></label>
                                        <div class="controls">
                                            <?php
                                            echo form_dropdown('id_project', $proj_options, $select_project,"class='span3' disabled");
                                            ?>
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
                                    <div class="control-group">											
                                        <label class="control-label"><b>No :</b></label>
                                        <div class="controls">
                                            <input type="text" class="span3" name="no_ba" value="<?php echo $ba->no_ba?>" disabled/>
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
                                    <div class="control-group">											
                                        <label class="control-label"><b>Posting Date :</b></label>
                                        <div class="controls">
                                            <input type="text" id="posting_date" class="span3" name="posting_date" value="<?php echo $ba->posting_date?>" />
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
                                    <div class="control-group">											
                                        <label class="control-label"><b>Symptom / Problem :</b></label>
                                        <div class="controls">
                                            <textarea name="symptom" rows="2" cols="20" class="span11" ><?php echo $ba->symptom?></textarea>
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
                                    <div class="control-group">											
                                        <label class="control-label"><b>Failure :</b></label>
                                        <div class="controls">
                                            <textarea name="failure" rows="2" cols="20" class="span11" ><?php echo $ba->failure?></textarea>
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
                                    <div class="control-group">											
                                        <label class="control-label"><b>Failure Cause :</b></label>
                                        <div class="form-horizontal">
                                            <?php foreach ($caused as $c): ?>
                                            <?php if($c->id_caused == $ba->id_caused):?>
                                            <label class="radio inline">
                                                <?php echo form_radio('id_caused', $c->id_caused, TRUE, '');?>&nbsp;<?php echo $c->caused;?>
                                            </label>
                                            <?php else:?>
                                            <label class="radio inline">
                                                <?php echo form_radio('id_caused', $c->id_caused, FALSE, '');?>&nbsp;<?php echo $c->caused;?>
                                            </label>
                                            <?php endif;?>
                                            <?php endforeach;?>
                                            <input type="text" class="span3" name="caused_other" placeholder="Other" value="<?php echo $ba->caused_other; ?>" />
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
                                    
                                    
                                    <div class=" control-group pricing-plans plans-3">
					<div class="plan-container">
                                            <div class="plan orange">
                                                <div class="plan-header">
                                                    <div class="plan-title">
                                                        Remove From (Diambil Dari)	        		
                                                    </div> <!-- /plan-title -->
						</div> <!-- /plan-header -->	        
                                                <div class="plan-features">
                                                    <table cellspacing="1" cellpadding="3">
<!--                                                        <tr>
                                                            <td>Replacement</td>
                                                            <td>:</td>
                                                            <td>
                                                                <select name="id_rep" id="wo" onchange="changeValue(this.value)" >
                                                                <option value=0>-- Select WO--</option>
                                                                //<?php 
//                                                                $result = mysql_query("select * from replacement left join unit on replacement.id_unit = unit.id_unit");    
//                                                                $jsArray = "var dtRep = new Array();\n";        
//                                                                while ($row = mysql_fetch_array($result)) {    
//                                                                    echo '<option value="' . $row['id_rep'] . '">' . $row['wo_no_kanibal'] . '</option>';    
//                                                                    $jsArray .= "dtRep['" . $row['id_rep'] . "'] = {wo_no_kanibal:'" . addslashes($row['wo_no_kanibal']) . "',wo_status_kanibal:'".addslashes($row['wo_status_kanibal'])."'};\n";    
//                                                                }      
//                                                                ?>    
                                                                </select>
                                                            </td>
                                                        </tr>-->
                                                        <tr>
                                                            <td>Date</td>
                                                            <td>:</td>
                                                            <td><input type="text" id="date1" class="span3" name="data_d[1][date]" value="<?php echo $det_r->date; ?>" disabled/></td>
                                                        </tr>
                                                        <tr>
                                                            <td>WO No</td>
                                                            <td>:</td>
                                                            <td><input type="text" class="span3" name="data_d[1][wo_no_kanibal]" id="wo_no_kanibal" value="<?php echo $det_r->wo_no_kanibal; ?>" disabled/></td>
                                                        </tr>
                                                        <tr>
                                                            <td>WO Status</td>
                                                            <td>:</td>
                                                            <td><input type="text" class="span3" name="data_d[1][wo_status_kanibal]" id="wo_status_kanibal" value="<?php echo $det_r->wo_status_kanibal; ?>" disabled/></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Unit No.</td>
                                                            <td>:</td>
                                                            <td><input type="text" class="span3" name="data_d[1][id_unit]" value="<?php echo $det_r->unit_no; ?>" disabled/></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Comp. Desc</td>
                                                            <td>:</td>
                                                            <td><input type="text" class="span3" name="data_d[1][comp_desc]" value="<?php echo $det_r->comp_desc; ?>" disabled/></td>
                                                        </tr>
                                                        <tr>
                                                            <td>P/N</td>
                                                            <td>:</td>
                                                            <td><input type="text" class="span3" name="data_d[1][pn]" value="<?php echo $det_r->pn; ?>" disabled/></td>
                                                        </tr>
                                                        <tr>
                                                            <td>S/N</td>
                                                            <td>:</td>
                                                            <td><input type="text" class="span3" name="data_d[1][sn]" value="<?php echo $det_r->sn; ?>" disabled/></td>
                                                        </tr>
                                                        <tr>
                                                            <td>POS</td>
                                                            <td>:</td>
                                                            <td><input type="text" class="span3" name="data_d[1][pos]" value="<?php echo $det_r->pos; ?>" disabled/></td>
                                                        </tr>
                                                        <tr>
                                                            <td>HM Comp</td>
                                                            <td>:</td>
                                                            <td><input type="text" class="span3" name="data_d[1][hm_comp]" value="<?php echo $det_r->hm_comp; ?>" disabled/></td>
                                                        </tr>
                                                    </table>
                                                </div> <!-- /plan-features -->
                                                <div class="plan-actions">				
                                                    <a href="<?php echo site_url('cannibal/edit_detail/'.$ba->no_ba.'/'.$det_r->id_kanibal); ?>" class="btn">Edit Removed Comp</a>				
                                                </div> <!-- /plan-actions -->
                                            </div> <!-- /plan -->
                                        </div> <!-- /plan-container -->	
					<div class="plan-container">
                                            <div class="plan green">
                                                <div class="plan-header">
                                                    <div class="plan-title">
                                                        Install To (Dipasang Ke)	        		
                                                    </div> <!-- /plan-title -->
						</div> <!-- /plan-header -->	        
                                                <div class="plan-features">
                                                    <table cellspacing="1" cellpadding="3">
<!--                                                        <tr>
                                                            <td>Replacement</td>
                                                            <td>:</td>
                                                            <td>
                                                                <select name="id_rep" id="wo" onchange="changeValue(this.value)" >
                                                                <option value=0>-- Select WO--</option>
                                                                //<?php 
//                                                                $result = mysql_query("select * from replacement left join unit on replacement.id_unit = unit.id_unit");    
//                                                                $jsArray = "var dtRep = new Array();\n";        
//                                                                while ($row = mysql_fetch_array($result)) {    
//                                                                    echo '<option value="' . $row['id_rep'] . '">' . $row['wo_no_kanibal'] . '</option>';    
//                                                                    $jsArray .= "dtRep['" . $row['id_rep'] . "'] = {wo_no_kanibal:'" . addslashes($row['wo_no_kanibal']) . "',wo_status_kanibal:'".addslashes($row['wo_status_kanibal'])."'};\n";    
//                                                                }      
//                                                                ?>    
                                                                </select>
                                                            </td>
                                                        </tr>-->
                                                        <tr>
                                                            <td>Date</td>
                                                            <td>:</td>
                                                            <td><input type="text" id="date2" class="span3" name="data_d[2][date]" value="<?php echo $det_i->date; ?>" disabled/></td>
                                                        </tr>
                                                        <tr>
                                                            <td>WO No</td>
                                                            <td>:</td>
                                                            <td><input type="text" class="span3" name="data_d[2][wo_no_kanibal]" id="wo_no_kanibal" value="<?php echo $det_i->wo_no_kanibal; ?>" disabled/></td>
                                                        </tr>
                                                        <tr>
                                                            <td>WO Status</td>
                                                            <td>:</td>
                                                            <td><input type="text" class="span3" name="data_d[2][wo_status_kanibal]" id="wo_status_kanibal" value="<?php echo $det_i->wo_status_kanibal; ?>" disabled/></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Unit No.</td>
                                                            <td>:</td>
                                                            <td><input type="text" class="span3" name="data_d[2][id_unit]" value="<?php echo $det_i->unit_no; ?>" disabled/></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Comp. Desc</td>
                                                            <td>:</td>
                                                            <td><input type="text" class="span3" name="data_d[2][comp_desc]" value="<?php echo $det_i->comp_desc; ?>" disabled/></td>
                                                        </tr>
                                                        <tr>
                                                            <td>P/N</td>
                                                            <td>:</td>
                                                            <td><input type="text" class="span3" name="data_d[2][pn]" value="<?php echo $det_i->pn; ?>" disabled/></td>
                                                        </tr>
                                                        <tr>
                                                            <td>S/N</td>
                                                            <td>:</td>
                                                            <td><input type="text" class="span3" name="data_d[2][sn]" value="<?php echo $det_i->sn; ?>" disabled/></td>
                                                        </tr>
                                                        <tr>
                                                            <td>POS</td>
                                                            <td>:</td>
                                                            <td><input type="text" class="span3" name="data_d[2][pos]" value="<?php echo $det_i->pos; ?>" disabled/></td>
                                                        </tr>
                                                        <tr>
                                                            <td>HM Comp</td>
                                                            <td>:</td>
                                                            <td><input type="text" class="span3" name="data_d[2][hm_comp]" value="<?php echo $det_i->hm_comp; ?>" disabled/></td>
                                                        </tr>
                                                    </table>
                                                </div> <!-- /plan-features -->
                                                <div class="plan-actions">				
                                                    <a href="<?php echo site_url('cannibal/edit_detail/'.$ba->no_ba.'/'.$det_i->id_kanibal); ?>" class="btn">Edit Installed Comp</a>				
                                                </div> <!-- /plan-actions -->
                                            </div> <!-- /plan -->
                                        </div> <!-- /plan-container -->	
                                        <div class="plan-container">
                                            <div class="plan">
                                                <div class="plan-header">
                                                    <div class="plan-title">
                                                        Status of Component Install	        		
                                                    </div> <!-- /plan-title -->
						</div> <!-- /plan-header -->	        
                                                <div class="plan-actions">
                                                    <table cellpadding="50">
                                                        <tr>
                                                            <td>
                                                                <div class="controls form-horizontal">
                                                                    <?php foreach ($status as $s): ?>
                                                                    <?php if($s->id_status == $ba->id_status):?>
                                                                    <label class="radio-inline">
                                                                        <?php echo form_radio('id_status', $s->id_status, TRUE, '');?>&nbsp;<?php echo $s->status;?>
                                                                    </label>
                                                                    <?php else:?>
                                                                    <label class="radio-inline">
                                                                        <?php echo form_radio('id_status', $s->id_status, FALSE, '');?>&nbsp;<?php echo $s->status;?>
                                                                    </label>
                                                                    <?php endif;?>
                                                                    <?php endforeach;?>
                                                                    <input type="text" class="span3" name="status_other" placeholder="Other" value="<?php echo $ba->status_other; ?>" />
                                                                </div> <!-- /controls -->
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div> <!-- /plan-features -->
                                            </div> <!-- /plan -->
                                        </div> <!-- /plan-container -->	
                                    </div> <!-- /pricing-plans -->
                                </fieldset>
                                <br>
                                <fieldset>
                                    
                                    <div class="control-group">											
                                        <label class="control-label"><b>Action by Planning Section :</b></label>
                                        <div class="form-horizontal">
                                            <?php foreach ($action as $a): ?>
                                            <?php if($a->id_action == $ba->id_action):?>
                                            <label class="radio inline">
                                                <?php echo form_radio('id_action', $a->id_action, TRUE, '');?>&nbsp;<?php echo $a->action;?>
                                            </label>
                                            <?php else:?>
                                            <label class="radio inline">
                                                <?php echo form_radio('id_action', $a->id_action, FALSE, '');?>&nbsp;<?php echo $a->action;?>
                                            </label>
                                            <?php endif;?>
                                            <?php endforeach;?>
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
                                    
                                    <div class="control-group">											
                                        <label class="control-label"><b>MR#</b></label>
                                        <div class="controls">
                                            <input type="text" class="span3" name="mr_no" value="<?php echo $ba->mr_no; ?>" />
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
                                    <div class="control-group">											
                                        <label class="control-label"><b>PR#</b></label>
                                        <div class="controls">
                                            <input type="text" class="span3" name="pr_no" value="<?php echo $ba->pr_no; ?>" />
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
                                    <div class="control-group">											
                                        <label class="control-label"><b>PO#</b></label>
                                        <div class="controls">
                                            <input type="text" class="span3" name="po_no" value="<?php echo $ba->po_no; ?>" />
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
                                    <div class="control-group">											
                                        <label class="control-label"><b>Remarks :</b></label>
                                        <div class="controls">
                                            <textarea name="remark_ba" rows="2" cols="20" class="span11"><?php echo $ba->remark_ba?></textarea>
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
                                </fieldset>
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary">Save</button> 
                                    <button type="reset"class="btn">Reset</button>
                                </div>  
                        </form>
                        </div>
                    </div> <!-- /widget-content -->	
                </div> <!-- /widget -->	
                </div> <!-- /span8 -->
            </div> <!-- /row -->
        </div> <!-- /container -->
    </div> <!-- /main-inner -->
</div> <!-- /main -->

<!--<script type="text/javascript">    
    <?php // echo $jsArray; ?>  
    function changeValue(wo){  
    document.getElementById('wo_no_kanibal').value = dtRep[wo].wo_no_kanibal;  
    document.getElementById('wo_status_kanibal').value = dtRep[wo].wo_status_kanibal;  
    };  
    </script> -->