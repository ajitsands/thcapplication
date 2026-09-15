$ErrorActionPreference = "Stop"

$baseDir = "d:\Projects\thcfm"

$pages = @(
    @{ prefix="tickets_not_assigned";    js="ticket_not_assigned.js" },
    @{ prefix="tickets_pending_list";    js="ticket_pending_list.js" },
    @{ prefix="tickets_assigned";        js="ticket_assigned.js" },
    @{ prefix="tickets_completed";       js="ticket_completed.js" },
    @{ prefix="tickets_closed";          js="ticket_closed.js" },
    @{ prefix="tickets_cancelled";       js="ticket_cancelled.js" },
    @{ prefix="tickets_escalated";       js="ticket_escalated.js" }
)

foreach ($page in $pages) {
    # 1. Patch JS File
    $jsPath = Join-Path $baseDir "httpdocs\user_js\$($page.js)"
    if (Test-Path $jsPath) {
        $content = Get-Content -Path $jsPath -Raw
        if ($content -notmatch "openMaterialRequisitionModal") {
            # Find the line: dropdownHTML += '<label class="dropdown-item text-danger">You have no Privilege</label>';
            # And the preceding } 
            # We want to insert our link right before the } else { block.
            
            # Since the structure is:
            #   dropdownHTML += '...';
            # }
            # else
            
            # Let's just do a regex replace on the closing brace of the if block before else
            $content = $content -replace "(?m)(dropdownHTML \+= '.*?';\s*)\r?\n(\s*)\}\s*else\s*\{", "`$1`r`n`$2    dropdownHTML += '<div class=`"dropdown-divider`"></div><a href=`"javascript:void(0);`" class=`"dropdown-item`" onclick=`"openMaterialRequisitionModal(\'\'+data+\'\')`" style=`"color: black;`"><i class=`"icon-cube`"></i> Material Requisition</a>';`r`n`$2}`r`n`$2else {"
            
            # Handle cases where there is no else, or it's formatted differently
            # Alternative: find `dropdownHTML += '</div></div></div>';` and if the file doesn't have openMaterialRequisitionModal, 
            # we just replace `dropdownHTML += '</div></div></div>';` with:
            # `if (filteredOptions !== "") { dropdownHTML += '<div class="dropdown-divider"></div><a href="javascript:void(0);" class="dropdown-item" onclick="openMaterialRequisitionModal(\''+data+'\')" style="color: black;"><i class="icon-cube"></i> Material Requisition</a>'; } dropdownHTML += '</div></div></div>';`
            # This is much safer and works regardless of the if/else structure.
            
            $safeReplace = "if (filteredOptions != `"`") { dropdownHTML += '<div class=`"dropdown-divider`"></div><a href=`"javascript:void(0);`" class=`"dropdown-item`" onclick=`"openMaterialRequisitionModal(\''+data+'\')`" style=`"color: black;`"><i class=`"icon-cube`"></i> Material Requisition</a>'; }`r`n`$0"
            
            $content = Get-Content -Path $jsPath -Raw
            $content = $content -replace "(?m)^\s*dropdownHTML \+= '<\/div><\/div><\/div>';", $safeReplace
            
            Set-Content -Path $jsPath -Value $content
            Write-Host "Patched $jsPath"
        } else {
            Write-Host "Already patched $jsPath"
        }
    }

    # 2. Patch PHP File
    $phpPath = Join-Path $baseDir "view\$($page.prefix).php"
    if (Test-Path $phpPath) {
        $content = Get-Content -Path $phpPath -Raw
        
        $modified = $false
        
        if ($content -notmatch "view_material_requests_ticket_modal.js") {
            # Insert after the existing script include
            $content = $content -replace "(<script src=`"\.\./httpdocs/user_js/$($page.js)`"></script>)", "`$1`r`n`t<script src=`"../httpdocs/user_js/view_material_requests_ticket_modal.js`"></script>"
            $modified = $true
        }
        
        if ($content -notmatch "view_ticket_material_requests_modal.php") {
            # Insert after modal_view_ticket.php or before footer
            if ($content -match "include_once\('tickets/view_ticket_modal_") {
                $content = $content -replace "(include_once\('tickets/view_ticket_modal_[a-z0-9_]+\.php'\);)", "`$1`r`n`t`t`t`tinclude_once('tickets/view_ticket_material_requests_modal.php');"
            } else {
                $content = $content -replace "(<!-- Footer -->)", "<?PHP include_once('tickets/view_ticket_material_requests_modal.php'); ?>`r`n`t`t`t<!-- Footer -->"
            }
            $modified = $true
        }
        
        if ($modified) {
            Set-Content -Path $phpPath -Value $content
            Write-Host "Patched $phpPath"
        } else {
            Write-Host "Already patched $phpPath"
        }
    }
}
Write-Host "Done"
