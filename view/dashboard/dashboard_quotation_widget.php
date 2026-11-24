<?php
// Quotation Overview Widget for THC Dashboard
?>
<div class="d-flex flex-column" style="gap: 12px;">
    <!-- Top Hero Metric Banner -->
    <div style="background: linear-gradient(135deg, #001D39 0%, #0A4174 100%); border-radius: 10px; padding: 14px 18px; color: #ffffff; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 4px 12px rgba(0,29,57,0.18);">
        <div>
            <div style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.8px; opacity: 0.85; font-weight: 600;">Total Quotations</div>
            <div style="font-size: 26px; font-weight: 700; line-height: 1.2; font-family: 'Outfit', sans-serif;"><?= (int)($qtn_counts['Total'] ?? 0) ?></div>
            <div style="font-size: 11px; opacity: 0.75;">Active proposals & variations in system</div>
        </div>
        <div style="text-align: right;">
            <a href="quotation_module.php?param=<?= $OBJ->URLEncode('head=quotation&open=1&title=quotation') ?>" class="btn btn-sm btn-light font-weight-semibold" style="border-radius: 20px; font-size: 11.5px; padding: 6px 14px; color: #001D39; background: #ffffff; border: none; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <i class="icon-list mr-1"></i> View All
            </a>
        </div>
    </div>

    <!-- 4 Key Status Metric Boxes -->
    <div class="row" style="margin-left: -5px; margin-right: -5px; row-gap: 10px;">
        <!-- Pending Approval -->
        <div class="col-6" style="padding-left: 5px; padding-right: 5px;">
            <a href="quotation_module.php?param=<?= $OBJ->URLEncode('head=quotation&open=1&title=quotation') ?>&status=Pending%20approval" style="text-decoration: none; color: inherit; display: block;">
                <div style="background: #fffbeb; border: 1px solid #fef3c7; border-left: 4px solid #f59e0b; border-radius: 8px; padding: 10px 12px; transition: transform 0.15s, box-shadow 0.15s; height: 100%;" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 4px 10px rgba(245,158,11,0.15)';" onmouseout="this.style.transform='';this.style.boxShadow='';">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <span style="font-size: 11px; font-weight: 600; color: #92400e; text-transform: uppercase; letter-spacing: 0.5px;">Pending Approval</span>
                        <i class="icon-clock2" style="font-size: 13px; color: #f59e0b;"></i>
                    </div>
                    <div style="font-size: 20px; font-weight: 700; color: #b45309; line-height: 1.1; font-family: 'Outfit', sans-serif;"><?= (int)(($qtn_counts['Pending approval'] ?? 0) ?: ($qtn_counts['Pending'] ?? 0)) ?></div>
                    <div style="font-size: 11px; color: #78350f; margin-top: 2px;">Awaiting decision</div>
                </div>
            </a>
        </div>

        <!-- Approved -->
        <div class="col-6" style="padding-left: 5px; padding-right: 5px;">
            <a href="quotation_module.php?param=<?= $OBJ->URLEncode('head=quotation&open=1&title=quotation') ?>&status=Approved" style="text-decoration: none; color: inherit; display: block;">
                <div style="background: #f0fdf4; border: 1px solid #dcfce7; border-left: 4px solid #10b981; border-radius: 8px; padding: 10px 12px; transition: transform 0.15s, box-shadow 0.15s; height: 100%;" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 4px 10px rgba(16,185,129,0.15)';" onmouseout="this.style.transform='';this.style.boxShadow='';">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <span style="font-size: 11px; font-weight: 600; color: #166534; text-transform: uppercase; letter-spacing: 0.5px;">Approved</span>
                        <i class="icon-checkmark-circle2" style="font-size: 13px; color: #10b981;"></i>
                    </div>
                    <div style="font-size: 20px; font-weight: 700; color: #15803d; line-height: 1.1; font-family: 'Outfit', sans-serif;"><?= (int)($qtn_counts['Approved'] ?? 0) ?></div>
                    <div style="font-size: 11px; color: #14532d; margin-top: 2px;">Confirmed by client</div>
                </div>
            </a>
        </div>

        <!-- Draft -->
        <div class="col-6" style="padding-left: 5px; padding-right: 5px;">
            <a href="quotation_module.php?param=<?= $OBJ->URLEncode('head=quotation&open=1&title=quotation') ?>&status=Draft" style="text-decoration: none; color: inherit; display: block;">
                <div style="background: #eff6ff; border: 1px solid #dbeafe; border-left: 4px solid #3b82f6; border-radius: 8px; padding: 10px 12px; transition: transform 0.15s, box-shadow 0.15s; height: 100%;" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 4px 10px rgba(59,130,246,0.15)';" onmouseout="this.style.transform='';this.style.boxShadow='';">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <span style="font-size: 11px; font-weight: 600; color: #1e40af; text-transform: uppercase; letter-spacing: 0.5px;">Drafts</span>
                        <i class="icon-pencil5" style="font-size: 13px; color: #3b82f6;"></i>
                    </div>
                    <div style="font-size: 20px; font-weight: 700; color: #1d4ed8; line-height: 1.1; font-family: 'Outfit', sans-serif;"><?= (int)($qtn_counts['Draft'] ?? 0) ?></div>
                    <div style="font-size: 11px; color: #1e3a8a; margin-top: 2px;">In progress</div>
                </div>
            </a>
        </div>

        <!-- Completed -->
        <div class="col-6" style="padding-left: 5px; padding-right: 5px;">
            <a href="quotation_module.php?param=<?= $OBJ->URLEncode('head=quotation&open=1&title=quotation') ?>&status=Completed" style="text-decoration: none; color: inherit; display: block;">
                <div style="background: #faf5ff; border: 1px solid #f3e8ff; border-left: 4px solid #8b5cf6; border-radius: 8px; padding: 10px 12px; transition: transform 0.15s, box-shadow 0.15s; height: 100%;" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 4px 10px rgba(139,92,246,0.15)';" onmouseout="this.style.transform='';this.style.boxShadow='';">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <span style="font-size: 11px; font-weight: 600; color: #6b21a8; text-transform: uppercase; letter-spacing: 0.5px;">Completed</span>
                        <i class="icon-task" style="font-size: 13px; color: #8b5cf6;"></i>
                    </div>
                    <div style="font-size: 20px; font-weight: 700; color: #7c3aed; line-height: 1.1; font-family: 'Outfit', sans-serif;"><?= (int)($qtn_counts['Completed'] ?? 0) ?></div>
                    <div style="font-size: 11px; color: #581c87; margin-top: 2px;">Execution finished</div>
                </div>
            </a>
        </div>
    </div>

    <!-- Quick Action Row -->
    <div class="d-flex align-items-center justify-content-between pt-2 mt-1" style="border-top: 1px solid #f1f5f9;">
        <span style="font-size: 12px; color: #64748b;">
            <i class="icon-shield-check text-success mr-1"></i> Ready for operations
        </span>
        <a href="quotation_module.php?param=<?= $OBJ->URLEncode('head=quotation&open=1&title=quotation') ?>" class="btn btn-sm btn-outline-primary font-weight-semibold" style="border-radius: 20px; font-size: 11.5px; padding: 4px 14px;">
            Go to Quotation Module &rarr;
        </a>
    </div>
</div>
