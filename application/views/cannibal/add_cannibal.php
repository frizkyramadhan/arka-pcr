<?php $conn = mysqli_connect('localhost', 'root', '', 'arka_pcr')?>
<div class="main">
    <div class="main-inner">
        <div class="container">
          <div class="row">
            <div class="span12">      		
                <div class="widget ">
                    <div class="widget-header">
                        <i class="icon-random"></i>
                        <h3>Add Cannibal Records</h3>
                    </div> <!-- /widget-header -->
                    <div class="widget-content">
                        <?php
                        $years = date("y");
                        if (empty($kode_project)){
                            
                        } else {
                            $kode = substr($kode_project->kode_project, 0, 3);
                        }
                        ?>
                        <div class="tab-pane" id="formcontrols">
                            <form class="form-group" role="form" action="" method="post">
                                <fieldset>
                                    <div class="alert alert-info">
                                              <button type="button" class="close" data-dismiss="alert">&times;</button>
                                              Fields with <strong>*</strong> are required!
                                            </div>
                                    <div class="control-group">											
                                        <label class="control-label"><b>Project* :</b></label>
                                        <div class="controls">
                                            <select name="data_c[1][id_project]" id="id_project" class="span3" onchange="return project()">
                                                <option value="">-- Select Project --</option>
                                                <?php 
                                                foreach($project as $p){
                                                    echo "<option value='$p[id_project]'>$p[kode_project]</option>";
                                                }
                                                ?>
                                            </select>
                                            <span style="color: red"><?php echo form_error("id_project");?></span>
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
                                    <div class="control-group">											
                                        <label class="control-label"><b>No* :</b></label>
                                        <div class="controls">
                                            <input type="text" class="span3" name="data_c[1][no_ba]" disabled/>
                                            <span style="color: red"><?php echo form_error("no_ba");?></span>
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
                                    <div class="control-group">											
                                        <label class="control-label"><b>Posting Date* :</b></label>
                                        <div class="controls">
                                            <input type="text" id="posting_date" class="span3" name="data_c[1][posting_date]"/>
                                            <span style="color: red"><?php echo form_error("posting_date");?></span>
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
                                    <div class="control-group">											
                                        <label class="control-label"><b>Symptom / Problem :</b></label>
                                        <div class="controls">
                                            <textarea name="data_c[1][symptom]" rows="2" cols="20" class="span11"></textarea>
                                            <span style="color: red"><?php echo form_error("symptom");?></span>
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
                                    <div class="control-group">											
                                        <label class="control-label"><b>Failure* :</b></label>
                                        <div class="controls">
                                            <textarea name="data_c[1][failure]" rows="2" cols="20" class="span11"></textarea>
                                            <span style="color: red"><?php echo form_error("failure");?></span>
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
                                    <div class="control-group">											
                                        <label class="control-label"><b>Failure Cause* :</b></label>
                                        <div class="form-horizontal">
                                            <?php foreach ($caused as $c): ?>
                                            <label class="radio inline">
                                                <input type="radio" name="data_c[1][id_caused]" value="<?php echo $c->id_caused;?>"/>&nbsp; <?php echo $c->caused;?> &nbsp;
                                            </label>
                                            <?php endforeach;?>
                                            <input type="text" class="span3" name="data_c[1][caused_other]" placeholder="Other"/>
                                            <span style="color: red"><?php echo form_error("id_caused");?></span>
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
                                                <div class="plan-features"><br>
                                                    <table cellspacing="1" cellpadding="3">
                                                        <tr>
                                                            <td>Replacement</td>
                                                            <td>:</td>
                                                            <td>
                                                                <select name="data_d[1][id_rep]" id="wo_r" onchange="changeValue_r(this.value)" class="span3" >
                                                                <option value=0>-- Select WO --</option>
                                                                <?php 
                                                                $result_r = mysqli_query($conn,
                                                                            "select * from replacement r
                                                                            left join unit u on r.id_unit = u.id_unit
                                                                            left join commod m on r.id_mod = m.id_mod
                                                                            left join comp c on m.id_comp = c.id_comp
                                                                            left join project p on u.id_project = p.id_project
                                                                            where wo_no != 0 and wo_status = 'OPEN'");
                                                                $jsArray_r = "var dtRep_r = new Array();\n";        
                                                                while ($row = mysqli_fetch_array($result_r)) {    
                                                                    echo '<option value="' . $row['id_rep'] . '">' . $row['wo_no'] . ' - ' . $row['unit_no'] . ' - ' . $row['comp_desc'] . '</option>';     
                                                                    $jsArray_r .= "dtRep_r['" . $row['id_rep'] . "'] = 
                                                                        {wo_no_kanibal1:'" . addslashes($row['wo_no']) . "',
                                                                         wo_status_kanibal1:'".addslashes($row['wo_status'])."',
                                                                         comp_hour1:'".addslashes($row['comp_hour'])."',
                                                                         id_unit1:'".addslashes($row['id_unit'])."',
                                                                         comp_desc1:'".addslashes($row['comp_desc'])."'
                                                                        };\n";    
                                                                }      
//                                                              ?>    
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Date*</td>
                                                            <td>:</td>
                                                            <td><input type="text" id="date1" class="span3" name="data_d[1][date]"/></td>
                                                        </tr>
                                                        <tr>
                                                            <td>WO No*</td>
                                                            <td>:</td>
                                                            <td><input type="text" class="span3" name="data_d[1][wo_no_kanibal]" id="wo_no_kanibal1"/></td>
                                                        </tr>
                                                        <tr>
                                                            <td>WO Status*</td>
                                                            <td>:</td>
                                                            <td><input type="text" class="span3" name="data_d[1][wo_status_kanibal]" id="wo_status_kanibal1"/></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Unit No.*</td>
                                                            <td>:</td>
                                                            <td>
                                                                <!--<input type="text" class="span3" name="data_d[1][id_unit]"/>-->
                                                                <select class='form-control span3' name="data_d[1][id_unit]" id="id_unit1">
                                                                    <option value='0'>-- Select Unit --</option>
                                                                    <?php 
                                                                    foreach ($unit_r as $u_r) {
                                                                    echo "<option value='$u_r[id_unit]'>$u_r[unit_no]</option>";
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Comp. Desc*</td>
                                                            <td>:</td>
                                                            <td><input type="text" class="span3" name="data_d[1][comp_desc]" id="comp_desc1"/></td>
                                                        </tr>
                                                        <tr>
                                                            <td>P/N*</td>
                                                            <td>:</td>
                                                            <td><input type="text" class="span3" name="data_d[1][pn]"/></td>
                                                        </tr>
                                                        <tr>
                                                            <td>S/N</td>
                                                            <td>:</td>
                                                            <td><input type="text" class="span3" name="data_d[1][sn]"/></td>
                                                        </tr>
                                                        <tr>
                                                            <td>POS</td>
                                                            <td>:</td>
                                                            <td><input type="text" class="span3" name="data_d[1][pos]"/></td>
                                                        </tr>
                                                        <tr>
                                                            <td>HM Comp*</td>
                                                            <td>:</td>
                                                            <td><input type="text" class="span3" name="data_d[1][hm_comp]" id="comp_hour1"/></td>
                                                        </tr>
                                                    </table>
                                                    <input type="hidden" class="span3" name="data_d[1][no_ba]" value=""/>
                                                    <input type="hidden" class="span3" name="data_d[1][type]" value="REMOVE"/>
                                                </div> <!-- /plan-features -->
                                                <div class="plan-actions">
                                                    <a class="btn" onclick="reset_r()">Reset Detail</a>
                                                </div>
                                            </div> <!-- /plan -->
                                        </div> <!-- /plan-container -->	
					<div class="plan-container">
                                            <div class="plan green">
                                                <div class="plan-header">
                                                    <div class="plan-title">
                                                        Install To (Dipasang Ke)	        		
                                                    </div> <!-- /plan-title -->
						</div> <!-- /plan-header -->	        
                                                <div class="plan-features"><br>
                                                    <table cellspacing="1" cellpadding="3">
                                                        <tr>
                                                            <td>Replacement</td>
                                                            <td>:</td>
                                                            <td>
                                                                <select name="data_d[2][id_rep]" id="wo_i" onchange="changeValue_i(this.value)" class="span3" >
                                                                <option value=0>-- Select WO --</option>
                                                                <?php 
                                                                $result_i = mysqli_query($conn,
                                                                            "select * from replacement r
                                                                            left join unit u on r.id_unit = u.id_unit
                                                                            left join commod m on r.id_mod = m.id_mod
                                                                            left join comp c on m.id_comp = c.id_comp
                                                                            left join project p on u.id_project = p.id_project
                                                                            where wo_no != 0 and wo_status = 'OPEN'");
                                                                $jsArray_i = "var dtRep_i = new Array();\n";        
                                                                while ($row = mysqli_fetch_array($result_i)) {    
                                                                    echo '<option value="' . $row['id_rep'] . '">' . $row['wo_no'] . ' - ' . $row['unit_no'] . ' - ' . $row['comp_desc'] . '</option>';    
                                                                    $jsArray_i .= "dtRep_i['" . $row['id_rep'] . "'] = 
                                                                        {wo_no_kanibal2:'" . addslashes($row['wo_no']) . "',
                                                                         wo_status_kanibal2:'".addslashes($row['wo_status'])."',
                                                                         comp_hour2:'".addslashes($row['comp_hour'])."',
                                                                         id_unit2:'".addslashes($row['id_unit'])."',
                                                                         comp_desc2:'".addslashes($row['comp_desc'])."'
                                                                        };\n";    
                                                                }      
//                                                              ?>    
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Date*</td>
                                                            <td>:</td>
                                                            <td><input type="text" id="date2" class="span3" name="data_d[2][date]"/></td>
                                                        </tr>
                                                        <tr>
                                                            <td>WO No*</td>
                                                            <td>:</td>
                                                            <td><input type="text" class="span3" name="data_d[2][wo_no_kanibal]" id="wo_no_kanibal2"/></td>
                                                        </tr>
                                                        <tr>
                                                            <td>WO Status*</td>
                                                            <td>:</td>
                                                            <td><input type="text" class="span3" name="data_d[2][wo_status_kanibal]" id="wo_status_kanibal2"/></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Unit No.*</td>
                                                            <td>:</td>
                                                            <td>
                                                                <!--<input type="text" class="span3" name="data_d[2][id_unit]"/>-->
                                                                <select class='form-control span3' name="data_d[2][id_unit]" id="id_unit2">
                                                                    <option value='0'>-- Select Unit --</option>
                                                                    <?php 
                                                                    foreach ($unit_i as $u_i) {
                                                                    echo "<option value='$u_i[id_unit]'>$u_i[unit_no]</option>";
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Comp. Desc*</td>
                                                            <td>:</td>
                                                            <td><input type="text" class="span3" name="data_d[2][comp_desc]" id="comp_desc2"/></td>
                                                        </tr>
                                                        <tr>
                                                            <td>P/N*</td>
                                                            <td>:</td>
                                                            <td><input type="text" class="span3" name="data_d[2][pn]"/></td>
                                                        </tr>
                                                        <tr>
                                                            <td>S/N</td>
                                                            <td>:</td>
                                                            <td><input type="text" class="span3" name="data_d[2][sn]"/></td>
                                                        </tr>
                                                        <tr>
                                                            <td>POS</td>
                                                            <td>:</td>
                                                            <td><input type="text" class="span3" name="data_d[2][pos]"/></td>
                                                        </tr>
                                                        <tr>
                                                            <td>HM Comp*</td>
                                                            <td>:</td>
                                                            <td><input type="text" class="span3" name="data_d[2][hm_comp]" id="comp_hour2"/></td>
                                                        </tr>
                                                    </table>
                                                    <input type="hidden" class="span3" name="data_d[2][no_ba]" value=""/>
                                                    <input type="hidden" class="span3" name="data_d[2][type]" value="INSTALL"/>
                                                </div> <!-- /plan-features -->
                                                <div class="plan-actions">
                                                    <a class="btn" onclick="reset_i()">Reset Detail</a>
                                                </div>
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
                                                                    <span style="color: red"><?php echo form_error("id_status");?></span>
                                                                    <?php foreach ($status as $s): ?>
                                                                    <label class="radio-inline">
                                                                        <input type="radio" name="data_c[1][id_status]" value="<?php echo $s->id_status;?>"/>&nbsp; <?php echo $s->status;?> &nbsp;
                                                                    </label>
                                                                    <?php endforeach;?>
                                                                    <input type="text" class="span3" name="data_c[1][status_other]" placeholder="Other"/>
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
                                            <label class="radio inline">
                                                <input type="radio" name="data_c[1][id_action]" value="<?php echo $a->id_action;?>"/>&nbsp; <?php echo $a->action;?> &nbsp;
                                            </label>
                                            <?php endforeach;?>
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
                                    
                                    <div class="control-group">											
                                        <label class="control-label"><b>MR#</b></label>
                                        <div class="controls">
                                            <input type="text" class="span3" name="data_c[1][mr_no]"/>
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
                                    <div class="control-group">											
                                        <label class="control-label"><b>PR#</b></label>
                                        <div class="controls">
                                            <input type="text" class="span3" name="data_c[1][pr_no]"/>
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
                                    <div class="control-group">											
                                        <label class="control-label"><b>PO#</b></label>
                                        <div class="controls">
                                            <input type="text" class="span3" name="data_c[1][po_no]"/>
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
                                    <div class="control-group">											
                                        <label class="control-label"><b>Remarks :</b></label>
                                        <div class="controls">
                                            <textarea name="data_c[1][remark_ba]" rows="2" cols="20" class="span11"></textarea>
                                        </div> <!-- /controls -->				
                                    </div> <!-- /control-group -->
                                </fieldset>
                                    
                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-primary">Save</button> 
                                        <button type="reset"class="btn">Reset</button>
                                    </div> <!-- /form-actions -->
                                
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
    function project(){
        var url		= '<?php echo base_url();?>cannibal/add_series/';
        var project	= document.getElementById('id_project').value;
        window.location = url+project;
    }
</script>
<script type="text/javascript">    
    <?php echo $jsArray_r; ?>  
    function changeValue_r(wo_r){  
    document.getElementById('wo_no_kanibal1').value = dtRep_r[wo_r].wo_no_kanibal1;  
    document.getElementById("wo_no_kanibal1").readOnly = true;
    document.getElementById('wo_status_kanibal1').value = dtRep_r[wo_r].wo_status_kanibal1;  
    document.getElementById('wo_status_kanibal1').readOnly = true;
    document.getElementById('comp_hour1').value = dtRep_r[wo_r].comp_hour1;  
    document.getElementById('comp_hour1').readOnly = true;
    document.getElementById('comp_desc1').value = dtRep_r[wo_r].comp_desc1;  
    document.getElementById('comp_desc1').readOnly = true;
    document.getElementById('id_unit1').value = dtRep_r[wo_r].id_unit1;  
    $('#id_unit1').prop('disabled', true);
    $('#form').on('submit', function() {
        $('#id_unit1').prop('disabled', false);
    });
    
    };  
</script>
<script type="text/javascript">    
    <?php echo $jsArray_i; ?>  
    function changeValue_i(wo_i){  
    document.getElementById('wo_no_kanibal2').value = dtRep_i[wo_i].wo_no_kanibal2;  
    document.getElementById("wo_no_kanibal2").readOnly = true;
    document.getElementById('wo_status_kanibal2').value = dtRep_i[wo_i].wo_status_kanibal2; 
    document.getElementById('wo_status_kanibal2').readOnly = true;
    document.getElementById('comp_hour2').value = dtRep_i[wo_i].comp_hour2; 
    document.getElementById('comp_hour2').readOnly = true;
    document.getElementById('comp_desc2').value = dtRep_i[wo_i].comp_desc2;
    document.getElementById('comp_desc2').readOnly = true;
    document.getElementById('id_unit2').value = dtRep_i[wo_i].id_unit2; 
    $('#id_unit2').prop('disabled', true);
    $('#form').on('submit', function() {
        $('#id_unit2').prop('disabled', false);
    });
    };  
</script>
<script>
function reset_r() {
    document.getElementById('wo_r').value = "0";  
    document.getElementById('wo_no_kanibal1').value = "";  
    document.getElementById("wo_no_kanibal1").readOnly = false;
    document.getElementById('wo_status_kanibal1').value = "";  
    document.getElementById('wo_status_kanibal1').readOnly = false;
    document.getElementById('comp_hour1').value = "";  
    document.getElementById('comp_hour1').readOnly = false;
    document.getElementById('comp_desc1').value = "";  
    document.getElementById('comp_desc1').readOnly = false;
    document.getElementById('id_unit1').value = "0";  
    $('#id_unit1').prop('disabled', false);
}
</script>
<script>
function reset_i() {
    document.getElementById('wo_i').value = "0";  
    document.getElementById('wo_no_kanibal2').value = "";  
    document.getElementById("wo_no_kanibal2").readOnly = false;
    document.getElementById('wo_status_kanibal2').value = "";  
    document.getElementById('wo_status_kanibal2').readOnly = false;
    document.getElementById('comp_hour2').value = "";  
    document.getElementById('comp_hour2').readOnly = false;
    document.getElementById('comp_desc2').value = "";  
    document.getElementById('comp_desc2').readOnly = false;
    document.getElementById('id_unit2').value = "0";  
    $('#id_unit2').prop('disabled', false);
}
</script>