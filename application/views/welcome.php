<?php $conn = mysqli_connect('localhost', 'root', '', 'arka_pcr')?>
<div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="row">
          <div class="span12">
              <div id="target-1" class="widget">
                  <div class="widget-content">
                      <br><div align="center"><h1>Welcome to ARKA Planned Component Replacement</h1></div><br>
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
                    <div align="center"><h6 class="bigstats">Hi, <?php echo $pengguna->username;?>. You are logged in as <?php echo $pengguna->level; ?> on site <?php echo $pengguna->kode_project;?> - <?php echo $pengguna->nama_project;?></h6></div>
                  <div id="big_stats" class="cf">
                      <div class="stat"> <a href="<?php echo base_url();?>welcome/replacement" title="PCR - Component Life that exceed Unit Policy"><i class="icon-wrench"></i> </a>
                        <span class="value">
                            <?php
//                            $pcr = 
//                                    "SELECT
//                                    h.id_unit,
//                                    u.unit_no,
//                                    p.kode_project,
//                                    c.comp_desc,
//                                    cm.policy,
//                                    h.hm_unit,
//                                    r.last_hm_rep,
//                                    r.comp_hour,
//                                    (h.hm_unit-r.last_hm_rep)+r.comp_hour as 'comp_life',
//                                    r.wo_status,
//                                    cm.id_mod
//                                    FROM hm h
//                                    LEFT JOIN unit u ON h.id_unit = u.id_unit
//                                    LEFT JOIN project p ON u.id_project = p.id_project
//                                    LEFT JOIN replacement r ON h.id_unit = r.id_unit
//                                    LEFT JOIN commod cm ON r.id_mod = cm.id_mod
//                                    LEFT JOIN model m ON cm.id_model = m.id_model
//                                    LEFT JOIN comp c ON cm.id_comp = c.id_comp
//                                    INNER JOIN (SELECT unit.id_unit, max(date_hm) as MaxDate from hm inner join unit on hm.id_unit = unit.id_unit group by unit.id_unit) h1 on h.id_unit = h1.id_unit and h.date_hm = h1.MaxDate
//                                    WHERE r.wo_status = 'OPEN'
//                                    GROUP BY u.unit_no, c.comp_desc
//                                    HAVING comp_life >= cm.policy
//                                    ORDER BY u.unit_no ASC, c.comp_desc ASC";
//                                    $result = mysqli_query($conn, $pcr);
//                                    $hitung = mysqli_num_rows($result);
//                            echo $hitung; ?>
                        </span> 
                    </div>                    
                    <div class="stat"> <a href="<?php echo base_url();?>welcome/cannibal" title="Cannibal - Not Approved by PM yet"><i class="icon-random"></i> </a>
                        <span class="value">
                            <?php 
                            $cannibal = $this->cannibal_m->selectPMNotApproved()->num_rows();
                            echo $cannibal; ?>
                        </span> 
                    </div>
                    
                    <div class="stat"> <a href="<?php // echo base_url();?>welcome/oil_sampling" title="Critical Component Condition"><i class="icon-warning-sign"></i> </a>
                        <span class="value">
                            <?php echo $crit;?>
                        </span> 
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
