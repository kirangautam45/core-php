# Day 11: File Handling in PHP

## 50-Minute Lesson Plan

### Learning Objectives
By the end of this lesson, students will be able to:
1. Open, write, and close files using `fopen`, `fwrite`, `fclose`
2. Read files using `fread` and `fgets`
3. Append data to existing files
4. Use shortcut functions `file_get_contents` and `file_put_contents`
5. Check if files exist before working with them

### Lesson Structure (50 minutes)

| Time | Topic |
|------|-------|
| 0-5 min | Introduction - Why file handling? |
| 5-15 min | Writing to files (`fopen`, `fwrite`, `fclose`) |
| 15-25 min | Reading files (`fread`, `fgets`, `feof`) |
| 25-35 min | Appending to files |
| 35-45 min | Shortcut functions & file checks |
| 45-50 min | Practice: Simple logger |

### File Modes Quick Reference

| Mode | Description | Creates File? |
|------|-------------|---------------|
| `r` | Read only (file must exist) | No |
| `w` | Write only (overwrites!) | Yes |
| `a` | Append (adds to end) | Yes |
| `r+` | Read and write | No |
| `w+` | Read and write (overwrites!) | Yes |
| `a+` | Read and append | Yes |

### Key Functions

```php
// Writing
$file = fopen("file.txt", "w");
fwrite($file, "Hello");
fclose($file);

// Reading entire file
$file = fopen("file.txt", "r");
$content = fread($file, filesize("file.txt"));
fclose($file);

// Reading line by line
while (!feof($file)) {
    $line = fgets($file);
}

// Shortcuts
file_put_contents("file.txt", "Hello");          // Write
file_get_contents("file.txt");                   // Read
file_put_contents("file.txt", "More", FILE_APPEND); // Append

// Check file
file_exists("file.txt");  // Returns true/false
filesize("file.txt");     // Returns size in bytes
```

### Running the Lesson
```bash
cd day11
php -S localhost:8000
# Open http://localhost:8000 in browser
```

### Files Created During Lesson
- `myfile.txt` - Basic read/write practice
- `quick.txt` - Shortcut functions demo
- `log.txt` - Logger practice

### Common Mistakes to Avoid
1. Forgetting `fclose()` - always close your files!
2. Using `w` mode when you meant `a` - `w` erases everything!
3. Trying to read a file that doesn't exist - check with `file_exists()` first
