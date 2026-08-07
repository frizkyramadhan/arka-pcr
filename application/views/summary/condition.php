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
                        <h3>Component Condition Summary</h3>
                    </div>
                    <div class="widget-content">
                        <form class="form-inline" method="POST" action="<?php echo site_url('condition'); ?>">
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
                                                            <td><label class="checkbox inline"><input type="checkbox" name="unitCat" <?php echo isset($_POST['unitCat']) ? 'checked' : ''; ?>> Unit No</label></td>
                                                            <td><label class="checkbox inline"><input type="text" name="unit_no" value="<?php echo isset($_POST['unit_no']) ? htmlspecialchars($_POST['unit_no']) : ''; ?>"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="checkbox inline"><input type="checkbox" name="modelCat" <?php echo isset($_POST['modelCat']) ? 'checked' : ''; ?>> Model</label></td>
                                                            <td><label class="checkbox inline"><input type="text" name="model_no" value="<?php echo isset($_POST['model_no']) ? htmlspecialchars($_POST['model_no']) : ''; ?>"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="checkbox inline"><input type="checkbox" name="compCat" <?php echo isset($_POST['compCat']) ? 'checked' : ''; ?>> Comp. Desc</label></td>
                                                            <td><label class="checkbox inline"><input type="text" name="comp_desc" value="<?php echo isset($_POST['comp_desc']) ? htmlspecialchars($_POST['comp_desc']) : ''; ?>"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="checkbox inline"><input type="checkbox" name="condCat" <?php echo isset($_POST['condCat']) ? 'checked' : ''; ?>> Condition</label></td>
                                                            <td><label class="checkbox inline"><?php echo form_dropdown('condition', array('NORMAL'=>'NORMAL','ATTENTION'=>'ATTENTION','CRITICAL'=>'CRITICAL'), isset($_POST['condition']) ? $_POST['condition'] : ''); ?></label></td>
                                                        </tr>
                                                        <tr><td></td><td><div align="center"><label class="checkbox inline"><input class="btn btn-info" type="submit" name="submit" value="Submit"> <a class="btn" href="<?php echo site_url('condition'); ?>">&nbsp;Reset&nbsp;</a></label></div></td></tr>
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

                        <form action="<?php echo site_url('condition/export'); ?>" method="POST">
                            <input type="hidden" name="where" id="summary_where" value="<?php echo htmlspecialchars($filter_where); ?>">
                            <div align="center"><input type="submit" value="Export to Excel" class="btn btn-success"></div>
                        </form>
                        <br>

                        <table id="summary_condition_table" class="table table-bordered table-condensed" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Site</th>
                                    <th>Unit No.</th>
                                    <th>Model</th>
                                    <th>Component Description</th>
                                    <th>Component Condition</th>
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
<input type="hidden" id="summary_datatable_url" value="<?php echo site_url('condition/datatable'); ?>"/>
<input type="hidden" id="summary_table_type" value="condition"/>
