<!-- View Ticket Modal -->
<div class="modal fade" id="viewModel" tabindex="-1" aria-labelledby="viewTicketLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content shadow-lg border-0 rounded-4 overflow-hidden">

      <!-- Header -->
      <div class="modal-header bg-white border-bottom px-4 py-3">
        <h5 class="modal-title fw-bold text-primary d-flex align-items-center" id="viewTicketLabel">
          <i class="ph-ticket me-2 fs-5"></i> Ticket Details
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Body -->
      <div class="modal-body px-4 py-3">
        
        <!-- Ticket Top Info -->
        <div class="row g-3">
          <div class="col-md-6">
            <div class="info-box">
              <span class="label">Subject</span>
              <p id="ticket_subject" class="value"></p>
            </div>
          </div>

          <div class="col-md-6">
            <div class="info-box">
              <span class="label">Status</span>
              <span id="ticket_status" class="badge bg-success rounded-pill px-3 py-2"></span>
            </div>
          </div>

          <div class="col-md-6">
            <div class="info-box">
              <span class="label">Created By</span>
              <p id="ticket_user" class="value"></p>
            </div>
          </div>

          <div class="col-md-6">
            <div class="info-box">
              <span class="label">Assigned To</span>
              <p id="assign_to1" class="value"></p>
            </div>
          </div>

          <div class="col-md-6">
            <div class="info-box">
              <span class="label">Category</span>
              <p id="categoryv" class="value"></p>
            </div>
          </div>
        </div>

        <!-- Divider -->
        <hr class="my-4">

        <!-- Description -->
        <div>
          <span class="label">Description</span>
          <div id="ticket_description" class="description-box"></div>
        </div>
      </div>

      <!-- Footer -->
      <div class="modal-footer bg-light px-4 py-3">
        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">
          <i class="ph-x-circle me-1"></i> Close
        </button>
      </div>
    </div>
  </div>
</div>

<style>
  /* Unified styling for pixel-perfect look */
  .info-box {
    background: #f8f9fa;
    border: 1px solid #e6e6e6;
    border-radius: 0.75rem;
    padding: 1rem;
    height: 100%;
  }
  .info-box .label {
    display: block;
    font-size: 0.8rem;
    font-weight: 600;
    color: #6c757d;
    margin-bottom: 0.25rem;
    letter-spacing: 0.3px;
  }
  .info-box .value {
    font-size: 0.95rem;
    font-weight: 500;
    color: #212529;
    margin: 0;
  }
  .description-box {
    background: #ffffff;
    border: 1px solid #e6e6e6;
    border-radius: 0.75rem;
    padding: 1rem;
    min-height: 80px;
    font-size: 0.95rem;
    color: #212529;
    line-height: 1.5;
    box-shadow: inset 0 1px 2px rgba(0,0,0,0.02);
  }
</style>
