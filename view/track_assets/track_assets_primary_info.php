<?PHP
include(__DIR__ . '/../../model/db_connection/connection.php');

$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();

$asset_code = isset($_POST['asset_code']) ? mysqli_real_escape_string($varDBConnection, trim($_POST['asset_code'])) : '';

if (empty($asset_code)) {
    echo '<div class="alert alert-warning border-0 alert-dismissible" style="background:#fffbeb; color:#b45309; border:1px solid #fde68a !important; border-radius:8px;">
            <i class="icon-warning22 mr-2"></i> Please provide a valid Asset Barcode.
          </div>';
    exit;
}

$result = mysqli_query($varDBConnection, "SELECT *, DATE_FORMAT(warentee_end_date, '%d-%m-%Y') as warentee_end_date FROM tbl_assets WHERE asset_ref_no = '$asset_code' LIMIT 1");
$num_rows = $result ? mysqli_num_rows($result) : 0;

if ($num_rows > 0) {
    $row = mysqli_fetch_assoc($result);

    // Fetch customer details
    $cust_contact_no = '-';
    $cust_email_id = '-';
    $cust_code = mysqli_real_escape_string($varDBConnection, $row['customer_code']);
    $result_cust = mysqli_query($varDBConnection, "SELECT customer_contact_no, customer_email_id FROM tbl_customers WHERE customer_code = '$cust_code' LIMIT 1");
    if ($result_cust && $row_cust = mysqli_fetch_assoc($result_cust)) {
        $cust_contact_no = !empty($row_cust['customer_contact_no']) && $row_cust['customer_contact_no'] != 'NA' ? $row_cust['customer_contact_no'] : '-';
        $cust_email_id = !empty($row_cust['customer_email_id']) && $row_cust['customer_email_id'] != 'NA' ? $row_cust['customer_email_id'] : '-';
    }

    // Fetch service history
    $result_service = mysqli_query($varDBConnection, "
        SELECT service_description, DATE_FORMAT(service_complete_cancel_date_time, '%d-%m-%Y') as service_complete_cancel_date_time, tech_remarks, tech_audio_file, ticket_ref_code as ref, ticket_id, 'Ticket' as service_source 
        FROM tbl_ticket_services 
        WHERE asset_code = '$asset_code' AND ticket_service_status IN ('Completed','Closed') 
        UNION 
        SELECT service_description, DATE_FORMAT(service_complete_cancel_date_time, '%d-%m-%Y') as service_complete_cancel_date_time, tech_remarks, tech_audio_file, amc_ref_code as ref, amc_visit_id as ticket_id, 'AMC' as service_source 
        FROM tbl_amc_services 
        WHERE asset_code = '$asset_code' AND amc_service_status IN ('Completed','Closed')
    ");

    $services_list = [];
    if ($result_service) {
        while ($rs = mysqli_fetch_assoc($result_service)) {
            $services_list[] = $rs;
        }
    }
    $total_services = count($services_list);

    $is_active = (strcasecmp(trim($row['asset_status']), 'Active') === 0);
    $has_attachment = (!empty($row['asset_attachment']) && $row['asset_attachment'] != 'default.jpg' && $row['asset_attachment'] != 'NA');
    $attachment_path = $has_attachment ? '../httpdocs/images/amc_attachements/' . $row['asset_attachment'] : '';
    ?>

    <!-- Hero Asset Header Card -->
    <div class="card mb-3" style="box-shadow: 0 4px 18px rgba(0,0,0,0.06); border-radius: 8px; border: 1px solid #e2e8f0; overflow: hidden;">
        <div style="background: linear-gradient(135deg, #2e2e79 0%, #1e1b4b 100%); padding: 22px 24px; color: #ffffff;">
            <div class="row align-items-center">
                <div class="col-md-9 col-sm-12">
                    <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap; margin-bottom: 8px;">
                        <span style="background: #ffffff; color: #2e2e79; padding: 4px 10px; border-radius: 6px; font-family: monospace; font-size: 14px; font-weight: 700; letter-spacing: 0.5px;">
                            <i class="icon-barcode2 mr-1"></i> <?php echo htmlspecialchars($asset_code); ?>
                        </span>
                        <?php if ($is_active) { ?>
                            <span style="background: #22c55e; color: #ffffff; padding: 3px 10px; border-radius: 12px; font-size: 11px; font-weight: 700; text-transform: uppercase;">
                                &#10003; Active
                            </span>
                        <?php } else { ?>
                            <span style="background: #ef4444; color: #ffffff; padding: 3px 10px; border-radius: 12px; font-size: 11px; font-weight: 700; text-transform: uppercase;">
                                &#10007; <?php echo htmlspecialchars($row['asset_status'] ? $row['asset_status'] : 'Inactive'); ?>
                            </span>
                        <?php } ?>

                        <?php if (!empty($row['asset_category_name'])) { ?>
                            <span style="background: rgba(255,255,255,0.15); color: #ffffff; border: 1px solid rgba(255,255,255,0.25); padding: 3px 9px; border-radius: 12px; font-size: 11.5px;">
                                <?php echo htmlspecialchars($row['asset_category_name']); ?>
                            </span>
                        <?php } ?>
                    </div>

                    <h3 style="color: #ffffff; font-weight: 700; margin: 0 0 6px 0; font-size: 20px;">
                        <?php echo htmlspecialchars(!empty($row['asset_type_name']) ? $row['asset_type_name'] : $row['asset_category_name']); ?>
                        <?php if (!empty($row['asset_brand']) && $row['asset_brand'] != 'NA') { ?>
                            <span style="font-size: 15px; font-weight: 400; opacity: 0.85;"> &bull; <?php echo htmlspecialchars($row['asset_brand']); ?></span>
                        <?php } ?>
                    </h3>

                    <div style="font-size: 12.5px; opacity: 0.9; display: flex; gap: 16px; flex-wrap: wrap; margin-top: 4px;">
                        <span><i class="icon-user mr-1"></i> <strong><?php echo htmlspecialchars($row['customer_name']); ?></strong> (<?php echo htmlspecialchars($row['customer_code']); ?>)</span>
                        <span><i class="icon-office mr-1"></i> <?php echo htmlspecialchars($row['asset_building']); ?></span>
                        <span><i class="icon-location4 mr-1"></i> <?php echo htmlspecialchars($row['asset_location']); ?></span>
                    </div>
                </div>

                <div class="col-md-3 col-sm-12 text-md-right mt-3 mt-md-0">
                    <?php if ($has_attachment) { ?>
                        <a href="<?php echo htmlspecialchars($attachment_path); ?>" target="_blank" title="Click to view full image" style="display: inline-block;">
                            <img src="<?php echo htmlspecialchars($attachment_path); ?>" alt="Asset Image" style="height: 72px; width: 72px; object-fit: cover; border-radius: 8px; border: 2px solid rgba(255,255,255,0.4); box-shadow: 0 4px 10px rgba(0,0,0,0.2); transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'" />
                        </a>
                    <?php } else { ?>
                        <div style="display: inline-flex; align-items: center; justify-content: center; height: 72px; width: 72px; border-radius: 8px; background: rgba(255,255,255,0.1); border: 2px dashed rgba(255,255,255,0.3); color: rgba(255,255,255,0.6);">
                            <i class="icon-image2" style="font-size: 28px;"></i>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Asset Tabs & Content Card -->
    <div class="card" style="box-shadow: 0 4px 18px rgba(0,0,0,0.06); border-radius: 8px; border: 1px solid #e2e8f0; overflow: hidden;">
        <!-- Navigation Tabs -->
        <div style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 8px 20px 0;">
            <ul class="nav nav-tabs nav-tabs-bottom mb-0 border-bottom-0" style="gap: 8px;">
                <li class="nav-item">
                    <a href="#tab-customer-location" class="nav-link active font-weight-semibold" data-toggle="tab" style="padding: 12px 18px; font-size: 13px;">
                        <i class="icon-location4 mr-2"></i> Customer &amp; Location
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#tab-general-specs" class="nav-link font-weight-semibold" data-toggle="tab" style="padding: 12px 18px; font-size: 13px;">
                        <i class="icon-cog mr-2"></i> Technical &amp; Specifications
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#tab-service-history" class="nav-link font-weight-semibold" data-toggle="tab" style="padding: 12px 18px; font-size: 13px;">
                        <i class="icon-wrench mr-2"></i> Service History 
                        <span class="badge badge-pill badge-primary ml-1" style="background: #2e2e79;"><?php echo $total_services; ?></span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Tab Contents -->
        <div class="card-body" style="padding: 24px;">
            <div class="tab-content">
                
                <!-- TAB 1: Customer & Location -->
                <div class="tab-pane fade show active" id="tab-customer-location">
                    <div class="row">
                        <!-- Customer Details Box -->
                        <div class="col-md-6 col-sm-12 mb-4 mb-md-0">
                            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 18px; height: 100%;">
                                <h6 class="font-weight-bold" style="color: #2e2e79; border-bottom: 1.5px solid #cbd5e1; padding-bottom: 8px; margin-bottom: 14px;">
                                    <i class="icon-user mr-1"></i> Customer Information
                                </h6>
                                <table class="table table-borderless table-sm mb-0">
                                    <tbody>
                                        <tr>
                                            <td style="width: 140px; color: #64748b; font-weight: 600; padding: 6px 0;">Customer Name:</td>
                                            <td style="font-weight: 700; color: #1e293b; padding: 6px 0;"><?php echo htmlspecialchars($row['customer_name']); ?></td>
                                        </tr>
                                        <tr>
                                            <td style="color: #64748b; font-weight: 600; padding: 6px 0;">Customer Code:</td>
                                            <td style="font-weight: 600; color: #2e2e79; padding: 6px 0;"><?php echo htmlspecialchars($row['customer_code']); ?></td>
                                        </tr>
                                        <tr>
                                            <td style="color: #64748b; font-weight: 600; padding: 6px 0;">Contact Number:</td>
                                            <td style="font-weight: 600; padding: 6px 0;">
                                                <?php if ($cust_contact_no != '-') { ?>
                                                    <a href="tel:<?php echo htmlspecialchars($cust_contact_no); ?>" style="color: #2e2e79;">
                                                        <i class="icon-phone mr-1"></i><?php echo htmlspecialchars($cust_contact_no); ?>
                                                    </a>
                                                <?php } else { echo '-'; } ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="color: #64748b; font-weight: 600; padding: 6px 0;">Email Address:</td>
                                            <td style="padding: 6px 0;">
                                                <?php if ($cust_email_id != '-') { ?>
                                                    <a href="mailto:<?php echo htmlspecialchars($cust_email_id); ?>" style="color: #2e2e79;">
                                                        <i class="icon-envelop mr-1"></i><?php echo htmlspecialchars($cust_email_id); ?>
                                                    </a>
                                                <?php } else { echo '-'; } ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Location Details Box -->
                        <div class="col-md-6 col-sm-12">
                            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 18px; height: 100%;">
                                <h6 class="font-weight-bold" style="color: #2e2e79; border-bottom: 1.5px solid #cbd5e1; padding-bottom: 8px; margin-bottom: 14px;">
                                    <i class="icon-office mr-1"></i> Location &amp; Space Placement
                                </h6>
                                <table class="table table-borderless table-sm mb-0">
                                    <tbody>
                                        <tr>
                                            <td style="width: 140px; color: #64748b; font-weight: 600; padding: 6px 0;">Location:</td>
                                            <td style="font-weight: 600; color: #1e293b; padding: 6px 0;">
                                                <?php echo htmlspecialchars($row['asset_location']); ?>
                                                <?php if (!empty($row['location_code']) && $row['location_code'] != 'NA') { ?>
                                                    <span class="badge badge-light border ml-1"><?php echo htmlspecialchars($row['location_code']); ?></span>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="color: #64748b; font-weight: 600; padding: 6px 0;">Facility / Building:</td>
                                            <td style="font-weight: 600; color: #1e293b; padding: 6px 0;">
                                                <?php echo htmlspecialchars($row['asset_building']); ?>
                                                <?php if (!empty($row['building_code']) && $row['building_code'] != 'NA') { ?>
                                                    <span class="badge badge-light border ml-1"><?php echo htmlspecialchars($row['building_code']); ?></span>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="color: #64748b; font-weight: 600; padding: 6px 0;">Zone / Floor:</td>
                                            <td style="padding: 6px 0;"><?php echo htmlspecialchars(!empty($row['zone_floor']) && $row['zone_floor'] != 'NA' ? $row['zone_floor'] : '-'); ?></td>
                                        </tr>
                                        <tr>
                                            <td style="color: #64748b; font-weight: 600; padding: 6px 0;">Flat / Area Code:</td>
                                            <td style="padding: 6px 0;"><?php echo htmlspecialchars(!empty($row['flat_area_code']) && $row['flat_area_code'] != 'NA' ? $row['flat_area_code'] : '-'); ?></td>
                                        </tr>
                                        <tr>
                                            <td style="color: #64748b; font-weight: 600; padding: 6px 0;">Room Number:</td>
                                            <td style="padding: 6px 0;"><?php echo htmlspecialchars(!empty($row['room_no']) && $row['room_no'] != 'NA' ? $row['room_no'] : '-'); ?></td>
                                        </tr>
                                        <?php if (!empty($row['asset_sp_des']) && $row['asset_sp_des'] != 'NA') { ?>
                                        <tr>
                                            <td style="color: #64748b; font-weight: 600; padding: 6px 0;">Specific Placement:</td>
                                            <td style="padding: 6px 0;"><?php echo htmlspecialchars($row['asset_sp_des']); ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 2: General & Technical Specs -->
                <div class="tab-pane fade" id="tab-general-specs">
                    <div class="row">
                        <!-- Equipment Specifications Box -->
                        <div class="col-md-6 col-sm-12 mb-4 mb-md-0">
                            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 18px; height: 100%;">
                                <h6 class="font-weight-bold" style="color: #2e2e79; border-bottom: 1.5px solid #cbd5e1; padding-bottom: 8px; margin-bottom: 14px;">
                                    <i class="icon-cogs mr-1"></i> Technical Specifications
                                </h6>
                                <table class="table table-borderless table-sm mb-0">
                                    <tbody>
                                        <tr>
                                            <td style="width: 140px; color: #64748b; font-weight: 600; padding: 6px 0;">Category:</td>
                                            <td style="font-weight: 600; color: #1e293b; padding: 6px 0;"><?php echo htmlspecialchars($row['asset_category_name'] ? $row['asset_category_name'] : '-'); ?></td>
                                        </tr>
                                        <tr>
                                            <td style="color: #64748b; font-weight: 600; padding: 6px 0;">Asset Type:</td>
                                            <td style="font-weight: 600; color: #2e2e79; padding: 6px 0;"><?php echo htmlspecialchars($row['asset_type_name'] ? $row['asset_type_name'] : '-'); ?></td>
                                        </tr>
                                        <tr>
                                            <td style="color: #64748b; font-weight: 600; padding: 6px 0;">Brand:</td>
                                            <td style="padding: 6px 0;"><?php echo htmlspecialchars(!empty($row['asset_brand']) && $row['asset_brand'] != 'NA' ? $row['asset_brand'] : '-'); ?></td>
                                        </tr>
                                        <tr>
                                            <td style="color: #64748b; font-weight: 600; padding: 6px 0;">Model / Serial No:</td>
                                            <td style="font-weight: 600; padding: 6px 0;"><?php echo htmlspecialchars(!empty($row['asset_serial_no']) && $row['asset_serial_no'] != 'NA' ? $row['asset_serial_no'] : '-'); ?></td>
                                        </tr>
                                        <tr>
                                            <td style="color: #64748b; font-weight: 600; padding: 6px 0;">Capacity:</td>
                                            <td style="padding: 6px 0;"><?php echo htmlspecialchars(!empty($row['asset_capacity']) && $row['asset_capacity'] != 'NA' ? $row['asset_capacity'] : '-'); ?></td>
                                        </tr>
                                        <tr>
                                            <td style="color: #64748b; font-weight: 600; padding: 6px 0;">Asset Cost:</td>
                                            <td style="font-weight: 700; color: #047857; padding: 6px 0;">
                                                <?php echo !empty($row['asset_cost']) && $row['asset_cost'] != '0' && $row['asset_cost'] != 'NA' ? htmlspecialchars($row['asset_cost']) . ' BHD' : '-'; ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Warranty & Attachment Box -->
                        <div class="col-md-6 col-sm-12">
                            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 18px; height: 100%;">
                                <h6 class="font-weight-bold" style="color: #2e2e79; border-bottom: 1.5px solid #cbd5e1; padding-bottom: 8px; margin-bottom: 14px;">
                                    <i class="icon-shield-check mr-1"></i> Warranty &amp; Documents
                                </h6>
                                <table class="table table-borderless table-sm mb-0">
                                    <tbody>
                                        <tr>
                                            <td style="width: 140px; color: #64748b; font-weight: 600; padding: 6px 0;">Warranty Status:</td>
                                            <td style="padding: 6px 0;">
                                                <?php if (strcasecmp($row['is_warentee'], 'YES') === 0) { ?>
                                                    <span class="badge badge-success" style="background:#dcfce7; color:#15803d; border:1px solid #86efac; font-weight:700;">Under Warranty</span>
                                                <?php } else { ?>
                                                    <span class="badge badge-light border" style="color:#64748b;">No Warranty (NA)</span>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="color: #64748b; font-weight: 600; padding: 6px 0;">Warranty Upto:</td>
                                            <td style="font-weight: 600; color: #b45309; padding: 6px 0;">
                                                <?php echo !empty($row['warentee_end_date']) && $row['warentee_end_date'] != '00-00-0000' ? htmlspecialchars($row['warentee_end_date']) : '-'; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="color: #64748b; font-weight: 600; padding: 6px 0;">Description:</td>
                                            <td style="padding: 6px 0;"><?php echo !empty($row['asset_description']) && $row['asset_description'] != 'NA' ? nl2br(htmlspecialchars($row['asset_description'])) : '-'; ?></td>
                                        </tr>
                                        <tr>
                                            <td style="color: #64748b; font-weight: 600; padding: 6px 0;">Photo / Attachment:</td>
                                            <td style="padding: 6px 0;">
                                                <?php if ($has_attachment) { ?>
                                                    <a href="<?php echo htmlspecialchars($attachment_path); ?>" target="_blank" class="btn btn-sm btn-light border" style="font-weight: 600; color: #2e2e79;">
                                                        <i class="icon-file-picture mr-1"></i> View Attachment
                                                    </a>
                                                <?php } else { ?>
                                                    <span class="text-muted">No attachment uploaded</span>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 3: Service History -->
                <div class="tab-pane fade" id="tab-service-history">
                    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden;">
                        <div style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 14px 18px; display: flex; justify-content: space-between; align-items: center;">
                            <h6 class="font-weight-bold mb-0" style="color: #2e2e79;">
                                <i class="icon-history mr-1"></i> Service &amp; Maintenance Logs
                            </h6>
                            <span class="badge badge-light border" style="font-weight: 600;">Total Services: <?php echo $total_services; ?></span>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0" style="font-size: 12.5px;">
                                <thead>
                                    <tr style="background: #f1f5f9; color: #334155; font-weight: 700;">
                                        <th style="width: 45px; text-align: center;">#</th>
                                        <th style="width: 170px;">Work Order No.</th>
                                        <th>Service Details</th>
                                        <th style="width: 140px;">Completed On</th>
                                        <th>Technician Remarks</th>
                                        <th style="width: 70px; text-align: center;">Audio</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    if ($total_services > 0) {
                                        $sl = 0;
                                        foreach ($services_list as $row_service) {
                                            $sl++;
                                            $is_ticket = ($row_service['service_source'] === 'Ticket');
                                            $ref_str = 'WO-' . $row_service['ref'] . '-' . $row_service['ticket_id'];
                                            $print_url = $is_ticket ? "../view/work_order_print.php?ticket_id=" . $row_service['ticket_id'] : "#";
                                            $has_audio = (!empty($row_service['tech_audio_file']) && $row_service['tech_audio_file'] != 'NA');
                                            ?>
                                            <tr>
                                                <td style="text-align: center; font-weight: 600; color: #64748b;"><?php echo $sl; ?></td>
                                                <td>
                                                    <?php if ($is_ticket) { ?>
                                                        <a href="<?php echo htmlspecialchars($print_url); ?>" target="_blank" style="color: #2e2e79; font-weight: 700; text-decoration: none;">
                                                            <i class="icon-file-text2 mr-1"></i> <?php echo htmlspecialchars($ref_str); ?>
                                                        </a>
                                                    <?php } else { ?>
                                                        <span style="font-weight: 700; color: #0369a1;"><?php echo htmlspecialchars($ref_str); ?></span>
                                                    <?php } ?>
                                                </td>
                                                <td style="font-weight: 500;"><?php echo htmlspecialchars($row_service['service_description']); ?></td>
                                                <td>
                                                    <i class="icon-calendar2 mr-1 text-muted"></i>
                                                    <?php echo htmlspecialchars($row_service['service_complete_cancel_date_time']); ?>
                                                </td>
                                                <td><?php echo !empty($row_service['tech_remarks']) && $row_service['tech_remarks'] != 'NA' ? htmlspecialchars($row_service['tech_remarks']) : '-'; ?></td>
                                                <td style="text-align: center;">
                                                    <?php if ($has_audio) { ?>
                                                        <a href="../httpdocs/audios/<?php echo htmlspecialchars($row_service['tech_audio_file']); ?>" target="_blank" class="btn btn-sm btn-light border p-1" title="Play Technician Voice Note" style="color: #2e2e79;">
                                                            <i class="icon-play3" style="color: #15803d;"></i>
                                                        </a>
                                                    <?php } else { ?>
                                                        <span class="text-muted">-</span>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php 
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="6" style="text-align: center; padding: 24px; color: #64748b; font-style: italic;">
                                                <i class="icon-info22 mr-1"></i> No service or maintenance records found for this asset.
                                            </td>
                                        </tr>
                                        <?php 
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <?PHP 
} else { 
    ?>
    <div class="card" style="box-shadow: 0 4px 18px rgba(0,0,0,0.04); border-radius: 8px; border: 1px solid #fee2e2; background: #fffaf0;">
        <div class="card-body text-center" style="padding: 36px 20px;">
            <div style="display: inline-flex; align-items: center; justify-content: center; height: 56px; width: 56px; border-radius: 50%; background: #fee2e2; color: #dc2626; margin-bottom: 14px;">
                <i class="icon-cross2" style="font-size: 28px;"></i>
            </div>
            <h5 class="font-weight-bold" style="color: #991b1b; margin-bottom: 6px;">Asset Record Not Found</h5>
            <p class="text-muted mb-0" style="font-size: 13px;">
                No asset was found matching barcode reference: <strong style="font-family: monospace; color: #1e293b;"><?php echo htmlspecialchars($asset_code); ?></strong>.<br>
                Please verify the barcode or try scanning again.
            </p>
        </div>
    </div>
    <?PHP 
}
?>