import os
import re

view_root = r"E:\thcnew\thc\view"
app_root  = r"E:\thcnew\thc"

# Pattern matches: include/require(_once)? with optional ( and then a quoted relative path starting with ../
# Captures: (include_once) ("../../model/db_connection/connection.php")
pattern = re.compile(
    r"""((?:require|include)(?:_once)?)\s*\(?\s*["']((?:\.\.\/)+(?:model|controller|qr|printpdf|auth)[^"']+)["']\s*\)?""",
    re.IGNORECASE
)

fixed_files = []
errors = []

for root, dirs, files in os.walk(view_root):
    # Skip backup folders
    dirs[:] = [d for d in dirs if 'backup' not in d.lower() and 'bkp' not in d.lower()]
    
    for fname in files:
        if not fname.endswith(('.php', '.inc')):
            continue
        
        fpath = os.path.join(root, fname)
        
        try:
            with open(fpath, 'r', encoding='utf-8', errors='replace') as f:
                content = f.read()
        except Exception as e:
            errors.append(f"Read error {fpath}: {e}")
            continue
        
        original = content
        
        def replace_include(m):
            keyword = m.group(1)   # e.g. include_once
            rel_path = m.group(2)  # e.g. ../../model/db_connection/connection.php
            return f"{keyword}(__DIR__ . '/{rel_path}')"
        
        new_content = pattern.sub(replace_include, content)
        
        if new_content != original:
            try:
                with open(fpath, 'w', encoding='utf-8') as f:
                    f.write(new_content)
                fixed_files.append(fpath)
            except Exception as e:
                errors.append(f"Write error {fpath}: {e}")

print(f"\n✅ Fixed {len(fixed_files)} files:")
for f in fixed_files:
    print(f"   {f}")

if errors:
    print(f"\n❌ Errors ({len(errors)}):")
    for e in errors:
        print(f"   {e}")
