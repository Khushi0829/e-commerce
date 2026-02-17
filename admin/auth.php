<!-- 
session_start();

// Allow login page without redirect
$currentPage = basename($_SERVER['PHP_SELF']);

if (!isset($_SESSION['admin_id']) && $currentPage !== 'login.php') {
    header("Location: " . ADMIN_URL . "/login.php");
    exit;
} -->
