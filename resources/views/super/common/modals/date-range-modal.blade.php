<!-- Date Range Modal  -->
<div class="modal fade" id="dateRangeModal" tabindex="-1" aria-labelledby="dateRangeModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="dateRangeModalLabel">{{ trans('global.select_date_range') }}</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
			</div>
			<form action="{{ $exportDataRoute ?? '' }}" method="POST">
				@csrf
				<div class="modal-body">
					<div class="mb-3">
						<label for="from_date" class="form-label">{{ trans('global.from_date') }}</label>
						<input type="date" class="form-control" id="from_date" name="from_date" required>
					</div>
					<div class="mb-3">
						<label for="to_date" class="form-label">{{ trans('global.to_date') }}</label>
						<input type="date" class="form-control" id="to_date" name="to_date" required>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('global.close') }}</button>
					<button type="submit" class="btn btn-primary" onclick="checkExportForm();">{{ trans('global.submit') }}</button>
				</div>
			</form>
		</div>
	</div>
</div>