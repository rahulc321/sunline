document.addEventListener('DOMContentLoaded', function () {
	let LeadSlotMinTime = "08:00:00"; // Start time of day
	let LeadslotMaxTime = "18:00:00"; // End time of day
	const calendarEl = document.getElementById('calendar');
	const calendarEventEl = document.getElementById('calendar-events');
	const loader = document.getElementById('calendarLoader');
	const refreshBtn = document.getElementById('refreshCalendarBtn');

	const calendar = new FullCalendar.Calendar(calendarEl, {
		initialView: 'dayGridMonth',
		headerToolbar: {
			left: 'prev,next',
			center: 'title',
			right: ''
		},
	});

	calendar.render();

	const calendarEvent = new FullCalendar.Calendar(calendarEventEl, {
		initialView: 'dayGridMonth',
		headerToolbar: {
			left: 'prev,next today',
			center: 'title',
			right: 'timeGridDay,timeGridWeek,dayGridMonth'
		},
		slotMinTime: LeadSlotMinTime, 
		slotMaxTime: LeadslotMaxTime, 
		allDaySlot: true,
		nowIndicator: true,
		events: route.admin.lead_event_calendar,
		loading: function (isLoading) {
			if (isLoading) {
				loader.style.display = 'inline-flex';
			} else {
				loader.style.display = 'none';
			}
		}
	});

	// Sync date when clicking on a day in the first calendar
	calendar.on('dateClick', function(info) {
		calendarEvent.gotoDate(info.date);
	});

	// Sync date when navigating (prev/next) in the first calendar
	calendar.on('datesSet', function(info) {
		// Only update if the visible month changes
		const viewDate = info.start;
		calendarEvent.gotoDate(viewDate);
	});

	/*
	calendar.on('dateClick', function(info) {
		calendarEvent.changeView('timeGridDay', info.date);
	}); */

	calendarEvent.render();

	refreshBtn.addEventListener('click', function () {
		calendarEvent.refetchEvents();
	});
});

/* ################ Calendar Permission Related ################# */	
	
const selectedUsers = new Map();

document.getElementById('share_calen_crm_sys').addEventListener('click', function () {
	const selectedOptions = Array.from(document.getElementById('calen_crm_sys').selectedOptions);
	selectedOptions.forEach(option => {
		const userId = option.value;
		const userName = option.dataset.name;

		if (!selectedUsers.has(userId)) {
			selectedUsers.set(userId, userName);
			appendUserRow(userId, userName);
		}
	});

	updateHiddenInput();
});

function appendUserRow(userId, userName) {
	const table = document.getElementById('selectedUsersTable').querySelector('tbody');
	const row = document.createElement('tr');
	row.id = `user-row-${userId}`;
	row.innerHTML = `
		<td>${userName}</td>
		<td>
			<div class="d-flex">
				<select name="calen_permission[${userId}]" class="form-control select2">
					<option value="1">View Calendar</option>
					<option value="2">Edit Calendar</option>
				</select>
				<button class="btn btn-danger btn-sm ms-2" onclick="removeUser('${userId}')">Delete</button>
			</div>
		</td>
	`;
	table.appendChild(row);
}

function removeUser(userId) {
	selectedUsers.delete(userId);
	document.getElementById(`user-row-${userId}`).remove();
	updateHiddenInput();
	// Also unselect from the select element
	const select = document.getElementById('userSelect');
	Array.from(select.options).forEach(option => {
		if (option.value === userId) {
			option.selected = false;
		}
	});
}

function updateHiddenInput() {
	const input = document.getElementById('selectedUsersInput');
	input.value = JSON.stringify(Array.from(selectedUsers.keys()));
}

$('#calenSharPermissForm').on('submit', function(e) {
	e.preventDefault();
	$('.error-message').remove();
	let isValid=true;
	const inputs = document.querySelectorAll('#calenSharPermissForm [data-required="true"]');
	let errors = [];
	
	inputs.forEach(input => {
		if(!input.value.trim()) {
			isValid=false;
			let cleanName = input.name.replace(/a_/g,' ').toLowerCase();
			cleanName = cleanName.replace(/_/g,' ').toLowerCase();					
			$('#'+input.id).after('<div class="error-message text-danger">'+`The ${cleanName} field is required.`+'</div>');
		}
	});		
	
	if(isValid) {
		let formData = new FormData(this);
		
		$.ajax({
		url:route.admin.save_selected_user_calendar,
			type:'POST',
			data: formData,
			contentType: false,
			processData: false,
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function(response) {
				if(response.status=='success')
				{
					$('#calenSharPermiss').modal('hide');
					Swal.fire("Created!", response.message, "success");
				}
				else 
				{
					Swal.fire("Error", response.message, "error");
				}
			},
			error: function(xhr) {
				console.error('Error: ', xhr.responseText);
			}
		});
	}
});