<div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="row">
        <div class="span12">
          <div id="target-1" class="widget">
            <div class="widget-content">
              <br>
              <div align="center">
                <h1>Welcome to ARKA Planned Component Replacement</h1>
              </div><br>
            </div> <!-- /widget-content -->
          </div> <!-- /widget -->
        </div> <!-- /span12 -->
        <div class="span12">
          <div class="widget widget-nopad">
            <div class="widget-header"> <i class="icon-list-alt"></i>
              <h3> Today's Stats</h3>
            </div>
            <div class="widget-content">
              <div class="widget big-stats-container">
                <div class="widget-content">
                  <div align="center">
                    <h6 class="bigstats">Hi, <?php echo $pengguna->username; ?>. You are logged in as <?php echo $pengguna->level; ?> on site <?php echo $pengguna->kode_project; ?> - <?php echo $pengguna->nama_project; ?></h6>
                  </div>
                  <div id="big_stats" class="cf">
                    <div class="stat"> <a href="<?php echo base_url(); ?>welcome/replacement" title="PCR - Component Life that exceed Unit Policy"><i class="icon-wrench"></i> </a>
                      <span class="value"><?php echo (int) $pcr_count; ?></span>
                    </div>
                    <div class="stat"> <a href="<?php echo base_url(); ?>welcome/cannibal" title="Cannibal - Not Approved by PM yet"><i class="icon-random"></i> </a>
                      <span class="value"><?php echo (int) $cannibal_count; ?></span>
                    </div>

                    <div class="stat"> <a href="<?php echo base_url(); ?>welcome/critical" title="Critical Component Condition"><i class="icon-warning-sign"></i> </a>
                      <span class="value"><?php echo (int) $crit; ?></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /span6 -->
      </div>
      <!-- /row -->
    </div>
    <!-- /container -->
  </div>
  <!-- /main-inner -->
</div>
<!-- /main -->
