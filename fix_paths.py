import os
import re
import sys

view_root = r"E:\thcnew\thc\view"

pattern = re.compile(
    r'((?:require|include)(?:_once)?)'   # group 1: include/require keyword
    r'\s*\(?\s*'                          # optional whitespace and (
    r'["\']'                              # opening quote
    r'((?:\.\.\/)+(?:model|controller|qr|printpdf|auth)[^"\']*)'  # group 2: relative path
    r'["\']'                              # closing quote
    r'\s*\)?',                            # optional )
    re.IGNORECASE
)

def replace_match(m):
    keyword  = m.group(1)
    rel_path = m.group(2)
    return keyword + "(__DIR__ . '/" + rel_path + "')"

fixed_count = 0
error_count = 0

for root, dirs, files in os.walk(view_root):
    # Skip backup/bkp folders
    dirs[:] = [d for d in dirs if 'backup' not in d.lower() and 'bkp' not in d.lower()]
    
    for fname in files:
        if not (fname.endswith('.php') or fname.endswith('.inc')):
            continue
        
        fpath = os.path.join(root, fname)
        
        try:
            with open(fpath, 'r', encoding='utf-8', errors='replace') as f:
                content = f.read()
            
            new_content = pattern.sub(replace_match, content)
            
            if new_content != content:
                with open(fpath, 'w', encoding='utf-8') as f:
                    f.write(new_content)
                fixed_count += 1
                short = fpath.replace(view_root, '').lstrip('\\/')
                print("FIXED: " + short)
        
        except Exception as e:
            error_count += 1
            print("ERROR: " + fpath + " -> " + str(e))

print("")
print("Total fixed: " + str(fixed_count))
print("Total errors: " + str(error_count))
