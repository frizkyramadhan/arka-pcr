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
.style6 {color: #FFFFFF}
body {
	margin: 0;
	padding: 0;
}
.print-wrap {
	width: 800px;
	margin: 0 auto;
	font-size: 14px;
}
.print-section {
	width: 100%;
	border: 2px solid black;
	margin: 0 0 4px 0;
	box-sizing: border-box;
}
.print-section table {
	width: 100%;
	border-collapse: collapse;
	table-layout: fixed;
}
.print-section td {
	word-wrap: break-word;
	overflow-wrap: break-word;
	vertical-align: top;
}
.print-header {
	border-collapse: collapse;
	table-layout: fixed;
	width: 100%;
}
.print-header > tbody > tr > td {
	border: 1px solid #000;
	vertical-align: middle;
	text-align: center;
}
.print-header .header-logo {
	width: 24%;
	padding: 2px 4px;
}
.print-header .header-logo img {
	display: block;
	margin: 0 auto;
	max-width: 140px;
	max-height: 42px;
	width: auto;
	height: auto;
}
.print-header .header-title {
	width: 50%;
	padding: 2px 4px;
}
.print-header .header-title .style4 {
	font-size: 20px;
	line-height: 1.1;
	margin: 0;
}
.print-header .header-title .style5 {
	font-size: 16px;
	line-height: 1.1;
	margin: 2px 0 0 0;
}
.print-header .header-meta {
	width: 26%;
	padding: 0;
	vertical-align: middle;
}
.print-header .header-meta table {
	width: 100%;
	border-collapse: collapse;
	table-layout: fixed;
}
.print-header .header-meta td {
	border: 1px solid #000;
	vertical-align: middle;
	padding: 1px 4px;
	text-align: left;
	font-size: 11px;
	line-height: 1.2;
}
.print-footer {
	background-color: #FFCC66;
}
@media print {
	.print-wrap {
		width: 800px;
	}
	.print-section {
		page-break-inside: avoid;
	}
}
-->
</style>
</head>

<body>
<div class="print-wrap">
<div class="print-section" align="center">
<table class="print-header" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="header-logo">
      <img src="<?php echo base_url()?>assets/img/logo.jpg" alt="ARKA" />
    </td>
    <td class="header-title">
      <div class="style4">BERITA ACARA KANIBAL</div>
      <div class="style5">No. <?php echo $ba->no_ba; ?></div>
    </td>
    <td class="header-meta">
      <table border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td class="style2" width="34%">Doc. No</td>
          <td class="style2" width="6%"><strong>:</strong></td>
          <td class="style2" width="60%">ARKA/PLT/IV/09.01</td>
        </tr>
        <tr>
          <td class="style2">Rev. No</td>
          <td class="style2"><strong>:</strong></td>
          <td class="style2">1</td>
        </tr>
        <tr>
          <td class="style2">Eff. Date</td>
          <td class="style2"><strong>:</strong></td>
          <td class="style2">01 Juni 2013</td>
        </tr>
        <tr>
          <td class="style2"><strong>Page</strong></td>
          <td class="style2"><strong>:</strong></td>
          <td class="style2">1 of 1</td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</div>
<div class="print-section" align="center">
<table width="100%" border="1" cellspacing="0">
  <tr>
    <td colspan="5" class="style2">Site : <?php echo isset($ba->kode_project) ? $ba->kode_project : ''; ?></td>
  </tr>
  <tr>
    <td colspan="5" class="style2">Component : <?php echo (isset($det_r) && $det_r) ? $det_r->comp_desc : ''; ?></td>
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
<div class="print-section" align="center">
<table width="100%" border="1" cellspacing="0">
  <tr>
    <td colspan="3" bgcolor="#000000"><div align="center"><span class="style3">COMPONENT DETAIL INFORMATION (RINCIAN INFORMASI KOMPONEN)</span></div></td>
    </tr>
  <tr>
    <td class="style2" width="34%"><div align="center">REMOVE FROM (DIAMBIL DARI)</div></td>
    <td class="style2" width="34%"><div align="center">INSTALL TO (DIPASANG KE)</div></td>
    <td class="style2" width="32%"><div align="center">Status of Component Detail</div></td>
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
<div class="print-section" align="center">
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
  <tr>
    <td class="style2"><div align="center">
      <label class="style2">GENERAL MANAGER</label>
        <?php if($ba->status_lgm == "PENDING"):?>
        <div align="center"><img src="<?php echo base_url()?>assets/img/pending.png" width="150" height="45" /></div>
        <?php elseif($ba->status_lgm == "APPROVED"):?>
        <div align="center"><img src="<?php echo base_url()?>assets/img/approved.png" width="150" height="45" /></div>
        <?php else:?>
        <div align="center"><img src="<?php echo base_url()?>assets/img/not-approved.png" width="150" height="45" /></div>
        <?php endif;?>
    </div>
    <br></td>
    <td class="style2"><div align="center">
      <label class="style2">PLANT MANAGER</label>
        <?php if($ba->status_lpl == "PENDING"):?>
        <div align="center"><img src="<?php echo base_url()?>assets/img/pending.png" width="150" height="45" /></div>
        <?php elseif($ba->status_lpl == "APPROVED"):?>
        <div align="center"><img src="<?php echo base_url()?>assets/img/approved.png" width="150" height="45" /></div>
        <?php else:?>
        <div align="center"><img src="<?php echo base_url()?>assets/img/not-approved.png" width="150" height="45" /></div>
        <?php endif;?>
    </div>
    <br></td>
    <td class="style2"><div align="center">
      <label class="style2">OPERATIONAL DIRECTOR</label>
        <?php if($ba->status_lod == "PENDING"):?>
        <div align="center"><img src="<?php echo base_url()?>assets/img/pending.png" width="150" height="45" /></div>
        <?php elseif($ba->status_lod == "APPROVED"):?>
        <div align="center"><img src="<?php echo base_url()?>assets/img/approved.png" width="150" height="45" /></div>
        <?php else:?>
        <div align="center"><img src="<?php echo base_url()?>assets/img/not-approved.png" width="150" height="45" /></div>
        <?php endif;?>
    </div>
    <br></td>
    <td class="style2"><div align="center">
      <label class="style2">PRESIDENT DIRECTOR</label>
        <?php if($ba->status_lpd == "PENDING"):?>
        <div align="center"><img src="<?php echo base_url()?>assets/img/pending.png" width="150" height="45" /></div>
        <?php elseif($ba->status_lpd == "APPROVED"):?>
        <div align="center"><img src="<?php echo base_url()?>assets/img/approved.png" width="150" height="45" /></div>
        <?php else:?>
        <div align="center"><img src="<?php echo base_url()?>assets/img/not-approved.png" width="150" height="45" /></div>
        <?php endif;?>
    </div>
    <br></td>
  </tr>
</table>
</div>
<div class="print-section print-footer" align="center">
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
</div>
</body>
</html>
