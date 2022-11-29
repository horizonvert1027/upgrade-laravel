@include('includes.mob-sim-images')
<div class="container-paginator">
	{{$images->links()}}
</div>
<script type="text/javascript">
	const observer = lozad();
observer.observe();
</script>