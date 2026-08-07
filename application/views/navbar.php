<div class="subnavbar">
  <div class="subnavbar-inner">
    <div class="container">
      <ul class="mainnav">
        <?php
        $user = $this->session->userdata('username');
        $pengguna = $this->login_m->dataPengguna($user);

        $approval_count = '';
        if ($pengguna->sign == "L1"){
            $count = $this->db->query("SELECT COUNT(*) AS c FROM ba WHERE status_l1 = 'PENDING' AND status_ba = 'OPEN' AND user_l1 = ".(int)$pengguna->id_user)->row()->c;
            $approval_count = "(".$count.")";
        } elseif ($pengguna->sign == "L2"){
            $count = $this->db->query("SELECT COUNT(*) AS c FROM ba WHERE status_l1 = 'APPROVED' AND status_l2 = 'PENDING' AND status_ba = 'OPEN' AND user_l2 = ".(int)$pengguna->id_user)->row()->c;
            $approval_count = "(".$count.")";
        } elseif ($pengguna->sign == "L3"){
            $count = $this->db->query("SELECT COUNT(*) AS c FROM ba WHERE status_l2 = 'APPROVED' AND status_l3 = 'PENDING' AND status_ba = 'OPEN' AND user_l3 = ".(int)$pengguna->id_user)->row()->c;
            $approval_count = "(".$count.")";
        } elseif ($pengguna->sign == "LGM"){
            $count = $this->db->query("SELECT COUNT(*) AS c FROM ba WHERE status_l3 = 'APPROVED' AND status_lgm = 'PENDING' AND status_ba = 'OPEN' AND user_lgm = ".(int)$pengguna->id_user)->row()->c;
            $approval_count = "(".$count.")";
        } elseif ($pengguna->sign == "LPL"){
            $count = $this->db->query("SELECT COUNT(*) AS c FROM ba WHERE status_lgm = 'APPROVED' AND status_lpl = 'PENDING' AND status_ba = 'OPEN' AND user_lpl = ".(int)$pengguna->id_user)->row()->c;
            $approval_count = "(".$count.")";
        } elseif ($pengguna->sign == "LOD"){
            $count = $this->db->query("SELECT COUNT(*) AS c FROM ba WHERE status_lpl = 'APPROVED' AND status_lod = 'PENDING' AND status_ba = 'OPEN' AND user_lod = ".(int)$pengguna->id_user)->row()->c;
            $approval_count = "(".$count.")";
        } elseif ($pengguna->sign == "LPD"){
            $count = $this->db->query("SELECT COUNT(*) AS c FROM ba WHERE status_lod = 'APPROVED' AND status_lpd = 'PENDING' AND status_ba = 'OPEN' AND user_lpd = ".(int)$pengguna->id_user)->row()->c;
            $approval_count = "(".$count.")";
        }
        ?>
        <?php if ($pengguna->level == "User"):?>
        <li class="<?php if($this->uri->segment(1)==""){echo "active";}?>"><a href="<?php echo base_url();?>"><i class="icon-dashboard"></i><span>Dashboard</span> </a> </li>
        <li class="dropdown">					
            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="icon-columns"></i>
                    <span>Summary</span>
                    <b class="caret"></b>
            </a>					
            <ul class="dropdown-menu">
                <li class="<?php if($this->uri->segment(1)=="pcr"){echo "active";}?>"><a href="<?php echo base_url();?>pcr"><i class="icon-wrench"></i>&nbsp; Replacement</a></li>
                <li class="<?php if($this->uri->segment(1)=="sos"){echo "active";}?>"><a href="<?php echo base_url();?>sos"><i class="icon-tint"></i>&nbsp;&nbsp; Oil Sampling</a></li>
                <li class="<?php if($this->uri->segment(1)=="inspection"){echo "active";}?>"><a href="<?php echo base_url();?>inspection"><i class="icon-check"></i>&nbsp;&nbsp; Inspection</a></li>
                <li class="<?php if($this->uri->segment(1)=="condition"){echo "active";}?>"><a href="<?php echo base_url();?>condition"><i class="icon-beaker"></i>&nbsp;&nbsp; Condition</a></li>
            </ul>    				
	</li>
        <li class="<?php if($this->uri->segment(1)=="approval"){echo "active";}?>">
            <a href="<?php echo base_url();?>approval"><i class="icon-check"></i>
                <span>Approval 
                    <b style="color: #ff0000"><?php echo $approval_count; ?></b>
                </span> 
            </a> 
        </li>
        <li class="<?php if($this->uri->segment(1)=="unit"){echo "active";}?>"><a href="<?php echo base_url();?>unit"><i class="icon-truck"></i><span>Units</span> </a> </li>
        <li class="<?php if($this->uri->segment(1)=="cannibal"){echo "active";}?>"><a href="<?php echo base_url();?>cannibal"><i class="icon-random"></i><span>Cannibal</span> </a> </li>
        <?php elseif ($pengguna->level == "User" || $pengguna->level == "Super User"):?>
        <li class="<?php if($this->uri->segment(1)==""){echo "active";}?>"><a href="<?php echo base_url();?>"><i class="icon-dashboard"></i><span>Dashboard</span> </a> </li>
        <li class="dropdown">					
            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="icon-columns"></i>
                    <span>Summary</span>
                    <b class="caret"></b>
            </a>					
            <ul class="dropdown-menu">
                <li class="<?php if($this->uri->segment(1)=="pcr"){echo "active";}?>"><a href="<?php echo base_url();?>pcr"><i class="icon-wrench"></i>&nbsp; Replacement</a></li>
                <li class="<?php if($this->uri->segment(1)=="sos"){echo "active";}?>"><a href="<?php echo base_url();?>sos"><i class="icon-tint"></i>&nbsp;&nbsp; Oil Sampling</a></li>
                <li class="<?php if($this->uri->segment(1)=="inspection"){echo "active";}?>"><a href="<?php echo base_url();?>inspection"><i class="icon-check"></i>&nbsp;&nbsp; Inspection</a></li>
                <li class="<?php if($this->uri->segment(1)=="condition"){echo "active";}?>"><a href="<?php echo base_url();?>condition"><i class="icon-beaker"></i>&nbsp;&nbsp; Condition</a></li>
            </ul>    				
	</li>
        <li class="<?php if($this->uri->segment(1)=="approval"){echo "active";}?>">
            <a href="<?php echo base_url();?>approval"><i class="icon-check"></i>
                <span>Approval 
                    <b style="color: #ff0000"><?php echo $approval_count; ?></b>
                </span> 
            </a> 
        </li>
        <li class="<?php if($this->uri->segment(1)=="unit"){echo "active";}?>"><a href="<?php echo base_url();?>unit"><i class="icon-truck"></i><span>Units</span> </a> </li>
        <li class="<?php if($this->uri->segment(1)=="cannibal"){echo "active";}?>"><a href="<?php echo base_url();?>cannibal"><i class="icon-random"></i><span>Cannibal</span> </a> </li>
        <li class="<?php if($this->uri->segment(1)=="model"){echo "active";}?>"><a href="<?php echo base_url();?>model"><i class="icon-th-large"></i><span>Models</span> </a> </li>
        <li class="<?php if($this->uri->segment(1)=="component"){echo "active";}?>"><a href="<?php echo base_url();?>component"><i class="icon-cogs"></i><span>Components</span> </a> </li>
        <?php elseif($pengguna->level == "Admin"):?>
        <li class="<?php if($this->uri->segment(1)==""){echo "active";}?>"><a href="<?php echo base_url();?>"><i class="icon-dashboard"></i><span>Dashboard</span> </a> </li>
        <li class="dropdown">					
            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="icon-columns"></i>
                    <span>Summary</span>
                    <b class="caret"></b>
            </a>					
            <ul class="dropdown-menu">
                <li class="<?php if($this->uri->segment(1)=="pcr"){echo "active";}?>"><a href="<?php echo base_url();?>pcr"><i class="icon-wrench"></i>&nbsp; Replacement</a></li>
                <li class="<?php if($this->uri->segment(1)=="sos"){echo "active";}?>"><a href="<?php echo base_url();?>sos"><i class="icon-tint"></i>&nbsp;&nbsp; Oil Sampling</a></li>
                <li class="<?php if($this->uri->segment(1)=="inspection"){echo "active";}?>"><a href="<?php echo base_url();?>inspection"><i class="icon-check"></i>&nbsp;&nbsp; Inspection</a></li>
                <li class="<?php if($this->uri->segment(1)=="condition"){echo "active";}?>"><a href="<?php echo base_url();?>condition"><i class="icon-beaker"></i>&nbsp;&nbsp; Condition</a></li>
            </ul>    				
	</li>
        <li class="<?php if($this->uri->segment(1)=="approval"){echo "active";}?>">
            <a href="<?php echo base_url();?>approval"><i class="icon-check"></i>
                <span>Approval 
                    <b style="color: #ff0000"><?php echo $approval_count; ?></b>
                </span> 
            </a> 
        </li>
        <li class="<?php if($this->uri->segment(1)=="unit"){echo "active";}?>"><a href="<?php echo base_url();?>unit"><i class="icon-truck"></i><span>Units</span> </a> </li>
        <li class="<?php if($this->uri->segment(1)=="cannibal"){echo "active";}?>"><a href="<?php echo base_url();?>cannibal"><i class="icon-random"></i><span>Cannibal</span> </a> </li>
        <li class="<?php if($this->uri->segment(1)=="hm"){echo "active";}?>"><a href="<?php echo base_url();?>hm"><i class="icon-time"></i><span>Hour Meter</span> </a> </li>
        <li class="<?php if($this->uri->segment(1)=="model"){echo "active";}?>"><a href="<?php echo base_url();?>model"><i class="icon-th-large"></i><span>Models</span> </a> </li>
        <li class="<?php if($this->uri->segment(1)=="component"){echo "active";}?>"><a href="<?php echo base_url();?>component"><i class="icon-cogs"></i><span>Components</span> </a> </li>
        <li class="<?php if($this->uri->segment(1)=="user"){echo "active";}?>"><a href="<?php echo base_url();?>user"><i class="icon-user"></i><span>Users</span> </a> </li>
        <li class="<?php if($this->uri->segment(1)=="project"){echo "active";}?>"><a href="<?php echo base_url();?>project"><i class="icon-sitemap"></i><span>Project</span> </a> </li>
        <?php endif;?>
      </ul>
    </div>
    <!-- /container --> 
  </div>
  <!-- /subnavbar-inner --> 
</div>
<!-- /subnavbar -->
