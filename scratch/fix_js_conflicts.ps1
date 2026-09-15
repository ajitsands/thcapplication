$ErrorActionPreference = "Stop"

$baseDir = "d:\Projects\thcfm"

$pages = @(
    "tickets_not_assigned.php",
    "tickets_pending_list.php",
    "tickets_assigned.php",
    "tickets_completed.php",
    "tickets_closed.php",
    "tickets_cancelled.php",
    "tickets_escalated.php"
)

foreach ($php in $pages) {
    $phpPath = Join-Path $baseDir "view\$php"
    if (Test-Path $phpPath) {
        $content = Get-Content -Path $phpPath -Raw
        
        if ($content -match "<script src=`"\.\./httpdocs/user_js/view_material_requisition_modal\.js`"></script>") {
            $content = $content -replace "\s*<script src=`"\.\./httpdocs/user_js/view_material_requisition_modal\.js`"></script>", ""
            Set-Content -Path $phpPath -Value $content
            Write-Host "Removed duplicate script from $phpPath"
        } else {
            Write-Host "No duplicate found in $phpPath"
        }
    }
}
Write-Host "Done"
