# Fix all relative include paths in view/ PHP files
# Replace ../model/ patterns with __DIR__ . '/../model/' etc.

$viewRoot = "E:\thcnew\thc\view"
$appRoot  = "E:\thcnew\thc"

$files = Get-ChildItem -Path $viewRoot -Recurse -Include "*.php","*.inc"

$fixedCount = 0

foreach ($file in $files) {
    $content = Get-Content $file.FullName -Raw -Encoding UTF8
    if ($null -eq $content) { continue }
    if ($content -notmatch 'include') { continue }

    $original = $content

    # Calculate relative depth from this file's directory to APP_ROOT
    $fileDir = $file.DirectoryName
    $relPath = [System.IO.Path]::GetRelativePath($appRoot, $fileDir)
    $depth = ($relPath.Split([System.IO.Path]::DirectorySeparatorChar) | Where-Object { $_ -ne "." }).Count

    # Build the __DIR__ prefix to reach app root
    # e.g. if file is in view/dashboard/ (depth 2), we need __DIR__ . '/../../'
    $upPath = ("../" * $depth).TrimEnd("/")
    $dirPrefix = "__DIR__ . '/" + $upPath + "/'"

    # Replace common relative include patterns:
    # include("../../model/...") -> include(__DIR__ . '/../../model/...')
    # include('../model/...')    -> include(__DIR__ . '/../model/...')
    # include("../model/...")    -> include(__DIR__ . '/../model/...')
    
    # Pattern: include(_once)?(\s*)\(? then quotes then ../
    $content = $content -replace `
        '((?:require|include)(?:_once)?)\s*[\("'"'"']\s*((?:\.\.\/)+(?:model|controller|view|qr|printpdf)[^"'"'"'\)]+)["\'"'"']\s*\)?', `
        '$1(__DIR__ . '"'"'/$2'"'"')'

    if ($content -ne $original) {
        Set-Content -Path $file.FullName -Value $content -Encoding UTF8 -NoNewline
        $fixedCount++
        Write-Host "Fixed: $($file.FullName)"
    }
}

Write-Host ""
Write-Host "Total files fixed: $fixedCount"
