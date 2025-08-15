<section id="Finance" class="section" style="display:none;">
	<div class="card-header">
		<h5>
			<ul class="card-title nav nav-tabs" role="tablist">
			  <li class="nav-item">
				<a style="background-color:#f0f3f5; border-color:#f0f3f5;" class="nav-link active" data-bs-toggle="pill" href="#firm_and_fees_splits" role="tab" aria-controls="firm_and_fees_splits" aria-selected="true">{{ trans('finance.firm_and_fees_splits') }}</a>
			  </li>
			  <li>
				<span><a class="nav-link" href="javascript:;">|</a></span>
			  </li>
			  <li class="nav-item">
				<a style="background-color:#f0f3f5; border-color:#f0f3f5;" class="nav-link" data-bs-toggle="pill" href="#firm_expenses" role="tab" aria-controls="firm_expenses" aria-selected="true">{{ trans('finance.expenses') }}</a>
			  </li>
			</ul>
		</h5>
	</div>
	<div class="card-body">
		<div class="tab-content">
			<div style="padding:0px;" class="tab-pane fade show active" id="firm_and_fees_splits" role="tabpanel">
				<div class="row">
					<div class="col-12">
						<div class="card-header">
							<h6 class="card-title">{{ trans('finance.refer_a_case') }}<small>&nbsp;</small></h6>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-12">
									<h6 for="send_to_firm">{{ trans('finance.send_to_firm') }}</h6>
									<div class="row mb-3">
									  <div class="col-4">
										<select name="st_firm_type" id="st_firm_type" class="form-control">
										<option value="all" selected >{{ trans('finance.all_firm_type') }}</option>
										@if(isset($firm_type_list) && !empty($firm_type_list))
											@foreach($firm_type_list as $key=>$value)
												<option value="{{$key}}" {{ (in_array($key, old('st_firm_type', []))) ? 'selected' : '' }}>{{$value}}</option>
											@endforeach
										@endif
										</select>
									  </div>
									  <div class="col-4">
										<select name="st_firm_name" id="st_firm_name" class="form-control" >
										<option value="">{{ trans('finance.select_firm_name') }}</option>
										@if(isset($firm_list) && !empty($firm_list))
											@foreach($firm_list as $key=>$value)
												<option value="{{$key}}" {{ (in_array($key, old('st_firm_name', []))) ? 'selected' : '' }}>{{$value}}</option>
											@endforeach
										@endif
										</select>
									  </div>
									  <div class="col-4">
										<input type="text" class="btn btn-primary form-control" name="firm_send_it" id="firm_send_it" value="Send It">
									  </div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12">
								<div class="card-header">
									<div class="row">
										<div class="col-6">
											<h6 class="card-title">{{ trans('finance.firms_and_fee_splits') }}<small>&nbsp;</small></h6>
										</div>
										<div class="col-6">
											<div class="d-flex justify-content-end align-items-center">
												<button type="button" class="btn btn-primary float-right mr-1" href="javascript:;" data-bs-toggle="modal" data-bs-target="#popupLeadFirmAdd" id="addFirmFinanceBtn">{{ trans('finance.add_firm') }}</button>
											</div>
										</div>
									</div>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-12">
											<table class="table" id="jsGridFirms">
												<thead>
													<tr>					
														<th>{{ trans('finance.firm_type') }}</th>
														<th>{{ trans('finance.agreement') }}?</th>
														<th>{{ trans('finance.firm') }}</th>
														<th>{{ trans('finance.firm_fee_share') }} %</th>
														<th>{{ trans('finance.firm_flat_fee') }}</th>
														<th>{{ trans('finance.referral_firm_status') }}</th>
														<th>&nbsp;</th>
													</tr>
												</thead>
												<tbody>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div style="padding:0px;" class="tab-pane fade" id="firm_expenses" role="tabpanel">
				<div class="row">
					<div class="col-12">
						<div class="card-body">
							<div class="row">
								<div class="col-12">
									<div class="d-flex justify-content-end align-items-center mb-2">
										<button type="button" class="btn btn-primary float-right mr-1" href="javascript:;" data-bs-toggle="modal" data-bs-target="#popupExpenseFinanceAdd" id="addExpenseFinanceBtn">{{ trans('finance.add_expense') }}</button>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-12">
									<div class="row mb-3">
									  <div class="col-4">
										<label for="total_billed">{{ trans('finance.total_billed') }}:</label>
										<input type="text" class="form-control" name="total_billed" id="total_billed" value="0.00" />
									  </div>
									  <div class="col-4">
										<label for="total_unbilled">{{ trans('finance.total_unbilled') }}:</label>
										<input type="text" class="form-control" name="total_unbilled" id="total_unbilled" value="0.00" />
									  </div>
									</div>
								</div>
							</div>
							<div class="row align-items-center mb-2">
								<div class="col-2">
									<h6>{{ trans('finance.filters') }}</h6>
								</div>
								<div class="col-10">
									<div class="d-flex flex-nowrap">
										<div class="mx-2">
											<input class="checkbox" type="checkbox" name="pop_expanse_filter_list[]" id="efl_all" {{ (in_array($key, old('pop_expanse_filter_list', []))) ? 'checked' : '' }} > {{ trans('finance.all') }}
										</div>
										@php
											$expanse_filter_list = [
												'medical_bill' => 'Medical Bills',
												'lien_hold' => 'Liens/Holds',
											];
										@endphp
										@if(isset($expanse_filter_list) && !empty($expanse_filter_list))
											@foreach($expanse_filter_list as $key=>$value)
											<div class="mx-2">
												<input class="checkbox" type="checkbox" name="pop_expanse_filter_list[]" id="efl_{{$key}}" {{ (in_array($key, old('pop_expanse_filter_list', []))) ? 'checked' : '' }} > {{$value}}
											</div>
											@endforeach
										@endif
									</div>
								</div>
							</div>
							<div class="row align-items-center mb-2">
								<div class="col-2">
									<h6>{{ trans('finance.cost_types') }}</h6>
								</div>
								<div class="col-10">
									<div class="d-flex flex-wrap">
										<div class="mx-2">
											<input class="checkbox" type="checkbox" name="pop_cost_type_filter[]" id="ctf_all" {{ (in_array($key, old('pop_cost_type_filter', []))) ? 'checked' : '' }} > {{ trans('finance.all') }}
										</div>
										@if(isset($cost_type_filter_list) && !empty($cost_type_filter_list))
											@foreach($cost_type_filter_list as $key=>$value)
											<div class="mx-2">
												<input class="checkbox" type="checkbox" name="pop_cost_type_filter[]" id="ctf_{{$key}}" {{ (in_array($key, old('pop_cost_type_filter', []))) ? 'checked' : '' }} > {{$value}}
											</div>
											@endforeach
										@endif
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-12">
									<table class="table" id="jsGridExpense">
										<thead>
											<tr>					
												<th>{{ trans('finance.date') }}</th>
												<th>{{ trans('finance.vendor_name') }}</th>
												<th>{{ trans('finance.cost_type') }} <i class="far fa-question-circle" title="Hard costs are expenses due to a third-party vendor. Examples: experts, travel tickets, court filing fees, etc. Soft costs are expenses that are due to our firm. Examples: mileage, photocopies, paper, firm administrative fees, etc. In contingency cases, special damages are client debts or medical bills that the client is responsible to pay. These need special handling during a settlement since they are owed by the client, not the law firm. Special damages will not create vendor bills until a Settlement reaches Final Approval."></i></th>
												<th>{{ trans('finance.expense_category') }}</th>
												<th>{{ trans('finance.description') }}</th>
												<th>{{ trans('finance.lien') }}/{{ trans('finance.hold') }}</th>
												<th>{{ trans('finance.amount_billed') }} <i class="far fa-question-circle" title="This is where you will track your Accounts Receivable (A/R) which is the amount owed by a Customer to your firm for each expense, also known as the Customer Balance. For A/R, the Amount Billed is what you invoice each Customer for each expense. The Customer Balance of each expense can only be updated with Bank Transactions by paying, crediting or adjusting Customer Invoices or with LawPay. Only Bank Transactions will affect A/R, not Vendor Transactions."></i></th>
												<th>{{ trans('finance.unbilled') }}</th>
												<th>{{ trans('finance.vendor_balance') }} <i class="far fa-question-circle" title="The Vendor Balance for each expense is what the Settlement Wizard will pay each Vendor during settlements. Add Vendor Transactions during the case to keep it up to date for vendor payments, negotiations, reductions, and credits. Also, if you have the QuickBooks Online sync active, then the Vendor Balance will always sync from Legal CRM to QuickBooks."></i></th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>