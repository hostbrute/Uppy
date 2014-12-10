{{ Form::model($album, ['url' => $url, 'method' => $method, 'class' => 'form-horizontal', 'files'=> true]) }}
<?php
?>
<div class="row">
	<div class="col-md-12">
		<fieldset>
			<legend>General</legend>
			<div class="form-group{{ $errors->has('name') ? ' has-error': ' ' }}">
				<label class="col-md-2 control-label" for="name">{{ trans('hostbrute/uppy::labels.albums.name') }}</label>
				<div class="col-md-10">
					{{ Form::text('name', null, array('id' => 'title', 'class' => 'form-control')) }}
					{{ $errors->first('name', '<p class="help-block error">:message</p>') }}
					<span class="help-block">{{ trans('hostbrute/uppy::help.albums.name')}}</span>
				</div>
			</div>
		</fieldset>
	<fieldset>
		<legend>Pictures</legend>
		<div class="form-group{{ $errors->has('pictures') ? ' has-error': ' ' }}">
			<label class="col-md-2 control-label" for="title">{{ trans('hostbrute/uppy::labels.albums.pictures') }}</label>
			<div class="col-md-10">
				{{ Form::select2('pictures', $pictures, ['sortable'	=> 1,'multiple' => 1, 'url' => URL::route('picture-select')]) }}
				{{ $errors->first('pictures', '<p class="help-block error">:message</p>') }}
				<span class="help-block">{{ trans('hostbrute/uppy::help.albums.pictures')}}</span>
			</div>
		</div>
	</fieldset>
	</div>

</div>
<div class="row">
	<div class="col-md-10 col-md-offset-2 btn-group">
		<button type="submit"  class="btn btn-primary">Save</button>
	</div>
</div>

{{ Form::close() }}
