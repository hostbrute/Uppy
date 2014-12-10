{{ Form::model($picture, ['url' => $url, 'method' => $method, 'class' => 'form-horizontal', 'files'=> true]) }}
<?php
?>
<div class="row">
	<div class="col-md-12">
		<fieldset>
			<legend>General</legend>
			<div class="form-group{{ $errors->has('name') ? ' has-error': ' ' }}">
				<label class="col-md-3 control-label" for="name">{{ trans('hostbrute/uppy::labels.pictures.name') }}</label>
				<div class="col-md-9">
					{{ Form::text('name', null, ['id' => 'title', 'class' => 'form-control']) }}
					{{ $errors->first('name', '<p class="help-block error">:message</p>') }}
					<span class="help-block">{{ trans('hostbrute/uppy::help.pictures.name')}}</span>
				</div>
			</div>
		</fieldset>
		<fieldset>
			<legend>File</legend>
			<div class="form-group{{ $errors->has('file') ? ' has-error': ' ' }}">
				<label class="col-md-3 control-label" for="title">{{ trans('hostbrute/uppy::labels.pictures.file') }}</label>
				<div class="col-md-9">
					{{ Form::file('file', null, ['id' => 'title', 'class' => 'form-control']) }}
					{{ $errors->first('file', '<p class="help-block error">:message</p>') }}
					<span class="help-block">{{ trans('hostbrute/uppy::help.pictures.file')}}</span>
				</div>
			</div>
		</fieldset>
	</div>

</div>
<div class="row">
	<div class="col-md-9 col-md-offset-3 btn-group">
		<button type="submit"  class="btn btn-primary">Save</button>
	</div>
</div>

{{ Form::close() }}
