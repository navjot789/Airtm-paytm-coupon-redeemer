	   <!--===================Step 2 start OTP Verification========================-->
				<div class="col-md-10 col-md-offset-1 mt-51" style="text-align: center;">
						<div class="alert alert-success alert" id="winners">Step 2: OTP Verification</div>

							<div class="row" style="display: block;margin-bottom: 10px">
						
								<form id="form-verify" class="form-horizontal" method="post" action="#" style="text-align:center">
									
									<div class="row">
										<div class="col-sm-3 col-sm-offset-2">
											<div class="form-group">
												<label for="inputEmail3" class="control-label" style="font-size: 16px">Verify OTP:</label>
											</div>
										</div>
									
										<div class="col-sm-4">
											<div class="form-group">
												<input type="text" name="salt" class="form-control" id="salt" autocomplete="off" required  placeholder="CODE">
											</div>
										</div>
									</div>
									
									<button class="btn btn-info" id="salt-btn">Verify</button>
									<a  class="btn btn-info" href="index.php">Re-send</a>
									<input type="hidden" name="hit" value="true">
									<br><br><b>Note:</b><span class="text-info"> Did you check your spam folder? </span>
								</form>
							
						</div>
							
				   </div>	
				   <!--===================Step 2 End========================-->
