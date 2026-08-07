<style>
.approval-table-wrap {
    width: 100%;
    overflow-x: auto;
}
#approval_table {
    width: 100% !important;
    min-width: 1100px;
}
#approval_table th,
#approval_table td {
    white-space: nowrap;
    vertical-align: middle;
    text-align: center;
}
#approval_table .label {
    font-size: 11px;
    padding: 3px 8px;
    display: inline-block;
    min-width: 90px;
}
.dataTables_wrapper .dataTables_scroll {
    clear: both;
}
.dataTables_processing {
    z-index: 10;
}
</style>
<div class="main">
    <div class="main-inner">
        <div class="container">
          <div class="row">
            <div class="span12">
                <div class="widget ">
                    <div class="widget-header">
                        <i class="icon-check"></i>
                        <h3>Approval List</h3>
                    </div>
                    <div class="widget-content">
                        <div class="approval-table-wrap">
                        <table id="approval_table" class="display table-condensed table-hover" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                  <th><div align="center">No</div></th>
                                  <th><div align="center">Document No.</div></th>
                                  <th><div align="center">Removed Unit</div></th>
                                  <th><div align="center">Installed Unit</div></th>
                                  <th><div align="center">Date</div></th>
                                  <th><div align="center">WH</div></th>
                                  <th><div align="center">SPT</div></th>
                                  <th><div align="center">PM</div></th>
                                  <th><div align="center">LGM</div></th>
                                  <th><div align="center">LPL</div></th>
                                  <th><div align="center">LOD</div></th>
                                  <th><div align="center">LPD</div></th>
                                  <th><div align="center">Action</div></th>
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
<input type="hidden" id="approval_datatable_url" value="<?php echo site_url('approval/datatable'); ?>"/>
