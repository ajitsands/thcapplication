import os
import re
import glob

def process_file(filepath):
    with open(filepath, 'r', encoding='utf-8', errors='ignore') as f:
        content = f.read()

    # Only process if it has left_menu.inc or page-content
    if 'template/left_menu.inc' not in content and 'page-content' not in content:
        return False

    original_content = content

    # 1. Add css
    if 'thc_topnav.css' not in content:
        # insert before </head>
        content = re.sub(r'(</head>)', r'\t<link href="assets/css/thc_topnav.css" rel="stylesheet" type="text/css">\n\1', content, flags=re.IGNORECASE)

    # 2. Remove Main navbar block
    content = re.sub(r'<!-- Main navbar -->.*?<!-- /main navbar -->', '', content, flags=re.DOTALL)
    
    # 3. Remove Page content and sidebar
    content = re.sub(r'<!-- Page content -->\s*<div class="page-content">\s*<!-- Main sidebar -->.*?<!-- /main sidebar -->', '', content, flags=re.DOTALL)
    
    # Also handle cases where <!-- Page content --> might not exactly match but page-content div and sidebar exist
    if 'class="page-content"' in content and 'left_menu.inc' in content:
        content = re.sub(r'<div class="page-content">\s*<!-- Main sidebar -->.*?<!-- /main sidebar -->', '', content, flags=re.DOTALL)

    # 4. Insert Top Nav and update content wrapper
    new_nav = """	<!-- ===== THC Horizontal Top Navigation ===== -->
	<?PHP include_once('template/top_menu_new.inc'); ?>
	<!-- ===== /THC Horizontal Top Navigation ===== -->

	<!-- Main content -->
	<div class="content-wrapper" style="margin-left:0;padding:20px 24px 0;">"""
    
    # Ensure we don't duplicate the horizontal top nav if run twice
    if 'THC Horizontal Top Navigation' not in content:
        content = re.sub(r'<!-- Main content -->\s*<div class="content-wrapper">', new_nav, content, flags=re.DOTALL)
        content = re.sub(r'<div class="content-wrapper">', new_nav, content, flags=re.DOTALL)

    # 5. Remove closing page-content div
    content = re.sub(r'</div>\s*<!-- /page content -->', '', content, flags=re.DOTALL)
    
    # If it was modified, save
    if content != original_content:
        with open(filepath, 'w', encoding='utf-8') as f:
            f.write(content)
        return True
    return False

def main():
    view_dir = 'e:/thcnew/thc/view'
    php_files = glob.glob(os.path.join(view_dir, '*.php'))
    
    count = 0
    for file in php_files:
        filename = os.path.basename(file)
        # skip dashboard and employees which are already done
        if filename in ['dashboard.php', 'employees.php']:
            continue
            
        if process_file(file):
            print(f"Updated {filename}")
            count += 1
            
    print(f"Total updated: {count}")

if __name__ == '__main__':
    main()
