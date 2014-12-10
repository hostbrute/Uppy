<div class="row">
	<div class="col-md-12">
		<table class="table table-striped table-bordered">
			<thead>
			<tr>
				<th class="col-md-10">Title</th>
				<th class="th-actions col-md-2">&nbsp;</th>
			</tr>
			</thead>
			<tbody>
			@if ($albums->isEmpty())
			<tr>
				<td colspan="2">No records at the moment.</td>
			</tr>
			@else
			@foreach ($albums as $album)
			<tr>
				<td> <b>{{{ $album->name }}}</b> <br>

				</td>

				<td>
					<div class="btn-group">
                        <a href="{{$urls['edit']($album->id) }}" class="btn btn-mini btn-primary">
						Edit
						</a>
						<a href="{{ $urls['delete']($album->id) }}" class="btn btn-mini btn-danger">
						Delete
						</a>

					</div>
				</td>
			</tr>
			@endforeach
			@endif
			</tbody>
		</table>

		{{ $albums->links() }}
	</div>
</div>
