<?php $date = Carbon\Carbon::yesterday()->format('Y-m-d'); ?>


<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

	@foreach( App\Models\User::where('status','active')->get() as $user )
    	<url>
             <loc>{{ url('/')}}/{{strtolower($user->username)}}</loc>
       </url>
   @endforeach
    
</urlset>