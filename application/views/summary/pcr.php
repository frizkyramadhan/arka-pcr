<?php $conn = mysqli_connect('localhost', 'root', '', 'arka_pcr')?>
<div class="main">
    <div class="main-inner">
        <div class="container">
          <div class="row">
            <div class="span12">      		
                <div class="widget ">
                    <div class="widget-header">
                        <i class="icon-columns"></i>
                        <h3>PCR Summary</h3>
                    </div> <!-- /widget-header -->
                    <div class="widget-content">
                        <form class="form-inline" method="POST">
                            <div class="control-group">
                                <div class="controls" align="center">
                                    <div class="accordion" id="accordion2">
                                        <div class="accordion-group">
                                            <div class="accordion-heading">
                                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
                                                    <div align="center">-- Advance Filter --</div>
                                                </a>
                                            </div>
                                            <div id="collapseOne" class="accordion-body collapse">
                                                <div class="accordion-inner">
                                                    <table>
                                                        <tr>
                                                            <td><label class="checkbox inline"><input type="checkbox" name="siteCat"> Project</label></td>
                                                            <td>
                                                                <label class="checkbox inline">
                                                                    <!--<input type="text" name="kode_project">-->
                                                                    <?php
                                                                    echo form_dropdown('kode_project', $proj_options, '');
                                                                    ?>
                                                                </label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="checkbox inline"><input type="checkbox" name="manCat"> Manufacture</label></td>
                                                            <td><label class="checkbox inline"><input type="text" name="manufacture"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="checkbox inline"><input type="checkbox" name="modCat"> Model</label></td>
                                                            <td><label class="checkbox inline"><input type="text" name="model_no"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="checkbox inline"><input type="checkbox" name="unitCat"> Unit No</label></td>
                                                            <td><label class="checkbox inline"><input type="text" name="unit_no"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="checkbox inline"><input type="checkbox" name="compCat"> Comp. Desc</label></td>
                                                            <td><label class="checkbox inline"><input type="text" name="comp_desc"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="checkbox inline"><input type="checkbox" name="polCat"> Policy</label></td>
                                                            <td><label class="checkbox inline"><input type="text" name="policy"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="checkbox inline"><input type="checkbox" name="priCat"> Price (IDR)</label></td>
                                                            <td><label class="checkbox inline"><input type="text" name="price"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="checkbox inline"><input type="checkbox" name="woCat"> WO Number</label></td>
                                                            <td><label class="checkbox inline"><input type="text" name="wo_no"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="checkbox inline"><input type="checkbox" name="staCat"> WO Status</label></td>
                                                            <td>
                                                                <label class="radio inline"><input type="radio" name="wo_status" value="OPEN"> OPEN </label>
                                                                <label class="radio inline"><input type="radio" name="wo_status" value="CLOSE"> CLOSE</label>
                                                            </td>
                                                        </tr>
                                                        <tr><td></td><td><label class="checkbox inline"><input class="btn btn-info" type="submit" name="submit" value="Submit"> <input class="btn" type="reset" name="reset" value="&nbsp;Reset&nbsp;"></label></td></tr>
                                                     </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- /controls -->				
                            </div> <!-- /control-group -->
                        </form>
                            <?php
                                $bagianWhere = "";
                                if (isset($_POST['manCat'])){
                                   $man = $_POST['manufacture'];
                                   if (empty($bagianWhere)){
                                        $bagianWhere .= "manufacture LIKE '%$man%'";
                                   }
                                }
                                if (isset($_POST['siteCat'])){
                                   $project = $_POST['kode_project'];
                                   if (empty($bagianWhere)){
                                        $bagianWhere .= "kode_project LIKE '$project'";
                                   }else{
                                        $bagianWhere .= " AND kode_project LIKE '$project'";
                                   }
                                }
                                if (isset($_POST['modCat'])){
                                   $model = $_POST['model_no'];
                                   if (empty($bagianWhere)){
                                        $bagianWhere .= "model_no LIKE '%$model%'";
                                   }else{
                                        $bagianWhere .= " AND model_no LIKE '%$model%'";
                                   }
                                }
                                if (isset($_POST['unitCat'])){
                                   $unit = $_POST['unit_no'];
                                   if (empty($bagianWhere)){
                                        $bagianWhere .= "unit_no LIKE '%$unit%'";
                                   }else{
                                        $bagianWhere .= " AND unit_no LIKE '%$unit%'";
                                   }
                                }
                                if (isset($_POST['compCat'])){
                                   $comp = $_POST['comp_desc'];
                                   if (empty($bagianWhere)){
                                        $bagianWhere .= "comp_desc LIKE '%$comp%'";
                                   }else{
                                        $bagianWhere .= " AND comp_desc LIKE '%$comp%'";
                                   }
                                }
                                if (isset($_POST['polCat'])){
                                   $pol = $_POST['policy'];
                                   if (empty($bagianWhere)){
                                        $bagianWhere .= "policy LIKE '%$pol%'";
                                   }else{
                                        $bagianWhere .= " AND policy LIKE '%$pol%'";
                                   }
                                }
                                if (isset($_POST['priCat'])){
                                   $pri = $_POST['price'];
                                   if (empty($bagianWhere)){
                                        $bagianWhere .= "price LIKE '%$pri%'";
                                   }else{
                                        $bagianWhere .= " AND price LIKE '%$pri%'";
                                   }
                                }
                                if (isset($_POST['woCat'])){
                                   $wo_no = $_POST['wo_no'];
                                   if (empty($bagianWhere)){
                                        $bagianWhere .= "wo_no LIKE '%$wo_no%'";
                                   }else{
                                        $bagianWhere .= " AND wo_no LIKE '%$wo_no%'";
                                   }
                                }
                                if (isset($_POST['staCat'])){
                                   $wo_status = $_POST['wo_status'];
                                   if (empty($bagianWhere)){
                                        $bagianWhere .= "wo_status LIKE '%$wo_status%'";
                                   }else{
                                        $bagianWhere .= " AND wo_status LIKE '%$wo_status%'";
                                   }
                                }
                            ?>
                        <div class="alert alert-success">
                          <button type="button" class="close" data-dismiss="alert">&times;</button>
                          Status Filter: <?php echo $bagianWhere;?>
                        </div>
                        
                        <form action="pcr/export" method="POST">
                            <?php
                            if (empty($bagianWhere)){
                                $where = 1;
                            }else{
                                $where = $bagianWhere;
                            }
//                            ?>
                            <input type="hidden" name="where" value="<?php echo $where ?>" >
                            <div align="center"><input type="submit" value="Export to Excel" class="btn btn-success" ></div>
                        </form>
                        
                            <table id="example1" class="table table-bordered table-condensed" cellspacing="0" width="100%" style="display: block; overflow-x: auto">
                            <thead>
                                <tr>
                                    <th><div align="center"><i class="icon-arrow-down"></i></div></th>
                                    <th><div align="center">Site</div></th>
                                    <th>Manufacture</th>
                                    <th>Model</th>
                                    <th>Unit No.</th>
                                    <th>Component Description</th>
                                    <th>Policy</th>
                                    <th>Price (IDR)</th>
                                    <th>% Life</th>
                                    <th>Comp Life</th>
                                    <th>Comp Condition</th>
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
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php 
                                    $pcr = 
                                            "SELECT * 
                                                FROM replacement r 
                                                LEFT JOIN unit u ON r.id_unit = u.id_unit
                                                LEFT JOIN commod cm ON r.id_mod = cm.id_mod
                                                LEFT JOIN model m ON u.id_model = m.id_model AND cm.id_model = m.id_model
                                                LEFT JOIN project p ON u.id_project = p.id_project
                                                LEFT JOIN comp c ON cm.id_comp = c.id_comp
                                                WHERE ".$bagianWhere."
                                                ORDER BY p.kode_project ASC, m.manufacture ASC, c.comp_desc ASC, r.id_rep DESC";
                                    $hasil = mysqli_query($conn,$pcr);
                                    ?>
                                    <?php if (empty($hasil)):?>
                                    <td colspan="16"><div align="center">No Data Available</div></td>
                                    <?php else:?>
                                    <?php while ($row = mysqli_fetch_array($hasil)):?>
                                    <?php
                                    $query = $this->db->query('
                                        select avg (wh_day) as "avg" 
                                        from hm where 
                                        date_hm <= curdate() 
                                        and date_hm >= (DATE_SUB(CURDATE(), INTERVAL 3 MONTH)) 
                                        and id_unit = '.$row['id_unit'].'')->row();
                                    $hm = $this->db->query('
                                        select * from unit left join hm on hm.id_unit = unit.id_unit where hm.id_unit = '.$row['id_unit'].' order by id_hm desc')->row_array();
                                    
                                    $a = $hm['hm_unit'];
                                    $b = $row['last_hm_rep'];
                                    $c = $row['comp_hour'];
                                    $comp_life = ($a-$b)+$c;
                                    $policy = $row['policy'];
                                    $life = ($comp_life/$policy)*100;
                                    $wh = round($query->avg,0);
                                    $date = date('Y-m-d');
                                    if ($wh == 0){
                                        $forecast = 0;
                                    } else {
                                        $forecast = round(($policy-$comp_life)/$wh,0);
                                    }
                                    $next = date('Y-m-d', strtotime($date.'+'. $forecast .'days'));
                                    ?>
                                    <td><div align="center"><a href="<?php echo base_url('unit/replacement/'.$row['id_unit'].'/'.$row['id_mod']);?>" target="blank"><i class="icon-circle-arrow-right"></i></a></div></td>
                                    <td><div align="center"><?php echo $row['kode_project']; ?></div></td>
                                    <td><?php echo $row['manufacture']; ?></td>
                                    <td><?php echo $row['model_no']; ?></td>
                                    <td><?php echo $row['unit_no']; ?></td>
                                    <td><?php echo $row['comp_desc']; ?></td>
                                    <td><?php echo $row['policy']; ?></td>
                                    <td><?php echo $row['price']; ?></td>
                                    <?php if($row['wo_status'] == "OPEN"):?>
                                    <td><div align="right"><?php echo round($life,1); ?> %</div></td>
                                    <td><div align="right"><?php echo $comp_life; ?></div></td>
                                    <?php else:?>
                                    <td><div align="right"><?php echo $row['life_percent']; ?> %</div></td>
                                    <td><div align="right"><?php echo $row['comp_life']; ?></div></td>
                                    <?php endif;?>
                                    <td><div align="center"><?php echo $row['comp_cond']; ?></div></td>
                                    <?php if($row['wo_status'] == "OPEN"):?>
                                    <td><div align="right"><?php echo $hm['hm_unit']; ?></div></td>
                                    <?php else:?>
                                    <td><div align="right"><?php echo $row['hm_rep']; ?></div></td>
                                    <?php endif;?>
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
                                    <td><?php echo $row['remarks']; ?></td>
                                </tr>
                                <?php endwhile;?>
                                <?php endif;?>
                            </tbody>
                        </table>
<!--                        <pre>
                        <?php // print_r($pcr);?><br>
                        <?php // print_r($bagianWhere);?>
                        </pre>-->
<!--                        <form>
                            <div align="center"><input class="btn btn-info" type="submit" name="submit" value="Submit"></div>
                        
                        <?php
//                        if (empty($bagianWhere)){
//                            $pcr = "";
//                        }
//                            $header = '';
//                            $result ='';
//                            $exportData = mysql_query ($pcr ) or die ( "Sql error : " . mysql_error( ) );
//
//                            $fields = mysql_num_fields ( $exportData );
//
//                            for ( $i = 0; $i < $fields; $i++ )
//                            {
//                                $header .= mysql_field_name( $exportData , $i ) . "\t";
//                            }
//
//                            while( $row = mysql_fetch_row( $exportData ) )
//                            {
//                                $line = '';
//                                foreach( $row as $value )
//                                {                                            
//                                    if ( ( !isset( $value ) ) || ( $value == "" ) )
//                                    {
//                                        $value = "\t";
//                                    }
//                                    else
//                                    {
//                                        $value = str_replace( '"' , '""' , $value );
//                                        $value = '"' . $value . '"' . "\t";
//                                    }
//                                    $line .= $value;
//                                }
//                                $result .= trim( $line ) . "\n";
//                            }
//                            $result = str_replace( "\r" , "" , $result );
//
//                            if ( $result == "" )
//                            {
//                                $result = "\nNo Record(s) Found!\n";                        
//                            }
//
//                            header("Content-type: application/octet-stream");
//                            header("Content-Disposition: attachment; filename=export.xls");
//                            header("Pragma: no-cache");
//                            header("Expires: 0");
//                            print "$header\n$result";

                            ?>
                            </form>-->
                        <!--</div>-->
                    </div> <!-- /widget-content -->	
                </div> <!-- /widget -->	
                </div> <!-- /span8 -->
            </div> <!-- /row -->
        </div> <!-- /container -->
    </div> <!-- /main-inner -->
</div> <!-- /main -->