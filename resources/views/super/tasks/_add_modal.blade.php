<div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header py-2">
                <h5 class="modal-title fw-bold" id="addTaskModalLabel">Create New Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Form -->
            <form action="{{ route('admin.taskStore') }}" method="POST">
                @csrf
                <div class="modal-body py-3">
                    <div class="row g-2">
                        <!-- g-2 gives tighter gap -->

                        <!-- Lead/Contact Name -->
                        <div class="col-12">
                            <label for="lead" class="form-label1 mb-1">Lead/Contact Name</label>
                            <select id="lead" name="lead" class="form-select form-select-sm" required>
                                <option value="">Select rep</option>
                                @foreach($leads as $lead)
                                <option value="{{ $lead->id }}">{{ $lead->first_name.' '.$lead->last_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Assigned Rep -->
                        <div class="col-12">
                            <label for="assigned_to" class="form-label mb-1">Assigned Rep</label>
                            <select id="assigned_to" name="assigned_to" class="form-select form-select-sm" required>
                                <option value="">Select rep</option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Task Description -->
                        <div class="col-12">
                            <label for="description" class="form-label1 mb-1">Task Description</label>
                            <textarea id="description" name="description" class="form-control form-control-sm"
                                rows="2" placeholder="Describe the task..." required></textarea>
                        </div>

                        <!-- Due Date & Due Time -->
                        <div class="col-sm-6">
                            <label for="due_date" class="form-label1 mb-1">Due Date</label>
                            <input type="date" id="due_date" name="due_date" class="form-control form-control-sm"
                                required>
                        </div>
                        <div class="col-sm-6">
                            <label for="due_time" class="form-label1 mb-1">Due Time</label>
                            <input type="time" id="due_time" name="due_time" class="form-control form-control-sm"
                                required>
                        </div>

                        <!-- Priority & Task Type -->
                        <div class="col-sm-6">
                            <label for="priority" class="form-label1 mb-1">Priority</label>
                            <select id="priority" name="priority" class="form-select form-select-sm" required>
                                <option value="">Select priority</option>
                                <option value="High">High</option>
                                <option value="Medium">Medium</option>
                                <option value="Low">Low</option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label for="task_type" class="form-label1 mb-1">Task Type</label>
                            <select id="task_type" name="task_type" class="form-select form-select-sm" required>
                                <option value="">Select type</option>
                                <option value="Call">Call</option>
                                <option value="Meeting">Meeting</option>
                                <option value="Follow-up">Follow-up</option>
                                <option value="Email">Email</option>
                            </select>
                        </div>

                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer py-2">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm bg_s">Create Task</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* reduce padding globally for this modal */
#addTaskModal .form-label {
    font-size: 0.85rem;
}

#addTaskModal .form-control,
#addTaskModal .form-select,
#addTaskModal textarea {
    padding: 0.35rem 0.5rem;
}
</style>