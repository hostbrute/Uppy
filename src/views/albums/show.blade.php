<div class="row">
@foreach($album->pictures as $picture)
	<div class="col-xs-3">
	<div class="thumbnail">
		<img class="img-responsive"  src="{{$picture->file->url('thumbnail')}}"/>
		<div clas="caption">
			<h4><span>{{$picture->name}}</span></h4>
		</div>
	</div>
	</div>
	@endforeach
</div>
<?php
$asset = \Orchestra\Support\Facades\Asset::container('header');
$asset->script('smoothzoom', 'http://kthornbloom.com/smoothzoom/js/smoothzoom.min.js', 'combined');
?>
<style>
/* Wrapper for image centering */
#lightwrap {
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    text-align:center;
    cursor:-webkit-zoom-out;
    cursor:-moz-zoom-out;
    z-index:999;
}
/* overlay covering website */
#lightbg {
    position:fixed;
    display:none;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(255, 255, 255, .9);
}
#lightwrap img {position:absolute;display:none;}
#lightzoomed {opacity:0;}
#off-screen {position: fixed;right:100%;opacity: 0;}
</style>
    <script type="text/javascript">
        $(window).load( function() {
            $('img').smoothZoom({
            	// Options go here
            });
        });
    </script>