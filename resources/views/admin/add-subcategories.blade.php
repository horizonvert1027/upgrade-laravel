@extends('admin.layout')

@section('css')
<link href="{{{ asset('public/plugins/iCheck/all.css') }}}" rel="stylesheet" type="text/css" />
<link href="{{ asset('public/plugins/tagsinput/jquery.tagsinput.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')


<?php 

if ( $catid == '31')
{
 $part  = 'abc pics, abc hd photos, abc wallpapers, abc image, abc cute pics, abc pic';
}

elseif( $catid == '216')
{
 $part  = 'abc images, abc hd background, abc wallpapers, abc photos, abc pics';
}
elseif( $catid == '221')
{
 $part  = 'abc images, abc hd background, abc wallpapers, abc photos, abc pics';
}
elseif( $catid == '222')
{
 $part  = 'abc images, abc hd background, abc wallpapers, abc photos, abc pics';
}

elseif( $catid == '224')
{
 $part  = 'abc Fortnite images, abc Fortnite hd background, abc Fortnite wallpapers, abc Fortnite photos, abc Fortnite pics';
}

elseif( $catid == '217')
{
 $part  = 'abc images, abc hd background, abc wallpapers, abc photos, abc pics';
}

elseif( $catid == '218')
{
 $part  = 'abc anime images, anime pics, abc hd background, abc wallpapers, abc photos, abc pics';
}

elseif( $catid == '219')
{
 $part  = 'abc Cartoon images, Cartoon pics, abc hd background, abc wallpapers, abc photos, abc pics';
}

elseif( $catid == '211')
{
 $part  = 'abc wishes, abc hd greetings, abc wallpapers, abc GIF Download, abc wishing, abc wishes images';
}

elseif( $catid == '28')
{
 $part  = 'abc wishes,abc festival, abc hd greetings, abc wallpapers, abc GIF Download, abc wishing, abc wishes images';
}

elseif( $catid == '11')
{
 $part  = 'abc Editing Background, abc hd Background, abc PicsArt Background, abc Background Download';
}

elseif( $datamain == '1')
{
 $part  = 'abc PNGs Images, abc png Images, abc Transparent Images, abc PNG';
}

elseif( $datamain == '2')
{
 $part  = 'abc Images, abc Mobile Wallpapers, abc Desktop Wallpapers, abc iPhone Wallpapers';
}

else
{
    $part = 'abc,';
};

if($catid == '31')
{
 $subgroup  = 'abc latest HD Pics, abc HD Photos, abc Mobile HD Wallpapers, abc iPhone HD Wallpapers, abc Desktop HD Wallpapers, abc Aesthetic HD Wallpapers, abc Old HD Pics Wallpapers, abc Happy Birthday, abc WhatsApp DP, abc Childhood HD Pics Photos,';
}

elseif( $catid == '224')
{
 $subgroup  = 'abc Fortnite Backgrounds, abc Fortnite Wallpapers, abc Fortnite HD Photos, abc Fortnite Pictures HD, Fortnite abc Images' ;
}


elseif( $catid == '216')
{
 $subgroup  = 'abc Backgrounds, abc Wallpapers, abc HD Photos, abc Pictures HD, abc Images' ;
}

elseif( $catid == '221')
{
 $subgroup  = 'abc Backgrounds, abc Wallpapers, abc HD Photos, abc Pictures HD, abc Images' ;
}
elseif( $catid == '222')
{
 $subgroup  = 'abc Backgrounds, abc Wallpapers, abc HD Photos, abc Pictures HD, abc Images' ;
}

elseif( $catid == '217')
{
 $subgroup  = 'abc Backgrounds, abc Wallpapers, abc HD Photos, abc Pictures HD, abc Images' ;
}

elseif( $catid == '218')
{
 $subgroup  = 'abc Anime Backgrounds, abc Wallpapers, abc HD Photos, abc Pictures HD, abc Images' ;
}

elseif( $catid == '219')
{
 $subgroup  = 'abc Cartoon Backgrounds, abc Wallpapers, abc HD Photos, abc Pictures HD, abc Cartoon Images' ;
}


elseif( $catid == '211')
{
 $subgroup  = 'abc HD Wishes Images, abc Greetings Photos, abc HD Wallpapers, abc GIFs Download, abc WhatsApp Status Images, abc Quotes Shayari Images, abc WhatsApp DP' ;
}

elseif( $catid == '28')
{
 $subgroup  = 'abc HD Wishes Images,abc Festival Images, abc Greetings Photos, abc HD Wallpapers, abc GIFs Download, abc WhatsApp Status Images, abc Quotes Shayari Images, abc WhatsApp DP' ;
}

elseif( $catid == '11')
{
 $subgroup  = 'abc Editing Background, abc hd Background, abc PicsArt Background, abc Background Download';
} 

elseif( $datamain == '1')
{
 $subgroup  = 'abc PNGs Images, abc HD png Images, abc Transparent Images, abc PNG download';
}

elseif( $datamain == '2')
{
$subgroup =  'abc Images, abc Mobile Wallpapers, abc Desktop Wallpapers, abc iPhone Wallpapers, abc WhatsApp DP';
}

else
{
    $subgroup = 'abc,';
};



if($catid == '31')
{
 $imgtitle  = 'abc HD Photos, Wallpapers, Images & WhatsApp DP';
}

elseif( $catid == '216')
{
 $imgtitle  = 'abc Animal Background, Wallpapers,Photos, Images Full HD';
}

elseif( $catid == '217')
{
 $imgtitle  = 'abc Brand Background, Wallpapers,Photos, Images Full HD';
}

elseif( $catid == '221')
{
 $imgtitle  = 'abc Space Background, Wallpapers,Photos, Images Full HD';
}

elseif( $catid == '222')
{
 $imgtitle  = 'abc Nature Background, Wallpapers,Photos, Images Full HD';
}
elseif( $catid == '218')
{
 $imgtitle  = 'abc Anime Background, Wallpapers,Photos, Images Full HD';
}


elseif( $catid == '219')
{
 $imgtitle  = 'abc Cartoon Background, Wallpapers,Photos, Images Full HD';
}

elseif( $catid == '211')
{
 $imgtitle  = 'abc Wishes Photos, Wallpapers, Status Images & WhatsApp DP';
}


elseif( $catid == '28')
{
 $imgtitle  = 'abc Festival Wishes Photos, Wallpapers, Status Images & WhatsApp DP';
}


elseif( $catid == '11')
{
 $imgtitle  = 'abc Editing Background Full HD for PicsArt';
} 

elseif( $datamain == '1')
{
 $imgtitle  = 'abc PNGs Transparent Images';
}

elseif( $datamain == '2')
{
  $imgtitle = 'abc Wallpapers Images Full HD';
}

else
{
    $imgtitle = 'abc';
};

if($catid == '31')
{
 $slugahead  = '-photos-wallpapers-hd';
}

elseif( $catid == '216')
{
 $slugahead  = '-animals-wallpaper-backgrounds-hd';
}


elseif( $catid == '221')
{
 $slugahead  = '-space-wallpaper-backgrounds-hd';
}


elseif( $catid == '222')
{
 $slugahead  = '-nature-wallpaper-backgrounds-hd';
}

elseif( $catid == '224')
{
 $slugahead  = '-fortnite-wallpaper-backgrounds-hd';
}


elseif( $catid == '217')
{
 $slugahead  = '-brand-wallpaper-backgrounds-hd';
}


elseif( $catid == '218')
{
 $slugahead  = '-anime-wallpaper-backgrounds-hd';
}

elseif( $catid == '219')
{
 $slugahead  = '-cartoon-wallpaper-backgrounds-hd';
}


elseif( $catid == '211')
{
 $slugahead  = '-wishes-images-photos';
}

elseif( $catid == '28')
{
 $slugahead  = '-wishes-greeting-images-photos';
}

elseif( $catid == '11')
{
 $slugahead  = '-background-hd';
} 

elseif( $datamain == '1')
{
 $slugahead  = '-png-images-transparent';
}

elseif( $datamain == '2')
{
  $slugahead = '-wallpapers-full-hd';
}

else
{
    $slugahead = '';
};

if($catid == '31')
{
 $autosubgroup =
 'Indian Actor,Indian Actress,American Actor,American Actress,Influencer,Model,Body Builder,Athelete,Football Player,WWE Fighter, Hockey Player,Boxer,Rapper,Singer,Politician,Hockey Player,Basketball Player,Cricketer,Badminton Player,American Singer';}

elseif( $catid == '216')
{
 $autosubgroup  = 'Animals';
}
elseif( $catid == '224')
{
 $autosubgroup  = 'Fortnite Video Game';
}

elseif( $catid == '217')
{
 $autosubgroup  = 'Brand';
}

elseif( $catid == '222')
{
 $autosubgroup  = 'Nature';
}

elseif( $catid == '221')
{
 $autosubgroup  = 'Space';
}

elseif( $catid == '218')
{
 $autosubgroup  = 'Anime';
}
elseif( $catid == '219')
{
 $autosubgroup  = 'Cartoon';
}
elseif( $catid == '211')
{
 $autosubgroup  = 'Celebration';
}
elseif( $catid == '28')
{
 $autosubgroup  = 'Festival';
}
elseif( $catid == '11')
{
 $autosubgroup  = 'Editing,Photoshop,PicsArt';
} 
elseif( $datamain == '1')
{
 $autosubgroup  = 'PNG,Transparent';
}
else
{
    $autosubgroup = '';
};

?>
                  
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h4>
            {{{ trans('admin.admin') }}}
            <a href="{{ url('panel/admin/subcategories/view').'/'.$data->id}}">
              <i class="fa fa-angle-right margin-separator"></i>
                {{$catname}}</a>
               
          </h4>

        </section>

        <!-- Main content -->
        <section class="content">

        @if(Session::has('info_message'))
        <div class="alert alert-warning">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
          <i class="fa fa-warning margin-separator"></i>  {{ Session::get('info_message') }}          
        </div>
        @endif

            <div class="content">

                <div class="row">

            <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">{{{ trans('misc.add_new') }}}</h3>
                </div><!-- /.box-header -->

                <!-- form start -->
                <form class="form-horizontal" id="addSubCat" method="post" action="{{{ url('panel/admin/subcategories/add/').'/'.$id }}}" enctype="multipart/form-data">

                    <input type="hidden" name="_token" value="{{{ csrf_token() }}}">
                           @include('errors.errors-forms')


                             <!-- Start Box Body -->
                  
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Status<br><p style="color:red; text-decoration-style: bold"> Be Cautious! </p></label>
                      <div class="col-sm-10">
                        <div class="radio">
                        <label class="padding-zero">
                          <input type="radio" name="mode" value="on" @if( $data->mode == 'on' ) checked @endif>
                         Yes
                        </label>
                      </div>

                      

                      <div class="radio">
                        <label class="padding-zero">
                          <input type="radio" name="mode" value="off" @if( $data->mode == 'off' ) checked @endif>
                          No
                        </label>
                      </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2 control-label">Watermark<br></label>
                      <div class="col-sm-10">
                        <div class="radio">
                        <label class="padding-zero">
                          <input type="radio" name="watermark" value="light" checked>
                         Light
                        </label>
                      </div>

                      <div class="radio">
                        <label class="padding-zero">
                          <input type="radio" name="watermark" value="bottom" @if( $data->watermark == 'bottom' ) checked @endif>
                          Bottom
                        </label>
                      </div>


                      <div class="radio">
                        <label class="padding-zero">
                          <input type="radio" name="watermark" value="both" @if( $data->watermark == 'both' ) checked @endif>
                          Both
                        </label>
                      </div>

                       <div class="radio">
                        <label class="padding-zero">
                          <input type="radio" name="watermark" value="no" @if( $data->watermark == 'no' ) checked @endif>
                          Off
                        </label>
                      </div>

                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">{{{ trans('admin.name') }}}</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{{ old('name') }}}" id="name" name="name" class="form-control" placeholder="{{{ trans('admin.name') }}}">
                        <span id="nerror" class="error"></span>
                      </div>
                    </div>

                  
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Similar Subcategory</label>

                      <div class="col-sm-10">
                        <select id="existing">
                        <?php foreach ($subcategories as $key => $value) {
                             echo "<option value='".$value->name."'>".$value->name."</option>";
                        } ?>
                        <?php ?>
                        </select>
                        <p class="help-block">If it matched to 'Name' you entered, Dont add.</p>
                      </div>
                    </div>
                                  
                    <div class="form-group">
                      <label class="col-sm-2 control-label">{{{ trans('admin.slug') }}}</label>
                      <div class="col-sm-10"> 
                        <div style="padding-left:15px;margin-bottom: 0px;" class="form-group">
                          <p style="
    border: 1px solid lightgrey;
    width: 98%;
    padding: 5px;
    border-radius: 5px;
    margin: 0px !important;"> {{url('/')}}/
                          <input type="text" value="{{{ old('slug') }}}" name="slug" id="slug" placeholder="...">
                        </p>
                        </div>
                      </div>
                    </div>





                    <div class="form-group">
                      <label class="col-sm-2 control-label">MetaKeywords</label>
                      <div class="col-sm-10">
                        <input type="text" id="copykeyword" 
                        value="{{$part}}" id="metakeywords" name="metakeywords" class="form-control">
                      </div>
                    </div>


                    <div class="form-group">
                      <label class="col-sm-2 control-label">SubGroups</label>
                      <div class="col-sm-10">
                        <input type="text" id="copysg" value="{{$subgroup}}" name="keyword" class="form-control" placeholder="enter keyword">
                        <p class="help-block">*No symbols should be used</p>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2 control-label">Select Group</label>
                      <div class="col-sm-6">
                        <?php 
                        $subgroupa =explode(',', $subgroup);
                        $subgroupa = $subgroupa[1]; ?>
                        <input type="text" id="copysgselect" value="{{$subgroupa}}" name="selectedgroup" class="form-control" placeholder="enter keyword">
                      </div>
                    </div>

                   <!-- Start Box Body -->
                  <div class="box-body" style="display: none">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Copy Description</label>
                      <div class="col-sm-10">
                        <textarea rows="8" class="form-control" id="copydescr">

                          @if($catid=='224')

                          <h2>abc Full HD Fortnite Online Video Wallpapers</h2> <p>#abc This is <b>abc</b> Fortnite Video Game Ultra HD 4k wallpaper for free downloading. We've collected <b>abc</b> Fortnite HD Photos & Wallpapers for mobile, WhatsApp DP (1080p).</p> <p>You are free to download any of these images to use as your Android Mobile Wallpaper or lockscreen, iPhone Wallpaper or iPad/Tablet Wallpaper, in HD Quality. As well as you can use this image as your WhatsApp DP, WhatsApp Image Status or Facebook profile picture and cover photo.</p>

                          @else
                          <h2>abc Full HD Wallpapers Pics </h2> <p>#abc This is <b>abc</b> Full Ultra HD 4k wallpaper for free downloading. We've collected <b>abc</b> HD Photos & Wallpapers for mobile, WhatsApp DP (1080p).</p> <p>You are free to download any of these images to use as your Android Mobile Wallpaper or lockscreen, iPhone Wallpaper or iPad/Tablet Wallpaper, in HD Quality. As well as you can use this image as your WhatsApp DP, WhatsApp Image Status or Facebook profile picture and cover photo.</p><h3>About abc</h3>
                          @endif

                          <br>

                        </textarea>
                      </div>
                    </div>
                  </div>
                  <!-- /.box-body -->



                    <div class="form-group">
                      <label class="col-sm-2 control-label">Post Description</label>
                      <div class="col-sm-10">
                      
                        <textarea name="spdescr" id="spdescr"></textarea>
                      </div>
                    </div>


                  
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Tags</label>
                      <div class="col-sm-10">
                        @if($catid=='224')
                        <input type="text" value="Fortnite Video Game" name="tags" class="form-control" placeholder="Enter Tags"/>
                        @else
                        <input type="text" value="{{ $data->tags }}" id="tags" name="tags" class="form-control" placeholder="Enter Tags"/>
                        @endif
                      </div>
                    </div>
                       <input type="hidden" id="selectedTags" name="tags"/>
                  

                  <!-- Start Box Body -->
                 
                    <div class="form-group">
                      <label class="col-sm-2 control-label">{{ trans('admin.thumbnail') }} ({{trans('misc.optional')}})</label>
                      <div class="col-sm-10">
                            <div class="btn btn-info box-file">
                              <input type="file" accept="image/*" name="thumbnail" />
                              <i class="glyphicon glyphicon-cloud-upload myicon-right"></i> {{ trans('misc.upload') }}
                            </div>
                                <input type="hidden" name="instathumbnail" />
                            
                            <div class="imgsug">
                                <p class="help-block">{{ trans('admin.thumbnail_desc') }}</p>
                                <div class="btn-default btn-lg btn-border btn-block pull-left text-left display-none fileContainer">
                                    <i class="glyphicon glyphicon-paperclip myicon-right"></i>
                                    <small class="myicon-right file-name-file"></small>
                                    <i class="icon-cancel-circle delete-attach-file-2 pull-right" title="{{ trans('misc.delete') }}"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                  
                  <!-- /.box-body -->

                  <!-- Start Box Body -->
                  
                    <div class="form-group">
                      <label class="col-sm-2 control-label">{{{ trans('admin.insta_username') }}}</label>
                      <div class="col-sm-10">
                        <input type="text" value="" name="search_insta_username" class="form-control" placeholder="Search Instagram Users">
                      </div>
                    </div>
                 

                  <!-- Start Box Body -->
                  
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Instagram ID</label>
                      <div class="col-sm-10">
                        <input type="number" value="{{{ old('insta_username') }}}" name="insta_username" class="form-control" placeholder="{{{ trans('admin.insta_id') }}}">
                        <button class="copyL copylines" data-value="window._sharedData.entry_data.ProfilePage[0].graphql.user.id">
                            <i class="fa fa-clone"></i>
                            <span id="copy_line_text">Copy Inspect Code</span>
                        </button>
                      </div>
                    </div>
                  

                    <div class="form-group">
                      <label class="col-sm-2 control-label">Pinthumb ?</label>

                      <div class="col-sm-10">

                        <div class="radio">
                        <label class="padding-zero">
                          <input type="radio" name="pinthumb" value="yes">
                         YES
                        </label>

                      </div>

                      <div class="radio">
                        <label class="padding-zero">
                          <input type="radio" name="pinthumb" value="no" checked>
                          NO
                        </label>
                       
                      </div>

                      </div>
                    </div>


                    <div class="form-group">
                      <label class="col-sm-2 control-label">Show at home?</label>

                      <div class="col-sm-10">

                        <div class="radio">
                        <label class="padding-zero">
                          <input type="radio" name="showathome" value="yes">
                         YES
                        </label>

                      </div>

                      <div class="radio">
                        <label class="padding-zero">
                          <input type="radio" name="showathome" value="no" checked>
                          NO
                        </label>
                       
                      </div>

                      </div>
                    </div>
                  


                    <div class="form-group">
                      <label class="col-sm-2 control-label">Upload All Insta Images <br><p style="color:red; text-decoration-style: bold"> Be Cautious! </p></label>

                      <div class="col-sm-10">

                        <div class="radio">
                        <label class="padding-zero">
                          <input type="radio" name="allinsta" value="yes">
                         YES
                        </label>

                      </div>

                      <div class="radio">
                        <label class="padding-zero">
                          <input type="radio" name="allinsta" value="no" checked>
                          NO
                        </label>
                        <p class="help-block">*Keep it 'NO'</p>
                      </div>

                      </div>
                    </div>
                  


                    <div class="form-group">
                      <label class="col-sm-2 control-label">Daily Insta Cro  <br><p style="color:red; text-decoration-style: bold"> Be Cautious! </p></label>

                      <div class="col-sm-10">

                        <div class="radio">
                        <label class="padding-zero">
                          <input type="radio" name="instacronstatus" value="on" checked>
                         ON
                        </label>
                      </div>

                      <div class="radio">
                        <label class="padding-zero">
                          <input type="radio" name="instacronstatus" value="off">
                          OFF
                        </label>
                        <p class="help-block">*Keep it 'ON'</p>
                      </div>

                      </div>
                    </div>

                    
                 
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Scrapped to be Pending?</label>
                      <div class="col-sm-10">
                        
                        <div class="radio">
                        <label class="padding-zero">
                          <input type="radio" name="cronstatus" value="yes" checked>
                          YES
                        </label>
                      </div>
                      
                      <div class="radio">
                        <label class="padding-zero">
                          <input type="radio" name="cronstatus" value="no">
                          NO
                        </label>
                        <p class="help-block">*Keep it 'YES'</p>
                      </div>
                      
                      </div>
                    </div>
                  
                    <div class="form-group">
                      <label class="col-sm-2 control-label">No. of images</label>
                      <div class="col-sm-10">
                        <input type="number" name="imagecount" class="form-control" value="500" placeholder="No. of images">
                      </div>
                    </div>
                  
                    <div class="form-group">
                      <label class="col-sm-2 control-label">IMG Title</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{$imgtitle}}" name="imgtitle" id="copyimg" class="form-control" placeholder="IMG Title">
                      </div>
                    </div>
                 
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Occation/Fesitval Date</label>
                      <div class="col-sm-10">
                        <input type="text" value="27-02-2021" name="special_date" id="special_date" class="form-control" placeholder="Occation Date">
                        <p class="help-block">(dd-mm-yyyy)</p>
                      </div>
                    </div>
                 


                 
                    <a href="{{{ url('panel/admin/categories') }}}" class="btn btn-default">{{{ trans('admin.cancel') }}}</a>
                    <button style="width: fit-content;" type="submit" class="btn btn-success pull-right">{{{ trans('admin.save') }}}</button>
                  
                </form>
              </div>

                </div><!-- /.row -->

            </div><!-- /.content -->

          <!-- Your Page Content Here -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
@endsection

@section('javascript')

<!-- icheck -->
  <script src="{{{ asset('public/plugins/iCheck/icheck.min.js') }}}" type="text/javascript"></script>
  <script src="{{{ asset('public/Trumbowyg-master/dist/trumbowyg.min.js') }}}"></script>
  <script src="{{ asset('public/plugins/tagsinput/jquery.tagsinput.min.js') }}" type="text/javascript"></script>

<!-- Include JS file. -->
<script type="text/javascript">

function copy_image_description(){

    var desc=$('.copyL').data('value');


    var ele = $('#copy_icon_button');
    
    ele.css('background-color', '#1f8c9e');

    ele.css('color', '#ffffff');

    setTimeout(function(){

      ele.css('background-color', '#ffffff');
      ele.css('color', '#3ba019');
    }, 700);

  document.addEventListener('copy', function(e){
      e.clipboardData.setData('text/plain', desc);
      e.preventDefault();
    }, true);
    document.execCommand('copy');
}

function scrollWin() {
  window.scrollTo(0, 750);
}

function onclickInfoIcon(){

  $('#infoModal').modal('show');

}
     $(document).ready(function()
 {

  $(".read-more").click(function(){
      $(this).siblings(".more-text").contents().unwrap();
      $(this).remove();
  });

  $('.copyL').click(function (e) 
  {
    e.preventDefault();
    var ele = $(this);
    $('#copy_line_text').text('Copied!');
    ele.css('background-color', '#2b9325');

    setTimeout(function(){
       $('#copy_line_text').text('Copy Inspect Code');
      ele.css('background-color', '#2b9318');
    }, 900);


    var copyText = $(this).data('value');
    document.addEventListener('copy', function(e){
      e.clipboardData.setData('text/plain', copyText);
      e.preventDefault();
    }, true);
    document.execCommand('copy');
  }); 
 });

    var insta_data = [];
    var slugahead = "<?php echo "".trim($slugahead);?>";

    function slugify(text) {
      const from = "ãàáäâẽèéëêìíïîõòóöôùúüûñç·/_,:;"
      const to = "aaaaaeeeeeiiiiooooouuuunc------"

      const newText = text.split('').map(
        (letter, i) => letter.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i)))

      return newText
        .toString()                     // Cast to string
        .toLowerCase()                  // Convert the string to lowercase letters
        .trim()                         // Remove whitespace from both sides of a string
        .replace(/\s+/g, '-')           // Replace spaces with -
        .replace(/&/g, '-y-')           // Replace & with 'and'
        .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
        .replace(/\-\-+/g, '-');        // Replace multiple - with single -
    }

    $(function () {
      $('#spdescr').trumbowyg();
     });

    function updateFields(title)
    {
        if( title == "" )
        {
            return false;
        }
        var slug = slugify(title);
        $("#slug").val(slug+slugahead);

        var t = title.trim().split(" ");

                if( t.length > 6 ) 
        {
          name = t[0]+" "+t[1]+" "+t[2]+" "+t[3]+" "+t[4]+" "+t[5]+" "+t[6];
          var imgtitle = $("#imgtitle").val();
          $("#imgtitle").val(name);
        }

        else if( t.length > 5 ) 
        {
          name = t[0]+" "+t[1]+" "+t[2]+" "+t[3]+" "+t[4]+" "+t[5];
          var imgtitle = $("#imgtitle").val();
          $("#imgtitle").val(name);
        }

        else if( t.length > 4 ) 
        {
          name = t[0]+" "+t[1]+" "+t[2]+" "+t[3]+" "+t[4];
          var imgtitle = $("#imgtitle").val();
          $("#imgtitle").val(name);
        }


        else if( t.length > 3 ) 
        {
          name = t[0]+" "+t[1]+" "+t[2]+" "+t[3];
          var imgtitle = $("#imgtitle").val();
          $("#imgtitle").val(name);
        }

        else if( t.length > 2 ) 
        {
          name = t[0]+" "+t[1]+" "+t[2];
          var imgtitle = $("#imgtitle").val();
          $("#imgtitle").val(name);
        }
        else if( t.length == 2 )
        {
          name = t[0]+" "+t[1];
          var imgtitle = $("#imgtitle").val();
          $("#imgtitle").val(name);
        }else{
          name = title;  
        }

        var copykeyword = $("#copykeyword").val();
        copykeyword1 = copykeyword.replace(/abc/g, name);
        $("#copykeyword").val(copykeyword1);

        var copysg = $("#copysg").val();
        copysg1 = copysg.replace(/abc/g, name);
        $("#copysg").val(copysg1);

        var copysgselect = $("#copysgselect").val();
        copysgselect1 = copysgselect.replace(/abc/g, name);
        $("#copysgselect").val(copysgselect1);


        var copydescr = $("#copydescr").val();
        var hash = name.replace(/ /g, '');
        copydescr1 = copydescr.replace(/#abc/g, "#"+hash);
        copydescr1 = copydescr1.replace(/abc/g, name);
        $("#copydescr").val(copydescr1);

        var copyimg = $("#copyimg").val();
        copyimg1 = copyimg.replace(/abc/g, name);
        $("#copyimg").val(copyimg1);

        spdescr1 = copydescr1;
        $("#spdescr").trumbowyg('html', '<p>'+spdescr1+'<p>');
    }

    $(document).ready(function()
    {
        $("#special_date").datepicker({
            dateFormat: 'dd-mm-yy'
        });

        $("#name").blur(function()
        {
            $("#name").css("color", "black");
            $("#nerror").html("");
            var search = $(this).val().trim();

            // this will make AnKiT to ankit
            // search  = search.charAt(0).toUpperCase() + search.slice(1).toLowerCase();

            // this will make ankit to Ankit aNkIT to ANkIT
            search = search.replace(/(^\w|\s\w)/g, m => m.toUpperCase());

            // Just for matching
            searchm = search.replace( /\s\s+/g, ' ' );
            searchmatch = searchm.toLowerCase();

            // removing unnecessary symbols
            search = search.replace(/[-()|/<>,";:?_+=*&^%$#@!{}.]/ig,'');
            search = search.replace('[','');
            search = search.replace(']','');
            search = search.replace(/\\/g,'');
            search = search.replace(/  /ig,' ');
            
            $(this).val(search);
            $("#existing > option").each(function() 
            {
                var val = this.value.toLowerCase();
                if( val.indexOf(searchmatch) != -1)
                {
                    $("#nerror").html(this.value+" already exists. You can skip adding.");
                    $("#existing").val(this.value);
                    $("#name").css("color", "red");
                    // This will not let other field edit
                    // $("#name").focus().css("color", "red");                    
                    // return false;        
                }
            });

        });


        $("input[name='search_insta_username']").autocomplete({
          source: function(request, response) {
              var dt = new Date().getTime();
              var q = request.term;
              $.get(URL_BASE+"/ajax/searchinsta?index="+dt+"&q="+q, function(data){
              if ( data ) {
                  if( data.error == 1 ) {
                    return false;
                  }
                  if( data.index == dt )
                  {
                    insta_data = data.insta_data;
                    response(data.data);
                  }
              }
          });
        },       
        minLength: 2,
        open: function( event, ui )
        {
          $("ul.ui-autocomplete").find(".ui-menu-item").each(function(){
              var username = $(this).text();
              var obj = insta_data[username];
              var status = (obj.is_verified == false) ? "notverified" : "verified";
              status += (obj.is_private == false) ? "-public" : "-private";
              var t = "<span style='border:1px solid grey;float:left;' class='instaimg'><img style='width:60px;height:60px;margin:2px;' src='"+obj.profile_pic_url+"'/></span><span style='margin-left:10px;float:left;'><b>Full Name :</b>"+obj.full_name+"<br/><b>Username :</b>"+$(this).text().trim()+"<br/><b> Status &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</b>"+status+"</span>";
              $(this).html(t);
          });
        },
        focus: function( event, ui ) { console.log(""); },
        select: function( event, ui ) 
        {
          $("input[name='search_insta_username']").val(ui.item.value.trim());
          $( "input[name='search_insta_username']" ).autocomplete( "close" );
          console.log(insta_data[ui.item.value]);
          var obj = insta_data[ui.item.value];
          $("input[name='instathumbnail']").val(obj.profile_pic_url);
          $("input[name='insta_username']").val(obj.pk);
          $("input[name='name']").val(obj.full_name);
          updateFields(obj.full_name);
        }
      });

      $("input[name='name']").on('blur', function(e)
      {
        updateFields($(this).val());
      });

    });

    $('input[type="radio"]').iCheck({
      radioClass: 'iradio_flat-red'
    });

    function replaceString(string) {
      return string.replace(/[\-\_\.\+]/ig,' ')
    }

    $('input[type="file"]').attr('title', window.URL ? ' ' : '');
    $("#specialtag").tagsInput({
       'delimiter': [','],   // Or a string with a single delimiter. Ex: ';'
       'width':'auto',
       'height':'auto',
       'removeWithBackspace' : true,
       'minChars' : 3,
       'maxChars' : 50,
       'defaultText':'{{ trans("misc.add_tag") }}',
       onChange: function() {
          var input = $(this).siblings('.tagsinput');
          if( input.children('span.tag').length >= maxLen){
              input.children('div').hide();
          }
          else{
              input.children('div').show();
    }}});
      
      /**
 * All auto suggestion boxes are fucked up or badly written.
 * This is an attempt to create something that doesn't suck...
 *
 * Requires: jQuery
 *
 * Author: Nicolas Bize
 * Date: Feb. 8th 2013
 * Version: 1.3.1
 * Licence: TagSuggest is licenced under MIT licence (https://www.opensource.org/licenses/mit-license.php)
 */
(function($)
{
    "use strict";
    var TagSuggest = function(element, options)
    {
        var ms = this;

        /**
         * Initializes the TagSuggest component
         * @param defaults - see config below
         */
        var defaults = {
            /**********  CONFIGURATION PROPERTIES ************/
            /**
             * @cfg {Boolean} allowFreeEntries
             * <p>Restricts or allows the user to validate typed entries.</p>
             * Defaults to <code>true</code>.
             */
            allowFreeEntries: true,

            /**
             * @cfg {String} cls
             * <p>A custom CSS class to apply to the field's underlying element.</p>
             * Defaults to <code>''</code>.
             */
            cls: '',

            /**
             * @cfg {Array / String / Function} data
             * JSON Data source used to populate the combo box. 3 options are available here:<br/>
             * <p><u>No Data Source (default)</u><br/>
             *    When left null, the combo box will not suggest anything. It can still enable the user to enter
             *    multiple entries if allowFreeEntries is * set to true (default).</p>
             * <p><u>Static Source</u><br/>
             *    You can pass an array of JSON objects, an array of strings or even a single CSV string as the
             *    data source.<br/>For ex. data: [* {id:0,name:"Paris"}, {id: 1, name: "New York"}]<br/>
             *    You can also pass any json object with the results property containing the json array.</p>
             * <p><u>Url</u><br/>
             *     You can pass the url from which the component will fetch its JSON data.<br/>Data will be fetched
             *     using a POST ajax request that will * include the entered text as 'query' parameter. The results
             *     fetched from the server can be: <br/>
             *     - an array of JSON objects (ex: [{id:...,name:...},{...}])<br/>
             *     - a string containing an array of JSON objects ready to be parsed (ex: "[{id:...,name:...},{...}]")<br/>
             *     - a JSON object whose data will be contained in the results property
             *      (ex: {results: [{id:...,name:...},{...}]</p>
             * <p><u>Function</u><br/>
             *     You can pass a function which returns an array of JSON objects  (ex: [{id:...,name:...},{...}])<br/>
             *     The function can return the JSON data or it can use the first argument as function to handle the data.<br/>
             *     Only one (callback function or return value) is needed for the function to succeed.<br/>
             *     See the following example:<br/>
             *     function (response) { var myjson = [{name: 'test', id: 1}]; response(myjson); return myjson; }</p>
             * Defaults to <b>null</b>
             */
            data: null,

            /**
             * @cfg {Object} dataParams
             * <p>Additional parameters to the ajax call</p>
             * Defaults to <code>{}</code>
             */
            dataUrlParams: {},

            /**
             * @cfg {Boolean} disabled
             * <p>Start the component in a disabled state.</p>
             * Defaults to <code>false</code>.
             */
            disabled: false,

            /**
             * @cfg {String} displayField
             * <p>name of JSON object property displayed in the combo list</p>
             * Defaults to <code>name</code>.
             */
            displayField: 'name',

            /**
             * @cfg {Boolean} editable
             * <p>Set to false if you only want mouse interaction. In that case the combo will
             * automatically expand on focus.</p>
             * Defaults to <code>true</code>.
             */
            editable: true,

            /**
             * @cfg {String} emptyText
             * <p>The default placeholder text when nothing has been entered</p>
             * Defaults to <code>'Type or click here'</code> or just <code>'Click here'</code> if not editable.
             */
            emptyText: function() {
                return cfg.editable ? 'Type or click here' : 'Click here';
            },

            /**
             * @cfg {String} emptyTextCls
             * <p>A custom CSS class to style the empty text</p>
             * Defaults to <code>'tag-empty-text'</code>.
             */
            emptyTextCls: 'tag-empty-text',

            /**
             * @cfg {Boolean} expanded
             * <p>Set starting state for combo.</p>
             * Defaults to <code>false</code>.
             */
            expanded: false,

            /**
             * @cfg {Boolean} expandOnFocus
             * <p>Automatically expands combo on focus.</p>
             * Defaults to <code>false</code>.
             */
            expandOnFocus: function() {
                return cfg.editable ? false : true;
            },

            /**
             * @cfg {String} groupBy
             * <p>JSON property by which the list should be grouped</p>
             * Defaults to null
             */
            groupBy: null,

            /**
             * @cfg {Boolean} hideTrigger
             * <p>Set to true to hide the trigger on the right</p>
             * Defaults to <code>false</code>.
             */
            hideTrigger: false,

            /**
             * @cfg {Boolean} highlight
             * <p>Set to true to highlight search input within displayed suggestions</p>
             * Defaults to <code>true</code>.
             */
            highlight: true,

            /**
             * @cfg {String} id
             * <p>A custom ID for this component</p>
             * Defaults to 'tag-ctn-{n}' with n positive integer
             */
            id: function() {
                return 'tag-ctn-' + $('div[id^="tag-ctn"]').length;
            },

            /**
             * @cfg {String} infoMsgCls
             * <p>A class that is added to the info message appearing on the top-right part of the component</p>
             * Defaults to ''
             */
            infoMsgCls: '',

            /**
             * @cfg {Object} inputCfg
             * <p>Additional parameters passed out to the INPUT tag. Enables usage of AngularJS's custom tags for ex.</p>
             * Defaults to <code>{}</code>
             */
            inputCfg: {},

            /**
             * @cfg {String} invalidCls
             * <p>The class that is applied to show that the field is invalid</p>
             * Defaults to tag-ctn-invalid
             */
            invalidCls: 'tag-ctn-invalid',

            /**
             * @cfg {Boolean} matchCase
             * <p>Set to true to filter data results according to case. Useless if the data is fetched remotely</p>
             * Defaults to <code>false</code>.
             */
            matchCase: false,

            /**
             * @cfg {Integer} maxDropHeight (in px)
             * <p>Once expanded, the combo's height will take as much room as the # of available results.
             *    In case there are too many results displayed, this will fix the drop down height.</p>
             * Defaults to 290 px.
             */
            maxDropHeight: 290,

            /**
             * @cfg {Integer} maxEntryLength
             * <p>Defines how long the user free entry can be. Set to null for no limit.</p>
             * Defaults to null.
             */
            maxEntryLength: null,

            /**
             * @cfg {String} maxEntryRenderer
             * <p>A function that defines the helper text when the max entry length has been surpassed.</p>
             * Defaults to <code>function(v){return 'Please reduce your entry by ' + v + ' character' + (v > 1 ? 's':'');}</code>
             */
            maxEntryRenderer: function(v) {
                return 'Please reduce your entry by ' + v + ' character' + (v > 1 ? 's':'');
            },

            /**
             * @cfg {Integer} maxSuggestions
             * <p>The maximum number of results displayed in the combo drop down at once.</p>
             * Defaults to null.
             */
            maxSuggestions: null,

            /**
             * @cfg {Integer} maxSelection
             * <p>The maximum number of items the user can select if multiple selection is allowed.
             *    Set to null to remove the limit.</p>
             * Defaults to 10.
             */
            maxSelection: 10,

            /**
             * @cfg {Function} maxSelectionRenderer
             * <p>A function that defines the helper text when the max selection amount has been reached. The function has a single
             *    parameter which is the number of selected elements.</p>
             * Defaults to <code>function(v){return 'You cannot choose more than ' + v + ' item' + (v > 1 ? 's':'');}</code>
             */
            maxSelectionRenderer: function(v) {
                return 'You cannot choose more than ' + v + ' item' + (v > 1 ? 's':'');
            },

            /**
             * @cfg {String} method
             * <p>The method used by the ajax request.</p>
             * Defaults to 'POST'
             */
            method: 'POST',

            /**
             * @cfg {Integer} minChars
             * <p>The minimum number of characters the user must type before the combo expands and offers suggestions.
             * Defaults to <code>0</code>.
             */
            minChars: 0,

            /**
             * @cfg {Function} minCharsRenderer
             * <p>A function that defines the helper text when not enough letters are set. The function has a single
             *    parameter which is the difference between the required amount of letters and the current one.</p>
             * Defaults to <code>function(v){return 'Please type ' + v + ' more character' + (v > 1 ? 's':'');}</code>
             */
            minCharsRenderer: function(v) {
                return 'Please type ' + v + ' more character' + (v > 1 ? 's':'');
            },

            /**
             * @cfg {String} name
             * <p>The name used as a form element.</p>
             * Defaults to 'null'
             */
            name: null,

            /**
             * @cfg {String} noSuggestionText
             * <p>The text displayed when there are no suggestions.</p>
             * Defaults to 'No suggestions"
             */
            noSuggestionText: 'No suggestions',

            /**
             * @cfg {Boolean} preselectSingleSuggestion
             * <p>If a single suggestion comes out, it is preselected.</p>
             * Defaults to <code>true</code>.
             */
            preselectSingleSuggestion: true,

            /**
             * @cfg (function) renderer
             * <p>A function used to define how the items will be presented in the combo</p>
             * Defaults to <code>null</code>.
             */
            renderer: null,

            /**
             * @cfg {Boolean} required
             * <p>Whether or not this field should be required</p>
             * Defaults to false
             */
            required: false,

            /**
             * @cfg {Boolean} resultAsString
             * <p>Set to true to render selection as comma separated string</p>
             * Defaults to <code>false</code>.
             */
            resultAsString: false,

            /**
             * @cfg {String} resultsField
             * <p>Name of JSON object property that represents the list of suggested objets</p>
             * Defaults to <code>results</code>
             */
            resultsField: 'results',

            /**
             * @cfg {String} selectionCls
             * <p>A custom CSS class to add to a selected item</p>
             * Defaults to <code>''</code>.
             */
            selectionCls: '',

            /**
             * @cfg {String} selectionPosition
             * <p>Where the selected items will be displayed. Only 'right', 'bottom' and 'inner' are valid values</p>
             * Defaults to <code>'inner'</code>, meaning the selected items will appear within the input box itself.
             */
            selectionPosition: 'inner',

            /**
             * @cfg (function) selectionRenderer
             * <p>A function used to define how the items will be presented in the tag list</p>
             * Defaults to <code>null</code>.
             */
            selectionRenderer: null,

            /**
             * @cfg {Boolean} selectionStacked
             * <p>Set to true to stack the selectioned items when positioned on the bottom
             *    Requires the selectionPosition to be set to 'bottom'</p>
             * Defaults to <code>false</code>.
             */
            selectionStacked: false,

            /**
             * @cfg {String} sortDir
             * <p>Direction used for sorting. Only 'asc' and 'desc' are valid values</p>
             * Defaults to <code>'asc'</code>.
             */
            sortDir: 'asc',

            /**
             * @cfg {String} sortOrder
             * <p>name of JSON object property for local result sorting.
             *    Leave null if you do not wish the results to be ordered or if they are already ordered remotely.</p>
             *
             * Defaults to <code>null</code>.
             */
            sortOrder: null,

            /**
             * @cfg {Boolean} strictSuggest
             * <p>If set to true, suggestions will have to start by user input (and not simply contain it as a substring)</p>
             * Defaults to <code>false</code>.
             */
            strictSuggest: false,

            /**
             * @cfg {String} style
             * <p>Custom style added to the component container.</p>
             *
             * Defaults to <code>''</code>.
             */
            style: '',

            /**
             * @cfg {Boolean} toggleOnClick
             * <p>If set to true, the combo will expand / collapse when clicked upon</p>
             * Defaults to <code>false</code>.
             */
            toggleOnClick: false,


            /**
             * @cfg {Integer} typeDelay
             * <p>Amount (in ms) between keyboard registers.</p>
             *
             * Defaults to <code>400</code>
             */
            typeDelay: 400,

            /**
             * @cfg {Boolean} useTabKey
             * <p>If set to true, tab won't blur the component but will be registered as the ENTER key</p>
             * Defaults to <code>false</code>.
             */
            useTabKey: false,

            /**
             * @cfg {Boolean} useCommaKey
             * <p>If set to true, using comma will validate the user's choice</p>
             * Defaults to <code>true</code>.
             */
            useCommaKey: true,


            /**
             * @cfg {Boolean} useZebraStyle
             * <p>Determines whether or not the results will be displayed with a zebra table style</p>
             * Defaults to <code>true</code>.
             */
            useZebraStyle: true,

            /**
             * @cfg {String/Object/Array} value
             * <p>initial value for the field</p>
             * Defaults to <code>null</code>.
             */
            value: null,

            /**
             * @cfg {String} valueField
             * <p>name of JSON object property that represents its underlying value</p>
             * Defaults to <code>id</code>.
             */
            valueField: 'id',

            /**
             * @cfg {Integer} width (in px)
             * <p>Width of the component</p>
             * Defaults to underlying element width.
             */
            width: function() {
                return $(this).width();
            }
        };

        var conf = $.extend({},options);
        var cfg = $.extend(true, {}, defaults, conf);

        // some init stuff
        if ($.isFunction(cfg.emptyText)) {
            cfg.emptyText = cfg.emptyText.call(this);
        }
        if ($.isFunction(cfg.expandOnFocus)) {
            cfg.expandOnFocus = cfg.expandOnFocus.call(this);
        }
        if ($.isFunction(cfg.id)) {
            cfg.id = cfg.id.call(this);
        }

        /**********  PUBLIC METHODS ************/
        /**
         * Add one or multiple json items to the current selection
         * @param items - json object or array of json objects
         * @param isSilent - (optional) set to true to suppress 'selectionchange' event from being triggered
         */
        this.addToSelection = function(items, isSilent)
        {
            if (!cfg.maxSelection || _selection.length < cfg.maxSelection) {
                if (!$.isArray(items)) {
                    items = [items];
                }
                var valuechanged = false;
                $.each(items, function(index, json) {
                    if ($.inArray(json[cfg.valueField], ms.getValue()) === -1) {
                        _selection.push(json);
                        valuechanged = true;
                    }
                });
                if(valuechanged === true) {
                    self._renderSelection();
                    this.empty();
                    if (isSilent !== true) {
                        $(this).trigger('selectionchange', [this, this.getSelectedItems()]);
                    }
                }
            }
        };

        /**
         * Clears the current selection
         * @param isSilent - (optional) set to true to suppress 'selectionchange' event from being triggered
         */
        this.clear = function(isSilent)
        {
            this.removeFromSelection(_selection.slice(0), isSilent); // clone array to avoid concurrency issues
        };

        /**
         * Collapse the drop down part of the combo
         */
        this.collapse = function()
        {
            if (cfg.expanded === true) {
                this.combobox.detach();
                cfg.expanded = false;
                $(this).trigger('collapse', [this]);
            }
        };

        /**
         * Set the component in a disabled state.
         */
        this.disable = function()
        {
            this.container.addClass('tag-ctn-disabled');
            cfg.disabled = true;
            ms.input.attr('disabled', true);
        };

        /**
         * Empties out the combo user text
         */
        this.empty = function(){
            this.input.removeClass(cfg.emptyTextCls);
            this.input.val('');
        };

        /**
         * Set the component in a enable state.
         */
        this.enable = function()
        {
            this.container.removeClass('tag-ctn-disabled');
            cfg.disabled = false;
            ms.input.attr('disabled', false);
        };

        /**
         * Expand the drop drown part of the combo.
         */
        this.expand = function()
        {
            if (!cfg.expanded && (this.input.val().length >= cfg.minChars || this.combobox.children().size() > 0)) {
                this.combobox.appendTo(this.container);
                self._processSuggestions();
                cfg.expanded = true;
                $(this).trigger('expand', [this]);
            }
        };

        /**
         * Retrieve component enabled status
         */
        this.isDisabled = function()
        {
            return cfg.disabled;
        };

        /**
         * Checks whether the field is valid or not
         * @return {boolean}
         */
        this.isValid = function()
        {
            return cfg.required === false || _selection.length > 0;
        };

        /**
         * Gets the data params for current ajax request
         */
        this.getDataUrlParams = function()
        {
            return cfg.dataUrlParams;
        };

        /**
         * Gets the name given to the form input
         */
        this.getName = function()
        {
            return cfg.name;
        };

        /**
         * Retrieve an array of selected json objects
         * @return {Array}
         */
        this.getSelectedItems = function()
        {
            return _selection;
        };

        /**
         * Retrieve the current text entered by the user
         */
        this.getRawValue = function(){
            return ms.input.val() !== cfg.emptyText ? ms.input.val() : '';
        };

        /**
         * Retrieve an array of selected values
         */
        this.getValue = function()
        {
            return $.map(_selection, function(o) {
                return o[cfg.valueField];
            });
        };

        /**
         * Remove one or multiples json items from the current selection
         * @param items - json object or array of json objects
         * @param isSilent - (optional) set to true to suppress 'selectionchange' event from being triggered
         */
        this.removeFromSelection = function(items, isSilent)
        {
            if (!$.isArray(items)) {
                items = [items];
            }
            var valuechanged = false;
            $.each(items, function(index, json) {
                var i = $.inArray(json[cfg.valueField], ms.getValue());
                if (i > -1) {
                    _selection.splice(i, 1);
                    valuechanged = true;
                }
            });
            if (valuechanged === true) {
                self._renderSelection();
                if(isSilent !== true){
                    $(this).trigger('selectionchange', [this, this.getSelectedItems()]);
                }
                if(cfg.expandOnFocus){
                    ms.expand();
                }
                if(cfg.expanded) {
                    self._processSuggestions();
                }
            }
        };

        /**
         * Set up some combo data after it has been rendered
         * @param data
         */
        this.setData = function(data){
            cfg.data = data;
            self._processSuggestions();
        };

        /**
         * Sets the name for the input field so it can be fetched in the form
         * @param name
         */
        this.setName = function(name){
            cfg.name = name;
            if(ms._valueContainer){
                ms._valueContainer.name = name;
            }
        };

        /**
         * Sets a value for the combo box. Value must be a value or an array of value with data type matching valueField one.
         * @param data
         */
        this.setValue = function(data)
        {
            var values = data, items = [];
            if(!$.isArray(data)){
                if(typeof(data) === 'string'){
                    if(data.indexOf('[') > -1){
                        values = eval(data);
                    } else if(data.indexOf(',') > -1){
                        values = data.split(',');
                    }
                } else {
                    values = [data];
                }
            }

            $.each(_cbData, function(index, obj) {
                if($.inArray(obj[cfg.valueField], values) > -1) {
                    items.push(obj);
                }
            });
            if(items.length > 0) {
                this.addToSelection(items);
            }
        };

        /**
         * Sets data params for subsequent ajax requests
         * @param params
         */
        this.setDataUrlParams = function(params)
        {
            cfg.dataUrlParams = $.extend({},params);
        };

        /**********  PRIVATE ************/
        var _selection = [],      // selected objects
            _comboItemHeight = 0, // height for each combo item.
            _timer,
            _hasFocus = false,
            _groups = null,
            _cbData = [],
            _ctrlDown = false;

        var self = {

            /**
             * Empties the result container and refills it with the array of json results in input
             * @private
             */
            _displaySuggestions: function(data) {
                ms.combobox.empty();

                var resHeight = 0, // total height taken by displayed results.
                    nbGroups = 0;

                if(_groups === null) {
                    self._renderComboItems(data);
                    resHeight = _comboItemHeight * data.length;
                }
                else {
                    for(var grpName in _groups) {
                        nbGroups += 1;
                        $('<div/>', {
                            'class': 'tag-res-group',
                            html: grpName
                        }).appendTo(ms.combobox);
                        self._renderComboItems(_groups[grpName].items, true);
                    }
                    resHeight = _comboItemHeight * (data.length + nbGroups);
                }

                if(resHeight < ms.combobox.height() || resHeight <= cfg.maxDropHeight) {
                    ms.combobox.height(resHeight);
                }
                else if(resHeight >= ms.combobox.height() && resHeight > cfg.maxDropHeight) {
                    ms.combobox.height(cfg.maxDropHeight);
                }

                if(data.length === 1 && cfg.preselectSingleSuggestion === true) {
                    ms.combobox.children().filter(':last').addClass('tag-res-item-active');
                }

                if(data.length === 0 && ms.getRawValue() !== "") {
                    self._updateHelper(cfg.noSuggestionText);
                    ms.collapse();
                }
            },

            /**
             * Returns an array of json objects from an array of strings.
             * @private
             */
            _getEntriesFromStringArray: function(data) {
                var json = [];
                $.each(data, function(index, s) {
                    var entry = {};
                    entry[cfg.displayField] = entry[cfg.valueField] = $.trim(s);
                    json.push(entry);
                });
                return json;
            },

            /**
             * Replaces html with highlighted html according to case
             * @param html
             * @private
             */
            _highlightSuggestion: function(html) {
                var q = ms.input.val() !== cfg.emptyText ? ms.input.val() : '';
                if(q.length === 0) {
                    return html; // nothing entered as input
                }

                if(cfg.matchCase === true) {
                    html = html.replace(new RegExp('(' + q + ')(?!([^<]+)?>)','g'), '<em>$1</em>');
                }
                else {
                    html = html.replace(new RegExp('(' + q + ')(?!([^<]+)?>)','gi'), '<em>$1</em>');
                }
                return html;
            },

            /**
             * Moves the selected cursor amongst the list item
             * @param dir - 'up' or 'down'
             * @private
             */
            _moveSelectedRow: function(dir) {
                if(!cfg.expanded) {
                    ms.expand();
                }
                var list, start, active, scrollPos;
                list = ms.combobox.find(".tag-res-item");
                if(dir === 'down') {
                    start = list.eq(0);
                }
                else {
                    start = list.filter(':last');
                }
                active = ms.combobox.find('.tag-res-item-active:first');
                if(active.length > 0) {
                    if(dir === 'down') {
                        start = active.nextAll('.tag-res-item').first();
                        if(start.length === 0) {
                            start = list.eq(0);
                        }
                        scrollPos = ms.combobox.scrollTop();
                        ms.combobox.scrollTop(0);
                        if(start[0].offsetTop + start.outerHeight() > ms.combobox.height()) {
                            ms.combobox.scrollTop(scrollPos + _comboItemHeight);
                        }
                    }
                    else {
                        start = active.prevAll('.tag-res-item').first();
                        if(start.length === 0) {
                            start = list.filter(':last');
                            ms.combobox.scrollTop(_comboItemHeight * list.length);
                        }
                        if(start[0].offsetTop < ms.combobox.scrollTop()) {
                            ms.combobox.scrollTop(ms.combobox.scrollTop() - _comboItemHeight);
                        }
                    }
                }
                list.removeClass("tag-res-item-active");
                start.addClass("tag-res-item-active");
            },

            /**
             * According to given data and query, sort and add suggestions in their container
             * @private
             */
            _processSuggestions: function(source) {
                var json = null, data = source || cfg.data;
                if(data !== null) {
                    if(typeof(data) === 'function'){
                        data = data.call(ms);
                    }
                    if(typeof(data) === 'string' && data.indexOf(',') < 0) { // get results from ajax
                        $(ms).trigger('beforeload', [ms]);
                        var params = $.extend({query: ms.input.val()}, cfg.dataUrlParams);
                        $.ajax({
                            type: cfg.method,
                            url: data,
                            data: params,
                            success: function(asyncData){
                                json = typeof(asyncData) === 'string' ? JSON.parse(asyncData) : asyncData;
                                self._processSuggestions(json);
                                $(ms).trigger('load', [ms, json]);
                            },
                            error: function(){
                                throw("Could not reach server");
                            }
                        });
                        return;
                    } else if(typeof(data) === 'string' && data.indexOf(',') > -1) { // results from csv string
                        _cbData = self._getEntriesFromStringArray(data.split(','));
                    } else { // results from local array
                        if(data.length > 0 && typeof(data[0]) === 'string') { // results from array of strings
                            _cbData = self._getEntriesFromStringArray(data);
                        } else { // regular json array or json object with results property
                            _cbData = data[cfg.resultsField] || data;
                        }
                    }
                    self._displaySuggestions(self._sortAndTrim(_cbData));

                }
            },

            /**
             * Render the component to the given input DOM element
             * @private
             */
            _render: function(el) {
                $(ms).trigger('beforerender', [ms]);
                var w = $.isFunction(cfg.width) ? cfg.width.call(el) : cfg.width;
                // holds the main div, will relay the focus events to the contained input element.
                ms.container = $('<div/>', {
                    id: cfg.id,
                    'class': 'tag-ctn ' + cfg.cls +
                        (cfg.disabled === true ? ' tag-ctn-disabled' : '') +
                        (cfg.editable === true ? '' : ' tag-ctn-readonly'),
                    style: cfg.style
                }).width(w);
                ms.container.focus($.proxy(handlers._onFocus, this));
                ms.container.blur($.proxy(handlers._onBlur, this));
                ms.container.keydown($.proxy(handlers._onKeyDown, this));
                ms.container.keyup($.proxy(handlers._onKeyUp, this));

                // holds the input field
                ms.input = $('<input/>', $.extend({
                    id: 'tag-input-' + $('input[id^="tag-input"]').length,
                    type: 'text',
                    'class': cfg.emptyTextCls + (cfg.editable === true ? '' : ' tag-input-readonly'),
                    value: cfg.emptyText,
                    readonly: !cfg.editable,
                    disabled: cfg.disabled
                }, cfg.inputCfg)).width(w - (cfg.hideTrigger ? 16 : 42));

                ms.input.focus($.proxy(handlers._onInputFocus, this));
                ms.input.click($.proxy(handlers._onInputClick, this));

                // holds the trigger on the right side
                if(cfg.hideTrigger === false) {
                    ms.trigger = $('<div/>', {
                        id: 'tag-trigger-' + $('div[id^="tag-trigger"]').length,
                        'class': 'tag-trigger',
                        html: '<div class="tag-trigger-ico"></div>'
                    });
                    ms.trigger.click($.proxy(handlers._onTriggerClick, this));
                    ms.container.append(ms.trigger);
                }

                // holds the suggestions. will always be placed on focus
                ms.combobox = $('<div/>', {
                    id: 'tag-res-ctn-' + $('div[id^="tag-res-ctn"]').length,
                    'class': 'tag-res-ctn '
                }).width(w).height(cfg.maxDropHeight);

                // bind the onclick and mouseover using delegated events (needs jQuery >= 1.7)
                ms.combobox.on('click', 'div.tag-res-item', $.proxy(handlers._onComboItemSelected, this));
                ms.combobox.on('mouseover', 'div.tag-res-item', $.proxy(handlers._onComboItemMouseOver, this));

                ms.selectionContainer = $('<div/>', {
                    id: 'tag-sel-ctn-' +  $('div[id^="tag-sel-ctn"]').length,
                    'class': 'tag-sel-ctn'
                });
                ms.selectionContainer.click($.proxy(handlers._onFocus, this));

                if(cfg.selectionPosition === 'inner') {
                    ms.selectionContainer.append(ms.input);
                }
                else {
                    ms.container.append(ms.input);
                }

                ms.helper = $('<div/>', {
                    'class': 'tag-helper ' + cfg.infoMsgCls
                });
                self._updateHelper();
                ms.container.append(ms.helper);


                // Render the whole thing
                $(el).replaceWith(ms.container);

                switch(cfg.selectionPosition) {
                    case 'bottom':
                        ms.selectionContainer.insertAfter(ms.container);
                        if(cfg.selectionStacked === true) {
                            ms.selectionContainer.width(ms.container.width());
                            ms.selectionContainer.addClass('tag-stacked');
                        }
                        break;
                    case 'right':
                        ms.selectionContainer.insertAfter(ms.container);
                        ms.container.css('float', 'left');
                        break;
                    default:
                        ms.container.append(ms.selectionContainer);
                        break;
                }

                self._processSuggestions();
                if(cfg.value !== null) {
                    ms.setValue(cfg.value);
                    self._renderSelection();
                }

                $(ms).trigger('afterrender', [ms]);
                $("body").click(function(e) {
                    if(ms.container.hasClass('tag-ctn-bootstrap-focus') &&
                        ms.container.has(e.target).length === 0 &&
                        e.target.className.indexOf('tag-res-item') < 0 &&
                        e.target.className.indexOf('tag-close-btn') < 0 &&
                        ms.container[0] !== e.target) {
                        handlers._onBlur();
                    }
                });

                if(cfg.expanded === true) {
                    cfg.expanded = false;
                    ms.expand();
                }
            },

            _renderComboItems: function(items, isGrouped) {
                var ref = this, html = '';
                $.each(items, function(index, value) {
                    var displayed = cfg.renderer !== null ? cfg.renderer.call(ref, value) : value[cfg.displayField];
                    var resultItemEl = $('<div/>', {
                        'class': 'tag-res-item ' + (isGrouped ? 'tag-res-item-grouped ':'') +
                            (index % 2 === 1 && cfg.useZebraStyle === true ? 'tag-res-odd' : ''),
                        html: cfg.highlight === true ? self._highlightSuggestion(displayed) : displayed,
                        'data-json': JSON.stringify(value)
                    });
                    resultItemEl.click($.proxy(handlers._onComboItemSelected, ref));
                    resultItemEl.mouseover($.proxy(handlers._onComboItemMouseOver, ref));
                    html += $('<div/>').append(resultItemEl).html();
                });
                ms.combobox.append(html);
                _comboItemHeight = ms.combobox.find('.tag-res-item:first').outerHeight();
            },

            /**
             * Renders the selected items into their container.
             * @private
             */
            _renderSelection: function() {
                var ref = this, w = 0, inputOffset = 0, items = [],
                    asText = cfg.resultAsString === true && !_hasFocus;

                ms.selectionContainer.find('.tag-sel-item').remove();
                if(ms._valueContainer !== undefined) {
                    ms._valueContainer.remove();
                }

                $.each(_selection, function(index, value){

                    var selectedItemEl, delItemEl,
                        selectedItemHtml = cfg.selectionRenderer !== null ? cfg.selectionRenderer.call(ref, value) : value[cfg.displayField];
                    // tag representing selected value
                    if(asText === true) {
                        selectedItemEl = $('<div/>', {
                            'class': 'tag-sel-item tag-sel-text ' + cfg.selectionCls,
                            html: selectedItemHtml + (index === (_selection.length - 1) ? '' : ',')
                        }).data('json', value);
                    }
                    else {
                        selectedItemEl = $('<div/>', {
                            'class': 'tag-sel-item ' + cfg.selectionCls,
                            html: selectedItemHtml
                        }).data('json', value);

                        if(cfg.disabled === false){
                            // small cross img
                            delItemEl = $('<span/>', {
                                'class': 'tag-close-btn'
                            }).data('json', value).appendTo(selectedItemEl);

                            delItemEl.click($.proxy(handlers._onTagTriggerClick, ref));
                        }
                    }

                    items.push(selectedItemEl);
                });

                ms.selectionContainer.prepend(items);
                ms._valueContainer = $('<input/>', {
                    type: 'hidden',
                    name: cfg.name,
                    value: JSON.stringify(ms.getValue())
                });
                ms._valueContainer.appendTo(ms.selectionContainer);

                if(cfg.selectionPosition === 'inner') {
                    ms.input.width(0);
                    inputOffset = ms.input.offset().left - ms.selectionContainer.offset().left;
                    w = ms.container.width() - inputOffset - 42;
                    ms.input.width(w);
                    ms.container.height(ms.selectionContainer.height());
                }

                if(_selection.length === cfg.maxSelection){
                    self._updateHelper(cfg.maxSelectionRenderer.call(this, _selection.length));
                } else {
                    ms.helper.hide();
                }
            },

            /**
             * Select an item either through keyboard or mouse
             * @param item
             * @private
             */
            _selectItem: function(item) {
                if(cfg.maxSelection === 1){
                    _selection = [];
                }
                ms.addToSelection(item.data('json'));
                item.removeClass('tag-res-item-active');
                if(cfg.expandOnFocus === false || _selection.length === cfg.maxSelection){
                    ms.collapse();
                }
                if(!_hasFocus){
                    ms.input.focus();
                } else if(_hasFocus && (cfg.expandOnFocus || _ctrlDown)){
                    self._processSuggestions();
                    if(_ctrlDown){
                        ms.expand();
                    }
                }
            },

            /**
             * Sorts the results and cut them down to max # of displayed results at once
             * @private
             */
            _sortAndTrim: function(data) {
                var q = ms.getRawValue(),
                    filtered = [],
                    newSuggestions = [],
                    selectedValues = ms.getValue();
                // filter the data according to given input
                if(q.length > 0) {
                    $.each(data, function(index, obj) {
                        var name = obj[cfg.displayField];
                        if((cfg.matchCase === true && name.indexOf(q) > -1) ||
                            (cfg.matchCase === false && name.toLowerCase().indexOf(q.toLowerCase()) > -1)) {
                            if(cfg.strictSuggest === false || name.toLowerCase().indexOf(q.toLowerCase()) === 0) {
                                filtered.push(obj);
                            }
                        }
                    });
                }
                else {
                    filtered = data;
                }
                // take out the ones that have already been selected
                $.each(filtered, function(index, obj) {
                    if($.inArray(obj[cfg.valueField], selectedValues) === -1) {
                        newSuggestions.push(obj);
                    }
                });
                // sort the data
                if(cfg.sortOrder !== null) {
                    newSuggestions.sort(function(a,b) {
                        if(a[cfg.sortOrder] < b[cfg.sortOrder]) {
                            return cfg.sortDir === 'asc' ? -1 : 1;
                        }
                        if(a[cfg.sortOrder] > b[cfg.sortOrder]) {
                            return cfg.sortDir === 'asc' ? 1 : -1;
                        }
                        return 0;
                    });
                }
                // trim it down
                if(cfg.maxSuggestions && cfg.maxSuggestions > 0) {
                    newSuggestions = newSuggestions.slice(0, cfg.maxSuggestions);
                }
                // build groups
                if(cfg.groupBy !== null) {
                    _groups = {};
                    $.each(newSuggestions, function(index, value) {
                        if(_groups[value[cfg.groupBy]] === undefined) {
                            _groups[value[cfg.groupBy]] = {title: value[cfg.groupBy], items: [value]};
                        }
                        else {
                            _groups[value[cfg.groupBy]].items.push(value);
                        }
                    });
                }
                return newSuggestions;
            },

            /**
             * Update the helper text
             * @private
             */
            _updateHelper: function(html) {
                ms.helper.html(html);
                if(!ms.helper.is(":visible")) {
                    ms.helper.fadeIn();
                }
            }
        };

        var handlers = {
            /**
             * Triggered when blurring out of the component
             * @private
             */
            _onBlur: function() {
                ms.container.removeClass('tag-ctn-bootstrap-focus');
                ms.collapse();
                _hasFocus = false;
                if(ms.getRawValue() !== '' && cfg.allowFreeEntries === true){
                    var obj = {};
                    obj[cfg.displayField] = obj[cfg.valueField] = ms.getRawValue();
                    ms.addToSelection(obj);
                }
                self._renderSelection();

                if(ms.isValid() === false) {
                    ms.container.addClass('tag-ctn-invalid');
                }

                if(ms.input.val() === '' && _selection.length === 0) {
                    ms.input.addClass(cfg.emptyTextCls);
                    ms.input.val(cfg.emptyText);
                }
                else if(ms.input.val() !== '' && cfg.allowFreeEntries === false) {
                    ms.empty();
                    self._updateHelper('');
                }

                if(ms.input.is(":focus")) {
                    $(ms).trigger('blur', [ms]);
                }
            },

            /**
             * Triggered when hovering an element in the combo
             * @param e
             * @private
             */
            _onComboItemMouseOver: function(e) {
                ms.combobox.children().removeClass('tag-res-item-active');
                $(e.currentTarget).addClass('tag-res-item-active');
            },

            /**
             * Triggered when an item is chosen from the list
             * @param e
             * @private
             */
            _onComboItemSelected: function(e) {
                self._selectItem($(e.currentTarget));
            },

            /**
             * Triggered when focusing on the container div. Will focus on the input field instead.
             * @private
             */
            _onFocus: function() {
                ms.input.focus();
            },

            /**
             * Triggered when clicking on the input text field
             * @private
             */
            _onInputClick: function(){
                if (ms.isDisabled() === false && _hasFocus) {
                    if (cfg.toggleOnClick === true) {
                        if (cfg.expanded){
                            ms.collapse();
                        } else {
                            ms.expand();
                        }
                    }
                }
            },

            /**
             * Triggered when focusing on the input text field.
             * @private
             */
            _onInputFocus: function() {
                if(ms.isDisabled() === false && !_hasFocus) {
                    _hasFocus = true;
                    ms.container.addClass('tag-ctn-bootstrap-focus');
                    ms.container.removeClass(cfg.invalidCls);

                    if(ms.input.val() === cfg.emptyText) {
                        ms.empty();
                    }

                    var curLength = ms.getRawValue().length;
                    if(cfg.expandOnFocus === true){
                        ms.expand();
                    }

                    if(_selection.length === cfg.maxSelection) {
                        self._updateHelper(cfg.maxSelectionRenderer.call(this, _selection.length));
                    } else if(curLength < cfg.minChars) {
                        self._updateHelper(cfg.minCharsRenderer.call(this, cfg.minChars - curLength));
                    }

                    self._renderSelection();
                    $(ms).trigger('focus', [ms]);
                }
            },

            /**
             * Triggered when the user presses a key while the component has focus
             * This is where we want to handle all keys that don't require the user input field
             * since it hasn't registered the key hit yet
             * @param e keyEvent
             * @private
             */
            _onKeyDown: function(e) {
                // check how tab should be handled
                var active = ms.combobox.find('.tag-res-item-active:first'),
                    freeInput = ms.input.val() !== cfg.emptyText ? ms.input.val() : '';
                $(ms).trigger('keydown', [ms, e]);

                if(e.keyCode === 9 && (cfg.useTabKey === false ||
                    (cfg.useTabKey === true && active.length === 0 && ms.input.val().length === 0))) {
                    handlers._onBlur();
                    return;
                }
                switch(e.keyCode) {
                    case 8: //backspace
                        if(freeInput.length === 0 && ms.getSelectedItems().length > 0 && cfg.selectionPosition === 'inner') {
                            _selection.pop();
                            self._renderSelection();
                            $(ms).trigger('selectionchange', [ms, ms.getSelectedItems()]);
                            ms.input.focus();
                            e.preventDefault();
                        }
                        break;
                    case 9: // tab
                    case 188: // esc
                    case 13: // enter
                        e.preventDefault();
                        break;
                    case 17: // ctrl
                        _ctrlDown = true;
                        break;
                    case 40: // down
                        e.preventDefault();
                        self._moveSelectedRow("down");
                        break;
                    case 38: // up
                        e.preventDefault();
                        self._moveSelectedRow("up");
                        break;
                    default:
                        if(_selection.length === cfg.maxSelection) {
                            e.preventDefault();
                        }
                        break;
                }
            },

            /**
             * Triggered when a key is released while the component has focus
             * @param e
             * @private
             */
            _onKeyUp: function(e) {
                var freeInput = ms.getRawValue(),
                    inputValid = $.trim(ms.input.val()).length > 0 && ms.input.val() !== cfg.emptyText &&
                        (!cfg.maxEntryLength || $.trim(ms.input.val()).length <= cfg.maxEntryLength),
                    selected,
                    obj = {};

                $(ms).trigger('keyup', [ms, e]);

                clearTimeout(_timer);

                // collapse if escape, but keep focus.
                if(e.keyCode === 27 && cfg.expanded) {
                    ms.combobox.height(0);
                }
                // ignore a bunch of keys
                if((e.keyCode === 9 && cfg.useTabKey === false) || (e.keyCode > 13 && e.keyCode < 32)) {
                    if(e.keyCode === 17){
                        _ctrlDown = false;
                    }
                    return;
                }
                switch(e.keyCode) {
                    case 40:case 38: // up, down
                    e.preventDefault();
                    break;
                    case 13:case 9:case 188:// enter, tab, comma
                    if(e.keyCode !== 188 || cfg.useCommaKey === true) {
                        e.preventDefault();
                        if(cfg.expanded === true){ // if a selection is performed, select it and reset field
                            selected = ms.combobox.find('.tag-res-item-active:first');
                            if(selected.length > 0) {
                                self._selectItem(selected);
                                return;
                            }
                        }
                        // if no selection or if freetext entered and free entries allowed, add new obj to selection
                        if(inputValid === true && cfg.allowFreeEntries === true) {
                            obj[cfg.displayField] = obj[cfg.valueField] = freeInput;
                            ms.addToSelection(obj);
                            ms.collapse(); // reset combo suggestions
                            ms.input.focus();
                        }
                        break;
                    }
                    default:
                        if(_selection.length === cfg.maxSelection){
                            self._updateHelper(cfg.maxSelectionRenderer.call(this, _selection.length));
                        }
                        else {
                            if(freeInput.length < cfg.minChars) {
                                self._updateHelper(cfg.minCharsRenderer.call(this, cfg.minChars - freeInput.length));
                                if(cfg.expanded === true) {
                                    ms.collapse();
                                }
                            }
                            else if(cfg.maxEntryLength && freeInput.length > cfg.maxEntryLength) {
                                self._updateHelper(cfg.maxEntryRenderer.call(this, freeInput.length - cfg.maxEntryLength));
                                if(cfg.expanded === true) {
                                    ms.collapse();
                                }
                            }
                            else {
                                ms.helper.hide();
                                if(cfg.minChars <= freeInput.length){
                                    _timer = setTimeout(function() {
                                        if(cfg.expanded === true) {
                                            self._processSuggestions();
                                        } else {
                                            ms.expand();
                                        }
                                    }, cfg.typeDelay);
                                }
                            }
                        }
                        break;
                }
            },

            /**
             * Triggered when clicking upon cross for deletion
             * @param e
             * @private
             */
            _onTagTriggerClick: function(e) {
                ms.removeFromSelection($(e.currentTarget).data('json'));
            },

            /**
             * Triggered when clicking on the small trigger in the right
             * @private
             */
            _onTriggerClick: function() {
                if(ms.isDisabled() === false && !(cfg.expandOnFocus === true && _selection.length === cfg.maxSelection)) {
                    $(ms).trigger('triggerclick', [ms]);
                    if(cfg.expanded === true) {
                        ms.collapse();
                    } else {
                        var curLength = ms.getRawValue().length;
                        if(curLength >= cfg.minChars){
                            ms.input.focus();
                            ms.expand();
                        } else {
                            self._updateHelper(cfg.minCharsRenderer.call(this, cfg.minChars - curLength));
                        }
                    }
                }
            }
        };

        // startup point
        if(element !== null) {
            self._render(element);
        }
    };

    $.fn.tagSuggest = function(options) {
        var obj = $(this);

        if(obj.size() === 1 && obj.data('tagSuggest')) {
            return obj.data('tagSuggest');
        }

        obj.each(function(i) {
            // assume $(this) is an element
            var cntr = $(this);

            // Return early if this element already has a plugin instance
            if(cntr.data('tagSuggest')){
                return;
            }

            if(this.nodeName.toLowerCase() === 'select'){ // rendering from select
                options.data = [];
                options.value = [];
                $.each(this.children, function(index, child){
                    if(child.nodeName && child.nodeName.toLowerCase() === 'option'){
                        options.data.push({id: child.value, name: child.text});
                        if(child.selected){
                            options.value.push(child.value);
                        }
                    }
                });

            }

            var def = {};
            // set values from DOM container element
            $.each(this.attributes, function(i, att){
                def[att.name] = att.value;
            });
            var field = new TagSuggest(this, $.extend(options, def));
            cntr.data('tagSuggest', field);
            field.container.data('tagSuggest', field);
        });

        if(obj.size() === 1) {
            return obj.data('tagSuggest');
        }
        return obj;
    };

//    $.fn.tagSuggest.defaults = {};
})(jQuery);


    $(document).ready(function() 
    {
        var jsonData = [];
        var subgroup = "<?php echo trim($autosubgroup);?>";
        var fruits = subgroup.split(',');
        for(var i=0;i<fruits.length;i++) jsonData.push({id:i,name:fruits[i]});
        var tags = $('#tags').tagSuggest({
            data: jsonData,
            sortOrder: 'name',
            maxDropHeight: 500,
            name: 'tags',
        });

        $("#addSubCat").submit(function(e){
            
            var tag = $("input[name='tags']").val();
            console.log(tag);
            var tags = "";
            tag = JSON.parse(tag);
            console.log(tag);
            $.each(jsonData, function(index, obj)
            {
                console.log(tag.indexOf(obj.id));
                if( tag.indexOf(obj.id) != -1 )
                {
                    tags += (tags == '') ? '' : ',';
                    tags += obj.name;
                }
            });
            $('#selectedTags').val(tags);
            return true;
        });

    });

</script>
<link rel="stylesheet" href="{{{ asset('public/Trumbowyg-master/dist/ui/trumbowyg.min.css') }}}">
 @include('admin.topbottom')
 @endsection
