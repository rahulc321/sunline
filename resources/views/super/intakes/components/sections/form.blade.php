@php

$question_data = [];
if(isset($lead_data) && $lead_data->question_answer)
	{
		$question_data=$lead_data->question_answer->pluck('answer','question_id')->toArray();
	}
$question_data = (object) $question_data;

@endphp
<section id="Form" class="section" style="display:none;">
	<div class="card-header">
		<div class="row">
			<div class="col-6">
				<h5 class="card-title">Intake/Case Info <small><i class="far fa-question-circle" title="Click each tab to open it and see more details below."></i></small></h5>
			</div>
			<div class="col-6">
				@php
					$add_question_url = '';
					$contact_id = '';
					if(isset($contact_data) && !empty($contact_data))
						{
							$contact_id = $contact_data->id;
						}
				@endphp
				<div class="d-flex justify-content-end align-items-center">
					<a class="btn btn-primary me-2" href="{{route('admin.email.compose',['add_question_url'=>$add_question_url,'contact'=>$contact_id,'lead'=>$lead_data->id])}}" target="_blank" >Send Form</a>
					<button type="button" class="btn btn-primary me-2" href="javascript:;" data-bs-toggle="modal" data-bs-target="#popupCardDisplayFormLink" id="displayFormLink">Display Form Link</button>
					<button type="button" class="btn btn-primary me-2" href="javascript:;" data-bs-toggle="modal" data-bs-target="#popupCardPrintForm" id="printForm">Print Form</button>
				<div>
			</div>
		</div>
	</div>
	<div class="row">
	  <div class="col-md-12">
		  <div class="p-2 pt-3">
			<ul class="nav nav-tabs" role="tablist">
			  <li class="nav-item">
				<a class="nav-link active" data-bs-toggle="pill" href="#general_questions" role="tab" aria-controls="general_questions" aria-selected="true">General Questions</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link" data-bs-toggle="pill" href="#required_fields_e_sign" role="tab" aria-controls="required_fields_e_sign" aria-selected="true">Required Fields for E-Sign</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link" data-bs-toggle="pill" href="#migration_dnt" role="tab" aria-controls="migration_dnt" aria-selected="true">Migration - DO NOT TOUCH</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link" data-bs-toggle="pill" href="#general_case_questions" role="tab" aria-controls="general_case_questions" aria-selected="true">General Case Questions</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link" data-bs-toggle="pill" href="#additional_mt_questions" role="tab" aria-controls="additional_mt_questions" aria-selected="true">Additional MT Questions</a>
			  </li>
			</ul>
		  <div>
		  <div class="tab-content">
			<div class="tab-pane fade show active" id="general_questions" role="tabpanel">
				<div class="row mt-2 mb-2">
				  <div class="col-3">
					<label for="f_genque_client_type">New or Current Client</label>
					<input type="hidden" name="f_genque_client_type" class="form-control" value="{{old('f_genque_client_type',isset($question_data->f_genque_client_type) && $question_data->f_genque_client_type)}}" />
					@error('f_genque_client_type')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>	
				  <div class="col-3">
					<label for="f_genque_case_type">1. Type of Case</label>
					<select name="f_genque_case_type" class="form-control">
						<option value="">{{ trans('global.select') }}</option>
						@if(isset($intake_values['case_type']) && !empty($intake_values['case_type']))
							@foreach($intake_values['case_type'] as $key=>$value)
								<option @if(old('f_genque_case_type',isset($question_data->f_genque_case_type) && $question_data->f_genque_case_type!=''?$question_data->f_genque_case_type:$lead_data->case_type)==$key) selected @endif  value="{{$key}}">{{$value}}</option>
							@endforeach
						@endif
					</select>
					@error('f_genque_case_type')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				  <div class="col-3">
					<label for="f_genque_first_name">2. First Name</label>
					<input type="text" name="f_genque_first_name" class="form-control" value="{{old('f_genque_first_name',isset($question_data->f_genque_first_name) && $question_data->f_genque_first_name!=''?$question_data->f_genque_first_name:(isset($contact_data)?$contact_data->first_name:''))}}" />
					@error('f_genque_first_name')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				  <div class="col-3">
					<label for="f_genque_last_name">3. Last Name</label>
					<input type="text" name="f_genque_last_name" class="form-control" value="{{old('f_genque_last_name',isset($question_data->f_genque_last_name) && $question_data->f_genque_last_name !=''?$question_data->f_genque_last_name:(isset($contact_data)?$contact_data->last_name:''))}}" />
					@error('f_genque_last_name')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				</div>
				
				<div class="row mt-2 mb-2">
				  <div class="col-3">
					<label for="f_genque_phone">4. Cell Phone Number</label>
					<input type="text" name="f_genque_phone" class="form-control" value="{{old('f_genque_phone',isset($question_data->f_genque_phone) && $question_data->f_genque_phone !=''?$question_data->f_genque_phone:(isset($contact_data)?$contact_data->phone:''))}}" />
					@error('f_genque_phone')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>	
				  <div class="col-3">
					<label for="f_genque_alt_phone">5. Alternate Phone Number:</label>
					<input type="text" name="f_genque_alt_phone" class="form-control" value="{{old('f_genque_alt_phone',isset($question_data->f_genque_alt_phone) && $question_data->f_genque_alt_phone?$question_data->f_genque_alt_phone:'')}}" />
					@error('f_genque_alt_phone')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				  <div class="col-3">
					<label for="f_genque_address">6. Street Address:</label>
					<input type="text" name="f_genque_address" class="form-control" value="{{old('f_genque_address',isset($question_data->f_genque_address) && $question_data->f_genque_address?$question_data->f_genque_address:'')}}" />
					@error('f_genque_address')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				  <div class="col-3">
					<label for="f_genque_city">7. City</label>
					<input type="text" name="f_genque_city" class="form-control" value="{{old('f_genque_city',isset($question_data->f_genque_city) && $question_data->f_genque_city?$question_data->f_genque_city:'')}}" />
					@error('f_genque_city')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				</div>
				
				<div class="row mt-2 mb-2">
				  <div class="col-3">
					<label for="f_genque_state">8. State</label>
					<select name="f_genque_state" class="form-control">
						<option value="">Select</option>
					</select>
					@error('f_genque_state')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>	
				  <div class="col-3">
					<label for="f_genque_zip">9. Zip</label>
					<input type="text" name="f_genque_zip" class="form-control" value="{{old('f_genque_zip',isset($question_data->f_genque_zip) && $question_data->f_genque_zip?$question_data->f_genque_zip:'')}}" />
					@error('f_genque_zip')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				  <div class="col-3">
					<label for="f_genque_email">10. Email Address:</label>
					<input type="text" name="f_genque_email" class="form-control" value="{{old('f_genque_email',isset($question_data->f_genque_email) && $question_data->f_genque_email !=''?$question_data->f_genque_email:(isset($contact_data)?$contact_data->email:''))}}" />
					@error('f_genque_email')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				  <div class="col-3">
					<label for="f_genque_11">11. How Did You Hear About Us:</label>
					<input type="text" name="f_genque_11" class="form-control" value="{{old('f_genque_11',isset($question_data->f_genque_11) && $question_data->f_genque_11?$question_data->f_genque_11:'')}}" />
					@error('f_genque_11')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				</div>
				
				<div class="row mt-2 mb-2">
				  <div class="col-3">
					<label for="f_genque_12">12. Receiving: (IF YES, ASK IF IT&#39;S EARLY RETIREMENT) </label>
					<div class="form-check">
					  <input class="form-check-input" type="radio" name="f_genque_12" value="1" {{ isset($question_data->f_genque_12) && $question_data->f_genque_12 == '1' ? 'checked':'' }} >
					  <label class="form-check-label">
						Yes
					  </label>
					</div>
					<div class="form-check">
					  <input class="form-check-input" type="radio" name="f_genque_12" value="0" {{ isset($question_data->f_genque_12) && $question_data->f_genque_12 == '0' ? 'checked':'' }} >
					  <label class="form-check-label">
						No
					  </label>
					</div>
					@error('f_genque_12')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>	
				  <div class="col-3">
					<label for="f_genque_13">13. What are they receiving? How much?</label>
					<input type="text" name="f_genque_13" class="form-control" value="{{old('f_genque_13',isset($question_data->f_genque_13) && $question_data->f_genque_13?$question_data->f_genque_13:'')}}" />
					@error('f_genque_13')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				  <div class="col-3">
					<label for="f_genque_14">14. Applied for SSD Before:</label>
					<div class="form-check">
					  <input class="form-check-input" type="radio" name="f_genque_14" value="1" {{ isset($question_data->f_genque_14) && $question_data->f_genque_14 == '1' ? 'checked':'' }} >
					  <label class="form-check-label">
						Yes
					  </label>
					</div>
					<div class="form-check">
					  <input class="form-check-input" type="radio" name="f_genque_14" value="0" {{ isset($question_data->f_genque_14) && $question_data->f_genque_14 == '0' ? 'checked':'' }} >
					  <label class="form-check-label">
						No
					  </label>
					</div>
					@error('f_genque_14')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				  <div class="col-3">
					<label for="f_genque_15">15. Is case pending? Denied? What level? When?</label>
					<textarea type="text" name="f_genque_15" class="form-control">{{old('f_genque_15',isset($question_data->f_genque_15) && $question_data->f_genque_15?$question_data->f_genque_15:'')}}</textarea>
					@error('f_genque_15')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				</div>
				
				<div class="row mt-2 mb-2">
				  <div class="col-3">
					<label for="f_genque_16">16. Attorney: (IF CURRENT NC ATTORNEY, THEN REJECT)</label>
					<div class="form-check">
					  <input class="form-check-input" type="radio" name="f_genque_16" value="1" {{ isset($question_data->f_genque_16) && $question_data->f_genque_16 == '1' ? 'checked':'' }} >
					  <label class="form-check-label">
						Yes
					  </label>
					</div>
					<div class="form-check">
					  <input class="form-check-input" type="radio" name="f_genque_16" value="0" {{ isset($question_data->f_genque_16) && $question_data->f_genque_16 == '0' ? 'checked':'' }} >
					  <label class="form-check-label">
						No
					  </label>
					</div>
					@error('f_genque_16')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>	
				  <div class="col-3">
					<label for="f_genque_17">17. Are you currently working?</label>
					<div class="form-check">
					  <input class="form-check-input" type="radio" name="f_genque_17" value="1" {{ isset($question_data->f_genque_17) && $question_data->f_genque_17 == '1' ? 'checked':'' }} >
					  <label class="form-check-label">
						Yes
					  </label>
					</div>
					<div class="form-check">
					  <input class="form-check-input" type="radio" name="f_genque_17" value="0" {{ isset($question_data->f_genque_17) && $question_data->f_genque_17 == '0' ? 'checked':'' }} >
					  <label class="form-check-label">
						No
					  </label>
					</div>
					@error('f_genque_17')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				  <div class="col-3">
					<label for="f_genque_18">18. If Yes, How many hours per week?&nbsp;(IF OVER 8 HOURS A WEEK ON AVERAGE, REJECT)</label>
					<input type="text" name="f_genque_18" class="form-control" value="{{old('f_genque_18',isset($question_data->f_genque_18) && $question_data->f_genque_18?$question_data->f_genque_18:'')}}" />
					@error('f_genque_18')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				  <div class="col-3">
					<label for="f_genque_19">19. If No, What was the date of your last full time job?</label>
					<input type="text" name="f_genque_19" class="form-control" value="{{old('f_genque_19',isset($question_data->f_genque_19) && $question_data->f_genque_19?$question_data->f_genque_19:'')}}" />
					@error('f_genque_19')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				</div>
				
				<div class="row mt-2 mb-2">
				  <div class="col-3">
					<label for="f_genque_20">20. How many years have you worked (all added together), full time, in the last 10 years?</label>
					<input type="text" name="f_genque_20" class="form-control" value="{{old('f_genque_20',isset($question_data->f_genque_20) && $question_data->f_genque_20?$question_data->f_genque_20:'')}}" />
					@error('f_genque_20')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>	
				  <div class="col-3">
					<label for="f_genque_21">21. Do you have any household income? (IF YES, MAKE SURE THEY HAVE ALWAYS WORKED REGULARLY, WORKED 5/10 PAST YEARS, AND STOPPED WORKING WITHIN LAST 5 YRS)</label>
					<input type="text" name="f_genque_21" class="form-control" value="{{old('f_genque_21',isset($question_data->f_genque_21) && $question_data->f_genque_21?$question_data->f_genque_21:'')}}" />
					@error('f_genque_21')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				  <div class="col-3">
					<label for="f_genque_22">22. What type of work have You/The Client done in the past?</label>
					<input type="text" name="f_genque_22" class="form-control" value="{{old('f_genque_22',isset($question_data->f_genque_22) && $question_data->f_genque_22?$question_data->f_genque_22:'')}}" />
					@error('f_genque_22')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				  <div class="col-3">
					<label for="f_genque_23">23. Are You/The Client married or single?</label>
					<select name="f_genque_23" class="form-control">
						<option value="">Select</option>
					</select>
					@error('f_genque_23')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				</div>
				
				<div class="row mt-2 mb-2">
				  <div class="col-3">
					<label for="f_genque_24">24. Age: (IF OVER 50 TAKE IT ALWAYS, AND IF UNDER 50 MAKE SURE THEY HAVE CONDITIONS AND TREATMENT. IF A MINOR (UNDER 18, ASSIGN TO KATHLEEN/ELIZABETH FOR REVIEW)</label>
					<input type="text" name="f_genque_24" class="form-control" value="{{old('f_genque_24',isset($question_data->f_genque_24) && $question_data->f_genque_24?$question_data->f_genque_24:'')}}" />
					@error('f_genque_24')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>	
				  <div class="col-3">
					<label for="f_genque_25">25. Conditions:</label>
					<textarea type="text" name="f_genque_25" class="form-control">{{old('f_genque_25',isset($question_data->f_genque_25) && $question_data->f_genque_25?$question_data->f_genque_25:'')}}</textarea>
					@error('f_genque_25')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				  <div class="col-3">
					<label for="f_genque_26">26. Frequency of Treatment:</label>
					<input type="text" name="f_genque_26" class="form-control" value="{{old('f_genque_26',isset($question_data->f_genque_26) && $question_data->f_genque_26?$question_data->f_genque_26:'')}}" />
					@error('f_genque_26')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				  <div class="col-3">
					<label for="f_genque_27">27. Doctor Ordered:</label>
					<div class="form-check">
					  <input class="form-check-input" type="radio" name="f_genque_27" value="1" {{ isset($question_data->f_genque_27) && $question_data->f_genque_27 == '1' ? 'checked':'' }} >
					  <label class="form-check-label">
						Yes
					  </label>
					</div>
					<div class="form-check">
					  <input class="form-check-input" type="radio" name="f_genque_27" value="0" {{ isset($question_data->f_genque_27) && $question_data->f_genque_27 == '0' ? 'checked':'' }} >
					  <label class="form-check-label">
						No
					  </label>
					</div>
					@error('f_genque_27')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				</div>
				
				<div class="row mt-2 mb-2">
				  <div class="col-3">
					<label for="f_genque_28">28. Do you have more than 1 vehicle in your name?</label>
					<div class="form-check">
					  <input class="form-check-input" type="radio" name="f_genque_28" value="1" {{ isset($question_data->f_genque_28) && $question_data->f_genque_28 == '1' ? 'checked':'' }} >
					  <label class="form-check-label">
						Yes
					  </label>
					</div>
					<div class="form-check">
					  <input class="form-check-input" type="radio" name="f_genque_28" value="0" {{ isset($question_data->f_genque_28) && $question_data->f_genque_28 == '0' ? 'checked':'' }} >
					  <label class="form-check-label">
						No
					  </label>
					</div>
					@error('f_genque_28')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>	
				  <div class="col-3">
					<label for="f_genque_29">29. Do you have any bank accts/retirement accts/life insurance policies? If so, how much is in them/how much are they for?</label>
					<input type="text" name="f_genque_29" class="form-control" value="{{old('f_genque_29',isset($question_data->f_genque_29) && $question_data->f_genque_29?$question_data->f_genque_29:'')}}" />
					@error('f_genque_29')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				  <div class="col-3">
					<label for="f_genque_30">30. Do you have any history of drug or alcohol abuse? If so, are you clean and sober now? If so, for how long?</label>
					<input type="text" name="f_genque_30" class="form-control" value="{{old('f_genque_30',isset($question_data->f_genque_30) && $question_data->f_genque_30?$question_data->f_genque_30:'')}}" />
					@error('f_genque_30')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				  <div class="col-3">
					<label for="f_genque_31">31. Have you spent any time in jail or prison? Do you have any pending charges?</label>
					<input type="text" name="f_genque_31" class="form-control" value="{{old('f_genque_31',isset($question_data->f_genque_31) && $question_data->f_genque_31?$question_data->f_genque_31:'')}}" />
					@error('f_genque_31')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				</div>
				
				<div class="row mt-2 mb-2">
				  <div class="col-3">
					<label for="f_genque_32">32. Have you had any Workers Compensation or Short or Long Term Disability Claims before?</label>
					<input type="text" name="f_genque_32" class="form-control" value="{{old('f_genque_32',isset($question_data->f_genque_32) && $question_data->f_genque_32?$question_data->f_genque_32:'')}}" />
					@error('f_genque_32')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>	
				  <div class="col-3">
					<label for="f_genque_33">33. Additional Notes</label>
					<textarea type="text" name="f_genque_33" class="form-control">{{old('f_genque_33',isset($question_data->f_genque_33) && $question_data->f_genque_33?$question_data->f_genque_33:'')}}</textarea>
					@error('f_genque_33')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				  <div class="col-3">
					<label for="f_genque_34">34. GCLID</label>
					<textarea type="text" name="f_genque_34" class="form-control">{{old('f_genque_34',isset($question_data->f_genque_34) && $question_data->f_genque_34?$question_data->f_genque_34:'')}}</textarea>
					@error('f_genque_34')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				  <div class="col-3">
					<label for="f_genque_35">35. Do you own any property you DON'T live on?</label>
					<div class="form-check">
					  <input class="form-check-input" type="radio" name="f_genque_35" value="1" {{ isset($question_data->f_genque_35) && $question_data->f_genque_35 == '1' ? 'checked':'' }} >
					  <label class="form-check-label">
						Yes
					  </label>
					</div>
					<div class="form-check">
					  <input class="form-check-input" type="radio" name="f_genque_35" value="0" {{ isset($question_data->f_genque_35) && $question_data->f_genque_35 == '0' ? 'checked':'' }} >
					  <label class="form-check-label">
						No
					  </label>
					</div>
					@error('f_genque_35')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				</div>
			</div>
			<div class="tab-pane fade" id="required_fields_e_sign" role="tabpanel">
				<div class="row mt-2 mb-2">
				  <div class="col-3">
					<label for="f_esign_first_name">1. Full Name</label>
					<div class="row mt-2 mb-2">
					  <div class="col-4">
						<input type="text" name="f_esign_first_name" class="form-control" value="{{old('f_esign_first_name',isset($question_data->f_esign_first_name) && $question_data->f_esign_first_name !=''?$question_data->f_esign_first_name:(isset($contact_data)?$contact_data->first_name:''))}}" />
						@error('f_esign_first_name')
							<div class="error text-danger">{{$message}}</div>
						@enderror
					  </div>
					  <div class="col-4">
						<input type="text" name="f_esign_middle_name" class="form-control" value="{{old('f_esign_middle_name',isset($question_data->f_esign_middle_name) && $question_data->f_esign_middle_name?$question_data->f_esign_middle_name:'')}}" />
						@error('f_esign_middle_name')
							<div class="error text-danger">{{$message}}</div>
						@enderror
					  </div>
					  <div class="col-4">
						<input type="text" name="f_esign_last_name" class="form-control" value="{{old('f_esign_last_name',isset($question_data->f_esign_last_name) && $question_data->f_esign_last_name !=''?$question_data->f_esign_last_name:(isset($contact_data)?$contact_data->last_name:''))}}" />
						@error('f_esign_last_name')
							<div class="error text-danger">{{$message}}</div>
						@enderror
					  </div>
					</div>
				  </div>	
				  <div class="col-3">
					<label for="f_esign_mail_address">2. Mailing Address 1</label>
					<input type="text" name="f_esign_mail_address" class="form-control" value="{{old('f_esign_mail_address',isset($question_data->f_esign_mail_address) && $question_data->f_esign_mail_address?$question_data->f_esign_mail_address:'')}}" />
					@error('f_esign_mail_address')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				  <div class="col-3">
					<label for="f_esign_city">3. City</label>
					<input type="text" name="f_esign_city" class="form-control" value="{{old('f_esign_city',isset($question_data->f_esign_city) && $question_data->f_esign_city?$question_data->f_esign_city:'')}}" />
					@error('f_esign_city')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				  <div class="col-3">
					<label for="f_esign_state">4. State</label>
					<select name="f_esign_state" class="form-control">
						<option value="">Select</option>
					</select>
					@error('f_esign_state')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				</div>
				
				<div class="row mt-2 mb-2">
				  <div class="col-3">
					<label for="f_esign_zip">5. ZIP</label>
					<input type="text" name="f_esign_zip" class="form-control" value="{{old('f_esign_zip',isset($question_data->f_esign_zip) && $question_data->f_esign_zip?$question_data->f_esign_zip:'')}}" />
					@error('f_esign_zip')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>	
				  <div class="col-3">
					<label for="f_esign_dob">6. Date of Birth (Value must be a date)</label>
					<input type="date" name="f_esign_dob" class="form-control" value="{{old('f_esign_dob',isset($question_data->f_esign_dob) && $question_data->f_esign_dob?$question_data->f_esign_dob:'')}}" />
					@error('f_esign_dob')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				  <div class="col-3">
					<label for="f_esign_phone">7. Cell Phone</label>
					<input type="text" name="f_esign_phone" class="form-control" value="{{old('f_esign_phone',isset($question_data->f_esign_phone) && $question_data->f_esign_phone !=''?$question_data->f_esign_phone:'$contact_data->phone')}}" />
					@error('f_esign_phone')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				  <div class="col-3">
					<label for="f_esign_ssn">8. SSN#</label>
					<input type="text" name="f_esign_ssn" class="form-control" value="{{old('f_esign_ssn',isset($question_data->f_esign_ssn) && $question_data->f_esign_ssn?$question_data->f_esign_ssn:'')}}" />
					@error('f_esign_ssn')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				</div>
				
				<div class="row mt-2 mb-2">
				  <div class="col-3">
					<label for="f_esign_ss1">9. SS1</label>
					<input type="text" name="f_esign_ss1" class="form-control" value="{{old('f_esign_ss1',isset($question_data->f_esign_ss1) && $question_data->f_esign_ss1?$question_data->f_esign_ss1:'')}}" />
					@error('f_esign_ss1')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>	
				  <div class="col-3">
					<label for="f_esign_ss2">10. SS2</label>
					<input type="text" name="f_esign_ss2" class="form-control" value="{{old('f_esign_ss2',isset($question_data->f_esign_ss2) && $question_data->f_esign_ss2?$question_data->f_esign_ss2:'')}}" />
					@error('f_esign_ss2')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				  <div class="col-3">
					<label for="f_esign_ss3">11. SS3</label>
					<input type="text" name="f_esign_ss3" class="form-control" value="{{old('f_esign_ss3',isset($question_data->f_esign_ss3) && $question_data->f_esign_ss3?$question_data->f_esign_ss3:'')}}" />
					@error('f_esign_ss3')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				  <div class="col-3">
					<label for="f_esign_ss4">12. SS4</label>
					<input type="text" name="f_esign_ss4" class="form-control" value="{{old('f_esign_ss4',isset($question_data->f_esign_ss4) && $question_data->f_esign_ss4?$question_data->f_esign_ss4:'')}}" />
					@error('f_esign_ss4')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				</div>
				
				<div class="row mt-2 mb-2">
				  <div class="col-3">
					<label for="f_esign_ss5">13. SS5</label>
					<input type="text" name="f_esign_ss5" class="form-control" value="{{old('f_esign_ss5',isset($question_data->f_esign_ss5) && $question_data->f_esign_ss5?$question_data->f_esign_ss5:'')}}" />
					@error('f_esign_ss5')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>	
				  <div class="col-3">
					<label for="f_esign_ss6">14. SS6</label>
					<input type="text" name="f_esign_ss6" class="form-control" value="{{old('f_esign_ss6',isset($question_data->f_esign_ss6) && $question_data->f_esign_ss6?$question_data->f_esign_ss6:'')}}" />
					@error('f_esign_ss6')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				  <div class="col-3">
					<label for="f_esign_ss7">15. SS7</label>
					<input type="text" name="f_esign_ss7" class="form-control" value="{{old('f_esign_ss7',isset($question_data->f_esign_ss7) && $question_data->f_esign_ss7?$question_data->f_esign_ss7:'')}}" />
					@error('f_esign_ss7')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				  <div class="col-3">
					<label for="f_esign_ss8">16. SS8</label>
					<input type="text" name="f_esign_ss8" class="form-control" value="{{old('f_esign_ss8',isset($question_data->f_esign_ss8) && $question_data->f_esign_ss8?$question_data->f_esign_ss8:'')}}" />
					@error('f_esign_ss8')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				</div>
				
				<div class="row mt-2 mb-2">
				  <div class="col-3">
					<label for="f_esign_ss9">17. SS9</label>
					<input type="text" name="f_esign_ss9" class="form-control" value="{{old('f_esign_ss9',isset($question_data->f_esign_ss9) && $question_data->f_esign_ss9?$question_data->f_esign_ss9:'')}}" />
					@error('f_esign_ss9')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				</div>
			</div>
			<div class="tab-pane fade" id="migration_dnt" role="tabpanel">
				<div class="row mt-2 mb-2">
				  <div class="col-3">
					<label for="f_migration_ncaseno">1. Needles Case Number:</label>
					<input type="text" name="f_migration_ncaseno" class="form-control" value="{{old('f_migration_ncaseno',isset($question_data->f_migration_ncaseno) && $question_data->f_migration_ncaseno?$question_data->f_migration_ncaseno:'')}}" />
					@error('f_migration_ncaseno')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>	
				  <div class="col-3">
					<label for="f_migration_lsso">2. Local SS Office</label>
					<input type="text" name="f_migration_lsso" class="form-control" value="{{old('f_migration_lsso',isset($question_data->f_migration_lsso) && $question_data->f_migration_lsso?$question_data->f_migration_lsso:'')}}" />
					@error('f_migration_lsso')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				  <div class="col-3">
					<label for="f_migration_dnt_odar">3. ODAR</label>
					<input type="text" name="f_migration_dnt_odar" class="form-control" value="{{old('f_migration_dnt_odar',isset($question_data->f_migration_dnt_odar) && $question_data->f_migration_dnt_odar?$question_data->f_migration_dnt_odar:'')}}" />
					@error('f_migration_dnt_odar')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				</div>
			</div>
			<div class="tab-pane fade" id="general_case_questions" role="tabpanel">
				<div class="row mt-2 mb-2">
				  <div class="col-3">
					<label for="f_gencaseque_client_type">New or Current Client:</label>
					<input type="text" name="f_gencaseque_client_type" class="form-control" value="{{old('f_gencaseque_client_type',isset($question_data->f_gencaseque_client_type) && $question_data->f_gencaseque_client_type?$question_data->f_gencaseque_client_type:'')}}" />
					@error('f_gencaseque_client_type')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>	
				  <div class="col-3">
					<label for="f_gencaseque_case_type">Type of Case:</label>
					<select name="f_gencaseque_case_type" class="form-control" >
						<option value="">Select</option>
					</select>
					@error('f_gencaseque_case_type')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				  <div class="col-3">
					<label for="f_gencaseque_first_name">First Name:</label>
					<input type="text" name="f_gencaseque_first_name" class="form-control" value="{{old('f_gencaseque_first_name',isset($question_data->f_gencaseque_first_name) && $question_data->f_gencaseque_first_name !=''?$question_data->f_gencaseque_first_name:(isset($contact_data)?$contact_data->first_name:''))}}" />
					@error('f_gencaseque_first_name')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				  <div class="col-3">
					<label for="f_gencaseque_last_name">Last Name:</label>
					<input type="text" name="f_gencaseque_last_name" class="form-control" value="{{old('f_gencaseque_last_name',isset($question_data->f_gencaseque_last_name) && $question_data->f_gencaseque_last_name !=''?$question_data->f_gencaseque_last_name:(isset($contact_data)?$contact_data->last_name:''))}}" />
					@error('f_gencaseque_last_name')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				</div>
				
				<div class="row mt-2 mb-2">
				  <div class="col-3">
					<label for="f_gencaseque_phone">Cell Phone Number:</label>
					<input type="text" name="f_gencaseque_phone" class="form-control" value="{{old('f_gencaseque_phone',isset($question_data->f_gencaseque_phone) && $question_data->f_gencaseque_phone !=''?$question_data->f_gencaseque_phone:(isset($contact_data)?$contact_data->phone:''))}}" />
					@error('f_gencaseque_phone')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>	
				  <div class="col-3">
					<label for="f_gencaseque_alt_phone">Alternate Phone Number:</label>
					<input type="text" name="f_gencaseque_alt_phone" class="form-control" value="{{old('f_gencaseque_alt_phone',isset($question_data->f_gencaseque_alt_phone) && $question_data->f_gencaseque_alt_phone?$question_data->f_gencaseque_alt_phone:'')}}" />
					@error('f_gencaseque_alt_phone')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				  <div class="col-3">
					<label for="f_gencaseque_address">Street Address:</label>
					<input type="text" name="f_gencaseque_address" class="form-control" value="{{old('f_gencaseque_address',isset($question_data->f_gencaseque_address) && $question_data->f_gencaseque_address?$question_data->f_gencaseque_address:'')}}" />
					@error('f_gencaseque_address')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				  <div class="col-3">
					<label for="f_gencaseque_city">City:</label>
					<input type="text" name="f_gencaseque_city" class="form-control" value="{{old('f_gencaseque_city',isset($question_data->f_gencaseque_city) && $question_data->f_gencaseque_city?$question_data->f_gencaseque_city:'')}}" />
					@error('f_gencaseque_city')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				</div>
				
				<div class="row mt-2 mb-2">
				  <div class="col-3">
					<label for="f_gencaseque_state">State:</label>
					<select name="f_gencaseque_state" class="form-control">
						<option value="">Select</option>
					</select>
					@error('f_gencaseque_state')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>	
				  <div class="col-3">
					<label for="f_gencaseque_zip">Zip:</label>
					<input type="text" name="f_gencaseque_zip" class="form-control" value="{{old('f_gencaseque_zip',isset($question_data->f_gencaseque_zip) && $question_data->f_gencaseque_zip?$question_data->f_gencaseque_zip:'')}}" />
					@error('f_gencaseque_zip')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				  <div class="col-3">
					<label for="f_gencaseque_email">Email Address:</label>
					<input type="text" name="f_gencaseque_email" class="form-control" value="{{old('f_gencaseque_email',isset($question_data->f_gencaseque_email) && $question_data->f_gencaseque_email !=''?$question_data->f_gencaseque_email:(isset($contact_data)?$contact_data->email:''))}}" />
					@error('f_gencaseque_email')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				  <div class="col-3">
					<label for="f_gencaseque_11">How Did You Hear About Us:</label>
					<input type="hidden" name="f_gencaseque_11" value="{{isset($question_data->f_gencaseque_11) && $question_data->f_gencaseque_11?$question_data->f_gencaseque_11:''}}">
					<select class="form-control" readonly disabled style="cursor:pointer;">
						<option value="">Select</option>
						@if(isset($intake_values['marketing_source']) && !empty($intake_values['marketing_source']))
							@foreach($intake_values['marketing_source'] as $options)
								<option @if(old('f_gencaseque_11',isset($question_data->f_gencaseque_11) && $question_data->f_gencaseque_11!=''?$question_data->f_gencaseque_11:$lead_data->marketing_source)==$options->id) selected @endif value="{{$options->id}}" >{{$options->value}}</option>
							@endforeach
						@endif
					</select>
					@error('f_gencaseque_11')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				</div>
				
				<div class="row mt-2 mb-2">
				  <div class="col-3">
					<label for="f_gencaseque_12">Receiving: (IF YES, ASK IF ITS EARLY RETIREMENT)</label>
					<input type="text" name="f_gencaseque_12" class="form-control" value="{{old('f_gencaseque_12',isset($question_data->f_gencaseque_12) && $question_data->f_gencaseque_12?$question_data->f_gencaseque_12:'')}}" />
					@error('f_gencaseque_12')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>	
				  <div class="col-3">
					<label for="f_gencaseque_14">Applied for SSD Before:</label>
					<input type="text" name="f_gencaseque_14" class="form-control" value="{{old('f_gencaseque_14',isset($question_data->f_gencaseque_14) && $question_data->f_gencaseque_14?$question_data->f_gencaseque_14:'')}}" />
					@error('f_gencaseque_14')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				  <div class="col-3">
					<label for="f_gencaseque_15">Attorney:  (IF CURRENT NC ATTY,  THEN REJECT)</label>
					<input type="text" name="f_gencaseque_15" class="form-control" value="{{old('f_gencaseque_15',isset($question_data->f_gencaseque_15) && $question_data->f_gencaseque_15?$question_data->f_gencaseque_15:'')}}" />
					@error('f_gencaseque_15')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				  <div class="col-3">
					<label for="f_gencaseque_16">Are you currently working?</label>
					<input type="text" name="f_gencaseque_16" class="form-control" value="{{old('f_gencaseque_16',isset($question_data->f_gencaseque_16) && $question_data->f_gencaseque_16?$question_data->f_gencaseque_16:'')}}" />
					@error('f_gencaseque_16')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				</div>
				
				<div class="row mt-2 mb-2">
				  <div class="col-3">
					<label for="f_gencaseque_17">If Yes, How many hours per week?  (IF OVER 8 HOURS A WEEK ON AVERAGE, REJECT)</label>
					<input type="text" name="f_gencaseque_17" class="form-control" value="{{old('f_gencaseque_17',isset($question_data->f_gencaseque_17) && $question_data->f_gencaseque_17?$question_data->f_gencaseque_17:'')}}" />
					@error('f_gencaseque_17')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>	
				  <div class="col-3">
					<label for="f_gencaseque_18">If No, What was the date of your last full time job?</label>
					<input type="text" name="f_gencaseque_18" class="form-control" value="{{old('f_gencaseque_18',isset($question_data->f_gencaseque_18) && $question_data->f_gencaseque_18?$question_data->f_gencaseque_18:'')}}" />
					@error('f_gencaseque_18')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				  <div class="col-3">
					<label for="f_gencaseque_19">Do you have any household income?</label>
					<input type="text" name="f_gencaseque_19" class="form-control" value="{{old('f_gencaseque_19',isset($question_data->f_gencaseque_19) && $question_data->f_gencaseque_19?$question_data->f_gencaseque_19:'')}}" />
					@error('f_gencaseque_19')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				  <div class="col-3">
					<label for="f_gencaseque_20">What type of work have You/The Client done in the past?</label>
					<input type="text" name="f_gencaseque_20" class="form-control" value="{{old('f_gencaseque_20',isset($question_data->f_gencaseque_20) && $question_data->f_gencaseque_20?$question_data->f_gencaseque_20:'')}}" />
					@error('f_gencaseque_20')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				</div>
				
				<div class="row mt-2 mb-2">
				  <div class="col-3">
					<label for="f_gencaseque_21">Are You/The Client married or single?</label>
					<input type="text" name="f_gencaseque_21" class="form-control" value="{{old('f_gencaseque_21',isset($question_data->f_gencaseque_21) && $question_data->f_gencaseque_21?$question_data->f_gencaseque_21:'')}}" />
					@error('f_gencaseque_21')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>	
				  <div class="col-3">
					<label for="f_gencaseque_22">Age: (IF OVER 50 TAKE IT ALWAYS, AND IF UNDER 50 MAKE SURE THEY HAVE CONDITIONS AND TREATMENT)</label>
					<input type="text" name="f_gencaseque_22" class="form-control" value="{{old('f_gencaseque_22',isset($question_data->f_gencaseque_22) && $question_data->f_gencaseque_22?$question_data->f_gencaseque_22:'')}}" />
					@error('f_gencaseque_22')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				  <div class="col-3">
					<label for="f_gencaseque_23">Conditions:</label>
					<input type="text" name="f_gencaseque_23" class="form-control" value="{{old('f_gencaseque_23',isset($question_data->f_gencaseque_23) && $question_data->f_gencaseque_23?$question_data->f_gencaseque_23:'')}}" />
					@error('f_gencaseque_23')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				  <div class="col-3">
					<label for="f_gencaseque_24">Frequency of Treatment:</label>
					<input type="text" name="f_gencaseque_24" class="form-control" value="{{old('f_gencaseque_24',isset($question_data->f_gencaseque_24) && $question_data->f_gencaseque_24?$question_data->f_gencaseque_24:'')}}" />
					@error('f_gencaseque_24')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				</div>
				
				<div class="row mt-2 mb-2">
				  <div class="col-3">
					<label for="f_gencaseque_25">Doctor Ordered:</label>
					<input type="text" name="f_gencaseque_25" class="form-control" value="{{old('f_gencaseque_25',isset($question_data->f_gencaseque_25) && $question_data->f_gencaseque_25?$question_data->f_gencaseque_25:'')}}" />
					@error('f_gencaseque_25')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>	
				  <div class="col-3">
					<label for="f_gencaseque_26">Do you have more than 1 vehicle in your name?</label>
					<input type="text" name="f_gencaseque_26" class="form-control" value="{{old('f_gencaseque_26',isset($question_data->f_gencaseque_26) && $question_data->f_gencaseque_26?$question_data->f_gencaseque_26:'')}}" />
					@error('f_gencaseque_26')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				  <div class="col-3">
					<label for="f_gencaseque_27">Is more than 1 piece of property (land/home) in your name?</label>
					<input type="text" name="f_gencaseque_27" class="form-control" value="{{old('f_gencaseque_27',isset($question_data->f_gencaseque_27) && $question_data->f_gencaseque_27?$question_data->f_gencaseque_27:'')}}" />
					@error('f_gencaseque_27')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				</div>
			</div>
			<div class="tab-pane fade" id="additional_mt_questions" role="tabpanel">
				<div class="row mt-2 mb-2">
				  <div class="col-3">
					<label for="f_additional_mtq_1">1. Have you had a hernia surgery where mesh was used?</label>
					<div class="form-check">
					  <input class="form-check-input" type="radio" name="f_additional_mtq_1" value="1" {{ isset($question_data->f_additional_mtq_1) && $question_data->f_additional_mtq_1 == '1' ? 'checked':'' }} >
					  <label class="form-check-label">
						Yes
					  </label>
					</div>
					<div class="form-check">
					  <input class="form-check-input" type="radio" name="f_additional_mtq_1" value="0" {{ isset($question_data->f_additional_mtq_1) && $question_data->f_additional_mtq_1 == '0' ? 'checked':'' }} >
					  <label class="form-check-label">
						No
					  </label>
					</div>
					@error('f_additional_mtq_1')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>	
				  <div class="col-3">
					<label for="f_additional_mtq_2">2. Did you have a revision surgery to remove the mesh?</label>
					<div class="form-check">
					  <input class="form-check-input" type="radio" name="f_additional_mtq_2" value="1" {{ isset($question_data->f_additional_mtq_2) && $question_data->f_additional_mtq_2 == '1' ? 'checked':'' }} >
					  <label class="form-check-label">
						Yes
					  </label>
					</div>
					<div class="form-check">
					  <input class="form-check-input" type="radio" name="f_additional_mtq_2" value="0" {{ isset($question_data->f_additional_mtq_2) && $question_data->f_additional_mtq_2 == '0' ? 'checked':'' }} >
					  <label class="form-check-label">
						No
					  </label>
					</div>
					@error('f_additional_mtq_2')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				  <div class="col-3">
					<label for="f_additional_mtq_3">3. Have you been diagnosed with ovarian or fallopian cancer?</label>
					<div class="form-check">
					  <input class="form-check-input" type="radio" name="f_additional_mtq_3" value="1" {{ isset($question_data->f_additional_mtq_3) && $question_data->f_additional_mtq_3 == '1' ? 'checked':'' }} >
					  <label class="form-check-label">
						Yes
					  </label>
					</div>
					<div class="form-check">
					  <input class="form-check-input" type="radio" name="f_additional_mtq_3" value="0" {{ isset($question_data->f_additional_mtq_3) && $question_data->f_additional_mtq_3 == '0' ? 'checked':'' }} >
					  <label class="form-check-label">
						No
					  </label>
					</div>
					@error('f_additional_mtq_3')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				  <div class="col-3">
					<label for="f_additional_mtq_4">4. Have you used talcum powder?</label>
					<div class="form-check">
					  <input class="form-check-input" type="radio" name="f_additional_mtq_4" value="1" {{ isset($question_data->f_additional_mtq_4) && $question_data->f_additional_mtq_4 == '1' ? 'checked':'' }} >
					  <label class="form-check-label">
						Yes
					  </label>
					</div>
					<div class="form-check">
					  <input class="form-check-input" type="radio" name="f_additional_mtq_4" value="0" {{ isset($question_data->f_additional_mtq_4) && $question_data->f_additional_mtq_4 == '0' ? 'checked':'' }} >
					  <label class="form-check-label">
						No
					  </label>
					</div>
					@error('f_additional_mtq_4')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				</div>
				
				<div class="row mt-2 mb-2">
				  <div class="col-3">
					<label for="f_additional_mtq_5">5. Have you taken Zantac and been diagnosed with cancer?</label>
					<div class="form-check">
					  <input class="form-check-input" type="radio" name="f_additional_mtq_5" value="1" {{ isset($question_data->f_additional_mtq_5) && $question_data->f_additional_mtq_5 == '1' ? 'checked':'' }} >
					  <label class="form-check-label">
						Yes
					  </label>
					</div>
					<div class="form-check">
					  <input class="form-check-input" type="radio" name="f_additional_mtq_5" value="0" {{ isset($question_data->f_additional_mtq_5) && $question_data->f_additional_mtq_5 == '0' ? 'checked':'' }} >
					  <label class="form-check-label">
						No
					  </label>
					</div>
					@error('f_additional_mtq_5')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>	
				  <div class="col-3">
					<label for="f_additional_mtq_6">6. Were you the victim of a serious auto accident in the past 3 years?</label>
					<div class="form-check">
					  <input class="form-check-input" type="radio" name="f_additional_mtq_6" value="1" {{ isset($question_data->f_additional_mtq_6) && $question_data->f_additional_mtq_6 == '1' ? 'checked':'' }} >
					  <label class="form-check-label">
						Yes
					  </label>
					</div>
					<div class="form-check">
					  <input class="form-check-input" type="radio" name="f_additional_mtq_6" value="0" {{ isset($question_data->f_additional_mtq_6) && $question_data->f_additional_mtq_6 == '0' ? 'checked':'' }} >
					  <label class="form-check-label">
						No
					  </label>
					</div>
					@error('f_additional_mtq_6')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				  <div class="col-3">
					<label for="f_additional_mtq_7">7. Would you like to speak with an attorney regarding this potential claim?</label>
					<div class="form-check">
					  <input class="form-check-input" type="radio" name="f_additional_mtq_7" value="1" {{ isset($question_data->f_additional_mtq_7) && $question_data->f_additional_mtq_7 == '1' ? 'checked':'' }} >
					  <label class="form-check-label">
						Yes
					  </label>
					</div>
					<div class="form-check">
					  <input class="form-check-input" type="radio" name="f_additional_mtq_7" value="0" {{ isset($question_data->f_additional_mtq_7) && $question_data->f_additional_mtq_7 == '0' ? 'checked':'' }} >
					  <label class="form-check-label">
						No
					  </label>
					</div>
					@error('f_additional_mtq_7')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				  <div class="col-3">
					<label for="f_additional_mtq_8">8. Have you ever served in the U.S. military?</label>
					<div class="form-check">
					  <input class="form-check-input" type="radio" name="f_additional_mtq_8" value="1" {{ isset($question_data->f_additional_mtq_8) && $question_data->f_additional_mtq_8 == '1' ? 'checked':'' }} >
					  <label class="form-check-label">
						Yes
					  </label>
					</div>
					<div class="form-check">
					  <input class="form-check-input" type="radio" name="f_additional_mtq_8" value="0" {{ isset($question_data->f_additional_mtq_8) && $question_data->f_additional_mtq_8 == '0' ? 'checked':'' }} >
					  <label class="form-check-label">
						No
					  </label>
					</div>
					@error('f_additional_mtq_8')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				</div>
				
				<div class="row mt-2 mb-2">
				  <div class="col-3">
					<label for="f_additional_mtq_9">9. Have you been diagnosed with tinnitus?</label>
					<div class="form-check">
					  <input class="form-check-input" type="radio" name="f_additional_mtq_9" value="1" {{ isset($question_data->f_additional_mtq_9) && $question_data->f_additional_mtq_9 == '1' ? 'checked':'' }} >
					  <label class="form-check-label">
						Yes
					  </label>
					</div>
					<div class="form-check">
					  <input class="form-check-input" type="radio" name="f_additional_mtq_9" value="0" {{ isset($question_data->f_additional_mtq_9) && $question_data->f_additional_mtq_9 == '0' ? 'checked':'' }} >
					  <label class="form-check-label">
						No
					  </label>
					</div>
					@error('f_additional_mtq_9')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>	
				  <div class="col-3">
					<label for="f_additional_mtq_10">10. What were your dates of service for each branch of the military you served in?</label>
					<input type="text" name="f_additional_mtq_10" class="form-control" value="{{old('f_additional_mtq_10',isset($question_data->f_additional_mtq_10) && $question_data->f_additional_mtq_10?$question_data->f_additional_mtq_10:'')}}" />
					@error('f_additional_mtq_10')
						<div class="error text-danger">{{$message}}</div>
					@enderror
				  </div>
				</div>
			</div>				  
		  </div>
	  </div>
	</div>
</section>