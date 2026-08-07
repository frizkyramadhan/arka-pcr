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
                        <i class="icon-columns"></i>
                        <h3>PCR Summary</h3>
                    </div>
                    <div class="widget-content">
                        <form class="form-inline" method="POST" action="<?php echo site_url('pcr'); ?>">
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
                                                            <td><label class="checkbox inline"><input type="checkbox" name="manCat" <?php echo isset($_POST['manCat']) ? 'checked' : ''; ?>> Manufacture</label></td>
                                                            <td><label class="checkbox inline"><input type="text" name="manufacture" value="<?php echo isset($_POST['manufacture']) ? htmlspecialchars($_POST['manufacture']) : ''; ?>"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="checkbox inline"><input type="checkbox" name="modCat" <?php echo isset($_POST['modCat']) ? 'checked' : ''; ?>> Model</label></td>
                                                            <td><label class="checkbox inline"><input type="text" name="model_no" value="<?php echo isset($_POST['model_no']) ? htmlspecialchars($_POST['model_no']) : ''; ?>"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="checkbox inline"><input type="checkbox" name="unitCat" <?php echo isset($_POST['unitCat']) ? 'checked' : ''; ?>> Unit No</label></td>
                                                            <td><label class="checkbox inline"><input type="text" name="unit_no" value="<?php echo isset($_POST['unit_no']) ? htmlspecialchars($_POST['unit_no']) : ''; ?>"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="checkbox inline"><input type="checkbox" name="compCat" <?php echo isset($_POST['compCat']) ? 'checked' : ''; ?>> Comp. Desc</label></td>
                                                            <td><label class="checkbox inline"><input type="text" name="comp_desc" value="<?php echo isset($_POST['comp_desc']) ? htmlspecialchars($_POST['comp_desc']) : ''; ?>"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="checkbox inline"><input type="checkbox" name="polCat" <?php echo isset($_POST['polCat']) ? 'checked' : ''; ?>> Policy</label></td>
                                                            <td><label class="checkbox inline"><input type="text" name="policy" value="<?php echo isset($_POST['policy']) ? htmlspecialchars($_POST['policy']) : ''; ?>"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="checkbox inline"><input type="checkbox" name="priCat" <?php echo isset($_POST['priCat']) ? 'checked' : ''; ?>> Price (IDR)</label></td>
                                                            <td><label class="checkbox inline"><input type="text" name="price" value="<?php echo isset($_POST['price']) ? htmlspecialchars($_POST['price']) : ''; ?>"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="checkbox inline"><input type="checkbox" name="woCat" <?php echo isset($_POST['woCat']) ? 'checked' : ''; ?>> WO Number</label></td>
                                                            <td><label class="checkbox inline"><input type="text" name="wo_no" value="<?php echo isset($_POST['wo_no']) ? htmlspecialchars($_POST['wo_no']) : ''; ?>"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="checkbox inline"><input type="checkbox" name="staCat" <?php echo isset($_POST['staCat']) ? 'checked' : ''; ?>> WO Status</label></td>
                                                            <td>
                                                                <label class="radio inline"><input type="radio" name="wo_status" value="OPEN" <?php echo (isset($_POST['wo_status']) && $_POST['wo_status']==='OPEN') ? 'checked' : ''; ?>> OPEN </label>
                                                                <label class="radio inline"><input type="radio" name="wo_status" value="CLOSE" <?php echo (isset($_POST['wo_status']) && $_POST['wo_status']==='CLOSE') ? 'checked' : ''; ?>> CLOSE</label>
                                                            </td>
                                                        </tr>
                                                        <tr><td></td><td><label class="checkbox inline"><input class="btn btn-info" type="submit" name="submit" value="Submit"> <a class="btn" href="<?php echo site_url('pcr'); ?>">&nbsp;Reset&nbsp;</a></label></td></tr>
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

                        <form action="<?php echo site_url('pcr/export'); ?>" method="POST">
                            <input type="hidden" name="where" id="summary_where" value="<?php echo htmlspecialchars($filter_where); ?>">
                            <div align="center"><input type="submit" value="Export to Excel" class="btn btn-success"></div>
                        </form>
                        <br>

                        <div style="width:100%; overflow-x:auto;">
                        <table id="summary_pcr_table" class="table table-bordered table-condensed" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Site</th>
                                    <th>Manufacture</th>
                                    <th>Model</th>
                                    <th>Unit No.</th>
                                    <th>Component</th>
                                    <th>Policy</th>
                                    <th>Price</th>
                                    <th>% Life</th>
                                    <th>Comp Life</th>
                                    <th>Condition</th>
                                    <th>HM Now</th>
                                    <th>WH/Day</th>
                                    <th>WO</th>
                                    <th>WO Date</th>
                                    <th>WO Status</th>
                                    <th>WO End</th>
                                    <th>Inst. Hrs</th>
                                    <th>Last HM</th>
                                    <th>Last Date</th>
                                    <th>Next Date</th>
                                    <th>Remarks</th>
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
<input type="hidden" id="summary_datatable_url" value="<?php echo site_url('pcr/datatable'); ?>"/>
<input type="hidden" id="summary_table_type" value="pcr"/>
