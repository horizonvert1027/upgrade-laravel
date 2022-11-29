@if (count($errors) > 0)
			<!-- Start Box Body -->
                  <div class="box-body">
						<div class="alert alert-danger" id="dangerAlert">
							
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">×</span>
								</button>
								
							<i class="glyphicon glyphicon-alert myicon-right"></i> {{{ trans('auth.error_desc') }}} <br><br>
							<ul class="list-unstyled">
								@foreach ($errors->all() as $error)
									<li><i class="glyphicon glyphicon-remove myicon-right"></i> {{{ $error }}}</li>
								@endforeach
							</ul>
						</div>
				</div><!-- /.box-body -->
					@endif		