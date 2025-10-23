<!-- Right Sidebar -->
<div class="layout-sidebar-right layout-section">
  <div class="card shadow-sm rounded-3 d-none d-lg-block fixed lg:static lg:max-w-full top-[0px] right-[0px]" style="diplay:none;">
    <div class="card-header bg-white flex justify-between">
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
      <div class="cross_icon">X</div>
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

<div class="fixed bottom-[0px] right-[0px] bg-[#fc7600] text-white p-2 rounded-md openbetsdiv">Open Bets</div>


<script>
  // $('.openbetsdiv')on('click',function(){
    
  // });
</script>