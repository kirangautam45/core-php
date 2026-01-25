# Day 12: File Uploads in PHP

## 50-Minute Lesson Plan

### Learning Objectives

By the end of this lesson, students will be able to:

1. Create HTML forms for file uploads
2. Process uploaded files using $\_FILES
3. Validate uploads (type, size, security)
4. Handle multiple file uploads

### Lesson Structure (50 minutes)

| Time      | Topic                        | File                    |
| --------- | ---------------------------- | ----------------------- |
| 0-5 min   | Upload security overview     | Lecture                 |
| 5-15 min  | Basic upload form & $\_FILES | 01_basic_upload.php     |
| 15-30 min | Validation & security        | 02_secure_upload.php    |
| 30-45 min | Multiple file uploads        | 03_multiple_uploads.php |
| 45-50 min | Practice & Q&A               | -                       |

### $\_FILES Structure

When a file is uploaded, PHP creates an array with:

```php
$_FILES['fieldname'] = [
    'name'     => 'photo.jpg',      // Original filename
    'type'     => 'image/jpeg',     // MIME type (don't trust!)
    'size'     => 12345,            // Size in bytes
    'tmp_name' => '/tmp/php123',    // Temporary location
    'error'    => 0                 // Error code
];
```

### Upload Error Codes

| Code | Constant             | Meaning               |
| ---- | -------------------- | --------------------- |
| 0    | UPLOAD_ERR_OK        | Success               |
| 1    | UPLOAD_ERR_INI_SIZE  | Exceeds php.ini limit |
| 2    | UPLOAD_ERR_FORM_SIZE | Exceeds form limit    |
| 3    | UPLOAD_ERR_PARTIAL   | Partial upload        |
| 4    | UPLOAD_ERR_NO_FILE   | No file selected      |

### Security Checklist

1. Always validate file type server-side (use finfo, not $\_FILES['type'])
2. Check file size limits
3. Generate unique filenames (don't use user's filename)
4. Store uploads outside web root when possible
5. Never execute uploaded files

### Running the Examples

```bash
cd /Users/kiran/Developer/codephp/days/day12-uploads-lesson
php -S localhost:8012
# Open browser to http://localhost:8012
```

### Homework

Build an image gallery that accepts multiple uploads
