@extends('layouts.multi')


	<style>
		.members {
    display: inline-grid;
    margin: 10px;
    width: -webkit-fill-available;
    justify-items: center;
    background: var(--light-white-clr);
    margin-right: 5px;
    margin-left: 5px;
    border: 1px solid var(--light-dark-clr);
    border-radius: 4px;
    padding: 10px 5px;
}
		img.img-circle.avatar-user {
		    width: 100px;
		}
		.allmem {
    display: block;
    margin: 15px auto;
}
		ul.membersul {
		        display: block;
		    width: fit-content;
		    margin-block-start: 0px;
		    margin-block-end: 0px;
		}
	</style>


@section('content') 
    <div class="container">
        <section>
            <div class="col-md-12">
                <div class="mt20 mt35">
        			<h1>{{ trans('misc.members') }} ({{number_format($data->total())}})</h1>
						<div class="allmem">
							@foreach( $data as $user )
								<div class="members">
									<a href="{{url($user->username)}}">
								      <img src="{{ url('public/avatar',$user->avatar) }}" class="img-circle avatar-user">
								    </a>
							  
								    <h4>
								    	<a href="{{url($user->username)}}">@if( $user->name != '' ) {{ e($user->name) }} @else {{ $user->username }} @endif</a>
								    </h4>

							    	<ul class="membersul">
										<li> {{trans('misc.member_since')}} {{ HH::formatDate($user->date) }}</li>

										@if( $user->countries_id != '' )
										<li>{{ $user->country()->country_name }}</li>
										@endif

										@if( $user->website != '' )
										<li><a href="{{ $user->website }}" target="_blank">{{ $user->website }}</a> </li>
										@endif					
									</ul>
							 
						  			{{ HH::formatNumber( $user->images()->count() ) }}
									{{trans_choice('misc.photos_plural', $user->images()->count() )}}
								</div>
							@endforeach
						</div>
		        			@if( $data->count() == 0  )
			    		<h3>
			    			{{ trans('misc.no_results_found') }}
			    		</h3>
			    			@endif		
   				</div>
   			</div>
   		</section>
   </div> 				
@endsection
