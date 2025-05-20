<?php

/**
 * Render a view
 *
 * @param string $view The view name
 * @param array $data The data to pass to the view
 * @param string|null $layout The layout to use
 *
 * @return void
 */
function render_view(string $view, array $data = [], string|null $layout = null)
{
  $path = VIEW_DIR . '/' . $view . '.php';

  if (!file_exists($path)) {
    throw new Exception('View not found: ' . $view); // Throw an exception if the view is not found
  }

  extract($data, EXTR_PREFIX_SAME, '__var_'); // Extract variables from $data

  if ($layout === null) {
    require $path; // Include the view file
    return;
  }

  $layoutPath = VIEW_DIR . '/layouts/' . $layout . '.php';

  if (!file_exists($layoutPath)) {
    throw new Exception('Layout not found: ' . $layout); // Throw an exception if the layout is not found
  }

  // keyword: output buffering
  ob_start(); // Start output buffering
  require $path; // Include the view file
  $content = ob_get_clean(); // Get the output buffer and clean it

  $data['content'] = $content; // Add the content to the data array
  extract($data, EXTR_PREFIX_SAME, '__var_'); // Extract variables from $data

  require $layoutPath; // Include the layout file
}

/**
 * Get the PDO instance
 *
 * @return \PDO
 */
function PDO(): \PDO
{
  static $pdo = null;

    if ($pdo === null) {
        $host = 'localhost';
        $dbname = 'petcareweb_db';   // <--- sửa theo tên database của bạn
        $username = 'root';
        $password = '';       // <--- mặc định XAMPP

        try {
            $pdo = new \PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    return $pdo;
}

function base_url(string $path = '')
{
  $baseUrl = defined('BASE_URL') ? BASE_URL : '';

  if (empty($baseUrl)) {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost'; // if HTTP_HOST is not set, use localhost
    $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';

    // Lấy thư mục gốc của ứng dụng  (thường là /public)
    $baseDir = dirname($scriptName);

    // Nếu baseDir là '/', đặt nó thành chuỗi rỗng để tránh URL có dạng '//'
    $baseDir = $baseDir === '/' ? '' : $baseDir;

    $baseUrl = $protocol . '://' . $host . $baseDir; // Tạo URL cơ sở: http://localhost/
  }

  // Đảm bảo path không bắt đầu bằng '/' để tránh URL có dạng '//'
  $path = ltrim($path, '/');

  if (!empty($path) && substr($baseUrl, -1) !== '/') {
    return "{$baseUrl}/{$path}"; // Thêm '/' giữa baseUrl và path
  }

  return "{$baseUrl}{$path}"; // Trả về URL
}

function section(string $name, $callback = null)
{
  global $sections; // Lấy biến $sections từ phạm vi cha

  if (!isset($sections)) {
    $sections = []; // Khởi tạo biến $sections nếu chưa tồn tại trong phạm vi cha
  }

  if ($callback === null) {
    echo $sections[$name] ?? ''; // Hiển thị nội dung của section nếu có
    return;
  }

  if (isset($sections[$name])) {
    echo $sections[$name]; // Hiển thị nội dung của section nếu có
    return;
  }

  ob_start(); // Bắt đầu buffer đầu ra

  if (is_string($callback)) {
    echo $callback; // Hiển thị nội dung của callback nếu là chuỗi
  } else {
    call_user_func($callback); // Gọi callback nếu là một hàm
  }

  $sections[$name] = ob_get_clean(); // Lấy nội dung đã buffer và lưu vào biến $sections
}

function start_section($name)
{
  global $currentSection;
  $currentSection = $name; // Lưu tên của section hiện tại
  ob_start(); // Bắt đầu buffer đầu ra
}

function end_section()
{
  global $currentSection;

  if (!isset($currentSection)) {
    throw new Exception('No section'); // Throw an exception if no section is started
  }

  $content = ob_get_clean(); // Lấy nội dung đã buffer và lưu vào biến $content

  section($currentSection, $content); // Gọi hàm section() để lưu nội dung vào biến $sections
  $currentSection = null; // Đặt biến $currentSection về null
}

function include_partial(string $partial, array $data = [])
{
  $path = VIEW_DIR . '/partials/' . $partial . '.php';

  if (!file_exists($path)) {
    throw new Exception('Partial not found: ' . $partial); // Throw an exception if the partial is not found
  }

  extract($data, EXTR_PREFIX_SAME, '__var_'); // Extract variables from $data

  require $path; // Include the partial file
}

function active_link(string $link, string $class = 'active')
{
  $currentUrl = $_SERVER['REQUEST_URI'];
  return strpos($currentUrl, $link) === 0 ? $class : ''; // Trả về true nếu $currentUrl bắt đầu bằng $link
}

function dd($data)
{
  echo '<pre>';
  var_dump($data);
  echo '</pre>';
  die();
}

function redirect(string $url)
{
  header('Location: ' . $url);
  exit();
}

function session_get_flash(string $key, $default = null)
{
  $message = $default;

  if (isset($_SESSION[$key])) {
    $message = $_SESSION[$key];
    unset($_SESSION[$key]);
  }

  return $message;
}
