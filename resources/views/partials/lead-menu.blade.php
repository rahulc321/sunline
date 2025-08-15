<!-- Sidebar content -->
 <div class="sidebar-content">

    <!-- Main navigation -->
        <div class="sidebar-section">
            <ul class="nav nav-sidebar" data-nav-type="accordion">
			@can('intake_access')
				<!-- Main -->
				<li class="nav-item-header">
					<div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide white ">{{ trans('intake.inbox_menu') }}</div>
					<i class="ph-dots-three sidebar-resize-show"></i>
				</li>

				<li class="nav-item">
					<a href="{{route('admin.intakes.edit', $lead_data->id)}}#Overview" class="nav-link">
						<i class="ph-table"></i>{{ trans('intake.overview') }}
					</a>
				</li>
				@can('contact_access')
				<li class="nav-item">
					<a href="{{route('admin.intakes.edit', $lead_data->id)}}#RelatedContacts" class="nav-link">
						<i class="ph-address-book"></i>{{ trans('intake.related_contacts') }}
					</a>
				</li>
				@endcan
				@can('intake_form_access')
				<li class="nav-item">
					<a href="{{route('admin.intakes.edit', $lead_data->id)}}#Form" class="nav-link">
						<i class="ph-file-text"></i>{{ trans('intake.form') }}
					</a>
				</li>
				@endcan
				@can('intake_key_dates_access')
				<li class="nav-item">
					<a href="{{route('admin.intakes.edit', $lead_data->id)}}#KeyDates" class="nav-link">
						<i class="ph-calendar-check "></i>{{ trans('intake.key_dates') }}
					</a>
				</li>
				@endcan
				@can('intake_notes_access')
				<li class="nav-item">
					<a href="{{route('admin.intakes.edit', $lead_data->id)}}#Notes" class="nav-link">
						<i class="ph-note"></i>{{ trans('intake.notes') }}
					</a>
				</li>
				@endcan
				@can('intake_events_access')
				<li class="nav-item">
					<a href="{{route('admin.intakes.edit', $lead_data->id)}}#Events" class="nav-link">
						<i class="ph-calendar-plus "></i>{{ trans('intake.events') }}
					</a>
				</li>
				@endcan
				@can('intake_tasks_access')
				<li class="nav-item">
					<a href="{{route('admin.intakes.edit', $lead_data->id)}}#Tasks" class="nav-link">
						<i class="ph-pencil-circle"></i>{{ trans('intake.tasks') }}
					</a>
				</li>
				@endcan
				@can('intake_documents_access')
				<li class="nav-item">
					<a href="{{route('admin.intakes.edit', $lead_data->id)}}#Documents" class="nav-link">
						<i class="ph-file-doc "></i>{{ trans('intake.documents') }}
					</a>
				</li>
				@endcan
				@can('intake_communications_access')
				<li class="nav-item">
					<a href="{{route('admin.intakes.edit', $lead_data->id)}}#Communications" class="nav-link">
						<i class="ph-chat-centered-text"></i>{{ trans('intake.communications') }}
					</a>
				</li>
				@endcan
				@can('intake_finance_access')
				<li class="nav-item">
					<a href="{{route('admin.intakes.edit', $lead_data->id)}}#Finance" class="nav-link">
						<i class="ph-bank"></i>{{ trans('intake.finance') }}
					</a>
				</li>			
				@endcan
				@can('activity_log_access')
				<li class="nav-item">
					<a href="{{route('admin.intakes.edit', $lead_data->id)}}#ActivityLogs" class="nav-link">
						<i class="ph-activity"></i>{{ trans('intake.activity_log') }}
					</a>
				</li>
				@endcan
			@endcan			
        </ul>

   
</div>
</div>