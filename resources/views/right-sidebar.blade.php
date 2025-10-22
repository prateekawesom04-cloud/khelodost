<!-- Right Sidebar -->
<div class="layout-sidebar-right layout-section">
    <div class="card shadow-sm rounded-3 d-none d-lg-block">
  <div class="card-header bg-white">
    <ul class="nav nav-tabs card-header-tabs" id="betTabs" role="tablist">
      <li class="nav-item" role="presentation">
        <a id="betslipTab" class="nav-link active" href="#betslip" data-bs-toggle="tab" role="tab" aria-controls="betslip" aria-selected="true">
          Betslip
        </a>
      </li>
      <li class="nav-item" role="presentation">
        <a id="openBetsTab" class="nav-link" href="#openbets" data-bs-toggle="tab" role="tab" aria-controls="openbets" aria-selected="false">
          Open Bets
        </a>
      </li>
    </ul>
  </div>

  <div class="card-body tab-content">
    <!-- Betslip Tab -->
    <div class="tab-pane fade show active" id="betslip" role="tabpanel">
      @include('includes.betslip')
    </div>

    <!-- Open Bets Tab -->
    <div class="tab-pane fade" id="openbets" role="tabpanel">
      
    </div>
  </div>
    </div>
</div>
