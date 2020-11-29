
 				   <!--===================DETAILS START Stats========================-->
					<div class="col-md-10 col-md-offset-1 mt-51" style="text-align: center;" id="stats">
						<div class="alert alert-success alert" id="winners">Total Winning Amount: 
							<b style="font-size:22px">&nbsp;&#x20b9;<?php $total = get_total_spend($dbc);echo $total[0][0];?></b>
						</div>
						<div id="sidtable">
							<table class="table table-striped">
								<thead>
									<tr>
										<th>ID</th>
										<th style="text-align: center;">Coupon Amount</th>
										<th style="text-align: center;">Redeemed By</th>
										<th style="text-align: center;">Redeemed On</th>
									</tr>
								</thead>
								<tbody>
									
									<?php

									 $data = fetch_paytm_redeemed($dbc);
									 foreach ($data as $value) {
									 ?>
											<tr class='success'>
												<th scope='row'>&num;<?php echo $value[0]; ?></th>
												<td><b style="color: #009800;">&#x20b9;<?php echo $value[3]; ?></b></td>
												<td>Mohit Verma</td>
												<td><?php echo $value[2]; ?></td>
											</tr>
										<?php
									
									 }
									?>
							
								</tbody>

								</table>
							</div>
							<br>
							<div class="alert alert-success alert" id="winners">Payment Proof</div>
							<div id="sidtable">
								<table class="table table-striped">
									<thead>
										<tr>
											<th>Date</th>
											<th style="text-align: center;">Details</th>
										</tr>
									</thead>
									<tbody>
										<tr class='success'>
											<th scope='row'>07/09/2020</th>
											<td><b><a href="paytm/sc.png" target="_blank">View Screenshot</a></b></td>
										</tr>
										
									</tbody>
								</table>
							</div> 
						
							
						</div>
						 <!--===================DETAILS END========================-->