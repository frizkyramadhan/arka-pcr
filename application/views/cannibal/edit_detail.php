<div class="main">
    <div class="main-inner">
        <div class="container">
          <div class="row">
            <div class="span12">      		
                <div class="widget ">
                    <div class="widget-header">
                        <i class="icon-random"></i>
                        <h3>Edit Detail Component</h3>
                    </div> <!-- /widget-header -->
                    <div class="widget-content">
<!--                        <pre><?php // print_r($select_rep);?></pre>-->
                        <div class="tab-pane" id="formcontrols">
                            <form class="form-horizontal" role="form" action="" method="post">
                                <fieldset>
                                    <div class="control-group">											
                                        <label class="control-label">WO Replacement</label>
                                        <div class="controls">
                                            <?php 
                                            //echo form_dropdown('id_rep', $rep, $select_rep, 'class=span4');
                                            ?>
                                            <select name="id_rep" id="wo" onchange="changeValue(this.value)" class="span4" >
                                            <option value="0">-- Select WO --</option>
                                            <?php
                                            $result = mysql_query(
                                                        "select * from replacement r
                                                        left join unit u on r.id_unit = u.id_unit
                                                        left join commod m on r.id_mod = m.id_mod
                                                        left join comp c on m.id_comp = c.id_comp
                                                        left join project p on u.id_project = p.id_project
                                                        where wo_no != 0 and wo_status = 'OPEN'");
                                            $jsArray = "var dtRep = new Array();\n";        
                                            while ($row = mysql_fetch_array($result)) {    
                                                $selected = '';
                                                if($row['id_rep'] == $select_rep['id_rep']){
                                                    $selected = 'selected="selected"';
                                                }
                                                echo '<option value="' . $row['id_rep'] . '" '.$selected.'>' . $row['wo_no'] . ' - ' . $row['unit_no'] . ' - ' . $row['comp_desc'] . '</option>';    
                                                $jsArray .= "dtRep['" . $row['id_rep'] . "'] = 
                                                    {wo_no_kanibal:'" . addslashes($row['wo_no']) . "',
                                                     wo_status_kanibal:'".addslashes($row['wo_status'])."',
                                                     comp_hour:'".addslashes($row['comp_hour'])."',
                                                     id_unit:'".addslashes($row['id_unit'])."',
                                                     comp_desc:'".addslashes($row['comp_desc'])."'
                                                    };\n";    
                                            }      
                                            ?>
                                            </select>
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
                                    <div class="control-group">											
                                        <label class="control-label">Date</label>
                                        <div class="controls">
                                            <input type="text" id="date1" class="span4" name="date" value="<?php echo $det->date; ?>"/>
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
                                    <div class="control-group">											
                                        <label class="control-label">WO Number</label>
                                        <div class="controls">
                                            <input type="text" class="span4" name="wo_no_kanibal" value="<?php echo $det->wo_no_kanibal; ?>" id="wo_no_kanibal"/>
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
                                    <div class="control-group">											
                                        <label class="control-label">WO Status</label>
                                        <div class="controls">
                                            <input type="text" class="span4" name="wo_status_kanibal" value="<?php echo $det->wo_status_kanibal; ?>" id="wo_status_kanibal"/>
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
                                    <div class="control-group">											
                                        <label class="control-label">Unit No</label>
                                        <div class="controls">
                                            <?php 
                                            echo form_dropdown('id_unit', $unit, $select_unit, 'class=span4 id=id_unit');
                                            ?>
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
                                    <div class="control-group">											
                                        <label class="control-label">Comp. Description</label>
                                        <div class="controls">
                                            <input type="text" class="span4" name="comp_desc" value="<?php echo $det->comp_desc?>" id="comp_desc"/>
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
                                    <div class="control-group">											
                                        <label class="control-label">Part Number</label>
                                        <div class="controls">
                                            <input type="text" class="span4" name="pn" value="<?php echo $det->pn?>"/>
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
                                    <div class="control-group">											
                                        <label class="control-label">Serial Number</label>
                                        <div class="controls">
                                            <input type="text" class="span4" name="sn" value="<?php echo $det->sn?>"/>
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
                                    <div class="control-group">											
                                        <label class="control-label">Position</label>
                                        <div class="controls">
                                            <input type="text" class="span4" name="pos" value="<?php echo $det->pos?>"/>
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
                                    <div class="control-group">											
                                        <label class="control-label">Hour Meter Comp</label>
                                        <div class="controls">
                                            <input type="text" class="span4" name="hm_comp" value="<?php echo $det->hm_comp?>" id="comp_hour"/>
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
<script type="text/javascript">    
    <?php echo $jsArray; ?>  
    function changeValue(wo){  
    document.getElementById('wo_no_kanibal').value = dtRep[wo].wo_no_kanibal;  
    document.getElementById('wo_status_kanibal').value = dtRep[wo].wo_status_kanibal;  
    document.getElementById('comp_hour').value = dtRep[wo].comp_hour;  
    document.getElementById('comp_desc').value = dtRep[wo].comp_desc;  
    document.getElementById('id_unit').value = dtRep[wo].id_unit;  
    };  
</script>