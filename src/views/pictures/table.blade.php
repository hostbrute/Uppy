
<div class="row">
	<div class="col-md-12">
		<table class="table table-striped table-bordered">
			<thead>
			<tr>
				<th class="col-md-8">Title</th>
				<th class="col-md-2">Thumbnail</th>
				<th class="th-actions col-md-2">&nbsp;</th>
			</tr>
			</thead>
			<tbody>
			@if ($pictures->isEmpty())
			<tr>
				<td colspan="3">No records at the moment.</td>
			</tr>
			@else
			@foreach ($pictures as $picture)
			<tr>
				<td> <b>{{{ $picture->name }}}</b> <br>
					link: {{ $picture->file->url()}}
				</td>
				<td>  <img src="{{ $picture->file->url('thumbnail')}}"/>
				</td>
				<td>
					<div class="btn-group">
                        <a href="{{ $urls['edit']($picture->id) }}" class="btn btn-primary">
						Edit
						</a>

						<a href="{{ $urls['delete']($picture->id) }}" class="btn  btn-danger">
						Delete
						</a>

					</div>
				</td>
			</tr>
			@endforeach
			@endif
			</tbody>
		</table>

		{{ $pictures->links() }}
	</div>
</div>
