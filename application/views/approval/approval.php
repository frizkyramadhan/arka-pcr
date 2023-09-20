<div class="main">
    <div class="main-inner">
        <div class="container">
          <div class="row">
            <div class="span12">      		
                <div class="widget ">
                    <div class="widget-header">
                        <i class="icon-check"></i>
                        <h3>Approval List</h3>
                    </div> <!-- /widget-header -->
                    <div class="widget-content">
                        <div class="form-horizontal">
                        <table id="example" class="display table-condensed table-hover" cellspacing="0" cellpadding ="0" width="100%">
                            <thead>
                                <tr>
                                  <th rowspan="2"><div align="center">No</div></th>
                                  <th rowspan="2"><div align="center">Document No.</div></th>
                                  <th rowspan="2"><div align="center">Removed Unit No.</div></th>
                                  <th rowspan="2"><div align="center">Installed Unit No.</div></th>
                                  <th rowspan="2"><div align="center">Date</div></th>
                                  <th colspan="3"><div align="center">Status</div></th>
                                  <th rowspan="2"><div align="center">Action</div></th>
                                </tr>
                                <tr>
                                    <th><div align="center">WH</div></th>
                                    <th><div align="center">SPT</div></th>
                                    <th><div align="center">PM</div></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php if(empty($app)):?>
                                    <td colspan="9"><div align="center">No Data Available</div></td>
                                    <?php else:?>
                                    <?php $i=1; ?>
                                    <?php foreach ($app->result() as $row): ?>
                                    <?php
                                    $u_r = $this->db->query("select * from kanibal k left join unit u on k.id_unit = u.id_unit where k.no_ba = '".$row->no_ba."' and k.type = 'REMOVE' order by k.id_kanibal desc limit 1")->row();
                                    $u_i = $this->db->query("select * from kanibal k left join unit u on k.id_unit = u.id_unit where k.no_ba = '".$row->no_ba."' and k.type = 'INSTALL' order by k.id_kanibal desc limit 1")->row();
                                    ?>
                                    <td><div align="center"><?php echo $i++; ?></div></td>
                                    <td><div align="center"><a href="<?php echo base_url();?>cannibal/detail/<?php echo $row->no_ba; ?>" target="blank"><?php echo $row->no_ba; ?></a></div></td>
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
                                    <td><div align="center"><?php echo $row->posting_date; ?></div></td>
                                    <td><div align="center"><?php echo $row->status_l1; ?></div></td>
                                    <td><div align="center"><?php echo $row->status_l2; ?></div></td>
                                    <td><div align="center"><?php echo $row->status_l3; ?></div></td>
                                    <td>
                                        <div align="center">
                                        <a href="<?php echo base_url('approval/detail/'.$row->no_ba); ?>" class="btn btn-mini btn-info">&nbsp;&nbsp;Detail&nbsp;&nbsp;</a>                                        </div>                                    </td>
                                </tr>
                                <?php endforeach;?>
                                <?php endif;?>
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