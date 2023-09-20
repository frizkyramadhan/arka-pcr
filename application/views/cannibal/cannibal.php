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
                        <div class="form-horizontal">
                        <table id="example" class="table table-striped table-bordered table-condensed" cellspacing="0" width="100%" style="display: block; overflow-x: auto">
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
                            <tbody>
                                <tr>
                                    <?php $i=1; ?>
                                    <?php foreach ($ba as $row): ?>
                                    <?php
                                    $u_r = $this->db->query("select * from kanibal k left join unit u on k.id_unit = u.id_unit where k.no_ba = '".$row->no_ba."' and k.type = 'REMOVE' order by k.id_kanibal desc limit 1")->row();
                                    $u_i = $this->db->query("select * from kanibal k left join unit u on k.id_unit = u.id_unit where k.no_ba = '".$row->no_ba."' and k.type = 'INSTALL' order by k.id_kanibal desc limit 1")->row();
                                    ?>
                                    <td><div align="center"><?php echo $i++; ?></div></td>
                                    <td><div align="center"><?php echo $row->kode_project; ?></div></td>
                                    <td><?php echo $row->posting_date; ?></td>
                                    <td><?php echo $row->no_ba; ?></td>
                                    <td><div align="center">
                                        <?php if (empty($u_r)){
                                            echo "-";
                                        }else{
                                            echo $u_r->unit_no;
                                        }?>
                                    </div></td>
                                    <td><div align="center">
                                        <?php if (empty($u_i)){
                                            echo "-";
                                        }else{
                                            echo $u_i->unit_no;
                                        }?>
                                    </div></td>
                                    <td><textarea rows="1" readonly="true"><?php echo strtoupper($row->symptom); ?></textarea></td>
                                    <td><?php echo strtoupper($row->action); ?></td>
                                    <td><div align="center"><?php echo $row->status_ba; ?></div></td>
                                    <td>
                                        <div align="center">
                                        <a href="<?php echo base_url('cannibal/detail/'.$row->no_ba); ?>" class="btn btn-mini btn-info">Detail</a>
                                        <!--<a href="<?php echo base_url('cannibal/delete/'.$row->id_ba); ?>" class="btn btn-mini btn-danger" onclick="return confirm('Are you want to delete this record?')">Delete</a>-->    
                                        </div>
                                    </td>
                                </tr>
                                <?php //print_r($u_r);?>
                                <?php endforeach?>
                            </tbody>
                        </table>
                        </div>
                    </div> <!-- /widget-content -->	
                </div> <!-- /widget -->	
                </div> <!-- /span8 -->
            </div> <!-- /row -->
        </div> <!-- /container -->
    </div> <!-- /main-inner -->
</div> <!-- /main -->