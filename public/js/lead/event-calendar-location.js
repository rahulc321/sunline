let calendar;
let LeadSlotMinTime; // Start time of day
let LeadslotMaxTime; // End time of day

document.addEventListener('DOMContentLoaded', function () {
	
	const calendarEl = document.getElementById('calendar');
	
	// Get current time and format it to HH:mm:ss
	const now = new Date();
	const hours = now.getHours();
	const minutes = now.getMinutes();
	
	const year = now.getFullYear();
	const month = String(now.getMonth() + 1).padStart(2, '0');
	const day = String(now.getDate()).padStart(2, '0');
	
	let date = `${year}-${month}-${day}`;
	
	document.getElementById('event_date').value = date;
	
	startHours = hours;
	startMinutes = minutes;
	// Round minutes up to nearest multiple of 5
	startMinutes = Math.ceil(startMinutes / 5) * 5;
	// If minutes become 60, increase hour and reset minutes to 0
	if (startMinutes === 60) {
		startMinutes = 0;
		startHours += 1;
	}	
	// Format as HH:mm:00
	startHours = startHours.toString().padStart(2, '0');
	startMinutes = startMinutes.toString().padStart(2, '0');	
	let startCurrentTime = `${startHours}:${startMinutes}:00`;
	document.getElementById('event_start_from').value = startCurrentTime;

	endHours = hours;
	endMinutes = minutes;
	// Round minutes up to nearest multiple of 5
	endMinutes = Math.ceil(endMinutes / 5) * 5;
	// If minutes become 60, increase hour and reset minutes to 0
	if (endMinutes === 60) {
		endMinutes = 0;
		endHours += 1;
	}
	// Add 1 hour
	endHours += 1;
	// Handle overflow (if hour becomes 24 or more)
	if (endHours >= 24) {
		endHours = endHours % 24;
	}
	// Format as HH:mm:00
	endHours = endHours.toString().padStart(2, '0');
	endMinutes = endMinutes.toString().padStart(2, '0');
	const endCurrentTime = `${endHours}:${endMinutes}:00`;	
	document.getElementById('event_start_to').value = endCurrentTime;
	
	// Optional: set min and max time range (e.g., +/- 2 hours from now)
	const minHour = Math.max(0, now.getHours() - 0);
	const maxHour = Math.min(24, now.getHours() + 24);
	LeadSlotMinTime = `${minHour.toString().padStart(2, '0')}:00:00`;
	LeadslotMaxTime = `${maxHour.toString().padStart(2, '0')}:00:00`;

	calendar = new FullCalendar.Calendar(calendarEl, {
		initialView: 'timeGridDay', // or 'timeGridWeek'
		headerToolbar: {
			left: '', //left: 'prev,next today',
			center: 'title',
			right: ''  //right: 'timeGridDay,timeGridWeek,dayGridMonth'
		},
		slotMinTime: LeadSlotMinTime, 
		slotMaxTime: LeadslotMaxTime,	
		allDaySlot: true, //allDaySlot: flase,
		nowIndicator: true,
		events: route.admin.lead_event_calendar // Laravel route that returns events in JSON
	});

	calendar.render();
});

document.getElementById('popupCardAddEvent').addEventListener('shown.bs.modal', function () {
    if (calendar) {
        //calendar.render();
        calendar.updateSize();
    }
});

function refreshCalendar() {
	
	const startInput = document.getElementById('event_start_from');
	const endInput = document.getElementById('event_start_to');
	const date = document.getElementById('event_date').value;

	const from = startInput.value;
	const to = endInput.value;

	if (!from) return;
	
	LeadSlotMinTime = from;
	LeadslotMaxTime =  to;
	
	//console.log('Start from:', from, '| Start to:', to, '| Date:', date);
	
	if (from && to && from > to) {
		const endInput = document.getElementById('event_start_to');
		endInput.value = from;
		LeadSlotMinTime = from;
		//console.log('Adjusted end time to match start time');
	}
    
    // Update event source with new parameters
	/*
    calendar.removeAllEventSources();
    calendar.addEventSource({
        events: route.admin.lead_event_calendar,
        extraParams: {
            date: date,
            start_time: from,
            end_time: to
        }
    });
	*/
	/*	
    fetch(route.admin.lead_event_calendar+'?start='+date+'&end='+date)
        .then(response => response.json())
        .then(events => {
            calendar.removeAllEvents();
            calendar.addEventSource(events);
        });
	*/	
		
	//calendar.setOption('initialDate', date); // new date in YYYY-MM-DD format
	calendar.gotoDate(date); // Navigate to new date
    //calendar.refetchEvents(); // Optional: if you want to reload events too	
		
}

class LocationSearch {
	constructor() {
		this.searchInput = document.getElementById('event_address');
		this.suggestionsContainer = document.getElementById('suggestionsContainer');
		this.selectedLocation = document.getElementById('selectedLocation');
		this.errorContainer = document.getElementById('errorContainer');
		this.searchTimeout = null;
		this.currentQuery = '';
		
		this.initEventListeners();
	}
	
	initEventListeners() {
		this.searchInput.addEventListener('input', (e) => {
			this.handleSearch(e.target.value);
		});
		
		this.searchInput.addEventListener('focus', () => {
			if (this.suggestionsContainer.children.length > 0) {
				this.suggestionsContainer.style.display = 'block';
			}
		});
		
		document.addEventListener('click', (e) => {
			if (!e.target.closest('.search-container')) {
				this.suggestionsContainer.style.display = 'none';
			}
		});
	}
	
	handleSearch(query) {
		clearTimeout(this.searchTimeout);
		
		if (query.length < 3) {
			this.hideSuggestions();
			return;
		}
		
		this.searchTimeout = setTimeout(() => {
			this.searchLocations(query);
		}, 300);
	}
	
	async searchLocations(query) {
		try {
			this.showLoading();
			
			const response = await fetch(`/api/locations/search?query=${encodeURIComponent(query)}`, {
				headers: {
					'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
				}
			});
			
			const data = await response.json();
			
			if (data.success) {
				this.displaySuggestions(data.data);
			} else {
				this.showError('Failed to fetch locations: ' + data.message);
			}
		} catch (error) {
			this.showError('Network error: ' + error.message);
		}
	}
	
	displaySuggestions(predictions) {
		this.suggestionsContainer.innerHTML = '';
		
		if (predictions.length === 0) {
			this.suggestionsContainer.innerHTML = '<div class="suggestion-item">No locations found</div>';
			this.suggestionsContainer.style.display = 'block';
			return;
		}
		
		predictions.forEach(prediction => {
			const suggestionItem = document.createElement('div');
			suggestionItem.className = 'suggestion-item';
			suggestionItem.innerHTML = `
				<div class="suggestion-main">${prediction.structured_formatting.main_text}</div>
				<div class="suggestion-secondary">${prediction.structured_formatting.secondary_text || prediction.description}</div>
			`;
			
			suggestionItem.addEventListener('click', () => {
				this.selectLocation(prediction);
			});
			
			this.suggestionsContainer.appendChild(suggestionItem);
		});
		
		this.suggestionsContainer.style.display = 'block';
	}
	
	showLoading() {
		this.suggestionsContainer.innerHTML = '<div class="loading">🔍 Searching...</div>';
		this.suggestionsContainer.style.display = 'block';
	}
	
	hideSuggestions() {
		this.suggestionsContainer.style.display = 'none';
	}
	
	showError(message) {
		this.errorContainer.textContent = message;
		this.errorContainer.style.display = 'block';
	}
	
	hideError() {
		this.errorContainer.style.display = 'none';
	}
}
        
// Initialize the location search when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
	new LocationSearch();
});