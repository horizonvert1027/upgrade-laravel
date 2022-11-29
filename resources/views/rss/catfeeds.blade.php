  @if( $settings->captcha == 'on' ) 
  {!! app('captcha')->render(); !!}
  @endif

<rss version="2.0"> 
<channel>
  <title>{{config('app.sitename')}}</title>
  <link>{{config('app.url')}}</link>
  <description>New {{$categories[0]->name}}</description>
  @foreach($images as $img)
  
  
     <?php  if( Str::slug( $img->title ) == '' ) {
				$slugUrl  = '';
			} else {
				$slugUrl  = '/'.\Illuminate\Support\Str::slug( $img->title );
			} ;

			if(isset($img->opt_file_source) && $img->opt_file_source != ""){
				$file='file/';
			}
			else
			{
				$file='photo/';
			}
			?>

  <item>
    <title>{{ $img->title }}</title>
    <link>{{url('/').('/')}}{{$file}}{{$img->id}}{{ ($slugUrl) }}</link>
    <guid isPermaLink="true">{{url('/').('/')}}{{$file}}{{$img->id}}{{($slugUrl)}}</guid>
    <enclosure url="{{config('app.filesurl').(config('path.large').$img->large)}}" length="123456789" type="image/jpeg" />
    <description>
    @php
    $tags = explode(",",$img->metakeywords);
    @endphp
    <![CDATA[
<div><img width="300" src="{{config('app.filesurl').(config('path.large').$img->large)}}"  />
{{App\helper::removetags($categories[0]->cpdescr)}} this is {{ $img->title }} @if (isset($tags[3])) {{$tags[3]}} @endif @if (isset($tags[4])) {{$tags[4]}} @endif @if (isset($tags[5])) {{$tags[5]}} @endif
</div> 
]]>
</description>
    <pubDate>{{ date("D, d M Y H:i:s T", strtotime($img->date)) }}</pubDate>
  </item>
  @endforeach
</channel>
</rss>
