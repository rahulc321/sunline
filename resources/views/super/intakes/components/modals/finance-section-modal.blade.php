<!-- Finance Section - Add Firm Modal  -->
<div class="modal fade" id="popupLeadFirmAdd" tabindex="-1" role="dialog" aria-labelledby="popupLeadFirmAdd" aria-hidden="true">
  <div class="modal-dialog" role="document">
	<div class="modal-content card card-primary">
	<form name="addFirmFinance" id="addFirmFinance" method="post" action="{{ route('admin.lead-firm.store') }}" enctype="multipart/form-data" >
	  @csrf
	  <div class="card-header">
		<h3 class="card-title">{{ trans('finance.add_firm') }}</h3>
		<button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <div class="card-body">
		<div class="row mt-2">
		  <div class="col-4">
			<label for="pop_firm_type">{{ trans('finance.firm_type') }} </label>
		  </div>
		  <div class="col-8">
			<select name="pop_firm_type" id="pop_firm_type" class="form-control">
				<option value="" >{{ trans('finance.all_firm') }}</option>
				@if(isset($firm_type_list) && !empty($firm_type_list))
					@foreach($firm_type_list as $key=>$value)
						<option value="{{$key}}" {{ (in_array($key, old('pop_firm_type', []))) ? 'selected' : '' }}>{{$value}}</option>
					@endforeach
				@endif
			</select>
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="pop_firm_name_id">{{ trans('finance.firm') }} </label>
		  </div>
		  <div class="col-8">
			<select name="pop_firm_name_id" id="pop_firm_name_id" class="form-control">
				<option value="" >{{ trans('finance.select_firm_name') }}</option>
				@if(isset($firm_list) && !empty($firm_list))
					@foreach($firm_list as $key=>$value)
						<option value="{{$key}}" {{ (in_array($key, old('pop_firm_name_id', []))) ? 'selected' : '' }}>{{$value}}</option>
					@endforeach
				@endif
			</select>
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="firm_percentage">{{ trans('finance.firm_percentage') }}</label>
		  </div>
		  <div class="col-8">
			<input type="text" name="firm_percentage" id="firm_percentage" readonly value="0"/>%
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="pop_firm_override_type">{{ trans('finance.override_type') }} </label>
		  </div>
		  <div class="col-8">
			<select name="pop_firm_override_type" id="pop_firm_override_type" class="form-control">
				<option value="" >{{ trans('global.select') }}</option>
				@if(isset($firm_override_type_list) && !empty($firm_override_type_list))
					@foreach($firm_override_type_list as $key=>$value)
						<option value="{{$key}}" {{ (in_array($key, old('pop_firm_override_type', []))) ? 'selected' : '' }}>{{$value}}</option>
					@endforeach
				@endif
			</select>
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="pop_firm_override_fee_share">{{ trans('finance.override_fee_share') }} %</label>
		  </div>
		  <div class="col-8">
			<input type="text" name="pop_firm_override_fee_share" id="pop_firm_override_fee_share" />%
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="pop_firm_aggrement_in_place">{{ trans('finance.firm_agreement_in_place') }} </label>
		  </div>
		  <div class="col-8">
			<select name="pop_firm_aggrement_in_place" id="pop_firm_aggrement_in_place" class="form-control">
				<option value="0" >{{ trans('global.no') }}</option>
				<option value="1" >{{ trans('global.yes') }}</option>
			</select>
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="pop_firm_referral_status">{{ trans('finance.referral_status') }} </label>
		  </div>
		  <div class="col-8">
			<select name="pop_firm_referral_status" id="pop_firm_referral_status" class="form-control">
				<option value="" >{{ trans('global.select') }}</option>
				@if(isset($firm_referral_status_list) && !empty($firm_referral_status_list))
					@foreach($firm_referral_status_list as $key=>$value)
						<option value="{{$key}}" {{ (in_array($key, old('pop_firm_referral_status', []))) ? 'selected' : '' }}>{{$value}}</option>
					@endforeach
				@endif
			</select>
		  </div>
		</div>
	</div>
	<div class="card-footer">
		<button type="submit" class="btn btn-primary" id="btnSaveFirm">{{ trans('global.save') }}</button>
		<button type="button" class="btn btn-secondary mx-1" data-bs-dismiss="modal" aria-label="Cancel" >{{ trans('global.cancel') }}</button>
	</div>
	</form>
	</div>
  </div>
</div>

<!-- Finance Section - Edit Firm Modal  -->
<div class="modal fade" id="popupLeadFirmEdit" tabindex="-1" role="dialog" aria-labelledby="popupLeadFirmEdit" aria-hidden="true">
  <div class="modal-dialog" role="document">
	<div class="modal-content card card-primary">
	<form name="editFirmFinance" id="editFirmFinance" method="post" action="{{ route('admin.lead-firm.firm_update') }}" enctype="multipart/form-data" >
	  @csrf
	  @method('POST')
	  <input type="hidden" name="epop_firm_id" id="epop_firm_id" />
	  <div class="card-header">
		<h3 class="card-title">{{ trans('finance.edit_firm') }}</h3>
		<button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <div class="card-body">
		<div class="row mt-2">
		  <div class="col-4">
			<label for="epop_firm_type">{{ trans('finance.firm_type') }} </label>
		  </div>
		  <div class="col-8">
			<select name="epop_firm_type" id="epop_firm_type" class="form-control">
				<option value="" >{{ trans('finance.all_firm') }}</option>
				@if(isset($firm_type_list) && !empty($firm_type_list))
					@foreach($firm_type_list as $key=>$value)
						<option value="{{$key}}" {{ (in_array($key, old('epop_firm_type', []))) ? 'selected' : '' }}>{{$value}}</option>
					@endforeach
				@endif
			</select>
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="epop_firm_name_id">{{ trans('finance.firm') }} </label>
		  </div>
		  <div class="col-8">
			<select name="epop_firm_name_id" id="epop_firm_name_id" class="form-control">
				<option value="" >{{ trans('finance.select_firm_name') }}</option>
				@if(isset($firm_list) && !empty($firm_list))
					@foreach($firm_list as $key=>$value)
						<option value="{{$key}}" {{ (in_array($key, old('epop_firm_name_id', []))) ? 'selected' : '' }}>{{$value}}</option>
					@endforeach
				@endif
			</select>
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="epop_firm_percentage">{{ trans('finance.firm_percentage') }}</label>
		  </div>
		  <div class="col-8">
			<input type="text" name="epop_firm_percentage" id="epop_firm_percentage" />%
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="epop_firm_override_type">{{ trans('finance.override_type') }} </label>
		  </div>
		  <div class="col-8">
			<select name="epop_firm_override_type" id="epop_firm_override_type" class="form-control">
				<option value="" >{{ trans('global.select') }}</option>
				@if(isset($firm_override_type_list) && !empty($firm_override_type_list))
					@foreach($firm_override_type_list as $key=>$value)
						<option value="{{$key}}" {{ (in_array($key, old('epop_firm_override_type', []))) ? 'selected' : '' }}>{{$value}}</option>
					@endforeach
				@endif
			</select>
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="epop_firm_override_fee_share">{{ trans('finance.override_fee_share') }} %</label>
		  </div>
		  <div class="col-8">
			<input type="text" name="epop_firm_override_fee_share" id="epop_firm_override_fee_share" />%
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="epop_firm_aggrement_in_place">{{ trans('finance.firm_agreement_in_place') }} </label>
		  </div>
		  <div class="col-8">
			<select name="epop_firm_aggrement_in_place" id="epop_firm_aggrement_in_place" class="form-control">
				<option value="0" >{{ trans('global.no') }}</option>
				<option value="1" >{{ trans('global.yes') }}</option>
			</select>
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="epop_firm_referral_status">{{ trans('finance.referral_status') }} </label>
		  </div>
		  <div class="col-8">
			<select name="epop_firm_referral_status" id="epop_firm_referral_status" class="form-control">
				<option value="" >{{ trans('global.select') }}</option>
				@if(isset($firm_referral_status_list) && !empty($firm_referral_status_list))
					@foreach($firm_referral_status_list as $key=>$value)
						<option value="{{$key}}" {{ (in_array($key, old('epop_firm_referral_status', []))) ? 'selected' : '' }}>{{$value}}</option>
					@endforeach
				@endif
			</select>
		  </div>
		</div>
	</div>
	<div class="card-footer">
		<button type="submit" class="btn btn-primary" id="btnUpdateFirm">{{ trans('finance.update_fee_share') }}</button>
		<button type="button" class="btn btn-secondary mx-1" data-bs-dismiss="modal" aria-label="Cancel" >{{ trans('global.cancel') }}</button>
	</div>
	</form>
	</div>
  </div>
</div>

<!-- Finance Section - Add Expense Modal  -->
<div class="modal fade" id="popupExpenseFinanceAdd" tabindex="-1" role="dialog" aria-labelledby="popupExpenseFinanceAdd" aria-hidden="true">
  <div class="modal-dialog" role="document">
	<div class="modal-content card card-primary">
	<form name="addExpenseFinance" id="addExpenseFinance" method="post" action="{{ route('admin.lead-expense.store') }}" enctype="multipart/form-data" >
	  @csrf
	  <div class="card-header">
		<h3 class="card-title">{{ trans('finance.add_expense') }}</h3>
		<button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <div class="card-body">
		<div class="row mt-2">
		  <div class="col-4">
			<label for="pop_cost_type">{{ trans('finance.cost_type') }} </label>
		  </div>
		  <div class="col-8">
			<select name="pop_cost_type" id="pop_cost_type" class="form-control">
				<option value="" >{{ trans('finance.all_firm') }}</option>
				@if(isset($cost_type_list) && !empty($cost_type_list))
					@foreach($cost_type_list as $key=>$value)
						<option value="{{$key}}" {{ (in_array($key, old('pop_cost_type', []))) ? 'selected' : '' }}>{{$value}}</option>
					@endforeach
				@endif
			</select>
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="pop_expense_date_issued">{{ trans('finance.date_issued') }} </label>
		  </div>
		  <div class="col-8">
			<input type="date" class="form-control" name="pop_expense_date_issued" id="pop_expense_date_issued" />
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="pop_expense_invoice_no">{{ trans('finance.invoice') }} # </label>
		  </div>
		  <div class="col-8">
			<input type="text" class="form-control" name="pop_expense_invoice_no" id="pop_expense_invoice_no" />
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="pop_expense_amount_billed">{{ trans('finance.amount_billed') }} </label>
		  </div>
		  <div class="col-8">
			<input type="text" class="form-control" name="pop_expense_amount_billed" id="pop_expense_amount_billed" />
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="pop_expense_qty">{{ trans('finance.qty') }} </label>
		  </div>
		  <div class="col-8">
			<input type="text" class="form-control" name="pop_expense_qty" id="pop_expense_qty" />
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="pop_expense_total">{{ trans('finance.total') }} </label>
		  </div>
		  <div class="col-8">
			<input type="text" class="form-control" name="pop_expense_total" id="pop_expense_total" />
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="pop_expense_category">{{ trans('finance.category') }} </label>
		  </div>
		  <div class="col-8">
			<select name="pop_expense_category" id="pop_expense_category" class="form-control">
				<option value="" >--{{ trans('finance.category') }}--</option>
				@if(isset($expense_category_list) && !empty($expense_category_list))
					@foreach($expense_category_list as $key=>$value)
						<option value="{{$key}}" {{ (in_array($key, old('pop_expense_category', []))) ? 'selected' : '' }}>{{$value}}</option>
					@endforeach
				@endif
			</select>
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="pop_expense_client_billable">{{ trans('finance.billable_to_client') }} <i class="far fa-question-circle" title="Some expenses are recoverable from a client. If you want to recover an expense, then you will want to turn this on. You could invoice the expense to the client or bill it against the case during a settlement."></i> </label>
		  </div>
		  <div class="col-8">
			<select name="pop_expense_client_billable" id="pop_expense_client_billable" class="form-control">
				<option value="0" >{{ trans('global.no') }}</option>
				<option value="1" >{{ trans('global.yes') }}</option>
			</select>
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-12">
			<textarea type="text" name="pop_expense_description" class="form-control" id="pop_expense_description" placeholder="Enter Description">{{old('pop_expense_description')}}</textarea>
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="pop_expense_document">{{ trans('finance.document') }}</label>
		  </div>
		  <div class="col-8">
			<input type="file" name="pop_expense_document" id="pop_expense_document" />
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="pop_expense_document_category_id">{{ trans('finance.document_category') }} </label>
		  </div>
		  <div class="col-8">
			<select name="pop_expense_document_category_id" id="pop_expense_document_category_id" class="form-control">
				<option value="" >--{{ trans('finance.category') }}--</option>
				@if(isset($document_category) && !empty($document_category))
					@foreach($document_category as $key=>$value)
						<option value="{{$key}}" {{ (in_array($key, old('pop_expense_document_category_id', []))) ? 'selected' : '' }}>{{$value}}</option>
					@endforeach
				@endif
			</select>
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="pop_expense_document_description">{{ trans('finance.document_description') }} </label>
		  </div>
		  <div class="col-8">
			<input type="text" class="form-control" name="pop_expense_document_description" id="pop_expense_document_description" />
		  </div>
		</div>
	</div>
	<div class="card-footer">
		<button type="submit" class="btn btn-primary" id="btnSaveExpense">{{ trans('global.save') }}</button>
		<button type="button" class="btn btn-secondary mx-1" data-bs-dismiss="modal" aria-label="Cancel" >{{ trans('global.cancel') }}</button>
	</div>
	</form>
	</div>
  </div>
</div>