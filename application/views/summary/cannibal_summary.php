<?php
$filter_where = isset($filter_where) ? $filter_where : '1';
$filter_label = ($filter_where === '1') ? '' : $filter_where;
?>
<div class="main">
    <div class="main-inner">
        <div class="container">
          <div class="row">
            <div class="span12">
                <div class="widget ">
                    <div class="widget-header">
                        <i class="icon-random"></i>
                        <h3>Cannibal Summary</h3>
                    </div>
                    <div class="widget-content">
                        <form class="form-inline" method="POST" action="<?php echo site_url('cannibal_summary'); ?>">
                            <div class="control-group">
                                <div class="controls" align="center">
                                    <div class="accordion" id="accordion2">
                                        <div class="accordion-group">
                                            <div class="accordion-heading">
                                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
                                                    <div align="center">-- Advance Filter --</div>
                                                </a>
                                            </div>
                                            <div id="collapseOne" class="accordion-body collapse<?php echo ($filter_where !== '1') ? ' in' : ''; ?>">
                                                <div class="accordion-inner">
                                                    <table>
                                                        <tr>
                                                            <td><label class="checkbox inline"><input type="checkbox" name="siteCat" <?php echo isset($_POST['siteCat']) ? 'checked' : ''; ?>> Project</label></td>
                                                            <td><label class="checkbox inline"><?php echo form_dropdown('kode_project', $proj_options, isset($_POST['kode_project']) ? $_POST['kode_project'] : ''); ?></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="checkbox inline"><input type="checkbox" name="dateCat" <?php echo isset($_POST['dateCat']) ? 'checked' : ''; ?>> Date</label></td>
                                                            <td><label class="checkbox inline"><input type="text" name="posting_date" placeholder="YYYY-MM-DD" value="<?php echo isset($_POST['posting_date']) ? htmlspecialchars($_POST['posting_date']) : ''; ?>"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="checkbox inline"><input type="checkbox" name="docCat" <?php echo isset($_POST['docCat']) ? 'checked' : ''; ?>> Doc. Number</label></td>
                                                            <td><label class="checkbox inline"><input type="text" name="no_ba" value="<?php echo isset($_POST['no_ba']) ? htmlspecialchars($_POST['no_ba']) : ''; ?>"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="checkbox inline"><input type="checkbox" name="removeUnitCat" <?php echo isset($_POST['removeUnitCat']) ? 'checked' : ''; ?>> Removed Unit</label></td>
                                                            <td><label class="checkbox inline"><input type="text" name="unit_remove" value="<?php echo isset($_POST['unit_remove']) ? htmlspecialchars($_POST['unit_remove']) : ''; ?>"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="checkbox inline"><input type="checkbox" name="installUnitCat" <?php echo isset($_POST['installUnitCat']) ? 'checked' : ''; ?>> Installed Unit</label></td>
                                                            <td><label class="checkbox inline"><input type="text" name="unit_install" value="<?php echo isset($_POST['unit_install']) ? htmlspecialchars($_POST['unit_install']) : ''; ?>"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="checkbox inline"><input type="checkbox" name="pnCat" <?php echo isset($_POST['pnCat']) ? 'checked' : ''; ?>> Part Number</label></td>
                                                            <td><label class="checkbox inline"><input type="text" name="pn" value="<?php echo isset($_POST['pn']) ? htmlspecialchars($_POST['pn']) : ''; ?>"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="checkbox inline"><input type="checkbox" name="compCat" <?php echo isset($_POST['compCat']) ? 'checked' : ''; ?>> Comp. Desc</label></td>
                                                            <td><label class="checkbox inline"><input type="text" name="comp_desc" value="<?php echo isset($_POST['comp_desc']) ? htmlspecialchars($_POST['comp_desc']) : ''; ?>"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="checkbox inline"><input type="checkbox" name="statusCat" <?php echo isset($_POST['statusCat']) ? 'checked' : ''; ?>> Status</label></td>
                                                            <td><label class="checkbox inline"><?php echo form_dropdown('status_ba', $status_options, isset($_POST['status_ba']) ? $_POST['status_ba'] : ''); ?></label></td>
                                                        </tr>
                                                        <tr><td></td><td><div align="center"><label class="checkbox inline"><input class="btn btn-info" type="submit" name="submit" value="Submit"> <a class="btn" href="<?php echo site_url('cannibal_summary'); ?>">&nbsp;Reset&nbsp;</a></label></div></td></tr>
                                                     </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="alert alert-success">
                          <button type="button" class="close" data-dismiss="alert">&times;</button>
                          Status Filter: <?php echo htmlspecialchars($filter_label); ?>
                        </div>

                        <form action="<?php echo site_url('cannibal_summary/export'); ?>" method="POST">
                            <input type="hidden" name="where" id="summary_where" value="<?php echo htmlspecialchars($filter_where); ?>">
                            <div align="center"><input type="submit" value="Export to Excel" class="btn btn-success"></div>
                        </form>
                        <br>

                        <div style="width:100%; overflow-x:auto;">
                        <table id="summary_cannibal_table" class="table table-bordered table-condensed" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Site</th>
                                    <th>Date</th>
                                    <th>Doc. Number</th>
                                    <th>Removed Unit</th>
                                    <th>Installed Unit</th>
                                    <th>Part Number</th>
                                    <th>Component</th>
                                    <th>Symptom / Problem</th>
                                    <th>Action by Planner</th>
                                    <th>Status</th>
                                    <th>MR No.</th>
                                    <th>PR No.</th>
                                    <th>PO No.</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
    </div>
</div>
<input type="hidden" id="summary_datatable_url" value="<?php echo site_url('cannibal_summary/datatable'); ?>"/>
<input type="hidden" id="summary_table_type" value="cannibal"/>
