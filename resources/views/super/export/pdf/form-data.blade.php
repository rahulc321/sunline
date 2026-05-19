<div id="Form" class="section">
	@php
		$question_data = [];
		if(isset($lead_data) && $lead_data->question_answer)
			{					$question_data=$lead_data->question_answer->pluck('answer','question_id')->toArray();
			}
		$question_data = (object) $question_data;
	@endphp
	<div class="row">
	  <div class="col-md-12">
			<div id="general_questions">
				<h2>General Questions</h2>
				<div class="row mt-2 mb-2">
				  <div class="col-3">
					<label for="f_genque_client_type">New or Current Client</label>
					@if(isset($question_data->f_genque_client_type) && $question_data->f_genque_client_type)
						<p>{{$question_data->f_genque_client_type}}</p>
					@endif
				  </div>	
				  <div class="col-3">
					<label for="f_genque_case_type">1. Type of Case</label>
					@if(isset($intake_values['case_type']) && !empty($intake_values['case_type']))
						@foreach($intake_values['case_type'] as $options)
							@if((isset($question_data->f_genque_case_type) && $question_data->f_genque_case_type!=''?$question_data->f_genque_case_type:$lead_data->case_type)==$options->id)
								<p>{{$options->value}}</p>
							@endif
						@endforeach
					@endif
				  </div>
				  <div class="col-3">
					<label for="f_genque_first_name">2. First Name</label>
					@if((isset($question_data->f_genque_first_name) && $question_data->f_genque_first_name!=''?$question_data->f_genque_first_name:(isset($contact_data)?$contact_data->first_name:'')))
						<p>{{(isset($question_data->f_genque_first_name) && $question_data->f_genque_first_name!=''?$question_data->f_genque_first_name:(isset($contact_data)?$contact_data->first_name:''))}}</p>
					@endif	
				  </div>
				  <div class="col-3">
					<label for="f_genque_last_name">3. Last Name</label>
					@if((isset($question_data->f_genque_last_name) && $question_data->f_genque_last_name !=''?$question_data->f_genque_last_name:(isset($contact_data)?$contact_data->last_name:'')))
						<p>{{(isset($question_data->f_genque_last_name) && $question_data->f_genque_last_name !=''?$question_data->f_genque_last_name:(isset($contact_data)?$contact_data->last_name:''))}}</p>
					@endif
				  </div>
				</div>
				
				<div class="row mt-2 mb-2">
				  <div class="col-3">
					<label for="f_genque_phone">4. Cell Phone Number</label>
					@if((isset($question_data->f_genque_phone) && $question_data->f_genque_phone !=''?$question_data->f_genque_phone:(isset($contact_data)?$contact_data->phone:'')))
						<p>{{(isset($question_data->f_genque_phone) && $question_data->f_genque_phone !=''?$question_data->f_genque_phone:(isset($contact_data)?$contact_data->phone:''))}}</p>
					@endif
				  </div>	
				  <div class="col-3">
					<label for="f_genque_alt_phone">5. Alternate Phone Number:</label>
					@if((isset($question_data->f_genque_alt_phone) && $question_data->f_genque_alt_phone?$question_data->f_genque_alt_phone:''))
						<p>{{(isset($question_data->f_genque_alt_phone) && $question_data->f_genque_alt_phone?$question_data->f_genque_alt_phone:'')}}</p>
					@endif
				  </div>
				  <div class="col-3">
					<label for="f_genque_address">6. Street Address:</label>
					@if((isset($question_data->f_genque_address) && $question_data->f_genque_address?$question_data->f_genque_address:''))
						<p>{{(isset($question_data->f_genque_address) && $question_data->f_genque_address?$question_data->f_genque_address:'')}}</p>
					@endif
				  </div>
				  <div class="col-3">
					<label for="f_genque_city">7. City</label>
					@if((isset($question_data->f_genque_city) && $question_data->f_genque_city?$question_data->f_genque_city:''))
						<p>{{(isset($question_data->f_genque_city) && $question_data->f_genque_city?$question_data->f_genque_city:'')}}</p>
					@endif
				  </div>
				</div>
				
				<div class="row mt-2 mb-2">
				  <div class="col-3">
					<label for="f_genque_state">8. State</label>
					<p>&nbsp;</p>
				  </div>	
				  <div class="col-3">
					<label for="f_genque_zip">9. Zip</label>
					@if((isset($question_data->f_genque_zip) && $question_data->f_genque_zip?$question_data->f_genque_zip:''))
						<p>{{(isset($question_data->f_genque_zip) && $question_data->f_genque_zip?$question_data->f_genque_zip:'')}}</p>
					@endif
				  </div>
				  <div class="col-3">
					<label for="f_genque_email">10. Email Address:</label>
					@if((isset($question_data->f_genque_email) && $question_data->f_genque_email !=''?$question_data->f_genque_email:(isset($contact_data)?$contact_data->email:'')))
						<p>{{(isset($question_data->f_genque_email) && $question_data->f_genque_email !=''?$question_data->f_genque_email:(isset($contact_data)?$contact_data->email:''))}}</p>
					@endif
				  </div>
				  <div class="col-3">
					<label for="f_genque_11">11. How Did You Hear About Us:</label>
					@if((isset($question_data->f_genque_11) && $question_data->f_genque_11?$question_data->f_genque_11:''))
						<p>{{(isset($question_data->f_genque_11) && $question_data->f_genque_11?$question_data->f_genque_11:'')}}</p>
					@endif
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
					@if((isset($question_data->f_genque_13) && $question_data->f_genque_13?$question_data->f_genque_13:''))
						<p>{{(isset($question_data->f_genque_13) && $question_data->f_genque_13?$question_data->f_genque_13:'')}}</p>
					@endif
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
					@if((isset($question_data->f_genque_15) && $question_data->f_genque_15?$question_data->f_genque_15:''))
						<p>{{(isset($question_data->f_genque_15) && $question_data->f_genque_15?$question_data->f_genque_15:'')}}</p>
					@endif
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
					@if((isset($question_data->f_genque_18) && $question_data->f_genque_18?$question_data->f_genque_18:''))
						<p>{{(isset($question_data->f_genque_18) && $question_data->f_genque_18?$question_data->f_genque_18:'')}}</p>
					@endif
				  </div>
				  <div class="col-3">
					<label for="f_genque_19">19. If No, What was the date of your last full time job?</label>
					@if((isset($question_data->f_genque_19) && $question_data->f_genque_19?$question_data->f_genque_19:''))
						<p>{{(isset($question_data->f_genque_19) && $question_data->f_genque_19?$question_data->f_genque_19:'')}}</p>
					@endif
				  </div>
				</div>
				
				<div class="row mt-2 mb-2">
				  <div class="col-3">
					<label for="f_genque_20">20. How many years have you worked (all added together), full time, in the last 10 years?</label>
					@if((isset($question_data->f_genque_20) && $question_data->f_genque_20?$question_data->f_genque_20:''))
						<p>{{(isset($question_data->f_genque_20) && $question_data->f_genque_20?$question_data->f_genque_20:'')}}</p>
					@endif
				  </div>	
				  <div class="col-3">
					<label for="f_genque_21">21. Do you have any household income? (IF YES, MAKE SURE THEY HAVE ALWAYS WORKED REGULARLY, WORKED 5/10 PAST YEARS, AND STOPPED WORKING WITHIN LAST 5 YRS)</label>
					@if((isset($question_data->f_genque_21) && $question_data->f_genque_21?$question_data->f_genque_21:''))
						<p>{{(isset($question_data->f_genque_21) && $question_data->f_genque_21?$question_data->f_genque_21:'')}}</p>
					@endif
				  </div>
				  <div class="col-3">
					<label for="f_genque_22">22. What type of work have You/The Client done in the past?</label>
					@if((isset($question_data->f_genque_22) && $question_data->f_genque_22?$question_data->f_genque_22:''))
						<p>{{(isset($question_data->f_genque_22) && $question_data->f_genque_22?$question_data->f_genque_22:'')}}</p>
					@endif
				  </div>
				  <div class="col-3">
					<label for="f_genque_23">23. Are You/The Client married or single?</label>
					<p>&nbsp;</p>
				  </div>
				</div>
				
				<div class="row mt-2 mb-2">
				  <div class="col-3">
					<label for="f_genque_24">24. Age: (IF OVER 50 TAKE IT ALWAYS, AND IF UNDER 50 MAKE SURE THEY HAVE CONDITIONS AND TREATMENT. IF A MINOR (UNDER 18, ASSIGN TO KATHLEEN/ELIZABETH FOR REVIEW)</label>
					@if((isset($question_data->f_genque_24) && $question_data->f_genque_24?$question_data->f_genque_24:''))
						<p>{{(isset($question_data->f_genque_24) && $question_data->f_genque_24?$question_data->f_genque_24:'')}}</p>
					@endif
				  </div>	
				  <div class="col-3">
					<label for="f_genque_25">25. Conditions:</label>
					@if((isset($question_data->f_genque_25) && $question_data->f_genque_25?$question_data->f_genque_25:''))
						<p>{{(isset($question_data->f_genque_25) && $question_data->f_genque_25?$question_data->f_genque_25:'')}}</p>
					@endif
				  </div>
				  <div class="col-3">
					<label for="f_genque_26">26. Frequency of Treatment:</label>
					@if((isset($question_data->f_genque_26) && $question_data->f_genque_26?$question_data->f_genque_26:''))
						<p>{{(isset($question_data->f_genque_26) && $question_data->f_genque_26?$question_data->f_genque_26:'')}}</p>
					@endif
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
					@if((isset($question_data->f_genque_29) && $question_data->f_genque_29?$question_data->f_genque_29:''))
						<p>{{(isset($question_data->f_genque_29) && $question_data->f_genque_29?$question_data->f_genque_29:'')}}</p>
					@endif
				  </div>
				  <div class="col-3">
					<label for="f_genque_30">30. Do you have any history of drug or alcohol abuse? If so, are you clean and sober now? If so, for how long?</label>
					@if((isset($question_data->f_genque_30) && $question_data->f_genque_30?$question_data->f_genque_30:''))
						<p>{{(isset($question_data->f_genque_30) && $question_data->f_genque_30?$question_data->f_genque_30:'')}}</p>
					@endif
				  </div>
				  <div class="col-3">
					<label for="f_genque_31">31. Have you spent any time in jail or prison? Do you have any pending charges?</label>
					@if((isset($question_data->f_genque_31) && $question_data->f_genque_31?$question_data->f_genque_31:''))
						<p>{{(isset($question_data->f_genque_31) && $question_data->f_genque_31?$question_data->f_genque_31:'')}}</p>
					@endif
				  </div>
				</div>
				
				<div class="row mt-2 mb-2">
				  <div class="col-3">
					<label for="f_genque_32">32. Have you had any Workers Compensation or Short or Long Term Disability Claims before?</label>
					@if((isset($question_data->f_genque_32) && $question_data->f_genque_32?$question_data->f_genque_32:''))
						<p>{{(isset($question_data->f_genque_32) && $question_data->f_genque_32?$question_data->f_genque_32:'')}}</p>
					@endif
				  </div>	
				  <div class="col-3">
					<label for="f_genque_33">33. Additional Notes</label>
					@if((isset($question_data->f_genque_33) && $question_data->f_genque_33?$question_data->f_genque_33:''))
						<p>{{(isset($question_data->f_genque_33) && $question_data->f_genque_33?$question_data->f_genque_33:'')}}</p>
					@endif
				  </div>
				  <div class="col-3">
					<label for="f_genque_34">34. GCLID</label>
					@if((isset($question_data->f_genque_34) && $question_data->f_genque_34?$question_data->f_genque_34:''))
						<p>{{(isset($question_data->f_genque_34) && $question_data->f_genque_34?$question_data->f_genque_34:'')}}</p>
					@endif
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
			<div id="required_fields_e_sign">
				<h2>Required Fields for E-Sign</h2>
				<div class="row mt-2 mb-2">
				  <div class="col-3">
					<label for="f_esign_first_name">1. Full Name</label>
					<div class="row mt-2 mb-2">
					  <div class="col-4">
						@if((isset($question_data->f_esign_first_name) && $question_data->f_esign_first_name !=''?$question_data->f_esign_first_name:(isset($contact_data)?$contact_data->first_name:'')))
							<p>{{(isset($question_data->f_esign_first_name) && $question_data->f_esign_first_name !=''?$question_data->f_esign_first_name:(isset($contact_data)?$contact_data->first_name:''))}}</p>
						@endif
					  </div>
					  <div class="col-4">
						@if((isset($question_data->f_esign_middle_name) && $question_data->f_esign_middle_name?$question_data->f_esign_middle_name:''))
							<p>{{(isset($question_data->f_esign_middle_name) && $question_data->f_esign_middle_name?$question_data->f_esign_middle_name:'')}}</p>
						@endif
					  </div>
					  <div class="col-4">
						@if((isset($question_data->f_esign_last_name) && $question_data->f_esign_last_name !=''?$question_data->f_esign_last_name:(isset($contact_data)?$contact_data->last_name:'')))
							<p>{{(isset($question_data->f_esign_last_name) && $question_data->f_esign_last_name !=''?$question_data->f_esign_last_name:(isset($contact_data)?$contact_data->last_name:''))}}</p>
						@endif
					  </div>
					</div>
				  </div>	
				  <div class="col-3">
					<label for="f_esign_mail_address">2. Mailing Address 1</label>
					@if((isset($question_data->f_esign_mail_address) && $question_data->f_esign_mail_address?$question_data->f_esign_mail_address:''))
						<p>{{(isset($question_data->f_esign_mail_address) && $question_data->f_esign_mail_address?$question_data->f_esign_mail_address:'')}}</p>
					@endif
				  </div>
				  <div class="col-3">
					<label for="f_esign_city">3. City</label>
					@if((isset($question_data->f_esign_city) && $question_data->f_esign_city?$question_data->f_esign_city:''))
						<p>{{(isset($question_data->f_esign_city) && $question_data->f_esign_city?$question_data->f_esign_city:'')}}</p>
					@endif
				  </div>
				  <div class="col-3">
					<label for="f_esign_state">4. State</label>
					<p>&nbsp;</p>
				  </div>
				</div>
				
				<div class="row mt-2 mb-2">
				  <div class="col-3">
					<label for="f_esign_zip">5. ZIP</label>
					@if((isset($question_data->f_esign_zip) && $question_data->f_esign_zip?$question_data->f_esign_zip:''))
						<p>{{(isset($question_data->f_esign_zip) && $question_data->f_esign_zip?$question_data->f_esign_zip:'')}}</p>
					@endif
				  </div>	
				  <div class="col-3">
					<label for="f_esign_dob">6. Date of Birth (Value must be a date)</label>
					@if((isset($question_data->f_esign_dob) && $question_data->f_esign_dob?$question_data->f_esign_dob:''))
						<p>{{(isset($question_data->f_esign_dob) && $question_data->f_esign_dob?$question_data->f_esign_dob:'')}}</p>
					@endif
				  </div>
				  <div class="col-3">
					<label for="f_esign_phone">7. Cell Phone</label>
					@if((isset($question_data->f_esign_phone) && $question_data->f_esign_phone !=''?$question_data->f_esign_phone:(isset($contact_data)?$contact_data->phone:'')))
						<p>{{(isset($question_data->f_esign_phone) && $question_data->f_esign_phone !=''?$question_data->f_esign_phone:(isset($contact_data)?$contact_data->phone:''))}}</p>
					@endif
				  </div>
				  <div class="col-3">
					<label for="f_esign_ssn">8. SSN#</label>
					@if((isset($question_data->f_esign_ssn) && $question_data->f_esign_ssn?$question_data->f_esign_ssn:''))
						<p>{{(isset($question_data->f_esign_ssn) && $question_data->f_esign_ssn?$question_data->f_esign_ssn:'')}}</p>
					@endif
				  </div>
				</div>
				
				<div class="row mt-2 mb-2">
				  <div class="col-3">
					<label for="f_esign_ss1">9. SS1</label>
					@if((isset($question_data->f_esign_ss1) && $question_data->f_esign_ss1?$question_data->f_esign_ss1:''))
						<p>{{(isset($question_data->f_esign_ss1) && $question_data->f_esign_ss1?$question_data->f_esign_ss1:'')}}</p>
					@endif
				  </div>	
				  <div class="col-3">
					<label for="f_esign_ss2">10. SS2</label>
					@if((isset($question_data->f_esign_ss2) && $question_data->f_esign_ss2?$question_data->f_esign_ss2:''))
						<p>{{(isset($question_data->f_esign_ss2) && $question_data->f_esign_ss2?$question_data->f_esign_ss2:'')}}</p>
					@endif
				  </div>
				  <div class="col-3">
					<label for="f_esign_ss3">11. SS3</label>
					@if((isset($question_data->f_esign_ss3) && $question_data->f_esign_ss3?$question_data->f_esign_ss3:''))
						<p>{{(isset($question_data->f_esign_ss3) && $question_data->f_esign_ss3?$question_data->f_esign_ss3:'')}}</p>
					@endif
				  </div>
				  <div class="col-3">
					<label for="f_esign_ss4">12. SS4</label>
					@if((isset($question_data->f_esign_ss4) && $question_data->f_esign_ss4?$question_data->f_esign_ss4:''))
						<p>{{(isset($question_data->f_esign_ss4) && $question_data->f_esign_ss4?$question_data->f_esign_ss4:'')}}</p>
					@endif
				  </div>
				</div>
				
				<div class="row mt-2 mb-2">
				  <div class="col-3">
					<label for="f_esign_ss5">13. SS5</label>
					@if((isset($question_data->f_esign_ss5) && $question_data->f_esign_ss5?$question_data->f_esign_ss5:''))
						<p>{{(isset($question_data->f_esign_ss5) && $question_data->f_esign_ss5?$question_data->f_esign_ss5:'')}}</p>
					@endif
				  </div>	
				  <div class="col-3">
					<label for="f_esign_ss6">14. SS6</label>
					@if((isset($question_data->f_esign_ss6) && $question_data->f_esign_ss6?$question_data->f_esign_ss6:''))
						<p>{{(isset($question_data->f_esign_ss6) && $question_data->f_esign_ss6?$question_data->f_esign_ss6:'')}}</p>
					@endif
				  </div>
				  <div class="col-3">
					<label for="f_esign_ss7">15. SS7</label>
					@if((isset($question_data->f_esign_ss7) && $question_data->f_esign_ss7?$question_data->f_esign_ss7:''))
						<p>{{(isset($question_data->f_esign_ss7) && $question_data->f_esign_ss7?$question_data->f_esign_ss7:'')}}</p>
					@endif
				  </div>
				  <div class="col-3">
					<label for="f_esign_ss8">16. SS8</label>
					@if((isset($question_data->f_esign_ss8) && $question_data->f_esign_ss8?$question_data->f_esign_ss8:''))
						<p>{{(isset($question_data->f_esign_ss8) && $question_data->f_esign_ss8?$question_data->f_esign_ss8:'')}}</p>
					@endif
				  </div>
				</div>
				
				<div class="row mt-2 mb-2">
				  <div class="col-3">
					<label for="f_esign_ss9">17. SS9</label>
					@if((isset($question_data->f_esign_ss9) && $question_data->f_esign_ss9?$question_data->f_esign_ss9:''))
						<p>{{(isset($question_data->f_esign_ss9) && $question_data->f_esign_ss9?$question_data->f_esign_ss9:'')}}</p>
					@endif
				  </div>
				</div>
			</div>
			<div id="migration_dnt">
				<h2>Migration - DO NOT TOUCH</h2>
				<div class="row mt-2 mb-2">
				  <div class="col-3">
					<label for="f_migration_ncaseno">1. Needles Case Number:</label>
					@if((isset($question_data->f_migration_ncaseno) && $question_data->f_migration_ncaseno?$question_data->f_migration_ncaseno:''))
						<p>{{(isset($question_data->f_migration_ncaseno) && $question_data->f_migration_ncaseno?$question_data->f_migration_ncaseno:'')}}</p>
					@endif
				  </div>	
				  <div class="col-3">
					<label for="f_migration_lsso">2. Local SS Office</label>
					@if((isset($question_data->f_migration_lsso) && $question_data->f_migration_lsso?$question_data->f_migration_lsso:''))
						<p>{{(isset($question_data->f_migration_lsso) && $question_data->f_migration_lsso?$question_data->f_migration_lsso:'')}}</p>
					@endif
				  </div>
				  <div class="col-3">
					<label for="f_migration_dnt_odar">3. ODAR</label>
					@if((isset($question_data->f_migration_dnt_odar) && $question_data->f_migration_dnt_odar?$question_data->f_migration_dnt_odar:''))
						<p>{{(isset($question_data->f_migration_dnt_odar) && $question_data->f_migration_dnt_odar?$question_data->f_migration_dnt_odar:'')}}</p>
					@endif
				  </div>
				</div>
			</div>
			<div id="general_case_questions">
				<h2>General Case Questions</h2>
				<div class="row mt-2 mb-2">
				  <div class="col-3">
					<label for="f_gencaseque_client_type">New or Current Client:</label>
					@if((isset($question_data->f_gencaseque_client_type) && $question_data->f_gencaseque_client_type?$question_data->f_gencaseque_client_type:''))
						<p>{{(isset($question_data->f_gencaseque_client_type) && $question_data->f_gencaseque_client_type?$question_data->f_gencaseque_client_type:'')}}</p>
					@endif
				  </div>	
				  <div class="col-3">
					<label for="f_gencaseque_case_type">Type of Case:</label>
					<p>&nbsp;</p>
				  </div>
				  <div class="col-3">
					<label for="f_gencaseque_first_name">First Name:</label>
					@if((isset($question_data->f_gencaseque_first_name) && $question_data->f_gencaseque_first_name !=''?$question_data->f_gencaseque_first_name:(isset($contact_data)?$contact_data->first_name:'')))
						<p>{{(isset($question_data->f_gencaseque_first_name) && $question_data->f_gencaseque_first_name !=''?$question_data->f_gencaseque_first_name:(isset($contact_data)?$contact_data->first_name:''))}}</p>
					@endif
				  </div>
				  <div class="col-3">
					<label for="f_gencaseque_last_name">Last Name:</label>
					@if((isset($question_data->f_gencaseque_last_name) && $question_data->f_gencaseque_last_name !=''?$question_data->f_gencaseque_last_name:(isset($contact_data)?$contact_data->last_name:'')))
						<p>{{(isset($question_data->f_gencaseque_last_name) && $question_data->f_gencaseque_last_name !=''?$question_data->f_gencaseque_last_name:(isset($contact_data)?$contact_data->last_name:''))}}</p>
					@endif
				  </div>
				</div>
				
				<div class="row mt-2 mb-2">
				  <div class="col-3">
					<label for="f_gencaseque_phone">Cell Phone Number:</label>
					@if((isset($question_data->f_gencaseque_phone) && $question_data->f_gencaseque_phone !=''?$question_data->f_gencaseque_phone:(isset($contact_data)?$contact_data->phone:'')))
						<p>{{(isset($question_data->f_gencaseque_phone) && $question_data->f_gencaseque_phone !=''?$question_data->f_gencaseque_phone:(isset($contact_data)?$contact_data->phone:''))}}</p>
					@endif
				  </div>	
				  <div class="col-3">
					<label for="f_gencaseque_alt_phone">Alternate Phone Number:</label>
					@if((isset($question_data->f_gencaseque_alt_phone) && $question_data->f_gencaseque_alt_phone?$question_data->f_gencaseque_alt_phone:''))
						<p>{{(isset($question_data->f_gencaseque_alt_phone) && $question_data->f_gencaseque_alt_phone?$question_data->f_gencaseque_alt_phone:'')}}</p>
					@endif
				  </div>
				  <div class="col-3">
					<label for="f_gencaseque_address">Street Address:</label>
					@if((isset($question_data->f_gencaseque_address) && $question_data->f_gencaseque_address?$question_data->f_gencaseque_address:''))
						<p>{{(isset($question_data->f_gencaseque_address) && $question_data->f_gencaseque_address?$question_data->f_gencaseque_address:'')}}</p>
					@endif
				  </div>
				  <div class="col-3">
					<label for="f_gencaseque_city">City:</label>
					@if((isset($question_data->f_gencaseque_city) && $question_data->f_gencaseque_city?$question_data->f_gencaseque_city:''))
						<p>{{(isset($question_data->f_gencaseque_city) && $question_data->f_gencaseque_city?$question_data->f_gencaseque_city:'')}}</p>
					@endif
				  </div>
				</div>
				
				<div class="row mt-2 mb-2">
				  <div class="col-3">
					<label for="f_gencaseque_state">State:</label>
					<p>&nbsp;</p>
				  </div>	
				  <div class="col-3">
					<label for="f_gencaseque_zip">Zip:</label>
					@if((isset($question_data->f_gencaseque_zip) && $question_data->f_gencaseque_zip?$question_data->f_gencaseque_zip:''))
						<p>{{(isset($question_data->f_gencaseque_zip) && $question_data->f_gencaseque_zip?$question_data->f_gencaseque_zip:'')}}</p>
					@endif
				  </div>
				  <div class="col-3">
					<label for="f_gencaseque_email">Email Address:</label>
					@if((isset($question_data->f_gencaseque_email) && $question_data->f_gencaseque_email !=''?$question_data->f_gencaseque_email:(isset($contact_data)?$contact_data->email:'')))
						<p>{{(isset($question_data->f_gencaseque_email) && $question_data->f_gencaseque_email !=''?$question_data->f_gencaseque_email:(isset($contact_data)?$contact_data->email:''))}}</p>
					@endif
				  </div>
				  <div class="col-3">
					<label for="f_gencaseque_11">How Did You Hear About Us:</label>
					@if(isset($intake_values['marketing_source']) && !empty($intake_values['marketing_source']))
						@foreach($intake_values['marketing_source'] as $options)
							@if((isset($question_data->f_gencaseque_11) && $question_data->f_gencaseque_11!=''?$question_data->f_gencaseque_11:$lead_data->marketing_source)==$options->id)
								<p>{{$options->value}}</p>
							@endif
						@endforeach
					@endif
				  </div>
				</div>
				
				<div class="row mt-2 mb-2">
				  <div class="col-3">
					<label for="f_gencaseque_12">Receiving: (IF YES, ASK IF ITS EARLY RETIREMENT)</label>
					@if((isset($question_data->f_gencaseque_12) && $question_data->f_gencaseque_12?$question_data->f_gencaseque_12:''))
						<p>{{(isset($question_data->f_gencaseque_12) && $question_data->f_gencaseque_12?$question_data->f_gencaseque_12:'')}}</p>
					@endif
				  </div>	
				  <div class="col-3">
					<label for="f_gencaseque_14">Applied for SSD Before:</label>
					@if((isset($question_data->f_gencaseque_14) && $question_data->f_gencaseque_14?$question_data->f_gencaseque_14:''))
						<p>{{(isset($question_data->f_gencaseque_14) && $question_data->f_gencaseque_14?$question_data->f_gencaseque_14:'')}}</p>
					@endif
				  </div>
				  <div class="col-3">
					<label for="f_gencaseque_15">Attorney:  (IF CURRENT NC ATTY,  THEN REJECT)</label>
					@if((isset($question_data->f_gencaseque_15) && $question_data->f_gencaseque_15?$question_data->f_gencaseque_15:''))
						<p>{{(isset($question_data->f_gencaseque_15) && $question_data->f_gencaseque_15?$question_data->f_gencaseque_15:'')}}</p>
					@endif
				  </div>
				  <div class="col-3">
					<label for="f_gencaseque_16">Are you currently working?</label>
					@if((isset($question_data->f_gencaseque_16) && $question_data->f_gencaseque_16?$question_data->f_gencaseque_16:''))
						<p>{{(isset($question_data->f_gencaseque_16) && $question_data->f_gencaseque_16?$question_data->f_gencaseque_16:'')}}</p>
					@endif
				  </div>
				</div>
				
				<div class="row mt-2 mb-2">
				  <div class="col-3">
					<label for="f_gencaseque_17">If Yes, How many hours per week?  (IF OVER 8 HOURS A WEEK ON AVERAGE, REJECT)</label>
					@if((isset($question_data->f_gencaseque_17) && $question_data->f_gencaseque_17?$question_data->f_gencaseque_17:''))
						<p>{{(isset($question_data->f_gencaseque_17) && $question_data->f_gencaseque_17?$question_data->f_gencaseque_17:'')}}</p>
					@endif
				  </div>	
				  <div class="col-3">
					<label for="f_gencaseque_18">If No, What was the date of your last full time job?</label>
					@if((isset($question_data->f_gencaseque_18) && $question_data->f_gencaseque_18?$question_data->f_gencaseque_18:''))
						<p>{{(isset($question_data->f_gencaseque_18) && $question_data->f_gencaseque_18?$question_data->f_gencaseque_18:'')}}</p>
					@endif
				  </div>
				  <div class="col-3">
					<label for="f_gencaseque_19">Do you have any household income?</label>
					@if((isset($question_data->f_gencaseque_19) && $question_data->f_gencaseque_19?$question_data->f_gencaseque_19:''))
						<p>{{(isset($question_data->f_gencaseque_19) && $question_data->f_gencaseque_19?$question_data->f_gencaseque_19:'')}}</p>
					@endif
				  </div>
				  <div class="col-3">
					<label for="f_gencaseque_20">What type of work have You/The Client done in the past?</label>
					@if((isset($question_data->f_gencaseque_20) && $question_data->f_gencaseque_20?$question_data->f_gencaseque_20:''))
						<p>{{(isset($question_data->f_gencaseque_20) && $question_data->f_gencaseque_20?$question_data->f_gencaseque_20:'')}}</p>
					@endif
				  </div>
				</div>
				
				<div class="row mt-2 mb-2">
				  <div class="col-3">
					<label for="f_gencaseque_21">Are You/The Client married or single?</label>
					@if((isset($question_data->f_gencaseque_21) && $question_data->f_gencaseque_21?$question_data->f_gencaseque_21:''))
						<p>{{(isset($question_data->f_gencaseque_21) && $question_data->f_gencaseque_21?$question_data->f_gencaseque_21:'')}}</p>
					@endif	
				  </div>	
				  <div class="col-3">
					<label for="f_gencaseque_22">Age: (IF OVER 50 TAKE IT ALWAYS, AND IF UNDER 50 MAKE SURE THEY HAVE CONDITIONS AND TREATMENT)</label>
					@if((isset($question_data->f_gencaseque_22) && $question_data->f_gencaseque_22?$question_data->f_gencaseque_22:''))
						<p>{{(isset($question_data->f_gencaseque_22) && $question_data->f_gencaseque_22?$question_data->f_gencaseque_22:'')}}</p>
					@endif
				  </div>
				  <div class="col-3">
					<label for="f_gencaseque_23">Conditions:</label>
					@if((isset($question_data->f_gencaseque_23) && $question_data->f_gencaseque_23?$question_data->f_gencaseque_23:''))
						<p>{{(isset($question_data->f_gencaseque_23) && $question_data->f_gencaseque_23?$question_data->f_gencaseque_23:'')}}</p>
					@endif
				  </div>
				  <div class="col-3">
					<label for="f_gencaseque_24">Frequency of Treatment:</label>
					@if((isset($question_data->f_gencaseque_24) && $question_data->f_gencaseque_24?$question_data->f_gencaseque_24:''))
						<p>{{(isset($question_data->f_gencaseque_24) && $question_data->f_gencaseque_24?$question_data->f_gencaseque_24:'')}}</p>
					@endif
				  </div>
				</div>
				
				<div class="row mt-2 mb-2">
				  <div class="col-3">
					<label for="f_gencaseque_25">Doctor Ordered:</label>
					@if((isset($question_data->f_gencaseque_25) && $question_data->f_gencaseque_25?$question_data->f_gencaseque_25:''))
						<p>{{(isset($question_data->f_gencaseque_25) && $question_data->f_gencaseque_25?$question_data->f_gencaseque_25:'')}}</p>
					@endif
				  </div>	
				  <div class="col-3">
					<label for="f_gencaseque_26">Do you have more than 1 vehicle in your name?</label>
					@if((isset($question_data->f_gencaseque_26) && $question_data->f_gencaseque_26?$question_data->f_gencaseque_26:''))
						<p>{{(isset($question_data->f_gencaseque_26) && $question_data->f_gencaseque_26?$question_data->f_gencaseque_26:'')}}</p>
					@endif
				  </div>
				  <div class="col-3">
					<label for="f_gencaseque_27">Is more than 1 piece of property (land/home) in your name?</label>
					@if((isset($question_data->f_gencaseque_27) && $question_data->f_gencaseque_27?$question_data->f_gencaseque_27:''))
						<p>{{(isset($question_data->f_gencaseque_27) && $question_data->f_gencaseque_27?$question_data->f_gencaseque_27:'')}}</p>
					@endif
				  </div>
				</div>
			</div>
			<div id="additional_mt_questions">
				<h2>Additional MT Questions</h2>
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
					@if((isset($question_data->f_additional_mtq_10) && $question_data->f_additional_mtq_10?$question_data->f_additional_mtq_10:''))
						<p>{{(isset($question_data->f_additional_mtq_10) && $question_data->f_additional_mtq_10?$question_data->f_additional_mtq_10:'')}}</p>
					@endif
				  </div>
				</div>
			</div>
	  </div>
	</div>
</div>
