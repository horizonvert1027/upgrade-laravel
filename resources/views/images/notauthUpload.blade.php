@extends('app')

@section('content')
<style type="text/css">
	.unauth {
    width: -webkit-fill-available;
    margin: 18%;
}
@media (max-width: 900px){
	.unauth{
	margin: 20%;
}
}
</style>
<div class="container">
<section>
  <div class="col-md-12">
  	<div id="mainLazy" class="ibox bsh mt20">
		
<div class="unauth">
		<h1>Sorry! Not Authorised</h1>
		
		<div class="aligncenter" style="margin:10px">
You're not authorised to upload!
		</div>

		<div class="aligncenter">
			<p>You can <a href="/contact-us">contact us</a> for further details.</p>
		</div>
			</div>
	 </div>
  </div>
</section>
</div>
@endsection