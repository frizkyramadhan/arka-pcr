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
    $('#pcr').dataTable();
 
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
    $('#example').dataTable();
} );
</script>
<script>
$(document).ready(function() {
    var table = $('#example1').DataTable();
 
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
    $('#example2').dataTable( {
        "paging":   false,
        "ordering": false,
        "info":     false,
        "filter": false
        
    } );
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
    $('#example3').dataTable();
} );
</script>



</body>
</html>
