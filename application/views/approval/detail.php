<?php
$opt_status = array(
    'PENDING' => 'PENDING',
    'APPROVED' => 'APPROVED',
    'NOT APPROVED' => 'NOT APPROVED'
);
$level_labels = array(
    'L1' => 'Logistic / WH Officer',
    'L2' => 'Superintendent',
    'L3' => 'Project Manager',
    'LGM' => 'General Manager',
    'LPL' => 'Plant Manager',
    'LOD' => 'Operational Director',
    'LPD' => 'President Director'
);
$levels = array(
    array('sign' => 'L1', 'row' => $l1, 'status' => 'status_l1', 'date' => 'date_l1', 'remark' => 'remark_l1', 'select' => $select_optl1, 'fn' => 'changeDate1'),
    array('sign' => 'L2', 'row' => $l2, 'status' => 'status_l2', 'date' => 'date_l2', 'remark' => 'remark_l2', 'select' => $select_optl2, 'fn' => 'changeDate2'),
    array('sign' => 'L3', 'row' => $l3, 'status' => 'status_l3', 'date' => 'date_l3', 'remark' => 'remark_l3', 'select' => $select_optl3, 'fn' => 'changeDate3'),
    array('sign' => 'LGM', 'row' => $lgm, 'status' => 'status_lgm', 'date' => 'date_lgm', 'remark' => 'remark_lgm', 'select' => $select_optlgm, 'fn' => 'changeDateLgm'),
    array('sign' => 'LPL', 'row' => $lpl, 'status' => 'status_lpl', 'date' => 'date_lpl', 'remark' => 'remark_lpl', 'select' => $select_optlpl, 'fn' => 'changeDateLpl'),
    array('sign' => 'LOD', 'row' => $lod, 'status' => 'status_lod', 'date' => 'date_lod', 'remark' => 'remark_lod', 'select' => $select_optlod, 'fn' => 'changeDateLod'),
    array('sign' => 'LPD', 'row' => $lpd, 'status' => 'status_lpd', 'date' => 'date_lpd', 'remark' => 'remark_lpd', 'select' => $select_optlpd, 'fn' => 'changeDateLpd'),
);

$status_badge = function ($status) {
    $status = (string) $status;
    $class = 'label';
    if ($status === 'APPROVED') {
        $class .= ' label-success';
    } elseif ($status === 'PENDING') {
        $class .= ' label-warning';
    } elseif ($status === 'NOT APPROVED') {
        $class .= ' label-important';
    } else {
        $class .= ' label-info';
    }
    return '<span class="'.$class.'">'.htmlspecialchars($status !== '' ? $status : '-').'</span>';
};

$ba_status = isset($ba->status_ba) ? $ba->status_ba : '';
$ba_status_class = 'label-info';
if ($ba_status === 'OPEN') {
    $ba_status_class = 'label-success';
} elseif ($ba_status === 'REJECTED') {
    $ba_status_class = 'label-important';
} elseif ($ba_status === 'CANCEL') {
    $ba_status_class = 'label-warning';
} elseif ($ba_status === 'CLOSE') {
    $ba_status_class = 'label';
}
?>
<style>
.appr-detail .appr-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 18px;
    flex-wrap: wrap;
}
.appr-detail .appr-title-block h3 {
    margin: 0 0 4px;
    font-size: 20px;
    line-height: 1.2;
}
.appr-detail .appr-title-block .muted {
    color: #777;
    margin: 0;
}
.appr-detail .appr-section {
    background: #fafafa;
    border: 1px solid #e5e5e5;
    border-radius: 4px;
    padding: 14px 16px;
    margin-bottom: 16px;
}
.appr-detail .appr-section h4 {
    margin: 0 0 12px;
    font-size: 14px;
    color: #555;
    text-transform: uppercase;
    letter-spacing: 0.03em;
    border-bottom: 1px solid #eee;
    padding-bottom: 8px;
}
.appr-detail .appr-meta {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px 18px;
}
.appr-detail .appr-meta .item label {
    display: block;
    font-size: 11px;
    color: #888;
    margin-bottom: 2px;
    text-transform: uppercase;
}
.appr-detail .appr-meta .item .val {
    font-size: 14px;
    color: #333;
    font-weight: 600;
}
.appr-detail .appr-meta .item.wide {
    grid-column: span 3;
}
.appr-detail .appr-meta .item .val.soft {
    font-weight: normal;
    white-space: pre-wrap;
}
.appr-detail .appr-transfer {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
}
.appr-detail .appr-panel {
    background: #fff;
    border: 1px solid #e0e0e0;
    border-radius: 4px;
    overflow: hidden;
}
.appr-detail .appr-panel .panel-head {
    padding: 8px 12px;
    font-weight: bold;
    font-size: 12px;
    text-transform: uppercase;
    color: #fff;
}
.appr-detail .appr-panel.remove .panel-head { background: #c4704b; }
.appr-detail .appr-panel.install .panel-head { background: #3a7ca5; }
.appr-detail .appr-panel .panel-body { padding: 12px; }
.appr-detail .appr-kv {
    display: grid;
    grid-template-columns: 110px 1fr;
    gap: 6px 10px;
    margin: 0;
    font-size: 13px;
}
.appr-detail .appr-kv dt { color: #888; margin: 0; }
.appr-detail .appr-kv dd { margin: 0; color: #333; font-weight: 600; }
.appr-detail .appr-flow-row {
    display: grid;
    grid-template-columns: 180px 170px 150px 1fr;
    gap: 12px;
    align-items: center;
    padding: 12px 14px;
    background: #fff;
    border: 1px solid #e6e6e6;
    border-radius: 4px;
    margin-bottom: 8px;
}
.appr-detail .appr-flow-row.active {
    border-color: #5b9bd5;
    background: #f3f8fc;
    box-shadow: 0 0 0 1px rgba(91,155,213,0.25);
}
.appr-detail .appr-flow-row .role {
    font-size: 11px;
    color: #888;
    text-transform: uppercase;
    margin-bottom: 2px;
}
.appr-detail .appr-flow-row .who {
    font-weight: 600;
    color: #333;
}
.appr-detail .appr-flow-row .date {
    color: #666;
    font-size: 13px;
}
.appr-detail .appr-flow-row .remark {
    color: #555;
    font-size: 13px;
}
.appr-detail .appr-flow-row input[type="text"],
.appr-detail .appr-flow-row select {
    margin-bottom: 0;
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
    height: 32px;
    padding: 6px 10px;
    font-size: 13px;
    line-height: 20px;
}
.appr-detail .appr-flow-row .date input[type="text"] {
    min-width: 140px;
}
.appr-detail .appr-flow-row .remark input[type="text"] {
    min-width: 220px;
}
.appr-detail .appr-flow-row .span5,
.appr-detail .appr-flow-row .span2 {
    width: 100% !important;
}
.appr-detail .form-actions {
    margin-top: 8px;
    padding: 14px 0 0;
    background: transparent;
    border-top: 1px solid #eee;
}
.appr-detail .label {
    font-size: 11px;
    padding: 3px 8px;
    display: inline-block;
    min-width: 88px;
    text-align: center;
}
@media (max-width: 900px) {
    .appr-detail .appr-meta { grid-template-columns: 1fr 1fr; }
    .appr-detail .appr-meta .item.wide { grid-column: span 2; }
    .appr-detail .appr-transfer { grid-template-columns: 1fr; }
    .appr-detail .appr-flow-row {
        grid-template-columns: 1fr 1fr;
        gap: 8px;
    }
}
@media (max-width: 560px) {
    .appr-detail .appr-meta { grid-template-columns: 1fr; }
    .appr-detail .appr-meta .item.wide { grid-column: span 1; }
    .appr-detail .appr-flow-row { grid-template-columns: 1fr; }
}
</style>

<div class="main appr-detail">
    <div class="main-inner">
        <div class="container">
          <div class="row">
            <div class="span12">
                <div class="widget">
                    <div class="widget-header">
                        <i class="icon-check"></i>
                        <h3>BA Cannibal Approval</h3>
                    </div>
                    <div class="widget-content">
                        <div class="appr-toolbar">
                            <div class="appr-title-block">
                                <h3>
                                    <?php echo htmlspecialchars($ba->no_ba); ?>
                                    <span class="label <?php echo $ba_status_class; ?>"><?php echo htmlspecialchars($ba_status); ?></span>
                                </h3>
                                <p class="muted">Project <?php echo htmlspecialchars($ba->kode_project); ?> &middot; <?php echo htmlspecialchars($ba->posting_date); ?></p>
                            </div>
                            <div>
                                <a href="<?php echo site_url('approval'); ?>" class="btn"><i class="icon-arrow-left"></i> Back</a>
                                <a href="<?php echo site_url('cannibal/detail/'.$ba->no_ba); ?>" class="btn btn-info" target="_blank"><i class="icon-external-link"></i> Open BA</a>
                            </div>
                        </div>

                        <form class="form-horizontal" role="form" action="" method="post">
                            <div class="appr-section">
                                <h4>Document Summary</h4>
                                <div class="appr-meta">
                                    <div class="item">
                                        <label>Document No</label>
                                        <div class="val"><?php echo htmlspecialchars($ba->no_ba); ?></div>
                                    </div>
                                    <div class="item">
                                        <label>Project</label>
                                        <div class="val"><?php echo htmlspecialchars($ba->kode_project); ?></div>
                                    </div>
                                    <div class="item">
                                        <label>Posting Date</label>
                                        <div class="val"><?php echo htmlspecialchars($ba->posting_date); ?></div>
                                    </div>
                                    <div class="item">
                                        <label>Failure Cause</label>
                                        <div class="val"><?php echo htmlspecialchars($ba->caused); ?></div>
                                    </div>
                                    <div class="item wide">
                                        <label>Symptom / Problem</label>
                                        <div class="val soft"><?php echo nl2br(htmlspecialchars($ba->symptom)); ?></div>
                                    </div>
                                    <div class="item wide">
                                        <label>Failure</label>
                                        <div class="val soft"><?php echo nl2br(htmlspecialchars($ba->failure)); ?></div>
                                    </div>
                                    <?php if (!empty($ba->remark_ba)): ?>
                                    <div class="item wide">
                                        <label>BA Remarks</label>
                                        <div class="val soft"><?php echo nl2br(htmlspecialchars($ba->remark_ba)); ?></div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="appr-section">
                                <h4>Component Transfer</h4>
                                <div class="appr-transfer">
                                    <div class="appr-panel remove">
                                        <div class="panel-head">Remove From</div>
                                        <div class="panel-body">
                                            <dl class="appr-kv">
                                                <dt>WO No.</dt><dd><?php echo htmlspecialchars($det_r->wo_no_kanibal); ?></dd>
                                                <dt>Unit No.</dt><dd><?php echo htmlspecialchars($det_r->unit_no); ?></dd>
                                                <dt>Component</dt><dd><?php echo htmlspecialchars($det_r->comp_desc); ?></dd>
                                                <dt>Part Number</dt><dd><?php echo htmlspecialchars($det_r->pn); ?></dd>
                                                <dt>HM Comp</dt><dd><?php echo htmlspecialchars($det_r->hm_comp); ?></dd>
                                            </dl>
                                        </div>
                                    </div>
                                    <div class="appr-panel install">
                                        <div class="panel-head">Installed To</div>
                                        <div class="panel-body">
                                            <dl class="appr-kv">
                                                <dt>WO No.</dt><dd><?php echo htmlspecialchars($det_i->wo_no_kanibal); ?></dd>
                                                <dt>Unit No.</dt><dd><?php echo htmlspecialchars($det_i->unit_no); ?></dd>
                                                <dt>Component</dt><dd><?php echo htmlspecialchars($det_i->comp_desc); ?></dd>
                                                <dt>Part Number</dt><dd><?php echo htmlspecialchars($det_i->pn); ?></dd>
                                                <dt>HM Comp</dt><dd><?php echo htmlspecialchars($det_i->hm_comp); ?></dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="appr-section">
                                <h4>Approval Workflow</h4>
                                <?php foreach ($levels as $lv):
                                    $row = $lv['row'];
                                    $status_field = $lv['status'];
                                    $date_field = $lv['date'];
                                    $remark_field = $lv['remark'];
                                    $is_active = ($pengguna->sign == $lv['sign']);
                                    $status_val = isset($row->$status_field) ? $row->$status_field : '';
                                    $date_val = isset($row->$date_field) ? $row->$date_field : '';
                                    $remark_val = isset($row->$remark_field) ? $row->$remark_field : '';
                                    $username = isset($row->username) ? $row->username : '-';
                                ?>
                                <div class="appr-flow-row<?php echo $is_active ? ' active' : ''; ?>">
                                    <div>
                                        <div class="role"><?php echo htmlspecialchars($level_labels[$lv['sign']]); ?></div>
                                        <div class="who"><?php echo htmlspecialchars($username); ?></div>
                                    </div>
                                    <div>
                                        <?php if ($is_active): ?>
                                            <?php echo form_dropdown($status_field, $opt_status, $lv['select'], 'id="'.$status_field.'" onchange="'.$lv['fn'].'(this.value)"'); ?>
                                        <?php else: ?>
                                            <?php echo $status_badge($status_val); ?>
                                        <?php endif; ?>
                                    </div>
                                    <div class="date">
                                        <?php if ($is_active): ?>
                                            <input id="<?php echo $date_field; ?>" type="text" name="<?php echo $date_field; ?>" value="<?php echo htmlspecialchars($date_val); ?>" readonly="readonly" placeholder="Date"/>
                                            <input id="status_ba_<?php echo strtolower($lv['sign']); ?>" type="hidden" name="status_ba"/>
                                        <?php else: ?>
                                            <?php echo $date_val !== '' && $date_val !== '0000-00-00' ? htmlspecialchars($date_val) : '—'; ?>
                                        <?php endif; ?>
                                    </div>
                                    <div class="remark">
                                        <?php if ($is_active): ?>
                                            <input type="text" name="<?php echo $remark_field; ?>" value="<?php echo htmlspecialchars($remark_val); ?>" placeholder="Remarks"/>
                                        <?php else: ?>
                                            <?php echo $remark_val !== '' ? htmlspecialchars($remark_val) : '—'; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>

                                <?php if ($pengguna->sign != 'L0'): ?>
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Save Decision</button>
                                    <button type="reset" class="btn">Reset</button>
                                </div>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
          </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function setApprovalDate(statusId, dateId, statusBaId){
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth()+1;
        var y = date.getFullYear();
        var x = document.getElementById(statusId).value;
        document.getElementById(dateId).value = y+"-"+m+"-"+d;
        document.getElementById(dateId).readOnly = true;
        if(x == "NOT APPROVED"){
            document.getElementById(statusBaId).value = "REJECTED";
        }else{
            document.getElementById(statusBaId).value = "OPEN";
        }
    }
    function changeDate1(){ setApprovalDate("status_l1", "date_l1", "status_ba_l1"); }
    function changeDate2(){ setApprovalDate("status_l2", "date_l2", "status_ba_l2"); }
    function changeDate3(){ setApprovalDate("status_l3", "date_l3", "status_ba_l3"); }
    function changeDateLpl(){ setApprovalDate("status_lpl", "date_lpl", "status_ba_lpl"); }
    function changeDateLgm(){ setApprovalDate("status_lgm", "date_lgm", "status_ba_lgm"); }
    function changeDateLod(){ setApprovalDate("status_lod", "date_lod", "status_ba_lod"); }
    function changeDateLpd(){ setApprovalDate("status_lpd", "date_lpd", "status_ba_lpd"); }
</script>
