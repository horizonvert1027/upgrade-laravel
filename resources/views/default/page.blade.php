@extends('layouts.multi')
<style>
.pagee{
    margin: 5% 2%;
}
</style>
@section('content') 
    <div class="container">
        <section>
            <div class="col-md-12">
                <div class="ibox mb35 mt35">
                        <div class="pagee">
                            <h1 style="font-size: 35px; margin-bottom: 5px">{{ $response->title }}</h1>
                         <?php echo html_entity_decode($response->content) ?>
                        </div>
                             
                </div>
            </div>
        </section>
   </div>               
@endsection