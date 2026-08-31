<?php
/* ============================================================
   TOP HORIZONTAL NAVIGATION MENU
   Replaces: left_menu_new.inc (vertical sidebar)
   ============================================================ */
if (!isset($_GET['param'])) { $_GET['param'] = ''; }
$_param = trim($_GET['param']);
$params = [];
if ($_param !== '') {
    $params = $OBJ->URLDecode($_param);
}

/* Helper: is a specific section active? */
function menuActive($p, $key, $val) {
    return (isset($p[$key]) && $p[$key] == $val);
}
?>
<!-- ======================================================
     HORIZONTAL MAIN NAVIGATION BAR
     ====================================================== -->
<nav class="thc-topnav">
  <div class="thc-topnav-inner">

    <!-- Brand logo -->
    <a class="thc-topnav-brand" href="dashboard.php?wo=m&param=<?= $OBJ->URLEncode('title=dashboard') ?>">
      <img src="../httpdocs/images/final_logo2.png" alt="THC Logo" class="brand-logo-img">
    </a>

    <!-- Hamburger for mobile -->
    <button class="thc-topnav-toggle" id="thcNavToggle" aria-label="Toggle navigation">
      <span></span><span></span><span></span>
    </button>

    <!-- Nav items -->
    <ul class="thc-nav" id="thcNavMenu">

      <!-- Dashboard -->
      <li class="thc-nav-item classDashboard">
        <a href="dashboard.php?wo=m&param=<?= $OBJ->URLEncode('title=dashboard') ?>"
           class="thc-nav-link<?= menuActive($params,'title','dashboard') ? ' active' : '' ?>">
          <i class="icon-home4"></i> Dashboard
        </a>
      </li>

      <!-- Dashboard Analytics -->
      <li class="thc-nav-item classDashboard">
        <a href="dashboard_analytics.php?wo=m&param=<?= $OBJ->URLEncode('title=dashboardnew') ?>"
           class="thc-nav-link<?= menuActive($params,'title','dashboardnew') ? ' active' : '' ?>">
          <i class="icon-grid6"></i> Analytics
        </a>
      </li>

      <!-- Calendar -->
      <li class="thc-nav-item classCalenderView">
        <a href="amc_shedule_calender.php?param=<?= $OBJ->URLEncode('title=amc_calendar') ?>"
           class="thc-nav-link<?= menuActive($params,'title','amc_calendar') ? ' active' : '' ?>">
          <i class="icon-calendar3"></i> Calendar
        </a>
      </li>

      <!-- HR Module -->
      <li class="thc-nav-item thc-has-dropdown classHRModule<?= menuActive($params,'head','hr') ? ' open' : '' ?>">
        <a href="#" class="thc-nav-link thc-dropdown-toggle<?= menuActive($params,'head','hr') ? ' active' : '' ?>">
          <i class="icon-users"></i> HR Module <i class="thc-arrow icon-arrow-down22"></i>
        </a>
        <ul class="thc-dropdown">
          <li class="classExpertiseView"><a href="expertise.php?param=<?= $OBJ->URLEncode('head=hr&open=2&title=expertise') ?>" class="<?= menuActive($params,'open','2') ? 'active' : '' ?>"><i class="icon-certificate"></i> Expertise</a></li>
          <li class="classEmployeesView"><a href="employees.php?param=<?= $OBJ->URLEncode('head=hr&open=1&title=employees') ?>" class="<?= menuActive($params,'open','1') ? 'active' : '' ?>"><i class="icon-user"></i> Employees</a></li>
          <li class="classEmployeesView"><a href="leave_type.php?param=<?= $OBJ->URLEncode('head=hr&open=19&title=leave_type') ?>" class="<?= menuActive($params,'open','19') ? 'active' : '' ?>"><i class="icon-palette"></i> Leave Types</a></li>
          <li class="classEmployeesView"><a href="employee_leave.php?param=<?= $OBJ->URLEncode('head=hr&open=17&title=employee_leave') ?>" class="<?= menuActive($params,'open','17') ? 'active' : '' ?>"><i class="icon-calendar3"></i> Leave Scheduler</a></li>
          <li class="classEmployeesView"><a href="employee_report.php?param=<?= $OBJ->URLEncode('head=hr&open=3&title=employees') ?>" class="<?= menuActive($params,'open','3') ? 'active' : '' ?>"><i class="icon-list"></i> Employee List</a></li>
          <li class="classCPRAndVisaExpiryView"><a href="employee_expiry.php?param=<?= $OBJ->URLEncode('head=hr&open=18&title=employee_expiry') ?>" class="<?= menuActive($params,'open','18') ? 'active' : '' ?>"><i class="icon-alarm"></i> CPR/Visa Expiry</a></li>
        </ul>
      </li>

      <!-- Assets & Services Master -->
      <li class="thc-nav-item thc-has-dropdown classAssetsAndServiceModule<?= menuActive($params,'head','master') ? ' open' : '' ?>">
        <a href="#" class="thc-nav-link thc-dropdown-toggle<?= menuActive($params,'head','master') ? ' active' : '' ?>">
          <i class="icon-target2"></i> Masters <i class="thc-arrow icon-arrow-down22"></i>
        </a>
        <ul class="thc-dropdown">
          <li class="classLocationAndFacilitiesView"><a href="location.php?param=<?= $OBJ->URLEncode('head=master&open=13&title=location') ?>" class="<?= menuActive($params,'open','13') ? 'active' : '' ?>"><i class="icon-location3"></i> Location / Facilities</a></li>
          <li class="classContractTypeAndAssetCategoryView"><a href="category.php?param=<?= $OBJ->URLEncode('head=master&open=4&title=contract&title1=category') ?>" class="<?= menuActive($params,'open','4') ? 'active' : '' ?>"><i class="icon-file-text2"></i> Contract Type / Asset Category</a></li>
          <li class="classAssetTypeView"><a href="asset_type.php?param=<?= $OBJ->URLEncode('head=master&open=5&title=asset_type') ?>" class="<?= menuActive($params,'open','5') ? 'active' : '' ?>"><i class="icon-box"></i> Asset Type</a></li>
          <li class="classServicesView"><a href="services.php?param=<?= $OBJ->URLEncode('head=master&open=6&title=services') ?>" class="<?= menuActive($params,'open','6') ? 'active' : '' ?>"><i class="icon-wrench3"></i> Services</a></li>
        </ul>
      </li>

      <!-- Customers & Assets -->
      <li class="thc-nav-item thc-has-dropdown classCustomerAndAssetsModule<?= menuActive($params,'head','customer_master') ? ' open' : '' ?>">
        <a href="#" class="thc-nav-link thc-dropdown-toggle<?= menuActive($params,'head','customer_master') ? ' active' : '' ?>">
          <i class="icon-vcard"></i> Customers <i class="thc-arrow icon-arrow-down22"></i>
        </a>
        <ul class="thc-dropdown">
          <li class="classCustomerView"><a href="customer.php?param=<?= $OBJ->URLEncode('head=customer_master&open=8&title=customer') ?>" class="<?= menuActive($params,'open','8') ? 'active' : '' ?>"><i class="icon-users4"></i> Customer</a></li>
          <li class="classCustomerFacilityView"><a href="customer_asset_details.php?param=<?= $OBJ->URLEncode('head=customer_master&open=15&title=customer_asset') ?>" class="<?= menuActive($params,'open','15') ? 'active' : '' ?>"><i class="icon-office"></i> Customer Facilities</a></li>
          <li class="classCustomerAssetView"><a href="amc_assets.php?param=<?= $OBJ->URLEncode('head=customer_master&open=16&title=customer_amc_asset') ?>" class="<?= menuActive($params,'open','16') ? 'active' : '' ?>"><i class="icon-cog5"></i> Customer Assets</a></li>
          <li class="classCustomerTeam"><a href="customer_team.php?param=<?= $OBJ->URLEncode('head=customer_master&open=22&title=customer_team') ?>" class="<?= menuActive($params,'open','22') ? 'active' : '' ?>"><i class="icon-people"></i> Customer Teams</a></li>
          <li class="classCustomerDirectoryView"><a href="customer_directory.php?param=<?= $OBJ->URLEncode('head=customer_master&open=19&title=customer_directory') ?>" class="<?= menuActive($params,'open','19') ? 'active' : '' ?>"><i class="icon-address-book"></i> Customer Directory</a></li>
          <li class="classCustomerAssetView"><a href="asset_tracking.php?param=<?= $OBJ->URLEncode('head=customer_master&open=20&title=asset_tracking') ?>" class="<?= menuActive($params,'open','20') ? 'active' : '' ?>"><i class="icon-location4"></i> Track Asset Services</a></li>
          <li class="classCustomerAssetView"><a href="asset_code_download.php?param=<?= $OBJ->URLEncode('head=customer_master&open=21&title=asset_download') ?>" class="<?= menuActive($params,'open','21') ? 'active' : '' ?>"><i class="icon-download"></i> Download Assets</a></li>
        </ul>
      </li>

      <!-- Work Orders -->
      <li class="thc-nav-item thc-has-dropdown classWorkOrderManagementModule<?= menuActive($params,'head','tickets') ? ' open' : '' ?>">
        <a href="#" class="thc-nav-link thc-dropdown-toggle<?= menuActive($params,'head','tickets') ? ' active' : '' ?>">
          <i class="icon-shutter"></i> Work Orders <i class="thc-arrow icon-arrow-down22"></i>
        </a>
        <ul class="thc-dropdown">
          <li class="classBookWoView"><a href="tickets.php?param=<?= $OBJ->URLEncode('head=tickets&open=1&title=ticket') ?>" class="<?= menuActive($params,'open','1') ? 'active' : '' ?>"><i class="icon-pencil6"></i> Book Work Order</a></li>
          <li class="classWoOpenedView"><a href="tickets_pending_list.php?param=<?= $OBJ->URLEncode('head=tickets&open=2&title=ticket_pending') ?>" class="<?= menuActive($params,'open','2') ? 'active' : '' ?>"><i class="icon-radio-checked"></i> Opened</a></li>
          <li class="classWoScheduledView"><a href="tickets_not_assigned.php?param=<?= $OBJ->URLEncode('head=tickets&open=6&title=ticket_schedule') ?>" class="<?= menuActive($params,'open','6') ? 'active' : '' ?>"><i class="icon-calendar5"></i> Scheduled</a></li>
          <li class="classWoAssignedView"><a href="tickets_assigned.php?param=<?= $OBJ->URLEncode('head=tickets&open=8&title=ticket_assigned') ?>" class="<?= menuActive($params,'open','8') ? 'active' : '' ?>"><i class="icon-user-check"></i> Assigned</a></li>
          <li class="classWoExtensionView"><a href="reschedule_pending_complaints.php?param=<?= $OBJ->URLEncode('head=tickets&open=5&title=ticket_reschedule') ?>" class="<?= menuActive($params,'open','5') ? 'active' : '' ?>"><i class="icon-history"></i> Request Extension</a></li>
          <li class="classWoCompletedView"><a href="tickets_completed.php?param=<?= $OBJ->URLEncode('head=tickets&open=7&title=ticket_completed') ?>" class="<?= menuActive($params,'open','7') ? 'active' : '' ?>"><i class="icon-checkmark2"></i> Completed</a></li>
          <li class="classWoClosedView"><a href="tickets_closed.php?param=<?= $OBJ->URLEncode('head=tickets&open=9&title=ticket_closed') ?>" class="<?= menuActive($params,'open','9') ? 'active' : '' ?>"><i class="icon-lock2"></i> Closed</a></li>
          <li class="classWoCancelledView"><a href="tickets_cancelled.php?param=<?= $OBJ->URLEncode('head=tickets&open=10&title=ticket_cancelled') ?>" class="<?= menuActive($params,'open','10') ? 'active' : '' ?>"><i class="icon-blocked"></i> Cancelled</a></li>
          <li class="classWoEscalatedView"><a href="tickets_escalated.php?param=<?= $OBJ->URLEncode('head=tickets&open=11&title=ticket_escalated') ?>" class="<?= menuActive($params,'open','11') ? 'active' : '' ?>"><i class="icon-warning2"></i> Escalated</a></li>
        </ul>
      </li>

      <!-- WO Reports -->
      <li class="thc-nav-item thc-has-dropdown classWorkOrderReportsModule<?= menuActive($params,'head','daily_reports') ? ' open' : '' ?>">
        <a href="#" class="thc-nav-link thc-dropdown-toggle<?= menuActive($params,'head','daily_reports') ? ' active' : '' ?>">
          <i class="icon-hour-glass"></i> WO Reports <i class="thc-arrow icon-arrow-down22"></i>
        </a>
        <ul class="thc-dropdown">
          <li class="classWoReport"><a href="tickets_search.php?param=<?= $OBJ->URLEncode('head=daily_reports&open=4&title=ticket_scheduled') ?>" class="<?= menuActive($params,'open','4') ? 'active' : '' ?>"><i class="icon-search4"></i> Work Orders</a></li>
          <li class="classTrackWo"><a href="track_complaints.php?param=<?= $OBJ->URLEncode('head=daily_reports&open=3&title=ticket_track') ?>" class="<?= menuActive($params,'open','3') ? 'active' : '' ?>"><i class="icon-map4"></i> Track Work Order</a></li>
          <li class="classDailyTeamReport"><a href="daily_team_report.php?param=<?= $OBJ->URLEncode('head=daily_reports&open=1&title=team_report') ?>" class="<?= menuActive($params,'open','1') ? 'active' : '' ?>"><i class="icon-users2"></i> Daily Team Report</a></li>
          <li class="classDailyActivityReport"><a href="daily_activity_log.php?param=<?= $OBJ->URLEncode('head=daily_reports&open=2&title=activity_log') ?>" class="<?= menuActive($params,'open','2') ? 'active' : '' ?>"><i class="icon-file-stats"></i> Daily Activity Log</a></li>
        </ul>
      </li>

      <!-- AMC -->
      <li class="thc-nav-item thc-has-dropdown classAmcModule<?= menuActive($params,'head','amc') ? ' open' : '' ?>">
        <a href="#" class="thc-nav-link thc-dropdown-toggle<?= menuActive($params,'head','amc') ? ' active' : '' ?>">
          <i class="icon-calculator3"></i> AMC <i class="thc-arrow icon-arrow-down22"></i>
        </a>
        <ul class="thc-dropdown">
          <li class="classSubContractorsView"><a href="subcontractors.php?param=<?= $OBJ->URLEncode('head=amc&open=3&title=amc') ?>" class="<?= menuActive($params,'open','3') ? 'active' : '' ?>"><i class="icon-briefcase3"></i> Subcontractors</a></li>
          <li class="classBookAMC"><a href="amc.php?param=<?= $OBJ->URLEncode('head=amc&open=1&title=amc') ?>" class="<?= menuActive($params,'open','1') ? 'active' : '' ?>"><i class="icon-pencil6"></i> Book AMC</a></li>
          <li class="classSearchAMC"><a href="search_amc.php?param=<?= $OBJ->URLEncode('head=amc&open=2&title=amc_list') ?>" class="<?= menuActive($params,'open','2') ? 'active' : '' ?>"><i class="icon-search4"></i> Search AMC</a></li>
          <li class="classScheduleAMC"><a href="amc_schedule.php?param=<?= $OBJ->URLEncode('head=amc&open=5&title=asset_schedule1') ?>" class="<?= menuActive($params,'open','5') ? 'active' : '' ?>"><i class="icon-calendar5"></i> Schedule AMC WO</a></li>
          <li class="classAssignServicesAMC"><a href="amc_services.php?param=<?= $OBJ->URLEncode('head=amc&open=7&title=amc_services') ?>" class="<?= menuActive($params,'open','7') ? 'active' : '' ?>"><i class="icon-wrench3"></i> Assign Services</a></li>
          <li class="classAssignTechniciansAMC"><a href="amc_assign_team.php?param=<?= $OBJ->URLEncode('head=amc&open=6&title=amc_assign') ?>" class="<?= menuActive($params,'open','6') ? 'active' : '' ?>"><i class="icon-user-check"></i> Assign Technician</a></li>
          <li class="classAMCReschedule"><a href="amc_reschedule.php?param=<?= $OBJ->URLEncode('head=amc&open=11&title=amc_extend_list') ?>" class="<?= menuActive($params,'open','11') ? 'active' : '' ?>"><i class="icon-history"></i> Request Reschedule</a></li>
          <li class="classCompletedAMCView"><a href="amc_completed.php?param=<?= $OBJ->URLEncode('head=amc&open=9&title=amc_completed_list') ?>" class="<?= menuActive($params,'open','9') ? 'active' : '' ?>"><i class="icon-checkmark2"></i> Completed AMC WO</a></li>
          <li class="classClosedAMCView"><a href="amc_closed.php?param=<?= $OBJ->URLEncode('head=amc&open=10&title=amc_closed_list') ?>" class="<?= menuActive($params,'open','10') ? 'active' : '' ?>"><i class="icon-lock2"></i> Closed AMC WO</a></li>
          <li class="classRenewAMC"><a href="amc_renewal.php?param=<?= $OBJ->URLEncode('title=amc_renewal') ?>" class="<?= menuActive($params,'title','amc_renewal') ? 'active' : '' ?>"><i class="icon-reload-alt"></i> AMC Renewal</a></li>
        </ul>
      </li>

      <!-- Material Requisition -->
      <li class="thc-nav-item thc-has-dropdown classMaterialRequisitionModule<?= menuActive($params,'head','requisition') ? ' open' : '' ?>">
        <a href="#" class="thc-nav-link thc-dropdown-toggle<?= menuActive($params,'head','requisition') ? ' active' : '' ?>">
          <i class="icon-folder-plus2"></i> Requisition <i class="thc-arrow icon-arrow-down22"></i>
        </a>
        <ul class="thc-dropdown">
          <li class="classMaterialRequisitionModify"><a href="requisition.php?param=<?= $OBJ->URLEncode('head=requisition&open=1&title=add_requisition') ?>" class="<?= menuActive($params,'open','1') ? 'active' : '' ?>"><i class="icon-pencil6"></i> Create Requisition</a></li>
          <li class="classMaterialRequisitionView"><a href="requisition_list.php?param=<?= $OBJ->URLEncode('head=requisition&open=2&title=view_requisition') ?>" class="<?= menuActive($params,'open','2') ? 'active' : '' ?>"><i class="icon-list"></i> View Requisition</a></li>
          <li><a href="request_spare_parts.php?param=<?= $OBJ->URLEncode('head=requisition&open=3&title=request_spare_parts') ?>" class="<?= menuActive($params,'open','3') ? 'active' : '' ?>"><i class="icon-wrench"></i> Request Spare Parts</a></li>
        </ul>
      </li>

      <!-- More (Feedback, Logs, Quotation, Local PO) -->
      <li class="thc-nav-item thc-has-dropdown">
        <a href="#" class="thc-nav-link thc-dropdown-toggle<?= (menuActive($params,'head','feedback') || menuActive($params,'head','log') || menuActive($params,'head','quotation') || menuActive($params,'head','localpo')) ? ' active' : '' ?>">
          <i class="icon-more2"></i> More <i class="thc-arrow icon-arrow-down22"></i>
        </a>
        <ul class="thc-dropdown thc-dropdown-right">

          <li class="thc-dropdown-section-header">Customer Feedback</li>
          <li class="classCustomerFeedbackQuestionsAdd"><a href="feedback_questions.php?param=<?= $OBJ->URLEncode('head=feedback&open=1&title=view_log') ?>" class="<?= (menuActive($params,'head','feedback') && menuActive($params,'open','1')) ? 'active' : '' ?>"><i class="icon-question3"></i> Questions</a></li>
          <li class="classCustomerFeedbackReportView"><a href="feedback_report.php?param=<?= $OBJ->URLEncode('head=feedback&open=2&title=feedback') ?>" class="<?= (menuActive($params,'head','feedback') && menuActive($params,'open','2')) ? 'active' : '' ?>"><i class="icon-comments3"></i> Feedback</a></li>

          <li class="thc-dropdown-section-header">Logs</li>
          <li><a href="admin_log.php?param=<?= $OBJ->URLEncode('head=log&open=1&title=view_log') ?>" class="<?= (menuActive($params,'head','log') && menuActive($params,'open','1')) ? 'active' : '' ?>"><i class="icon-enter3"></i> Login &amp; Logout</a></li>
          <li><a href="amc_event_log.php?param=<?= $OBJ->URLEncode('head=log&open=2&title=view_log') ?>" class="<?= (menuActive($params,'head','log') && menuActive($params,'open','2')) ? 'active' : '' ?>"><i class="icon-calculator3"></i> AMC Log</a></li>

          <li class="thc-dropdown-section-header">Quotation</li>
          <li class="classCreateQuotation"><a href="quotation.php?param=<?= $OBJ->URLEncode('head=quotation&open=1&title=add_quotation') ?>" class="<?= (menuActive($params,'head','quotation') && menuActive($params,'open','1')) ? 'active' : '' ?>"><i class="icon-pencil6"></i> Create Quotation</a></li>
          <li class="classViewQuotation"><a href="quotation_list.php?param=<?= $OBJ->URLEncode('head=quotation&open=2&title=view_quotation') ?>" class="<?= (menuActive($params,'head','quotation') && menuActive($params,'open','2')) ? 'active' : '' ?>"><i class="icon-list"></i> View Quotation</a></li>
          <li class="classViewQuotationRevision"><a href="quotation_rivision.php?param=<?= $OBJ->URLEncode('head=quotation&open=3&title=view_quotation_rivision') ?>" class="<?= (menuActive($params,'head','quotation') && menuActive($params,'open','3')) ? 'active' : '' ?>"><i class="icon-redo2"></i> Quotation Revision</a></li>

          <li class="thc-dropdown-section-header">Local PO</li>
          <li class="classCreateLocalPO"><a href="localpo.php?param=<?= $OBJ->URLEncode('head=localpo&open=1&title=add_localpo') ?>" class="<?= (menuActive($params,'head','localpo') && menuActive($params,'open','1')) ? 'active' : '' ?>"><i class="icon-pencil6"></i> Create Local PO</a></li>
          <li class="classViewLocalPO"><a href="localpo_list.php?param=<?= $OBJ->URLEncode('head=localpo&open=2&title=view_localpo') ?>" class="<?= (menuActive($params,'head','localpo') && menuActive($params,'open','2')) ? 'active' : '' ?>"><i class="icon-list"></i> View Local PO</a></li>
        </ul>
      </li>

    </ul><!-- /.thc-nav -->

    <!-- Right side: Date/Time + User info dropdown -->
    <div class="d-flex align-items-center ml-auto">
      <span class="badge badge-pill mr-3 d-none d-md-inline-flex align-items-center" id="div_date_time" style="background: rgba(255,255,255,0.18); color: #ffffff; padding: 6px 14px; font-weight: 500; font-size: 12px; letter-spacing: 0.3px; border: 1px solid rgba(255,255,255,0.25); box-shadow: 0 1px 3px rgba(0,0,0,0.1);"></span>

      <ul class="thc-nav thc-nav-right">
        <li class="thc-nav-item thc-has-dropdown">
          <a href="#" class="thc-nav-link thc-dropdown-toggle thc-user-btn">
            <?php if (!empty($_SESSION['user_image']) && file_exists(__DIR__ . '/../../httpdocs/images/employee_image/' . $_SESSION['user_image'])): ?>
              <img src="../httpdocs/images/employee_image/<?php echo $_SESSION['user_image']; ?>" class="rounded-circle mr-1" height="28" width="28" alt="User" style="object-fit: cover; border: 1px solid rgba(255,255,255,0.4);" />
            <?php else: ?>
              <i class="icon-user-tie"></i>
            <?php endif; ?>
            <span class="thc-username"><?php echo htmlspecialchars($_SESSION['user_type'] ?? $_SESSION['username'] ?? 'User'); ?></span>
            <i class="icon-arrow-down22 thc-arrow"></i>
          </a>
          <ul class="thc-dropdown thc-dropdown-right">
            <li>
              <a href="#" data-toggle="modal" data-target="#modal_form_vertical" id="reset_password">
                <i class="icon-user-plus"></i> Reset Password
              </a>
            </li>
            <li class="classGivePermission">
              <a href="roll_and_permissions.php" class="classGivePermission">
                <i class="icon-key"></i> Permission Settings
              </a>
            </li>
            <li class="thc-divider"></li>
            <li>
              <form id="logout_form" style="margin: 0; padding: 0;">
                <a href="#" id="log_out" class="dropdown-item" style="display: flex; align-items: center; gap: 10px;">
                  <i class="icon-switch2"></i> Logout
                </a>
                <span id="user_type" style="display: none;"><?php echo $_SESSION['user_type'] ?? '';?></span>
              </form>
            </li>
          </ul>
        </li>
      </ul>
    </div>

  </div><!-- /.thc-topnav-inner -->
</nav>

<script>
// Toggle mobile hamburger
document.getElementById('thcNavToggle').addEventListener('click', function() {
  document.getElementById('thcNavMenu').classList.toggle('open');
});

// Dropdown click handler for all dropdowns (including right-corner user menu)
document.querySelectorAll('.thc-has-dropdown').forEach(function(item) {
  var link = item.querySelector('.thc-dropdown-toggle');
  if (link) {
    link.addEventListener('click', function(e) {
      e.preventDefault();
      e.stopPropagation();
      var isOpen = item.classList.contains('open');
      // Close all other dropdowns
      document.querySelectorAll('.thc-has-dropdown.open').forEach(function(el) {
        if (el !== item) el.classList.remove('open');
      });
      if (!isOpen) {
        item.classList.add('open');
      } else {
        item.classList.remove('open');
      }
    });
  }
});

// Close dropdowns on outside click
document.addEventListener('click', function(e) {
  if (!e.target.closest('.thc-has-dropdown')) {
    document.querySelectorAll('.thc-has-dropdown.open').forEach(function(el) {
      el.classList.remove('open');
    });
  }
});
</script>
