<?php

// Câu 2:
// Tạo session có thời gian tồn tại 1 năm.
$lifetime = 60 * 60 * 24 * 365;

// Thiết lập thời gian sống của cookie Session ID.
session_set_cookie_params($lifetime);

// Khởi động session.
session_start();


// Câu 3:
// Nếu chưa có danh sách công việc trong session
// thì tạo một mảng rỗng.
if (!isset($_SESSION['task_list'])) {
    $_SESSION['task_list'] = array();
}


// Lấy danh sách công việc từ Session.
$task_list = $_SESSION['task_list'];


// Lấy action từ form.
$action = filter_input(INPUT_POST, 'action');


// Mảng lưu lỗi.
$errors = array();


// Xử lý các action.
switch ($action) {

    // =========================
    // THÊM CÔNG VIỆC
    // =========================
    case 'add':

        $new_task = filter_input(INPUT_POST, 'newtask');

        if (empty($new_task)) {

            $errors[] = 'The new task cannot be empty.';

        } else {

            // Thêm công việc vào Session.
            $_SESSION['task_list'][] = $new_task;

            // Cập nhật lại biến task_list.
            $task_list = $_SESSION['task_list'];
        }

        break;


    // =========================
    // XÓA CÔNG VIỆC
    // =========================
    case 'delete':

        $task_index = filter_input(
            INPUT_POST,
            'taskid',
            FILTER_VALIDATE_INT
        );

        if (
            $task_index === NULL ||
            $task_index === FALSE ||
            !isset($_SESSION['task_list'][$task_index])
        ) {

            $errors[] = 'The task cannot be deleted.';

        } else {

            // Xóa task khỏi Session.
            unset($_SESSION['task_list'][$task_index]);

            // Sắp xếp lại chỉ số mảng.
            $_SESSION['task_list'] =
                array_values($_SESSION['task_list']);

            // Cập nhật lại biến task_list.
            $task_list = $_SESSION['task_list'];
        }

        break;
}


include('task_list.php');

?>