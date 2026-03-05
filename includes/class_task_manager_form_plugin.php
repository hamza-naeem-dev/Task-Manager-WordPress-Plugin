<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" 
integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>

<?php 
if(!defined("ABSPATH"))
    {
        exit;
    }

class TMFrontend{
    public function __construct()
    {
       add_shortcode("tm_form", array($this, "task_manager_form_design"));
       add_shortcode("tm_list", array($this, "task_display_design"));
       add_action("init", array($this, "tmform_data_submission"));
       add_action("init", array($this, "tmform_update_task_status"));
       add_action("init", array($this, "tm_cpt"));
    }

    public function task_manager_form_design() {
        

    ob_start();
    if(isset($_GET['tm_success']))
            {
                echo '<p>' . esc_html("Task has been added successfully!") .'</p>';
            }
    if (isset($_GET['tm_updated'])) {
            echo '<p>' . esc_html('Task status updated successfully!') . '</p>';
        }
    ?>
        <form class="bg-primary p-3 w-75 mx-auto" action="" method="post">
            <div class="row mb-3 mt-3">
                <label class="col-sm-3 col-form-label text-warning fw-bold" for="task_title">Task Title</label><br/>
                <div class="col-sm-9">  
                    <input type="text" name="task_title" required><br/>
                </div>
            </div>
            
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label text-warning fw-bold" for="task_description">Description</label><br/>
                <div class="col-sm-9">
                    <textarea name="task_description" required></textarea><br/>
                </div>
            </div>
            
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label text-warning fw-bold" for="status" class="status_label">Task Status:</label><br/>
                <div class="col-sm-9">
                    <select class="fs-5" name="status" id="status">
                        <option value="InComplete">InComplete</option>
                        <option value="InProgress">InProgress</option>
                        <option value="Completed">Completed</option>
                    </select><br/><br/>
                </div>
            </div>
            <?php wp_nonce_field("tm_task_submit_action", "tmf_nonce") ?>
            <div class="text-center fs-5">
                <input class="w-auto p-2 bg-success text-light border border-0 rounded-1" type="submit" name="tm_submit" value="Submit Task Entry">
            </div>
            
        </form>
    <?php
     return ob_get_clean();
   }

   public function tmform_data_submission(){
    if(is_admin())
        {
            return;
        }
    if(isset($_POST["tm_submit"]))
        {
            if(!isset($_POST["tmf_nonce"]) || ! wp_verify_nonce($_POST["tmf_nonce"], "tm_task_submit_action"))
                {
                    return;
                }

            //Sanitizing Input Fields

            $task_title = sanitize_text_field($_POST["task_title"]);
            $task_desc = sanitize_textarea_field($_POST["task_description"]);
            $status = sanitize_text_field($_POST["status"]);

            $allowed_status = array("InComplete", "InProgress", "Completed");

            if(!in_array($status, $allowed_status))
                {
                    return;
                }

            //Creating a post

            $create_task_post = array("post_type" => "tm_posts",
                                        "post_title" => "Task Heading: " . $task_title,
                                        "post_content" => "Task Description: " . $task_desc,
                                        "post_status" => "publish",
                                        "meta_input" => array("_task_status" => $status));
                //Insert the created post in wp function
            $post_id = wp_insert_post($create_task_post);
            if($post_id && !is_wp_error($post_id))
                {
                    wp_redirect(home_url('/task-list/'));
                    exit;
                }
        }
   }

   public function tm_cpt()
   {
    $labels = array('name' => 'Tasks',
        'singular_name' => 'Task',
        'add_new' => 'Add New Task',
        'add_new_item' => 'Add New Task',
        'edit_item' => 'Edit Task',
        'new_item' => 'New Task',
        'view_item' => 'View Task',
        'search_items' => 'Search Tasks',
        'not_found' => 'No Tasks Found',
        'menu_name' => 'Task Manager');

        $args = array('labels'  => $labels,
        'public'             => true,
        'has_archive'        => true,
        'rewrite'            => array('slug' => 'daily-task'),
        'show_in_rest'       => true, // Enable Gutenberg editor
        'supports'           => array('title', 'editor'),
        'menu_icon'          => 'dashicons-list-view',);

        register_post_type("tm_posts", $args);
   }

   //Display Tasks
   public function task_display_design()
   {
    $edit_task_id = isset($_GET["edit_task"]) ? absint($_GET["edit_task"]) : 0;
    $task_list = new WP_Query(array("post_type" => "tm_posts",
                                     "post_status" => "publish"));
    ob_start();
    if($task_list -> have_posts())
        {
            echo '<div class="task_list">';
                echo '<h1>List of Tasks</h1>';
            while($task_list -> have_posts())
                {
                    $task_list -> the_post();
                    $task_id = get_the_ID();
                    $status = get_post_meta(get_the_ID(), '_task_status', true);
                    echo '<div class="task_items bg-primary p-3 mt-3">';
                    echo '<h3>'. esc_html(get_the_title()). '</h3>';
                    echo '<p>' . wp_kses_post(get_the_content()) . '</p>';
                    echo '<p>Status: ' . esc_html($status) . '</p>';
                    echo '</div>';

                    if($edit_task_id === $task_id)
                        {
                            ?>
                                <form method="post" style="margin-top:10px;">
                                    <?php wp_nonce_field('tm_update_status_action', 'tm_update_nonce'); ?>

                                    <input type="hidden" name="task_id" value="<?php echo esc_attr($task_id); ?>">

                                    <label>Update status:</label>
                                    <select name="status">
                                        <option value="InComplete" <?php selected($status, 'InComplete'); ?>>InComplete</option>
                                        <option value="InProgress" <?php selected($status, 'InProgress'); ?>>InProgress</option>
                                        <option value="Completed" <?php selected($status, 'Completed'); ?>>Completed</option>
                                    </select>

                                    <button type="submit" name="tm_update_status">Save</button>

                                    <a href="<?php echo esc_url(remove_query_arg('edit_task')); ?>" style="margin-left:10px;">Cancel</a>
                                </form>
                            <?php
                        }
                        else {
                            // Otherwise show Edit link
                            $edit_url = add_query_arg('edit_task', $task_id);
                            echo '<a href="' . esc_url($edit_url) . '">Edit</a>';
                        }
                    
                }
            echo '</div>';
            wp_reset_postdata();
        }
    else{
        echo'<p> No Task Found!</p>';
    }
    return ob_get_clean();
   }

   public function tmform_update_task_status()
   {
    if(is_admin())
        {
            return;
        }
    if(!isset($_POST["tm_update_status"]))
        {
            return;
        }

    if(!isset($_POST["tm_update_nonce"]) || ! wp_verify_nonce($_POST["tm_update_nonce"], "tm_update_status_action"))
        {
            return;
        }

    $task_id = isset($_POST['task_id']) ? absint($_POST['task_id']) : 0;
        if (!$task_id) {
            return;
        }

        // Must be our post type
        if (get_post_type($task_id) !== 'tm_posts') {
            return;
        }

        $status = isset($_POST['status']) ? sanitize_text_field($_POST['status']) : '';
        $allowed_status = array('InComplete', 'InProgress', 'Completed');

        if (!in_array($status, $allowed_status, true)) {
            return;
        }

        update_post_meta($task_id, '_task_status', $status);

        // Redirect back to same page, removing edit_task
        $redirect_url = remove_query_arg('edit_task', wp_get_referer());
        $redirect_url = add_query_arg('tm_updated', '1', $redirect_url);

        wp_redirect($redirect_url);
        exit;
   }


}