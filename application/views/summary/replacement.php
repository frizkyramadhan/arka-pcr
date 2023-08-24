<?php $conn = mysqli_connect('localhost', 'root', '@rk@*', 'arka_pcr')?>
<div class="main">
    <div class="main-inner">
        <div class="container">
          <div class="row">
            <div class="span12">      		
                <div class="widget ">
                    <div class="widget-header">
                        <i class="icon-wrench"></i>
                        <h3>PCR - Component Life that exceed Unit Policy</h3>
                    </div> <!-- /widget-header -->
                    <div class="widget-content">
                        <table id="example" class="table table-bordered table-condensed" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th><div align="center"><i class="icon-arrow-down"></i></div></th>
                            <th><div align="center">Site</div></th>
<!--                                    <th>Manufacture</th>
                            <th>Model</th>-->
                            <th>Unit No.</th>
                            <th>Component Description</th>
                            <th>Policy</th>
                            <!--<th>% Life</th>-->
                            <th>Comp Life</th>
<!--                                    <th>Comp Condition</th>
                            <th>HM Unit</th>
                            <th>WH/Day</th>
                            <th>Work Order</th>
                            <th>WO Schedule Date</th>
                            <th>WO Status</th>
                            <th>WO Complete Date</th>
                            <th>Installed Comp Hrs</th>
                            <th>Last Replacement H/M</th>
                            <th>Last Replacement Date</th>
                            <th>Next Replacement Date</th>
                            <th>Remarks</th>-->
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php 
                            $sql = "SELECT
                                    h.id_unit,
                                    u.unit_no,
                                    p.kode_project,
                                    c.comp_desc,
                                    cm.policy,
                                    h.hm_unit,
                                    r.last_hm_rep,
                                    r.comp_hour,
                                    (h.hm_unit-r.last_hm_rep)+r.comp_hour as 'comp_life',
                                    r.wo_status,
                                    cm.id_mod
                                    FROM hm h
                                    LEFT JOIN unit u ON h.id_unit = u.id_unit
                                    LEFT JOIN project p ON u.id_project = p.id_project
                                    LEFT JOIN replacement r ON h.id_unit = r.id_unit
                                    LEFT JOIN commod cm ON r.id_mod = cm.id_mod
                                    LEFT JOIN model m ON cm.id_model = m.id_model
                                    LEFT JOIN comp c ON cm.id_comp = c.id_comp
                                    INNER JOIN (SELECT unit.id_unit, max(date_hm) as MaxDate from hm inner join unit on hm.id_unit = unit.id_unit group by unit.id_unit) h1 on h.id_unit = h1.id_unit and h.date_hm = h1.MaxDate
                                    WHERE r.wo_status = 'OPEN'
                                    GROUP BY u.unit_no, c.comp_desc
                                    HAVING comp_life >= cm.policy
                                    ORDER BY u.unit_no ASC, c.comp_desc ASC";
									$hasil = mysqli_query($conn,$sql);
                            ?>
                            <?php if (empty($hasil)):?>
                            <td colspan="16"><div align="center">No Data Available</div></td>
                            <?php else:?>
                            <?php while ($row = mysqli_fetch_array($hasil)):?>
                            <?php
//                            $query = $this->db->query('
//                                select avg (wh_day) as "avg" 
//                                from hm where 
//                                date_hm <= curdate() 
//                                and date_hm >= (DATE_SUB(CURDATE(), INTERVAL 3 MONTH)) 
//                                and id_unit = '.$row['id_unit'].'')->row();
//                            $hm = $this->db->query('
//                                select * from unit left join hm on hm.id_unit = unit.id_unit where hm.id_unit = '.$row['id_unit'].' order by id_hm desc')->row_array();
//
//                            $a = $hm['hm_unit'];
//                            $b = $row['last_hm_rep'];
//                            $c = $row['comp_hour'];
//                            $comp_life = ($a-$b)+$c;
//                            $policy = $row['policy'];
//                            $life = ($comp_life/$policy)*100;
//                            $wh = round($query->avg,0);
//                            $date = date('Y-m-d');
//                            if ($wh == 0){
//                                $forecast = 0;
//                            } else {
//                                $forecast = round(($policy-$comp_life)/$wh,0);
//                            }
//                            $next = date('Y-m-d', strtotime($date.'+'. $forecast .'days'));
//                            ?>
                            <td><div align="center"><a href="<?php echo base_url('unit/replacement/'.$row['id_unit'].'/'.$row['id_mod']);?>" target="blank"><i class="icon-circle-arrow-right"></i></a></div></td>
                            <td><div align="center"><?php echo $row['kode_project']; ?></div></td>
<!--                        <td><?php echo $row['manufacture']; ?></td>
                            <td><?php echo $row['model_no']; ?></td>-->
                            <td><?php echo $row['unit_no']; ?></td>
                            <td><?php echo $row['comp_desc']; ?></td>
                            <td><div align="right"><?php echo $row['policy']; ?></div></td>
                            <?php if($row['wo_status'] == "OPEN"):?>
                            <!--<td><div align="right"><?php echo round($life,1); ?> %</div></td>-->
                            <td><div align="right"><?php echo round($row['comp_life'],1); ?></div></td>
                            <?php else:?>
                            <!--<td><div align="right"><?php echo $row['life_percent']; ?> %</div></td>-->
                            <td><div align="right"><?php echo round($row['comp_life'],1); ?></div></td>
                            <?php endif;?>
<!--                        <td><div align="center"><?php echo $row['comp_cond']; ?></div></td>
                            <td><div align="right"><?php echo $row['hm_rep']; ?></div></td>
                            <td><div align="right"><?php echo $wh;?></div></td>
                            <td><div align="right"><?php echo $row['wo_no']; ?></div></td>
                            <td><div align="center"><?php echo $row['wo_date']; ?></div></td>
                            <td><div align="center"><?php echo $row['wo_status']; ?></div></td>
                            <td><div align="center"><?php echo $row['wo_end_date']; ?></div></td>
                            <td><div align="right"><?php echo $row['comp_hour']; ?></div></td>
                            <td><div align="right"><?php echo $row['last_hm_rep']; ?></div></td>
                            <td><div align="center"><?php echo $row['last_rep_date']; ?></div></td>
                            <?php if($row['wo_status'] == "OPEN"):?>
                            <td><div align="center"><?php echo $next; ?></div></td>
                            <?php else:?>
                            <td></td>
                            <?php endif;?>
                            <td><?php echo $row['remarks']; ?></td>-->
                        </tr>
                        <?php endwhile;?>
                        <?php endif;?>
                    </tbody>
                </table>
                    </div> <!-- /widget-content -->	
                </div> <!-- /widget -->	
                </div> <!-- /span8 -->
            </div> <!-- /row -->
        </div> <!-- /container -->
    </div> <!-- /main-inner -->
</div> <!-- /main -->