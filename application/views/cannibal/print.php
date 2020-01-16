<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title; ?></title>
<link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet">
<style type="text/css">
<!--
.style2 {font-family: Arial, Helvetica, sans-serif; font-weight:bold; font-size:12px;}
.style3 {font-family: Arial, Helvetica, sans-serif; font-weight: bold; color:#FFFFFF}
.style4 {
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 24px;
}
.style5 {
	font-size: 20px
}
.tengahjudul {position: absolute;
margin-left: auto;
margin-right: auto;
left: 0;
right: 0;
width: 800px;
font-size: 12px;
border: 2px solid black;
}
.tengahsymtom {position: absolute;
margin-left: auto;
margin-right: auto;
top:113px;
left: 0;
right: 0;
width: 800px;
font-size: 14px;
border: 2px solid black;
}
.tengahdetail {position: absolute;
margin-left: auto;
margin-right: auto;
top:355px;
left: 0;
right: 0;
width: 800px;
font-size: 14px;
border: 2px solid black;
}
.tengahsign {position: absolute;
margin-left: auto;
margin-right: auto;
top:640px;
left: 0;
right: 0;
width: 800px;
font-size: 14px;
border: 2px solid black;
}
.tengahbawah {
	position: absolute;
	margin-left: auto;
	margin-right: auto;
	top:725px;
	left: 0;
	right: 0;
	width: 800px;
	font-size: 14px;
	border: 2px solid black;
	background-color: #FFCC66;
}
.input{
position: absolute;
margin-left: auto;
margin-right: auto;
left: 80px;
top: 345px
}
.style6 {color: #FFFFFF}
-->
</style>
</head>

<body>
<div class="tengahjudul" align="center">
<table width="100%" height="70" border="1" cellspacing="0">
  <tr>
    <td colspan="2" rowspan="4"><div align="center"><img src="<?php echo base_url()?>assets/img/logo.jpg" width="200" height="55" /></div></td>
    <td width="48%" rowspan="4" class="style4"><div align="center" class="style4">BERITA ACARA KANIBAL</div><div align="center" class="style5">No. <?php echo $ba->no_ba; ?></div></td>
    <td width="8%" class="style2">Doc. No</td>
    <td width="1%"><strong>:</strong></td>
    <td width="17%" class="style2">ARKA/PLT/IV/09.01</td>
  </tr>
  <tr>
    <td class="style2">Rev. No</td>
    <td><strong>:</strong></td>
    <td class="style2">1</td>
  </tr>
  <tr>
    <td class="style2">Eff. Date</td>
    <td><strong>:</strong></td>
    <td class="style2">01 Juni 2013</td>
  </tr>
  <tr>
    <td height="21" class="style2"><strong>Page</strong></td>
    <td><strong>:</strong></td>
    <td class="style2">1 of 1</td>
  </tr>
</table>
</div>
<div class="tengahsymtom" align="center">
<table width="100%" border="1" cellspacing="0">
  <tr>
    <td colspan="5" class="style2">SYMPTOM / PROBLEM :<em></em></td>
  </tr>
  <tr>
      <td height="50" colspan="5" class="style2"><?php echo $ba->symptom;?></td>
  </tr>
  <tr>
    <td colspan="5" class="style2">FAILURE / KERUSAKAN :<em></em></td>
  </tr>
  <tr>
    <td height="50" colspan="5" class="style2"><?php echo $ba->failure;?></td>
  </tr>
  <tr>
    <td colspan="5" class="style2">FAILURE CAUSED / PENYEBAB KERUSAKAN :<em></em></td>
  </tr>
  <tr>
    <td height="50" colspan="5" class="style2">
    <div class="form-group">
    	<?php foreach ($caused as $c): ?>
        <?php if($c->id_caused == $ba->id_caused):?>
        <label class="radio-inline">
        <?php echo form_checkbox('data_c[1][id_caused]', $c->id_caused, TRUE, 'disabled');?>&nbsp;<?php echo $c->caused;?>
        </label>
        <?php else:?>
        <label class="radio-inline">
        <?php echo form_checkbox('data_c[1][id_caused]', $c->id_caused, FALSE, 'disabled');?>&nbsp;<?php echo $c->caused;?>
        </label>
        <?php endif;?>
        <?php endforeach;?><br>
        Other : <input type="text" size="102" name="data_c[1][caused_other]" placeholder="......" value="<?php echo $ba->caused_other; ?>" disabled/>
    </div>
    </td>
  </tr>
</table>
</div>
<div class="tengahdetail" align="center">
<table width="100%" border="1" cellspacing="0">
  <tr>
    <td colspan="3" bgcolor="#000000"><div align="center"><span class="style3">COMPONENT DETAIL INFORMATION (RINCIAN INFORMASI KOMPONEN)</span></div></td>
    </tr>
  <tr>
    <td class="style2"><div align="center">REMOVE FROM (DIAMBIL DARI)</div></td>
    <td class="style2"><div align="center">INSTALL TO (DIPASANG KE)</div></td>
    <td class="style2"><div align="center">Status of Component Detail</div></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="1" class="style2">
  <tr>
    <td width="28%">Date</td>
    <td width="5%">:</td>
    <td width="67%"><?php echo $det_r->date; ?></td>
  </tr>
  <tr>
    <td>WO No.</td>
    <td>:</td>
    <td><?php echo $det_r->wo_no_kanibal; ?></td>
  </tr>
  <tr>
    <td>WO Status</td>
    <td>:</td>
    <td><?php echo $det_r->wo_status_kanibal; ?></td>
  </tr>
  <tr>
    <td>Unit No.</td>
    <td>:</td>
    <td><?php echo $det_r->unit_no; ?></td>
  </tr>
  <tr>
    <td>Comp. Desc</td>
    <td>:</td>
    <td><?php echo $det_r->comp_desc; ?></td>
  </tr>
  <tr>
    <td>P/N</td>
    <td>:</td>
    <td><?php echo $det_r->pn; ?></td>
  </tr>
  <tr>
    <td>S/N</td>
    <td>:</td>
    <td><?php echo $det_r->sn; ?></td>
  </tr>
  <tr>
    <td>POS</td>
    <td>:</td>
    <td><?php echo $det_r->pos; ?></td>
  </tr>
  <tr>
    <td>HM Comp</td>
    <td>:</td>
    <td><?php echo $det_r->hm_comp; ?></td>
  </tr>
</table>
</td>
    <td><table width="100%" border="0" cellspacing="1" class="style2">
  <tr>
    <td width="33%">Date</td>
    <td width="3%">:</td>
    <td width="64%"><?php echo $det_i->date; ?></td>
  </tr>
  <tr>
    <td>WO No.</td>
    <td>:</td>
    <td><?php echo $det_i->wo_no_kanibal; ?></td>
  </tr>
  <tr>
    <td>WO Status</td>
    <td>:</td>
    <td><?php echo $det_i->wo_status_kanibal; ?></td>
  </tr>
  <tr>
    <td>Unit No.</td>
    <td>:</td>
    <td><?php echo $det_i->unit_no; ?></td>
  </tr>
  <tr>
    <td>Comp. Desc</td>
    <td>:</td>
    <td><?php echo $det_i->comp_desc; ?></td>
  </tr>
  <tr>
    <td>P/N</td>
    <td>:</td>
    <td><?php echo $det_i->pn; ?></td>
  </tr>
  <tr>
    <td>S/N</td>
    <td>:</td>
    <td><?php echo $det_i->sn; ?></td>
  </tr>
  <tr>
    <td>POS</td>
    <td>:</td>
    <td><?php echo $det_i->pos; ?></td>
  </tr>
  <tr>
    <td>HM Comp</td>
    <td>:</td>
    <td><?php echo $det_i->hm_comp; ?></td>
  </tr>
</table></td>
    <td class="style2">
    <?php foreach ($status as $s): ?>
    <?php if($s->id_status == $ba->id_status):?>
    <label class="radio-inline">
    <?php echo form_checkbox('data_c[1][id_status]', $s->id_status, TRUE, 'disabled');?>&nbsp;<?php echo $s->status;?>    </label><br>
    <?php else:?>
    <label class="radio-inline">
    <?php echo form_checkbox('data_c[1][id_status]', $s->id_status, FALSE, 'disabled');?>&nbsp;<?php echo $s->status;?>    </label><br>
    <?php endif;?>
    <?php endforeach;?>
	<input type="text" size="20" name="data_c[1][status_other]" placeholder="......" value="<?php echo $ba->status_other; ?>" disabled/>    </td>
  </tr>
</table>
</div>
<div class="tengahsign" align="center">
<table width="100%" border="1" cellspacing="0">
  <tr>
    <td class="style2"><div align="center">
      <label class="style2">STATUS</label>
        <?php if($ba->status_ba == "OPEN"):?>
        <div align="center"><img src="<?php echo base_url()?>assets/img/open.png" width="150" height="45" /></div>
        <?php elseif($ba->status_ba == "CLOSE"):?>
        <div align="center"><img src="<?php echo base_url()?>assets/img/close.png" width="150" height="45" /></div>
        <?php elseif($ba->status_ba == "CANCEL"):?>
        <div align="center"><img src="<?php echo base_url()?>assets/img/cancel.png" width="150" height="45" /></div>
        <?php elseif($ba->status_ba == "REJECTED"):?>
        <div align="center"><img src="<?php echo base_url()?>assets/img/rejected.png" width="150" height="45" /></div>
        <?php else:?>
        <div align="center"><img src="<?php echo base_url()?>assets/img/draft.png" width="150" height="45" /></div>
        <?php endif;?>
      </div>
    <br></td>
    <td class="style2"><div align="center">
        <label class="style2">LOGISTIC / WH OFFICER</label>
        <?php if($ba->status_l1 == "PENDING"):?>
        <div align="center"><img src="<?php echo base_url()?>assets/img/pending.png" width="150" height="45" /></div>
        <?php elseif($ba->status_l1 == "APPROVED"):?>
        <div align="center"><img src="<?php echo base_url()?>assets/img/approved.png" width="150" height="45" /></div>
        <?php else:?>
        <div align="center"><img src="<?php echo base_url()?>assets/img/not-approved.png" width="150" height="45" /></div>
        <?php endif;?>
    </div>
    <br></td>
    <td class="style2"><div align="center">
      <label class="style2">SUPERINTENDENT</label>
        <?php if($ba->status_l2 == "PENDING"):?>
        <div align="center"><img src="<?php echo base_url()?>assets/img/pending.png" width="150" height="45" /></div>
        <?php elseif($ba->status_l2 == "APPROVED"):?>
        <div align="center"><img src="<?php echo base_url()?>assets/img/approved.png" width="150" height="45" /></div>
        <?php else:?>
        <div align="center"><img src="<?php echo base_url()?>assets/img/not-approved.png" width="150" height="45" /></div>
        <?php endif;?>
    </div>
    <br></td>
    <td class="style2"><div align="center">
      <label class="style2">PROJECT MANAGER</label>
        <?php if($ba->status_l3 == "PENDING"):?>
        <div align="center"><img src="<?php echo base_url()?>assets/img/pending.png" width="150" height="45" /></div>
        <?php elseif($ba->status_l3 == "APPROVED"):?>
        <div align="center"><img src="<?php echo base_url()?>assets/img/approved.png" width="150" height="45" /></div>
        <?php else:?>
        <div align="center"><img src="<?php echo base_url()?>assets/img/not-approved.png" width="150" height="45" /></div>
        <?php endif;?>
    </div>
    <br>
    </td>
  </tr>
</table>
</div>
<div class="tengahbawah" align="center">
<table width="100%" border="1" cellspacing="0">
  <tr>
   <td colspan="3" bgcolor="#000000"><div align="center"><span class="style3">***** RECORD AND DOCUMENTATION *****</span></div></td>
    </tr>
  <tr>
    <td colspan="3" class="style2"><div align="left">ACTION BY PLANNING SECTION</div></td>
    </tr>
  <tr>
    <td colspan="2" class="style2">
	<?php foreach ($action as $a): ?>
	<?php if($a->id_action == $ba->id_action):?>
    <label class="radio inline">
    <?php echo form_checkbox('data_c[1][id_action]', $a->id_action, TRUE, 'disabled');?>&nbsp;<?php echo $a->action;?><br>
    </label>
    <?php else:?>
    <label class="radio inline">
    <?php echo form_checkbox('data_c[1][id_action]', $a->id_action, FALSE, 'disabled');?>&nbsp;<?php echo $a->action;?><br>
    </label>
    <?php endif;?>
    <?php endforeach;?>    </td>
    <td width="32%" class="style2">
	    <table width="100%" border="0" cellspacing="1">
  <tr>
    <td width="17%">MR#</td>
    <td width="9%">:</td>
    <td width="74%"><?php echo $ba->mr_no;?></td>
  </tr>
  <tr>
    <td>PR#</td>
    <td>:</td>
    <td><?php echo $ba->pr_no;?></td>
  </tr>
  <tr>
    <td>PO#</td>
    <td>:</td>
    <td><?php echo $ba->po_no;?></td>
  </tr>
</table>

    </td>
    </tr>
  <tr>
    <td class="style2"><div align="center">
      <p class="style2">Update Component Schedule
      <br><br><br>
      (...........................................)<br>
      Date: _________________</p>
      </div></td>
    <td class="style2"><div align="center">
      <p class="style2">Closing Work Order
      <br><br><br>
      (...........................................)<br>
      Date: _________________</p>
      </div></td>
    <td class="style2"><div align="center">
      <p class="style2">Filling Document
      <br><br><br>
      (...........................................)<br>
      Date: _________________</p>
      </div></td>
    </tr>
</table>
</div>
</body>
</html>
