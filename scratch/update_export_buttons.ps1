$ErrorActionPreference = "Stop"

$baseDir = "d:\Projects\thcfm\view"

$files = Get-ChildItem -Path $baseDir -Recurse -Filter *.php

$pdfClassesToRemove = "bg-warning-400", "bg-warning", "btn-warning", "bg-danger-400", "bg-danger", "btn-danger", "bg-info"
$excelClassesToRemove = "bg-primary-400", "bg-primary", "btn-primary", "bg-success-400", "bg-success", "btn-success"

$pdfClassToAdd = "bg-white text-danger border-danger font-weight-semibold shadow-sm"
$excelClassToAdd = "bg-white text-success border-success font-weight-semibold shadow-sm"

$count = 0

foreach ($file in $files) {
    $content = Get-Content -Path $file.FullName -Raw
    $modified = $false
    
    # We will split the content into lines to safely parse buttons
    $lines = $content -split "`r`n"
    if ($lines.Count -eq 1) { $lines = $content -split "`n" }
    
    for ($i = 0; $i -lt $lines.Count; $i++) {
        $line = $lines[$i]
        
        # Only process lines that have a button tag and mention PDF or Excel
        if ($line -match "<button[^>]+>") {
            if ($line -match "PDF" -or $line -match "pdf") {
                # Is this a PDF export button? (checks id or class or text)
                if ($line -match "(exportToPDF|class.*PDF|id=`".*pdf`"|PDF\s*<\/button>)") {
                    $newLine = $line
                    foreach ($c in $pdfClassesToRemove) {
                        $newLine = $newLine -replace "\b$c\b", $pdfClassToAdd
                    }
                    
                    # Deduplicate classes just in case
                    # We inserted a long string multiple times if there were multiple hits. Better approach:
                    if ($newLine -ne $line) {
                        # Clean up multiple inserts of the same class string
                        $newLine = $newLine -replace "($pdfClassToAdd\s*){2,}", "$pdfClassToAdd "
                        $lines[$i] = $newLine
                        $modified = $true
                    }
                }
            }
            
            if ($line -match "Excel" -or $line -match "excel") {
                # Is this an Excel export button?
                if ($line -match "(exportToExcel|class.*Excel|id=`".*excel`"|Excel\s*<\/button>)") {
                    $newLine = $line
                    foreach ($c in $excelClassesToRemove) {
                        $newLine = $newLine -replace "\b$c\b", $excelClassToAdd
                    }
                    
                    if ($newLine -ne $line) {
                        $newLine = $newLine -replace "($excelClassToAdd\s*){2,}", "$excelClassToAdd "
                        $lines[$i] = $newLine
                        $modified = $true
                    }
                }
            }
        }
    }
    
    if ($modified) {
        $newContent = $lines -join "`r`n"
        Set-Content -Path $file.FullName -Value $newContent
        Write-Host "Updated $($file.FullName)"
        $count++
    }
}

Write-Host "Updated $count files."
