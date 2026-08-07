<style>
.cannibal-table-wrap {
    width: 100%;
    overflow-x: auto;
}
#cannibal_table {
    width: 100% !important;
    min-width: 1000px;
}
#cannibal_table th,
#cannibal_table td {
    vertical-align: middle;
}
#cannibal_table textarea {
    width: 100%;
    margin: 0;
    resize: vertical;
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
                        <i class="icon-random"></i>
                        <h3>Cannibal Lists</h3>
                    </div> <!-- /widget-header -->
                    <div class="widget-content">
                        <h4><span style="float: left"><a href="<?php echo site_url('cannibal/export'); ?>" class="btn btn-info">Export </a></span></h4>
                        <h4><span style="float: right"><a href="<?php echo site_url('cannibal/add'); ?>" class="btn btn-success">+ Add Cannibal </a></span></h4><br><br>
                        <div class="cannibal-table-wrap">
                        <table id="cannibal_table" class="table table-striped table-bordered table-condensed" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th><div align="center">No</div></th>
                                    <th><div align="center">Site</div></th>
                                    <th>Date</th>
                                    <th>Doc. Number</th>
                                    <th>Removed Unit No.</th>
                                    <th>Installed Unit No.</th>
                                    <th>Symptom / Problem</th>
                                    <th>Action by Planner</th>
                                    <th><div align="center">Status</div></th>
                                    <th><div align="center">Action</div></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        </div>
                    </div> <!-- /widget-content -->
                </div> <!-- /widget -->
                </div> <!-- /span8 -->
            </div> <!-- /row -->
        </div> <!-- /container -->
    </div> <!-- /main-inner -->
</div> <!-- /main -->
<input type="hidden" id="cannibal_datatable_url" value="<?php echo site_url('cannibal/datatable'); ?>"/>
