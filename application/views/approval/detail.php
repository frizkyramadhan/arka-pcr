<div class="main">
    <div class="main-inner">
        <div class="container">
          <div class="row">
            <div class="span12">      		
                <div class="widget ">
                    <div class="widget-header">
                        <i class="icon-random"></i>
                        <h3>Approval Detail</h3>
                    </div> <!-- /widget-header -->
<!--                    <pre>
                    <?php // print_r($ba);?>
                    <?php // print_r($l1);?>
                    <?php // print_r($l2);?>
                    <?php // print_r($l3);?>
                    </pre>-->
                    <div class="widget-content">
                        <h4><span style="float: left"><a href="<?php echo site_url('approval'); ?>" class="btn btn-info"><i class="icon-arrow-left"></i> Back</a></span></h4>
                        <br><br>
                        <div class="tab-pane" id="formcontrols">
                            <form class="form-horizontal" role="form" action="" method="post">
                                <fieldset>
                                <table width="100%" border="0" cellspacing="1">
                                    <tr>
                                      <td width="16%"><strong>No</strong></td>
                                      <td width="1%">:</td>
                                      <td width="32%"><?php echo $ba->no_ba; ?></td>
                                      <td width="16%"><strong>Symptom</strong></td>
                                      <td width="1%">:</td>
                                      <td width="34%"><?php echo $ba->symptom?></td>
                                    </tr>
                                    <tr>
                                      <td><strong>Project</strong></td>
                                      <td>:</td>
                                      <td><?php echo $ba->kode_project?></td>
                                      <td><strong>Failure</strong></td>
                                      <td>:</td>
                                      <td><?php echo $ba->failure?></td>
                                    </tr>
                                    <tr>
                                      <td><strong>Posting Date</strong></td>
                                      <td>:</td>
                                      <td><?php echo $ba->posting_date?></td>
                                      <td><strong>Caused</strong></td>
                                      <td>:</td>
                                      <td><?php echo $ba->caused;?></td>
                                    </tr>
                                    <tr>
                                      <td colspan="6">&nbsp;</td>
                                    </tr>
                                    <tr>
                                      <td colspan="3"><div align="center"><strong>REMOVE FROM (DIAMBIL DARI)</strong></div></td>
                                      <td colspan="3"><div align="center"><strong>INSTALLED TO (DIPASANG KE)</strong></div></td>
                                      </tr>
                                    <tr>
                                      <td><strong>WO No.</strong></td>
                                      <td>:</td>
                                      <td><?php echo $det_r->wo_no_kanibal?></td>
                                      <td><strong>WO No.</strong></td>
                                      <td>:</td>
                                      <td><?php echo $det_i->wo_no_kanibal?></td>
                                    </tr>
                                    <tr>
                                      <td><strong>Unit No.</strong></td>
                                      <td>:</td>
                                      <td><?php echo $det_r->unit_no?></td>
                                      <td><strong>Unit No.</strong></td>
                                      <td>:</td>
                                      <td><?php echo $det_i->unit_no?></td>
                                    </tr>
                                    <tr>
                                      <td><strong>Component Description</strong></td>
                                      <td>:</td>
                                      <td><?php echo $det_r->comp_desc?></td>
                                      <td><strong>Component Description</strong></td>
                                      <td>:</td>
                                      <td><?php echo $det_i->comp_desc?></td>
                                    </tr>
                                    <tr>
                                      <td><strong>Part Number</strong></td>
                                      <td>:</td>
                                      <td><?php echo $det_r->pn?></td>
                                      <td><strong>Part Number</strong></td>
                                      <td>:</td>
                                      <td><?php echo $det_i->pn?></td>
                                    </tr>
                                    <tr>
                                      <td><strong>HM Comp</strong></td>
                                      <td>:</td>
                                      <td><?php echo $det_r->hm_comp?></td>
                                      <td><strong>HM Comp</strong></td>
                                      <td>:</td>
                                      <td><?php echo $det_i->hm_comp?></td>
                                    </tr>
                                    <tr>
                                      <td colspan="6">&nbsp;</td>
                                    </tr>
                                    <tr>
                                      <td><strong>Remarks</strong></td>
                                      <td>:</td>
                                      <td colspan="4"><?php echo $ba->remark_ba?></td>
                                      </tr>
                                  </table>
                                  <br>
                                  <table width="100%" border="2" cellspacing="5" cellpadding="5">
                                    <tr>
                                      <th width="13%"><strong>Authorizer</strong></th>
                                      <th width="33%"><strong>Answer</strong></th>
                                      <th width="12%"><strong>Date</strong></th>
                                      <th width="42%"><strong>Remarks</strong></th>
                                    </tr>
                                    <?php if($pengguna->sign == 'L1'):?>
                                    <tr>
                                      <td><?php echo $l1->username;?></td>
                                      <td>
                                          <?php $opt_l1 = array(
                                                      'PENDING'     => 'PENDING',
                                                      'APPROVED'    => 'APPROVED',
                                                      'NOT APPROVED' => 'NOT APPROVED'
                                                    );
                                            echo form_dropdown('status_l1', $opt_l1, $select_optl1, 'class=span5 id="status_l1" onchange="changeDate1(this.value)"');
                                            ?>
                                      </td>
                                      <td>
                                          <input id="date_l1" type="text" class="span2" name="date_l1" value="<?php echo $l1->remark_l1; ?>" readonly="TRUE"/>
                                          <input id="status_bal1" type="hidden" class="span2" name="status_ba"/>
                                      </td>
                                      <td><input type="text" class="span5" name="remark_l1" value="<?php echo $l1->remark_l1; ?>"/></td>
                                    </tr>
                                    <?php else:?>
                                    <tr>
                                      <td><?php echo $l1->username;?></td>
                                      <td><?php echo $l1->status_l1;?></td>
                                      <td><?php echo $l1->date_l1;?></td>
                                      <td><?php echo $l1->remark_l1;?></td>
                                    </tr>
                                    <?php endif;?>
                                    <?php if($pengguna->sign == 'L2'):?>
                                    <tr>
                                      <td><?php echo $l2->username;?></td>
                                      <td>
                                          <?php $opt_l2 = array(
                                                      'PENDING'     => 'PENDING',
                                                      'APPROVED'    => 'APPROVED',
                                                      'NOT APPROVED' => 'NOT APPROVED'
                                                    );
                                            echo form_dropdown('status_l2', $opt_l2, $select_optl2, 'class=span5 id="status_l2" onchange="changeDate2(this.value)"');
                                            ?>
                                      </td>
                                      <td>
                                          <input id="date_l2" type="text" class="span2" name="date_l2" value="<?php echo $l2->remark_l2; ?>" readonly="TRUE"/>
                                          <input id="status_bal2" type="hidden" class="span2" name="status_ba"/>
                                      </td>
                                      <td><input type="text" class="span5" name="remark_l2" value="<?php echo $l2->remark_l2; ?>"/></td>
                                    </tr>
                                    <?php else:?>
                                    <tr>
                                      <td><?php echo $l2->username;?></td>
                                      <td><?php echo $l2->status_l2;?></td>
                                      <td><?php echo $l2->date_l2;?></td>
                                      <td><?php echo $l2->remark_l2;?></td>
                                    </tr>
                                    <?php endif;?>
                                    <?php if($pengguna->sign == 'L3'):?>
                                    <tr>
                                      <td><?php echo $l3->username;?></td>
                                      <td>
                                          <?php $opt_l3 = array(
                                                      'PENDING'     => 'PENDING',
                                                      'APPROVED'    => 'APPROVED',
                                                      'NOT APPROVED' => 'NOT APPROVED'
                                                    );
                                            echo form_dropdown('status_l3', $opt_l3, $select_optl3, 'class=span5 id="status_l3" onchange="changeDate3(this.value)"');
                                            ?>
                                      </td>
                                      <td>
                                          <input id="date_l3" type="text" class="span2" name="date_l3" value="<?php echo $l3->remark_l3; ?>" readonly="TRUE"/>
                                          <input id="status_bal3" type="hidden" class="span2" name="status_ba"/>
                                      </td>
                                      <td><input type="text" class="span5" name="remark_l3" value="<?php echo $l3->remark_l3; ?>"/></td>
                                    </tr>
                                    <?php else:?>
                                    <tr>
                                      <td><?php echo $l3->username;?></td>
                                      <td><?php echo $l3->status_l3;?></td>
                                      <td><?php echo $l3->date_l3;?></td>
                                      <td><?php echo $l3->remark_l3;?></td>
                                    </tr>
                                    <?php endif;?>
                                  </table>
                              </fieldset>
                            <?php if($pengguna->sign != 'L0'):?>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">Save</button> 
                                <button type="reset"class="btn">Reset</button>
                            </div>   
                            <?php endif;?>
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
    function changeDate1(status_l1){ 
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth()+1;
        var y = date.getFullYear();
        var x = document.getElementById("status_l1").value;
        document.getElementById('date_l1').value = y+"-"+m+"-"+d;  
        document.getElementById("date_l1").readOnly = true;
        if(x == "NOT APPROVED"){
            document.getElementById('status_bal1').value = "REJECTED";  
        }else{
            document.getElementById('status_bal1').value = "OPEN";  
        }
    };  
</script>

<script type="text/javascript">    
    function changeDate2(status_l2){ 
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth()+1;
        var y = date.getFullYear();
        var x = document.getElementById("status_l2").value;
        document.getElementById('date_l2').value = y+"-"+m+"-"+d;  
        document.getElementById("date_l2").readOnly = true;
        if(x == "NOT APPROVED"){
            document.getElementById('status_bal2').value = "REJECTED";  
        }else{
            document.getElementById('status_bal2').value = "OPEN";  
        }
    };  
</script>

<script type="text/javascript">    
    function changeDate3(status_l3){ 
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth()+1;
        var y = date.getFullYear();
        var x = document.getElementById("status_l3").value;
        document.getElementById('date_l3').value = y+"-"+m+"-"+d;  
        document.getElementById("date_l3").readOnly = true;
        if(x == "NOT APPROVED"){
            document.getElementById('status_bal3').value = "REJECTED";  
        }else{
            document.getElementById('status_bal3').value = "OPEN";  
        }
    };  
</script>