<!--<div class="extra">
  <div class="extra-inner">
    <div class="container">
      <div class="row">
                    <div class="span3">
                        <h4>
                            About Free Admin Template</h4>
                        <ul>
                            <li><a href="javascript:;">EGrappler.com</a></li>
                            <li><a href="javascript:;">Web Development Resources</a></li>
                            <li><a href="javascript:;">Responsive HTML5 Portfolio Templates</a></li>
                            <li><a href="javascript:;">Free Resources and Scripts</a></li>
                        </ul>
                    </div>
                     /span3 
                    <div class="span3">
                        <h4>
                            Support</h4>
                        <ul>
                            <li><a href="javascript:;">Frequently Asked Questions</a></li>
                            <li><a href="javascript:;">Ask a Question</a></li>
                            <li><a href="javascript:;">Video Tutorial</a></li>
                            <li><a href="javascript:;">Feedback</a></li>
                        </ul>
                    </div>
                     /span3 
                    <div class="span3">
                        <h4>
                            Something Legal</h4>
                        <ul>
                            <li><a href="javascript:;">Read License</a></li>
                            <li><a href="javascript:;">Terms of Use</a></li>
                            <li><a href="javascript:;">Privacy Policy</a></li>
                        </ul>
                    </div>
                     /span3 
                    <div class="span3">
                        <h4>
                            Open Source jQuery Plugins</h4>
                        <ul>
                            <li><a href="http://www.egrappler.com">Open Source jQuery Plugins</a></li>
                            <li><a href="http://www.egrappler.com;">HTML5 Responsive Tempaltes</a></li>
                            <li><a href="http://www.egrappler.com;">Free Contact Form Plugin</a></li>
                            <li><a href="http://www.egrappler.com;">Flat UI PSD</a></li>
                        </ul>
                    </div>
                     /span3 
                </div>
       /row  
    </div>
     /container  
  </div>
   /extra-inner  
</div>-->
<!-- /extra -->
<div class="footer">
  <div class="footer-inner">
    <div class="container">
      <div class="row">
        <div class="span6"> &copy; 2016 <a href="<?php echo base_url();?>">ARKA Planned Component Replacement</a></div> 
        <div class="span6" align="right">Page rendered in <strong>{elapsed_time}</strong> seconds.</div> 
        <!-- /span12 --> 
      </div>
      <!-- /row --> 
    </div>
    <!-- /container --> 
  </div>
  <!-- /footer-inner --> 
</div>
<!-- /footer --> 
<!-- Le javascript
================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 

<script src="<?php echo base_url();?>assets/js/jquery-1.7.2.min.js" type="text/javascript"></script> 
<script src="<?php echo base_url();?>assets/js/excanvas.min.js"></script> 
<script src="<?php echo base_url();?>assets/js/chart.min.js" type="text/javascript"></script> 
<script src="<?php echo base_url();?>assets/js/bootstrap.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo base_url();?>assets/js/full-calendar/fullcalendar.min.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.dataTables.min.js"></script> 
<script src="<?php echo base_url();?>datepicker/js/jquery-ui-1.10.4.custom.js"></script>
<script src="<?php echo base_url();?>assets/js/base.js"></script> 
<script>
function filterGlobal () {
    $('#pcr').DataTable().search( 
        $('#global_filter').val(),
        $('#global_regex').prop('checked'), 
        $('#global_smart').prop('checked')
    ).draw();
}
 
function filterColumn ( i ) {
    $('#pcr').DataTable().column( i ).search( 
        $('#col'+i+'_filter').val(),
        $('#col'+i+'_regex').prop('checked'), 
        $('#col'+i+'_smart').prop('checked')
    ).draw();
}
 
$(document).ready(function() {
    if ($('#pcr').length) {
        $('#pcr').dataTable();
    }
 
    $('input.global_filter').on( 'keyup click', function () {
        filterGlobal();
    } );
 
    $('input.column_filter').on( 'keyup click', function () {
        filterColumn( $(this).parents('tr').attr('data-column') );
    } );
} );
</script>
<script>     
$(document).ready(function() {
    function initSummaryTable(selector, columns, orderCol) {
        var url = $('#summary_datatable_url').val();
        var where = $('#summary_where').val() || '1';
        $(selector).DataTable({
            processing: true,
            serverSide: true,
            scrollX: true,
            autoWidth: false,
            pageLength: 25,
            order: [[orderCol, 'desc']],
            ajax: {
                url: url,
                type: 'GET',
                data: function (d) {
                    d.where = where;
                },
                error: function (xhr, error, thrown) {
                    console.error('Summary DataTable AJAX error', error, thrown, xhr && xhr.responseText);
                }
            },
            columns: columns
        });
    }

    if ($('#summary_pcr_table').length) {
        initSummaryTable('#summary_pcr_table', [
            { data: 'no', orderable: false, searchable: false },
            { data: 'kode_project' },
            { data: 'manufacture' },
            { data: 'model_no' },
            { data: 'unit_no' },
            { data: 'comp_desc' },
            { data: 'policy' },
            { data: 'price' },
            { data: 'life_percent', orderable: false },
            { data: 'comp_life', orderable: false },
            { data: 'comp_cond' },
            { data: 'hm_now', orderable: false },
            { data: 'wh_day', orderable: false },
            { data: 'wo_no' },
            { data: 'wo_date' },
            { data: 'wo_status' },
            { data: 'wo_end_date' },
            { data: 'comp_hour' },
            { data: 'last_hm_rep' },
            { data: 'last_rep_date' },
            { data: 'next_date', orderable: false },
            { data: 'remarks' }
        ], 1);
    } else if ($('#summary_sos_table').length) {
        initSummaryTable('#summary_sos_table', [
            { data: 'no', orderable: false, searchable: false },
            { data: 'kode_project' },
            { data: 'sample_date' },
            { data: 'unit_no' },
            { data: 'comp_desc' },
            { data: 'lab_no' },
            { data: 'eval_code' }
        ], 2);
    } else if ($('#summary_inspection_table').length) {
        initSummaryTable('#summary_inspection_table', [
            { data: 'no', orderable: false, searchable: false },
            { data: 'kode_project' },
            { data: 'ins_date' },
            { data: 'unit_no' },
            { data: 'comp_desc' },
            { data: 'ins_hm' },
            { data: 'rating' },
            { data: 'type' }
        ], 2);
    } else if ($('#summary_condition_table').length) {
        initSummaryTable('#summary_condition_table', [
            { data: 'no', orderable: false, searchable: false },
            { data: 'kode_project' },
            { data: 'unit_no' },
            { data: 'model_no' },
            { data: 'comp_desc' },
            { data: 'condition' }
        ], 1);
    } else if ($('#summary_cannibal_table').length) {
        initSummaryTable('#summary_cannibal_table', [
            { data: 'no', orderable: false, searchable: false },
            { data: 'kode_project' },
            { data: 'posting_date' },
            { data: 'no_ba' },
            { data: 'unit_remove' },
            { data: 'unit_install' },
            { data: 'pn' },
            { data: 'comp_desc' },
            { data: 'symptom' },
            { data: 'action_planner' },
            { data: 'status_ba' },
            { data: 'mr_no' },
            { data: 'pr_no' },
            { data: 'po_no' }
        ], 2);
    } else if ($('#approval_table').length) {
        var approvalUrl = $('#approval_datatable_url').val();
        $('#approval_table').DataTable({
            processing: true,
            serverSide: true,
            scrollX: true,
            autoWidth: false,
            pageLength: 25,
            order: [[4, 'desc']],
            ajax: {
                url: approvalUrl,
                type: 'GET',
                error: function (xhr, error, thrown) {
                    console.error('Approval DataTable AJAX error', error, thrown, xhr && xhr.responseText);
                }
            },
            columns: [
                { data: 'no', orderable: false, searchable: false, defaultContent: '' },
                { data: 'no_ba', defaultContent: '' },
                { data: 'unit_remove', defaultContent: '-' },
                { data: 'unit_install', defaultContent: '-' },
                { data: 'posting_date', defaultContent: '' },
                { data: 'status_l1', defaultContent: '' },
                { data: 'status_l2', defaultContent: '' },
                { data: 'status_l3', defaultContent: '' },
                { data: 'status_lgm', defaultContent: '' },
                { data: 'status_lpl', defaultContent: '' },
                { data: 'status_lod', defaultContent: '' },
                { data: 'status_lpd', defaultContent: '' },
                { data: 'action', orderable: false, searchable: false, defaultContent: '' }
            ]
        });
    } else if ($('#cannibal_table').length) {
        var cannibalUrl = $('#cannibal_datatable_url').val();
        $('#cannibal_table').DataTable({
            processing: true,
            serverSide: true,
            scrollX: true,
            autoWidth: false,
            pageLength: 25,
            order: [[2, 'desc']],
            ajax: {
                url: cannibalUrl,
                type: 'GET',
                error: function (xhr, error, thrown) {
                    console.error('Cannibal DataTable AJAX error', error, thrown, xhr && xhr.responseText);
                }
            },
            columns: [
                { data: 'no', orderable: false, searchable: false, defaultContent: '' },
                { data: 'kode_project', defaultContent: '' },
                { data: 'posting_date', defaultContent: '' },
                { data: 'no_ba', defaultContent: '' },
                { data: 'unit_remove', defaultContent: '-' },
                { data: 'unit_install', defaultContent: '-' },
                { data: 'symptom', orderable: false, defaultContent: '' },
                { data: 'action_planner', defaultContent: '' },
                { data: 'status_ba', defaultContent: '' },
                { data: 'action', orderable: false, searchable: false, defaultContent: '' }
            ]
        });
    } else if ($('#example').length) {
        var exampleCols = $('#example thead th').length;
        var exampleFirst = $('#example tbody tr:first td').length;
        if (!(exampleFirst > 0 && exampleFirst !== exampleCols)) {
            $('#example').dataTable();
        }
    }
} );
</script>
<script>
$(document).ready(function() {
    if (!$('#example1').length) {
        return;
    }
    // Skip init when tbody has colspan placeholder / incomplete rows
    var colCount = $('#example1 thead th').length;
    var firstRowCells = $('#example1 tbody tr:first td').length;
    if (firstRowCells > 0 && firstRowCells !== colCount) {
        return;
    }
    var table = $('#example1').DataTable({
        autoWidth: false,
        pageLength: 25,
        order: []
    });
 
    $('#example1 tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    } );
} );
</script>
<script>
$(document).ready(function() {
    if ($('#example2').length) {
    $('#example2').dataTable( {
        "paging":   false,
        "ordering": false,
        "info":     false,
        "filter": false
        
    } );
    }
} );
</script>
<!-- /Calendar -->
<script>
$(document).ready(function(){
$('#rep_date').datepicker({
	dateFormat  : "yy-mm-dd"
});
});
</script>
<script>
$(document).ready(function(){
$('#wo_date').datepicker({
	dateFormat  : "yy-mm-dd"
});
});
</script>
<script>
$(document).ready(function(){
$('#wo_end_date').datepicker({
	dateFormat  : "yy-mm-dd"
});
});
</script>
<script>
$(document).ready(function(){
$('#date_hm').datepicker({
	dateFormat  : "yy-mm-dd"
});
});
</script>
<script>
$(document).ready(function(){
$('#posting_date').datepicker({
	dateFormat  : "yy-mm-dd"
});
});
</script>
<script>
$(document).ready(function(){
$('#date1').datepicker({
	dateFormat  : "yy-mm-dd"
});
});
</script>
<script>
$(document).ready(function(){
$('#date2').datepicker({
	dateFormat  : "yy-mm-dd"
});
});
</script>
<script>     
$(document).ready(function() {
    if ($('#example3').length) {
        $('#example3').dataTable();
    }
} );
</script>



</body>
</html>
